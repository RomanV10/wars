Unfortunately i don't have time to complete all what i want. This is what was in my plan:
1. Add third api for test (3 hours).
2. Add cache for all query to api. This will make code faster and api query limit will not affect to us (5 hours).
3. I have write code for ajax query. Expand code if JS is not work in browser (4 hours).
4. Write test for code.(5 hours)
5. Add exceptions. Refactor and optimize code.(Reuse models, replace and remove some method) (3 hours).
6. Make more interactive interface for adding api (8 hours).

```bash
Copy file "wars.css" from  css/test.css to public "/css". 
Copy file "wars.js" from  js/wars.js to public "/js". 
```
**To "composer.json" add**
```json
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "testroman/wars",
                "version": "dev",
                "source": {
                    "url": "git@github.com:RomanV10/wars.git",
                    "type": "git",
                    "reference": "master"
                },
                "autoload": {
                    "psr-4": {
                        "TestRoman\\Wars\\": "src/"
                    }
                }
            }
        }
    ]
```

**Run**
```bash
composer require vinelab/http
composer require "testroman/wars @dev"
 ```
**To "providers" in /config/app.php add**
```php
Vinelab\Http\HttpServiceProvider::class,
TestRoman\Wars\WarsServiceProvider::class,
```

**Then run**
```bash
composer dumpautoload
php artisan vendor:publish
php artisan migrate
```

