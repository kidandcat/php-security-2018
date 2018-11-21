# Session based Auth

Unir el ID de sesión a la IP y al User-Agent.


# Regenerate session

Pasando como parámetro `true` php borrará la sesión antigua.

```php
// Deletes old session
session_regenerate_id(true);
```

If an application creates a lot of quick connections to the server some interesting things can happen. PHP, and many other languages, restricts access to the session data to one running script at a time, so if multiple requests come in that try to access the session data the second request (and any other) gets queued up. When the first request changes the ID and deletes the old session the second request still has the old session ID which no longer exists. This results in a third, new session being opened and generally means your user gets logged out.

This bug is ridiculously hard to diagnose as the timing of not just the requests but the ID regeneration has to be just right.


# Timing attack

Probando usuarios y contraseñas en un login, podemos saber si hemos encontrado un usuario correcto por el tiempo de respuesta. Si el usuario no existe, el servidor responderá inmediatamente. Mientras que si el usuario existe, el servidor tendrá que traer el hash de la contraseña de la base de datos, hashear la contraseña que le enviamos nosotros y hacer la comparación, todo esto lleva obviamente más tiempo.

https://cwe.mitre.org/data/definitions/385.html

https://codeseekah.com/2012/04/29/timing-attacks-in-web-applications/


# Login errors

Nunca!!

    ERROR: Invalid password.
    ERROR: Invalid username.

Buena práctica:

    ERROR: Invalid combination of username and password.



# Session Cookies Vs. JWTs

Login forms are one of the most common attack vectors. We want the user to give us a username and password, so we know who they are and what they have access to. We want to remember who the user is, allowing them to use the UI without having to present those credentials a second time. And we want to do all that securely. How can JWTs help?



The traditional solution is to put a session cookie in the user’s browser. This cookie contains an identifier that references a “session” in your server, a place in your database where the server remembers who this user is.

This strategy is secure, if the following conditions are met:

- You implement HTTPS on your server, and the login form is posted over this secure channel.
- You store the session ID in a secure, HTTPS-only cookie that can only be sent to your server over secure channels.


However there are some drawbacks to session identifiers:

- They’re stateful. Your server has to remember that ID and look it up for every request. This can become a burden on large systems.
- They’re opaque. They have no meaning to your client or your server. Your client doesn’t know what it’s allowed to access, and your server has to go to a database to figure out who this session is for and if they are allowed to perform the requested operation.
- They’re in a silo. They only have meaning within your system, and cannot be used to share authentication assertions with other services and APIs.

---

# JSON Web Tokens

https://jwt.io/

JWTs are self-contained strings signed with a secret key. They contain a set of claims that assert an identity and a scope of access.


If you encounter a JWT in the wild, it will look like this:

`eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS5zdG9ybXBhdGguY29tL3YxL2FwcGxpY2F0aW9ucy81WndFRjdud0x3Y0dYd3h0aFJiZDI3Iiwic3ViIjoiaHR0cHM6Ly9hcGkuc3Rvcm1wYXRoLmNvbS92MS9hY2NvdW50cy81ell0RFAxaG85S0laMTNOeHkzU0NpIiwianRpIjoiYWYyZjMwMzctZWEzNi00NzM2LWFlYWQtMzE1NjI3YjM0Y2Q5IiwiaWF0IjoxNDMzMTk1NTk1LCJleHAiOjE0MzMxOTkxOTUsInhzcmZUb2tlbiI6Ijk2Njg4Y2ZkLTYxMjItNGY2OC1hZTAwLTM3YTljMmJhYWZiNCJ9.KfRkBoE83wirxrOJttF9lAx1lD1xPO_zl0DsrzdYkYY`


Hmm… looks like an opaque session ID, you say? Well, that’s just how it looks! In fact it’s a three-part string, separated by periods. If you base 64 decode each part, you get the three parts of a JWT:

## The Header:
    {
        "typ":"JWT",
        "alg":"HS256"
    }

The header is telling us how this token was signed. All JWTs should be signed with a private signing key. When a JWT is used for authentication, your server must verify that the token has been signed with the server’s private key. Otherwise, someone could create an arbitrary JWT that would be trusted by your system.


## The Body:

    {
        "iss":"http://trustyapp.com/",
        "exp": 1300819380,
        "sub": "users/8983462",
        "scope": "self api/buy"
    }

The claims body is where the JWT really shines. It tells us:

- Who the user is (sub)
- Who issued this token (iss)
- When it expires (exp)
- What this user can do (scope)

Because we’ve signed this token, we can trust this information (after verifying the signature!). With this trust, our sever can get on with the task of resolving the request accordingly – no need to hit your database for all this information!


## The Signature:

    "tß´—™à%O˜v+nî…SZu¯µ€U…8H×"

This is the hash that was created by the signing algorithm, you will use this (with your secret key) to verity that the token was issued by your service.

## How To Store JWTs In The Browser

Short answer: use cookies, with the HttpOnly; Secure flags. 

This will allow the browser to send along the token for authentication purposes, but won’t expose it to the JavaScript environment.


## Implicit Trust is a Tradeoff

How long can this token be trusted? How do you know if it’s been stolen during a MITM attack? These are the challenges posed by JWTs.

Refresh tokens are the typical solution. In this situation, you provide a short lived access token, and a longer lived token used to get more shorter-lived tokens. Both of these can be JWTs, though the claims bodies will look different. This gives you some control over how often you re-hit your authentication database to assert that the user is still allowed to have tokens.

If you need high security, you can add a unique value to every access token, using the jti field in the claims body. You can then maintain a blacklist of tokens that you know have been compromised. You can purge your blacklist of tokens as they expire.


## Refresh Token Flow

```
              JWT expiration: 5min


                                           Login
+-----------+                           User, Pass                             +--------------+
|           |    +-------------------------------------------------------->    |              |
|           |                                                                  |              |
|           |                         Set token header                         |              |
|           |                   Cookie=  access_token: {JWT1...}               |              |
|   Client  |                            refresh_token: {JWT0...}              |     Server   |
|           |    <--------------------------------------------------------+    |              |
|           |                                                                  |              |
|           |         ^                                                        |              |
|           |         |                                                        |              |
|           |         |   3 minutes                                            |              |
|           |         |                                                        |              |
|           |         v               Verify JWT validity                      |              |
|           |                   Cookie=  access_token: {JWT1...}               |              |
|           |                            refresh_token: {JWT0...}              |              |
|           |    +-------------------------------------------------------->    |              |
|           |                                                                  |              |
|           |                                                                  |              |
|           |                                                                  |              |
|           |                   Cookie=  access_token: {JWT1...}               |              |
|           |                            refresh_token: {JWT0...}              |              |
|           |    <--------------------------------------------------------+    |              |
|           |                                                                  |              |
|           |         ^                                                        |              |
|           |         |                                                        |              |
|           |         |                                                        |              |
|           |         |   4 minutes                                            |              |
|           |         |                                                        |              |
|           |         |                                                        |              |
|           |         v               Verify JWT validity                      |              |
|           |                   Cookie=  access_token: {JWT1...}               |              |
|           |                            refresh_token: {JWT0...}              |              |
|           |    +-------------------------------------------------------->    |              |
|           |                                                                  |              |
|           |                                                                  |              |
|           |                    refresh_token is valid!!                      |              |
|           |                                                                  |              |
|           |                   Create a new access_token                      |              |
|           |                   with new info obtained from                    |              |
|           |                   the DB about the user.                         |              |
|           |                                                                  |              |
|           |                                                                  |              |
|           |                          Set new token                           |              |
|           |                   Cookie=  access_token: {JWT2...}               |              |
|           |                            refresh_token: {JWT0...}              |              |
|           |    <--------------------------------------------------------+    |              |
|           |                                                                  |              |
|           |                                                                  |              |
+-----------+                                                                  +--------------+

```


## Sliding-Sessions

Sliding-sessions are sessions that expire after a period of inactivity. When a user performs an action, a new access token is issued. If the user uses an expired access token, the session is considered inactive and a new access token is required. This new token can be obtained with a refresh token or requiring credentials


```
              JWT expiration: 5min


                                           Login
+-----------+                           User, Pass                             +--------------+
|           |    +-------------------------------------------------------->    |              |
|           |                                                                  |              |
|           |                                                                  |              |
|           |                         Set token header                         |              |
|   Client  |                   Cookie=  access_token: {JWT1...}               |     Server   |
|           |    <--------------------------------------------------------+    |              |
|           |                                                                  |              |
|           |         ^                                                        |              |
|           |         |                                                        |              |
|           |         |   3 minutes                                            |              |
|           |         |                                                        |              |
|           |         v               Verify JWT validity                      |              |
|           |                   Cookie=  access_token: {JWT1...}               |              |
|           |    +-------------------------------------------------------->    |              |
|           |                                                                  |              |
|           |                                                                  |              |
|           |                          Set new token                           |              |
|           |                   Cookie=  access_token: {JWT2...}               |              |
|           |    <--------------------------------------------------------+    |              |
|           |                                                                  |              |
|           |         ^                                                        |              |
|           |         |                                                        |              |
|           |         |                                                        |              |
|           |         |   8 minutes                                            |              |
|           |         |                                                        |              |
|           |         |                                                        |              |
|           |         v               Verify JWT validity                      |              |
|           |                   Cookie=  access_token: {JWT2...}               |              |
|           |    +-------------------------------------------------------->    |              |
|           |                                                                  |              |
|           |                X     X                                           |              |
|           |                 X   X                                            |              |
|           |                  X X        JWT Token has expired!!              |              |
|           |                   X                                              |              |
|           |                  X X       user needs to login again             |              |
+-----------+                 X   X                                            +--------------+
                             X     X

```


#### They don’t help us secure our browser applications, that’s your responsibility.

#### They help us by being signed and stateless, and by having a common data format.



### Libraries

https://github.com/firebase/php-jwt

https://github.com/lcobucci/jwt