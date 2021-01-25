<?php

namespace App\Http\Controllers;

use App\CurrencyRates;

class CurrencyController extends Controller
{
    public static function getCurrency()
    {
        if (auth()->user()) {
            if (auth()->user()->address) {
                $userCountry = auth()->user()->address->country;
                if (strtolower($userCountry) == 'srbija') {
                    return 'RSD';
                } else {
                    return 'EUR';
                }
            } else {
                return 'RSD';
            }
        } else {
            return 'RSD';
        }
    }

    public static function isSerbia()
    {
        if (self::getCurrency() == 'RSD') {
            return true;
        } else {
            return false;
        }
    }

    public static function getInRSD($productPrice)
    {
        if (self::isSerbia()) {
            return $productPrice * self::getCurrencyValue();
        }
    }

    public static function getCurrencyValue()
    {
        $value = CurrencyRates::where('name', self::getCurrency())->get('value')->first();
        return $value['value'];
    }
}
