<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use App\Category;
use App\CurrencyRates;
use App\ProductAd;

class PagesController extends Controller
{
    public function index()
    {
        CartController::addCartToSession();

        $agent = new Agent();

        // $product = Product::select()->orderBy('created_at', 'desc')->first();
        $products_on_sale = ProductAd::all();
        $currency = CurrencyController::getCurrency();
        $categories = Category::all();
        $currencyEur = CurrencyRates::where('name', 'EUR')->get('name')->first();

        $currencyValue = CurrencyController::getCurrencyValue();

        return view('pages.index')->with(
            [
                'products_on_sale' => $products_on_sale,
                'agent' => $agent,
                'currency' => $currency,
                'currencyValue' => $currencyValue,
                'categories' => $categories,
                'currencyEur' => $currencyEur->name
            ]
        );
    }

    public function aboutShipping()
    {
        return view('pages.about.shipping');
    }

    public function aboutTerms()
    {
        return view('pages.about.terms');
    }

    public function aboutCancel()
    {
        return view('pages.about.cancel');
    }

    public function aboutReclamation()
    {
        return view('pages.about.reclamation');
    }

    public function aboutSizes()
    {
        return view('pages.about.sizes');
    }

    public function aboutCookies()
    {
        return view('pages.about.cookies');
    }
}
