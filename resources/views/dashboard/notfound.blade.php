@extends('dashboard.index')
@section('title', '- Nema rezultata')
@section('dashboard.content')
<h1 class="dashboard__content-title">{{ $heading }}</h1>


    <h1>{{ $message }}</h1>

    <a href="{{ URL::previous() }}" class="btn btn--primary-fill u-margin-top-m">Nazad</a>


@endsection