@extends('layouts.app')

@section('content')
<div class="schedule-page">
    <div class="container">
        <div class="schedule-title">
            <h1>{{ __('header_schedule') }}</h1>
            <p>{{ __('flights_page_subtitle') }}</p>
        </div>

        {{-- Formulir Filter --}}
        <div class="filter-form-container">
            {{-- Kita ganti <form> menjadi <div> karena akan dikontrol oleh JS --}}
            <div id="filter-form" class="filter-form">
                <div class="form-group search-group">
                    <label for="search">{{ __('filter_search_label') }}</label>
                    <div class="search-input-wrapper">
                        <input type="text" name="search" id="search" placeholder="{{ __('filter_search_placeholder') }}" value="{{ $filters['search'] ?? '' }}" autocomplete="off">
                        @if (!empty($filters['search']))
                            <button class="search-reset-button" id="reset-search-btn" title="Reset Search">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">{{ __('filter_status_label') }}</label>
                    <select name="status" id="status">
                        <option value="">{{ __('filter_status_all') }}</option>
                        <option value="Scheduled" @selected(($filters['status'] ?? '') === 'Scheduled')>Scheduled</option>
                        <option value="On Time" @selected(($filters['status'] ?? '') === 'On Time')>On Time</option>
                        <option value="Delayed" @selected(($filters['status'] ?? '') === 'Delayed')>Delayed</option>
                        <option value="Departed" @selected(($filters['status'] ?? '') === 'Departed')>Departed</option>
                        <option value="Landed" @selected(($filters['status'] ?? '') === 'Landed')>Landed</option>
                        <option value="Cancelled" @selected(($filters['status'] ?? '') === 'Cancelled')>Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="schedule-tabs">
            <button class="tab-button {{ $direction === 'departure' ? 'active' : '' }}" data-direction="departure">
                {{ __('flights_departures') }}
            </button>
            <button class="tab-button {{ $direction === 'arrival' ? 'active' : '' }}" data-direction="arrival">
                {{ __('flights_arrivals') }}
            </button>
        </div>
        
        <div class="tab-loader-container" id="tab-loader">
            <div class="loader-bar"></div>
        </div>

        {{-- Kontainer ini akan diisi ulang oleh AJAX --}}
        <div id="schedule-container">
            @include('partials.flights-table', ['flights' => $flights, 'direction' => $direction])
        </div>
    </div>
</div>
@endsection
