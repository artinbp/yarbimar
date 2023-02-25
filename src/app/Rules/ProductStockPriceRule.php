<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class ProductStockPriceRule implements InvokableRule, DataAwareRule
{
    protected array $data = [];

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        $products = array_filter($value);
        if (count($products) == 0) {
            $fail('Please select at least one product');
        }


//        $errors = [];
//        foreach ($products as $product) {
//            if (!isset($product['quantity'])) {
//                $errors[]
//            }
//
//            if (empty($product['quantity'])) {
//
//            }
//
//            if (!isset($product['price'])) {
//
//            }
//
//            if (empty($product['price'])) {
//
//            }
//        }

        $dbProducts = Product::find(array_map('intval', array_keys($products)))->keyBy('id');

        $errorText = '';
        foreach ($products as $productID => $productFields) {
            if ($dbProducts[$productID]->stock < $productFields['quantity'])
        }
    }
}
