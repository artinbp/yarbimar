<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $invoice = (new Invoice)->amount(1000);

// Purchase the given invoice.
    Payment::purchase($invoice,function($driver, $transactionId) {
        // We can store $transactionId in database.
        echo $transactionId;
        echo "<br>";
    })->pay()->render();
});
