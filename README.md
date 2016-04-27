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

Generate a key from teleduino.org

# Methods for response
* `getValue()` to get a single value from the response
* `getValues()` to get all values in the response
* `hasValues()` check whether there is a value to get
* `getRequestTime()` request time from the API
* `isSuccess()` 1:success, 0:failed
* `getMessage()` returns the output message from the API

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
        $myArduino = new Teleduino('YOUR_API_KEY');	//default for 328

        /*all functions accept same parameters as the API documentation
        **https://www.teleduino.org/documentation/api/328-full
        */
        $myArduino->definePinMode(4,1);
        $myArduino->setDigitalOutput(4,2);

       	//a function with a return
        $input = $myArduino->getDigitalInput(5)->getValue();
    }
}

```

# Contribution
Feel free to fork and create a pull request!

# Contact
For more information please get in touch: khaledkhamis@live.com
