# laravel-teleduino
A laravel interface for Teleduino API
# Installation
require the package using composer

```
composer require khaledkhamis/teleduino dev-master
```

add Teleduino service provider in `providers` array in `config/app.php`

```
Khaledkhamis\Teleduino\TeleduinoServiceProvider::class,
```

then publish the configuration file

```
php artisan vendor:publish
```

open `config/teleduino.php` and insert your API key from teleduino.org
# Example

```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//use Teleduino namespace
use Khaledkhamis\Teleduino\Teleduino;

class ArduinoController extends Controller
{
    public function setOutput()
    {
        $myArduino = new Teleduino();	//default for 328

        /*all functions accept same parameters as the API documentation
        **https://www.teleduino.org/documentation/api/328-full
        */
        $myArduino->definePinMode(4,1);
        $myArduino->setDigitalOutput(4,2);
    }
}

```

# Contribution
Feel free to fork and create a pull request!

# Contact
For more information please get in touch: khaledkhamis@live.com