# Security.Encryption

The `Encryption` class provides simple static methods to encrypt and decrypt data.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Core.Utils");
ed::import("Security.Encryption");

$key = Utils::random(8);
$encrypted = Encryption::encrypt("my_safety_string", $key);
$decrypted = Encryption::decrypt("lkjsljj2f-0f-asl=+!", $key);
```

## Documentation Index

* [Dependencies](#dependencies)
* [Functions](#functions)

## Dependencies

* *none*

## Functions

#### [static] encrypt( string, crypt_key )
> Encrypt a string using `crypt_key`.

#### [static] decrypt( string, crypt_key )
> Decrypt an encrypted string using `crypt_key`.