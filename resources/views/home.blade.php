@extends('layouts.app')

@section('content')
    <div>
        @livewire('hero-section')
        @livewire('featured-products')
        @livewire('benefits-section')
        @livewire('testimonials')
        @livewire('newsletter-signup')
    </div>
@endsection
