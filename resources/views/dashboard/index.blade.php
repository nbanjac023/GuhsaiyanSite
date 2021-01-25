@extends('layouts.app')

@section('content')
    <section class="dashboard u-margin-top-xxxl" id="cartToggleArea">
        <div class="container">
            <div class="row">
                <div class="dashboard__navbar col-sm-12 col-md-4 col-lg-4">
                    <ul class="dashboard__navbar-list u-margin-top-m u-margin-bottom-m">
                        <li class="dashboard__navbar-item"><a href="/dashboard/orders" class="dashboard__navbar-link {{ Request::is('dashboard/orders') ? 'u-is-active' : '' }}">Porudžbe</a></li>
                        <li class="dashboard__navbar-item"><a href="/dashboard/payments" class="dashboard__navbar-link {{ Request::is('dashboard/payments') ? 'u-is-active' : '' }}">Plaćanja</a></li>
                        <li class="dashboard__navbar-item"><a href="/dashboard/statistics" class="dashboard__navbar-link {{ Request::is('dashboard/statistics') ? 'u-is-active' : '' }}">Statistika</a></li>
                    </ul>
                </div>
                <div class="dashboard__content col-sm-12 col-md-8 col-lg-8">
                    @yield('dashboard.content')
                </div>
            </div>
            

        </div>



    </section>

    @include('includes.footer')
@endsection

