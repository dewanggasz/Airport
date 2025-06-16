@extends('layouts.app')

@section('content')
<div class="homepage">

    {{-- 1. HERO SECTION --}}
    <section class="hero-v2">
        <div class="hero-v2-background">
            <img  src="{{ asset('assets/t.PNG') }}" class="hero-v2-bg-image">
        </div>
        <div class="hero-v2-content">
            <div class="container hero-container">
                <h1 class="hero-main-title">
                    <span class="line"><span>Gerbang Anda Menuju</span></span>
                    <span class="line"><span>Jantung Timor-Leste</span></span>
                </h1>
                <div class="hero-flight-finder">
                    <form action="{{ route('flights.index') }}" method="GET" class="finder-form-v2">
                        <div class="icon-wrapper">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari no. penerbangan atau kota tujuan...">
                        <button type="submit">CARI</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="hero-scroll-down">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
        </div>
    </section>

     {{-- 2. LIVE FLIGHTS TICKER --}}
    <section class="live-flights-section">
        <div class="container">
            <div class="live-flights-grid">
                <div class="flight-ticker" id="departures-ticker">
                    <h3>Keberangkatan Berikutnya</h3>
                    {{-- Data ini diasumsikan datang dari controller --}}
                    @if(isset($upcomingDepartures) && $upcomingDepartures->count() > 0)
                        @foreach($upcomingDepartures as $flight)
                        <div class="ticker-item">
                            <span class="time">{{ $flight->scheduled_time->format('H:i') }}</span>
                            <span class="city">{{ $flight->city }}</span>
                            <span class="flight-no">{{ $flight->flight_number }}</span>
                            <span class="status-dot status-{{ strtolower($flight->status) }}"></span>
                        </div>
                        @endforeach
                    @else
                         <div class="ticker-item-empty">Tidak ada jadwal keberangkatan berikutnya.</div>
                    @endif
                </div>
                <div class="flight-ticker" id="arrivals-ticker">
                    <h3>Kedatangan Berikutnya</h3>
                     @if(isset($upcomingArrivals) && $upcomingArrivals->count() > 0)
                        @foreach($upcomingArrivals as $flight)
                        <div class="ticker-item">
                            <span class="time">{{ $flight->scheduled_time->format('H:i') }}</span>
                            <span class="city">{{ $flight->city }}</span>
                            <span class="flight-no">{{ $flight->flight_number }}</span>
                            <span class="status-dot status-{{ strtolower($flight->status) }}"></span>
                        </div>
                        @endforeach
                    @else
                        <div class="ticker-item-empty">Tidak ada jadwal kedatangan berikutnya.</div>
                    @endif
                </div>
            </div>
            <div class="ticker-footer">
                <a href="{{ route('flights.index') }}" class="cta-link">Lihat Semua Jadwal &rarr;</a>
            </div>
        </div>
    </section>

    {{-- 3. JOURNEY GUIDE SECTION --}}
    <section class="journey-guide-section">
        <div class="container">
            <div class="journey-steps">
                <a class="journey-step item1">
                    <img src="{{ asset('assets/tanushree-rao-TM_el_7jNqk-unsplash.jpg') }}" alt="">
                    <div class="step-content">
                        <span class="step-number">01</span>
                        <h4>Informasi Penerbangan</h4>
                    </div>
                </a>
                <a class="journey-step item2">
                    <img src="{{ asset('assets/john-mcarthur-X_MOr6oa4-k-unsplash.jpg') }}" alt="">
                    <div class="step-content">
                        <span class="step-number">02</span>
                        <h4>Informasi Maskapai</h4>
                    </div>
                </a>
                <a class="journey-step item3">
                    <img src="{{ asset('assets/jay-wennington-N_Y88TWmGwA-unsplash.jpg') }}" alt="">
                    <div class="step-content">
                        <span class="step-number">03</span>
                        <h4>Kuliner</h4>
                    </div>
                </a>
                <a class="journey-step item4">
                    <img src="{{ asset('assets/heidi-fin-2TLREZi7BUg-unsplash.jpg') }}" alt="">
                    <div class="step-content">
                        <span class="step-number">04</span>
                        <h4>Belanja</h4>
                    </div>
                </a>
                <a class="journey-step item5">
                    <img src="{{ asset('assets/kelly-sikkema-RiUZQOfQ8XE-unsplash.jpg') }}" alt="">
                    <div class="step-content">
                        <span class="step-number">05</span>
                        <h4>Imigrasi</h4>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- 4. TRANSPORT HUB SECTION --}}
    <section class="transport-hub-section">
        <div class="container transport-container">
            <div class="transport-options">
                <a href="#" class="transport-option one">
                    <div class="transport-icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><path d="M7 17h10"/><path d="M6 17H4a2 2 0 0 0-2 2v1h16v-1a2 2 0 0 0-2-2h-2"/><path d="M10 17v-1.1"/><path d="M14 17v-1.1"/><circle cx="6" cy="11.5" r="1.5"/><circle cx="18" cy="11.5" r="1.5"/></svg>
                    </div>
                    <span>Taksi</span>
                </a>
                 <a href="#" class="transport-option two">
                    <div class="transport-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 20 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </div>
                    <span>Bus</span>
                </a>
                 <a href="#" class="transport-option three">
                    <div class="transport-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16.5V8.28a2.26 2.26 0 0 0-1.72-2.2L6.15 4.91a2.26 2.26 0 0 0-2.33 2.2V18a2 2 0 0 0 2 2h10.38a2.26 2.26 0 0 0 2.33-2.2v-.93a2.26 2.26 0 0 0-1.72-2.2z"/><path d="M6.15 4.91a2.25 2.25 0 0 1 2.33-2.2h.02a2.25 2.25 0 0 1 2.25 2.25v0"/><path d="M18 10.3V4a2 2 0 0 0-2-2h-2"/><path d="M7 15h4"/><path d="M7 11h7"/></svg>
                    </div>
                    <span>Sewa Mobil</span>
                </a>
                 <a href="#" class="transport-option four">
                    <div class="transport-icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a8 8 0 1 0 0 16 8 8 0 1 0 0-16z"/><path d="M12 18a7.4 7.4 0 0 0 5-2.5"/><path d="M12 6v6h6"/></svg>
                    </div>
                    <span>Parkir</span>
                </a>
            </div>
        </div>
    </section>

    {{-- 5. NEWS SECTION --}}
    <section class="news-section-home">
        <div class="container">
            <div class="news-header">
                <h2 class="section-heading">Info Terkini dari Bandara</h2>
                <a href="#" class="cta-link mobile-hidden">Lihat Semua Berita &rarr;</a>
            </div>
            <div class="news-grid-home">
                @forelse($latestNews as $news)
                    <a href="#" class="news-card-v2">
                        <div class="news-card-image">
                             <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}">
                        </div>
                        <div class="news-card-content">
                            <span class="news-date">{{ $news->published_at->translatedFormat('d F Y') }}</span>
                            <h4>{{ $news->title }}</h4>
                        </div>
                    </a>
                @empty
                    <p>Belum ada berita untuk ditampilkan.</p>
                @endforelse
            </div>
             <div class="view-all-news-mobile">
                <a href="#" class="cta-link">Lihat Semua Berita &rarr;</a>
            </div>
        </div>
    </section>

</div>
@endsection
