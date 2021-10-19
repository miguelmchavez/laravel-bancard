# Laravel Bancard

## Installation

Install via composer

```bash
composer require deviam/laravel-bancard
```
Publish config and migrations

```bash
php artisan vendor:publish --provider="Deviam\Bancard\BancardServiceProvider"
```
This is the contents of the file which will be published at config/bancard.php:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Bancard Keys
    |--------------------------------------------------------------------------
    |
    | The Bancard public key and private key give you access to Bancard's
    | API.
    |
    */
    'public' => env('BANCARD_PUBLIC_KEY', ''),

    'private' => env('BANCARD_PRIVATE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Bancard Environment
    |--------------------------------------------------------------------------
    |
    | This value determines if your application is using the 
    | staging environment from Bancard's API.
    |
    */
    'staging' => (bool) env('BANCARD_STAGING', true),

    /*
    |--------------------------------------------------------------------------
    | Bancard URL
    |--------------------------------------------------------------------------
    */

    // The return URL for the Single Buy Operation
    'single_buy_return_url' => env('BANCARD_SINGLE_BUY_RETURN_URL', ''), 
    
    // The cancel URL for the Single Buy Operation
    'single_buy_cancel_url' => env('BANCARD_SINGLE_BUY_CANCEL_URL', ''), 
    
    // The return URL for the New Card Operation
    'new_card_return_url' => env('BANCARD_NEW_CARD_RETURN_URL', ''), 
];
```
Run migrations

```
php artisan migrate
```
## Usage
The methods listed below return an instance of the class [Illuminate\Http\Client\Response](https://laravel.com/api/8.x/Illuminate/Http/Client/Response.html).

- [singleBuy](#single-buy)
- [newCard](#cards-new)
- [listCards](#users-cards)
- [deleteCard](#delete)
- [tokenCharge](#charge)
- [confirmation](#single-buy-get-confirmation)
- [rollback](#single-buy-rollback)

According to [Laravel Documentation](https://laravel.com/docs/8.x/http-client) these are some of the methods you can use to inspect the response.
```php
// Get the body of the response.
$response->body() : string;

// Get the JSON decoded body of the response as an array or scalar value.
$response->json() : array|mixed;

// Determine if the status code is >= 200 and < 300...
$response->successful();

// Determine if the status code is >= 400...
$response->failed();
```

### Single Buy
Start the payment process.
```php
use Deviam\Bancard\Bancard;

$response = Bancard::singleBuy('Ejemplo de pago', 10330.00);
if ($response->failed()) {
	// Do something here.
}
$data = $response->json();
$processId = $data['process_id'];
$scriptUrl = Bancard::scriptUrl();

return view('your_view_here', compact('processId', 'scriptUrl'));
```
Through the `singleBuy` method an eloquent model called `SingleBuy` is created. 
You can retrieve the record using the `process_id` value.
```php
use Deviam\Bancard\Models\SingleBuy;

$order = SingleBuy::where('process_id', '')->first();
```

### Cards New
Start the registration process of a card.
```php
use Deviam\Bancard\Bancard;

$response = Bancard::newCard(966389, '09********', 'user@example.com');
if ($response->failed()) {
	// Do something here.
}
$data = $response->json();
$processId = $data['process_id'];
$scriptUrl = Bancard::scriptUrl();

return view('your_view_here', compact('processId', 'scriptUrl'));
```
Through the `newCard` method an eloquent model called `Card` is created.
You can retrieve all the cards from an user with the `user_id` value;
```php
use Deviam\Bancard\Models\Card;

$cards = Card::where('user_id', '')->get();
```

### Users Cards
Operation that allow you to list the cards registered from an user.
```php
use Deviam\Bancard\Bancard;

$response = Bancard::listCards(966389);
if ($response->failed()) {
	// Do something here.
}
$data = $response->json();
$cards = $data['cards'];
```

### Delete
Operation that allow you to delete a registered card.
```php
use Deviam\Bancard\Bancard;

$response = Bancard::deleteCard(966389, 'c8996fb92427ae41e4649b934ca495991b7852b855');
if ($response->failed()) {
	// Do something here.
}
$data = $response->json();
$status = $data['status'];
```

### Charge
Operation that allow you to make a payment with a token.
```php
use Deviam\Bancard\Bancard;

$response = Bancard::tokenCharge('Ejemplo de pago', 10330.00, 'c8996fb92427ae41e4649b934ca495991b7852b855');
if ($response->failed()) {
	// Do something here.
}
$data = $response->json();
$confirmation = $data['confirmation'];
```
Through the `tokenCharge` method two eloquent models are created.  These models are `SingleBuy` and `Confirmation`. 
You can retrieve each record with the `shop_process_id` value that comes in the response.
```php
use Deviam\Bancard\Models\{SingleBuy, Confirmation};

$order = SingleBuy::where('shop_process_id', '')->first();
$confirmation = Confirmation::where('shop_process_id', '')->first();
```

### Single Buy Rollback
Operation that allow you to cancel the payment.
```php
use Deviam\Bancard\Bancard;

$response = Bancard::rollback('12313');
if ($response->failed()) {
	// Do something here.
}
$data = $response->json();
$status = $data['status'];
```
Through the `rollback` method an eloquent model called `Rollback` is created.
You can retrieve the record using the `shop_process_id` value.
```php
use Deviam\Bancard\Models\Rollback;

$record = Rollback::where('shop_process_id', '')->first();
```

### Single Buy Get Confirmation
Operation that allow you to know if a payment was confirmed or not.
```php
use Deviam\Bancard\Bancard;

$response = Bancard::confirmation('12313');
if ($response->failed()) {
	// Do something here.
}
$data = $response->json();
$confirmation = $data['confirmation'];
```
Through the `confirmation` method an eloquent model called `Confirmation` is created.
You can retrieve the record using the `shop_process_id` value.
```php
use Deviam\Bancard\Models\Confirmation;

$record = Confirmation::where('shop_process_id', '')->first();
```

## Credits

- [Miguel Chávez](https://github.com/miguelmchavez)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

