{{--  <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>  --}}


@extends('include.header')

@section('content')
    <!-- ====================================
                                                                                                                                                                    ——— CONTENT WRAPPER
                                                                                                                                                                    ===================================== -->
    <div class="content-wrapper">
        <div class="content">
            <!-- Top Statistics -->
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card card-default bg-primary">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-blogger text-primary"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $blogscount }}</span>
                                <p class="text-white">Blogs</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('blogs.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card card-default bg-secondary">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-account-question text-secondary"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $clientReviewscount }}</span>
                                <p class="text-white">Client Reviews</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('clients.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card card-default bg-success">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-account-group text-success"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $employscount }}</span>
                                <p class="text-white">Employees</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('employs.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card card-default bg-info">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-phone-classic text-info"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $contactUsCount }}</span>
                                <p class="text-white">Contact Us</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('contacts.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card card-default bg-danger">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-alpha-q-box text-danger"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $quoteCount }}</span>
                                <p class="text-white">Quotes</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('quotes.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card card-default" style="background-color: #f8da80;">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-alpha-s-box" style="background-color: #f8da80;"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $serviceCount }}</span>
                                <p class="text-white">Services</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('services.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection
