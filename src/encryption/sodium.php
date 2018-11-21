<?php

function safeEncrypt($message, $key){
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $cipher = base64_encode($nonce.sodium_crypto_secretbox($message, $nonce, $key));
    sodium_memzero($message);
    sodium_memzero($key);
    return $cipher;
}

function safeDecrypt($encrypted, $key){   
    $decoded = base64_decode($encrypted);
    if ($decoded === false) {
        throw new Exception('the encoding failed');
    }
    if (mb_strlen($decoded, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES)) {
        throw new Exception('the message was truncated');
    }
    $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
    $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
    $plain = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
    if ($plain === false) {
         throw new Exception('the message was tampered with in transit');
    }
    sodium_memzero($ciphertext);
    sodium_memzero($key);
    return $plain;
}


//Encrypt & Decrypt your message
$key = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);

//generates random encrypted string (Base64 related)
$enc = safeEncrypt('My Data to encrypt', $key); 
echo $enc;

echo "<br />";

//decrypts encoded string generated via safeEncrypt function 
$dec = safeDecrypt($enc, $key); 
echo $dec;