<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\Country;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('noadmin');
        $this->middleware('xss');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Address $address)
    {
        $this->authorize('create', $address);
        if (auth()->user()->address) {
            return redirect('/orders');
        }
        $countries = Country::all();
        return view('orders.shipping.create')->with([
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->address) {
            return redirect('/orders');
        }

        // $attributes = $this->validateAddress();
        $attributes = $this->validate(
            $request,
            [
                'street_name' => ['required', 'min:8'],
                'apt_number' => ['required', 'min:1'],
                'city' => ['required', 'min:3'],
                'postal_code' => ['required', 'min:3'],
                'country' => ['required'],
                'phone_number' => ['required', 'min:10']
            ]
        );

        $attributes['user_id'] = auth()->user()->id;

        $address = new Address;
        $address->add($attributes);

        $user = auth()->user();
        $user->phone_number = $attributes['phone_number'];
        $user->save();

        return redirect('/orders');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = Address::find($id);
        $this->authorize('update', $address);
        $countries = Country::all();
        return view('orders.shipping.edit')->with(['address' => $address, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $address = Address::find($id);
        $this->authorize('update', $address);
        $attributes = $this->validate(
            $request,
            [
                'street_name' => ['required', 'min:8'],
                'apt_number' => ['required', 'min:1'],
                'city' => ['required', 'min:3'],
                'postal_code' => ['required', 'min:3'],
                'country' => ['required', 'exists:countries,name'],
                'phone_number' => ['required', 'min:10']
            ]
        );

        $user = auth()->user();

        if ($user->phone_number != $attributes['phone_number']) {
            $user->editPhoneNumber($attributes['phone_number']);
        }

        $attributes['user_id'] = $user->id;
        $address->edit($attributes);

        return redirect('/orders');
    }
}
