@extends('admin.layouts.app')

@section('htmlheader_title') {{ __('Dashboard') }} @endsection

@section('main-content')
<header class="PageHeader">
	<h1 class="PageTitle"> {{ __('Dashboard') }} </h1>
</header>
@push('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/bootstrap.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/animate.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/font-awesome.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/icon.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/font.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/app.css') }}"/>
@endpush

<section class="vbox">
    <section class="hbox stretch">
        <section id="content">
            <section class="hbox stretch">
                <section>
                    <section class="vbox">
                        
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>

@endsection
