# solidpay-php-client

`solidpay-php-client` is a official client for Solidpay. The Solidpay API enables you to accept payments in a secure and reliable manner. 
# Installation
### Composer
Simply add a dependency on solidpay/solidpay-php-client to your project's composer.json file if you use Composer to manage the dependencies of your project. Here is a minimal example of a composer.json file that just defines a dependency on newest stable version of Solidpay:
<pre><code>{
    "require": {
        "solidpay/php-client": "1.0.*"
    }
}
</code></pre>
### With command line
Adding the Solidpay repository with command line is easy as well. 
Just type:
<pre><code>composer require solidpay/php-client</code></pre>
### Manually upload
If you cannot use composer or don't have SSH access to your server, you can upload /solidpay/ to your web space. However, then you need to manage the autoloading of the classes yourself.

# Usage
Before doing anything you should register yourself with Solidpay and get access credentials. 
### Create a new payment
```php
require_once("/vendor/autoload.php");

use Solidpay\Solidpay;

try {

$api_key = 'YOUR_KEY';
$merchant_id = 'YOUR_MERCHANT_ID';

$client = new Solidpay($api_key, $merchant_id);

$form = array(
    'order_id' => 'YOUR_TRANSACTION_ID',
    'currency' => 'gbp',
    'amount' => '100',
    'capture' => false,
    'return_url' => 'https://example.com/success/123456'
);

$payments = $client->request->post('/payments/', $form);

$status = $payments->httpStatus();

} catch (Exception $e) {
    echo $e;
}
```

### Response
If the payload was successful, you will get a success response like the one below.
```json
{
    "status": "Success",
    "id": "502244",
    "url": "https://solidpay.io/payments/bd1b9bc8c35df675a9b174d499aa7e2e4dfd1658fe8bbd4c4a94a247deb969f3"
}
```
### API Calls
You can afterwards call any method described in Solidpay api with corresponding http method and endpoint. These methods are supported currently: <code>get</code>, <code>post</code>, <code>put</code>, <code>patch</code> and <code>delete</code>.

```php
// Get all payments
$payments = $client->request->get('/payments');

// Get specific payment
$payments = $client->request->get('/payments/{id}');

// Capture payment
$form = array(
    'amount' => '100',
);

$payments = $client->request->post('/payments/{id}/capture', $form);

$status = $payments->httpStatus();
if ($status == 201) {
    // Successful created
}

// Refund payment
$form = array(
    'amount' => '100',
);

$payments = $client->request->post('/payments/{id}/refund', $form);

```
