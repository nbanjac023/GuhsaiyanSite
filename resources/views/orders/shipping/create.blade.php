@extends('layouts.app')

@section('title', '- Informacije o dostavi')
@section('content')

    <section class="shipping u-margin-top-xxxl" id="cartToggleArea">

        <div class="container">

            <form action="{{ route('address.store') }}" method="POST" class="shipping__form col-11 col-sm-11 col-md-8 col-lg-6">
                <h1 class="shipping__form-heading heading-primary-m">Informacije o dostavi</h1>
                @csrf
                <div class="shipping__form-group">
                    <label for="streetName" class="shipping__form-label">Ulica</label>
                    <input type="text" name="street_name" id="streetName" class="shipping__form-input" autocomplete="street-address" value="{{ old('street_name') }}" required>
                    @error('street_name')
                        <p class="shipping__form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="shipping__form-group">
                    <label for="aptNumber" class="shipping__form-label">Broj stana, sprat, ulaz</label>
                    <input type="text" name="apt_number" value="{{ old('apt_number') }}" id="aptNumber" class="shipping__form-input" required>
                    @error('apt_number')
                        <p class="shipping__form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="shipping__form-group">
                    <label for="city" class="shipping__form-label">Grad</label>
                    <input type="text" name="city" value="{{ old('city') }}" id="city" class="shipping__form-input" required>
                    @error('city')
                        <p class="shipping__form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="shipping__form-group-2">
                    <div class="shipping__form-group u-w-40">
                        <label for="country" class="shipping__form-label">Država</label>
                        <select class="shipping__form-select" name="country" id="country" autocomplete="country-name" required>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="shipping__form-group u-w-40">
                        <label for="postalCode" class="shipping__form-label">Poštanski broj</label>
                        <input type="number" name="postal_code" value="{{ old('postal_code') }}" id="postalCode" class="shipping__form-input" autocomplete="postal_code" required>
                    </div>
                    @error('postal_code')
                        <p class="shipping__form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="shipping__form-group">
                    <label for="phoneNumber" class="shipping__form-label">Broj telefona sa pozivnim za državu u kojoj se nalazite</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" id="phoneNumber" class="shipping__form-input" autocomplete="tel" required>
                    @error('phone_number')
                        <p class="shipping__form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="shipping__form-btn-container">
                    <button type="submit" class="btn btn--primary-fill">Sačuvaj</button>
                </div>

            </form>


        </div>




    </section>

    @include('includes.footer')



@endsection
