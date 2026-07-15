@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="cover" style="padding: 5px;">
    <div style="margin: 30px;">
        <img src="{{ asset('images/logo/DSWD STB Bagong Pil logo.png')}}" alt="STBSRS logo" class="img-fluid" style="max-width: 400px; height: auto;">
    </div>

    <div style="margin-left:35px; margin-top:100px;">
        <h3 class="text-dark" style="font-size: 2.0rem;">
            How can we help you today?
        </h3>
        <p class="text-muted" style="font-size: 1rem; max-width: 600px;">
            Welcome to the STB Service Request System! We make it easy for you to request assistance or get information.
        </p>
    </div>
</div>
@endsection