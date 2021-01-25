<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductImage;
use App\Category;
use App\CurrencyRates;
use \DB;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $currency = CurrencyController::getCurrency();
        $currencyValue = CurrencyController::getCurrencyValue();
        $currencyEur = CurrencyRates::where('name', 'EUR')->get('name')->first();

        // Ako je korisnik ulogovan uracunaj cijenu postarine drzave u kojoj se nalazi, else uracunaj cijenu postarine za srbiju
        $shippingPrice = 0;
        if (auth()->user()) {
            if (isset(auth()->user()->address)) {
                $shippingPrice = DB::table('shipping_prices')->where('country_name', auth()->user()->address->country)->value('price');
            }
        } else {
            $shippingPrice = DB::table('shipping_prices')->where('country_name', 'Srbija')->value('price');
        }

        return view('product.show')->with([
            'product' => $product,
            'currency' => $currency,
            'currencyValue' => $currencyValue,
            'currencyEur' => $currencyEur->name,
            'shippingPrice' => $shippingPrice,
        ]);
    }

    public function product($id)
    {
        $product = Product::find($id);
        $product['images'] = $product->images;

        $product['category_name'] = $product->category->name;

        $currency = CurrencyController::getCurrency();
        $currencyValue = CurrencyController::getCurrencyValue();
        $product->price *= $currencyValue;
        $product->price = round($product->price, 2);

        return $product;
    }

    public function latest($id)
    {
        $currency = CurrencyController::getCurrency();
        $currencyValue = CurrencyController::getCurrencyValue();
        // Gets latest products in category but skips first because we show first on index intro section
        $products = Product::select()->where('category_id', $id)->orderBy('created_at', 'desc')->limit(2)->skip(1)->get();

        $data = [
            'data' => []
        ];

        foreach ($products as $product) {
            $images = ProductImage::select()->where('product_id', $product->id)->get();
            $product['images'] = $images;
            $product['category_name'] = Category::find($id)->name;
            $product->price = round($product->price * $currencyValue, 2);
            $product['currency'] = $currency;
            array_push($data['data'], $product);
        }

        return $data;
    }
}
