Clara Library
===============

Library file manager for Clara.

## Installation

```php
composer require ceddyg/clara-library
```

Add to your providers in 'config/app.php'
```php
CeddyG\ClaraLibrary\LibraryServiceProvider::class,
```

Then to publish the files.
```php
php artisan vendor:publish --provider="CeddyG\ClaraLibrary\LibraryServiceProvider"
```
