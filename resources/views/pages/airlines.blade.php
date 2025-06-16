@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="container">
        <div class="page-title">
            <h1>{{ __('Daftar Maskapai') }}</h1>
            <p>{{ __('Maskapai yang beroperasi di bandara kami.') }}</p>
        </div>
        <div class="airline-grid">
            @foreach($airlines as $airline)
                <div class="airline-card">
                    @if($airline->logo)
                        <img src="{{ Storage::url($airline->logo) }}" alt="Logo {{ $airline->name }}">
                    @else
                        <div class="logo-placeholder">{{ substr($airline->name, 0, 1) }}</div>
                    @endif
                    <h3>{{ $airline->name }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
