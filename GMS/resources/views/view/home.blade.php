@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header Navigation -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <header>
                <nav>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('aboutUs') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('service') }}">Services</a></li>
                        <li><a href="{{ route('tyres') }}">Tyres</a></li>
                    </ul>
                </nav>
            </header>
        </div>

        <!-- Vehicle Registration and Make-Year Model Search -->
        <div class="row my-4">
            <div class="col-md-6">
                <h3>Search Vehicle by Registration Number</h3>
                <form action="{{ route('searchVehicle') }}" method="GET">
                    <div class="form-group">
                        <label for="reg_number">Vehicle Registration Number</label>
                        <input type="text" class="form-control" id="reg_number" name="reg_number"
                            placeholder="Enter Registration Number">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="col-md-6">
                <h3>Search by Make, Year, and Model</h3>
                <form action="{{ route('searchByMakeYear') }}" method="GET">
                    <div class="form-group">
                        <label for="make">Make</label>
                        <input type="text" class="form-control" id="make" name="make" placeholder="Enter Make">
                    </div>
                    <div class="form-group">
                        <label for="year">Year</label>
                        <input type="text" class="form-control" id="year" name="year" placeholder="Enter Year">
                    </div>
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" id="model" name="model" placeholder="Enter Model">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Dynamic Services Section -->

    <div class="services-section mt-4">
        <h2>Our Services</h2>
        @include('view.service', ['services' => $services])
    </div>

    <!-- About Garage Section -->
    <section class="">

        <div class="services-section mt-4">
            <h2>About Garage Automation</h2>
            @include('view.about', ['aboutUs' => $aboutUs])
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="mt-4">
        <div class="row">
            <div class="col-md-4">
                <h5>Important Links</h5>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('aboutUs') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('service') }}">Services</a></li>
                    <li><a href="{{ route('tyres') }}">Tyres</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h5>Sitemap</h5>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('aboutUs') }}">About Us</a></li>
                    <li><a href="{{ route('service') }}">Services</a></li>
                    <li><a href="{{ route('tyres') }}">Tyres</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>
    @endsection