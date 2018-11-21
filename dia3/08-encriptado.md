# Encriptado de datos en PHP

# PHP What is new
https://www.combell.com/en/blog/what-is-new-php-7-2/


# MCrypt is deprecated, what is the alternative?
https://stackoverflow.com/a/41272680/4158710


# libSodium
https://github.com/jedisct1/libsodium-php

http://php.net/manual/es/book.sodium.php


# mcrypt
http://php.net/manual/es/function.mcrypt-encrypt.php

- DEPRECATED
- OBSOLETE

#### Esta extensión está obsoleta desde PHP 7.1.0 y ha sido movida a PECL a partir de PHP 7.2.0.

# OpenSSL
http://php.net/manual/en/function.openssl-encrypt.php

```php
$key = base64_encode(openssl_random_pseudo_bytes(32));

function my_encrypt($data, $key) {
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // Generate an initialization vector
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
    return base64_encode($encrypted . '::' . $iv);
}

function my_decrypt($data, $key) {
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}
```


# Envelope encryption

https://cloud.google.com/kms/


Let’s consider a malicious user that gains access to the server that hosts our application. In this scenario, chances are the attacker will be able to discover our secret key which we used to encrypt the data. This leaves our data completely exposed.

The simple solution is to not store our secret key in the same location as the encrypted data, but this presents a problem. How do we encrypt and decrypt on demand? Enter Google Cloud Key Management Service (Cloud KMS).

Cloud KMS is a service provided by Google for securely hosting cryptographic keys. It provides a variety of useful features around key storage, including automatic key rotation and delayed key destruction. However, in this example we’re primarily concerned with storing our secret key away from our data.


## Encryption
1. Generate a unique encryption key (DEK)
2. Encrypt the data using secret key encryption
3. Send the unique encryption key (DEK) to Cloud KMS for encryption, which returns the KEK
4. Store the encrypted data and encrypted key (KEK) side-by-side
5. Destroy the generated key (DEK)

```
                                                            +--------------------------+
                                                            |        Cloud KMS         |
                                              +             |                          |
+---------------------------------+           | +---------> |  Receive $dek            |
|             Server              |           |             |                          |
|                                 |           | <---------+ |  Returns encrypted $dek  |
|  $dek = generate_key();         |           |             |                          |
|                                 |           |             +--------------------------+
|  $enc = encrypt($data, $dek);   |           |
|                                 |           |
|  $kek = \KMS\encrypt($dek); +---------------+
|                                 |
|  db_write($enc, $kek); +--------------------+
|                                 |           |
|  unset($dek);                   |           |
|                                 |           |
+---------------------------------+           |             +------------+
                                              |             |            |
                                              +-----------> |  DataBase  |
                                                            |            |
                                                            +------------+

```

## Decryption
1. Retrieve the encrypted data and encrypted key (KEK) from the database
2. Send the KEK to Cloud KMS for decryption, which returns the DEK
3. Use the DEK to decrypt our encrypted data
4. Destroy the DEK

```
                                                            +--------------------------+
                                                            |        Cloud KMS         |
                                                +           |                          |
+---------------------------------+             | +-------> |  Receive $kek            |
|             Server              |             |           |                          |
|                                 |             | <-------+ |  Returns decrypted $dek  |
|   $kek = db_read('kek');  <--------------+    |           |                          |
|   $enc = db_read('data');       |        |    |           +--------------------------+
|                                 |        |    |
|                                 |        |    |
|   $dek = \KMS\decrypt($kek); +----------------+
|                                 |        |
|   $data = decrypt($enc, $dek);  |        |
|                                 |        |
|   unset($dek);                  |        |
|                                 |        |
+---------------------------------+        |                +------------+
                                           |                |            |
                                           +--------------+ |  DataBase  |
                                                            |            |
                                                            +------------+

```


# Envelope encryption VS Local encryption

If an attacker compromised our system, would they be able to also gain our API credentials for Cloud KMS? Depending on the authentication method used, then yes it may be a possibility. If that’s the case, you may be wondering how envelope encryption is any more secure than regular secret key encryption? The key difference (pun intended) is that API access can be revoked, thus thwarting an attacker that’s made off with your sensitive data. It’s the equivalent of changing your locks if someone steals your house key. With regular secret key encryption where a single local key is compromised you don’t have that luxury. The attacker has all the time in the world to decrypt your sensitive data.





---

##### source: https://deliciousbrains.com/php-encryption-methods/