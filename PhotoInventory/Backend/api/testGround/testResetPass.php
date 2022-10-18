<?php


// echo random_bytes(16);

echo bin2hex(random_bytes(64));
echo "\n Hashing: ";
echo hash("sha256", random_bytes(64));
echo "\n Hashing Mac: ";
echo hash_hmac("sha256", random_bytes(64), random_bytes(32));
?>