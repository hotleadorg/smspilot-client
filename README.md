# [SMSPilot](https://smspilot.ru/)  PHP client
Installation
------------
```
composer require xiaklizrum/smspilot-client
```
Usage
-----
Example:
```php
<?php
    use SMSPilot\Client;
    use SMSPilot\Request;
    
    $apiKey = 'your api key from https://smspilot.ru/my-settings.php';
    $client = new Client($apiKey);
    $request = new Request(
        'SENDERNAME', // empty string if u haven't
        '79991111111',
        'Hello world'
    );
    var_dump($client->send($request));
?>
```
Output:
```html
array (size=3)
  'send' => 
    array (size=4)
      'server_id' => string '123456789' (length=9)
      'phone' => string '79991111111' (length=11)
      'price' => string '2.22' (length=4)
      'status' => string '0' (length=1)
  'balance' => string '98.88' (length=6)
  'cost' => string '2.22' (length=4)
```