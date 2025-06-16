{{-- Header untuk Desktop (Akan disembunyikan di mobile) --}}
<header id="main-header" class="main-header {{ !request()->routeIs('home') ? 'is-solid' : '' }}">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            ADI<span>SUTJIPTO</span>
        </a>
        <div class="nav-wrapper">
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('header_home') }}</a>
                <div class="nav-item has-megamenu">
                    <a href="#" class="nav-link" id="mega-menu-trigger">{{ __('header_flights') }}</a>
                    <div class="mega-menu">
                        <div class="mega-menu-content">
                           <a href="{{ route('flights.index') }}" class="mega-menu-item">
                               <h4>{{ __('header_schedule') }}</h4>
                               <p>{{ __('Lihat jadwal kedatangan & keberangkatan.') }}</p>
                           </a>
                           <a href="{{ route('airlines.index') }}" class="mega-menu-item">
                               <h4>{{ __('header_airlines') }}</h4>
                               <p>{{ __('Lihat daftar maskapai yang beroperasi.') }}</p>
                           </a>
                           <a href="{{ route('airport-guide') }}" class="mega-menu-item">
                               <h4>{{ __('header_airport_guide') }}</h4>
                               <p>{{ __('Panduan praktis untuk perjalanan Anda.') }}</p>
                           </a>
                        </div>
                    </div>
                </div>
                <a href="#">{{ __('header_transport') }}</a>
                <a href="#">{{ __('header_news') }}</a>
                <a href="#">{{ __('header_contact') }}</a>
            </nav>
            <div class="lang-switcher">
                <div class="lang-selected">
                    @if(app()->getLocale() == 'id')
                        <img src="{{ asset('assets/flags/id.svg') }}" width="24" alt="Bendera Indonesia">
                    @elseif(app()->getLocale() == 'en')
                        <img src="{{ asset('assets/flags/gb.svg') }}" width="24" alt="Bendera Inggris">
                    @elseif(app()->getLocale() == 'pt')
                         <img src="{{ asset('assets/flags/pt.svg') }}" width="24" alt="Bendera Portugal">
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </div>
                <ul class="lang-options">
                    <li><a href="{{ route('lang.switch', 'pt') }}"><img src="{{ asset('assets/flags/pt.svg') }}" width="20" alt="Bendera Portugal"> Português</a></li>
                    <li><a href="{{ route('lang.switch', 'en') }}"><img src="{{ asset('assets/flags/gb.svg') }}" width="20" alt="Bendera Inggris"> English</a></li>
                    <li><a href="{{ route('lang.switch', 'id') }}"><img src="{{ asset('assets/flags/id.svg') }}" width="20" alt="Bendera Indonesia"> Indonesia</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>



{{-- Navigasi Bawah untuk Mobile & Tablet --}}
<div class="mobile-bottom-nav">
    <a href="{{ route('home') }}" class="nav-action {{ request()->routeIs('home') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>{{ __('header_home') }}</span>
    </a>
    <a href="{{ route('flights.index') }}" class="nav-action {{ request()->is('flights*') || request()->is('airlines*') || request()->is('airport-guide*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        <span>{{ __('header_flights') }}</span>
    </a>
    <a href="#" class="nav-action">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><path d="M7 17h10"/><path d="M6 17H4a2 2 0 0 0-2 2v1h16v-1a2 2 0 0 0-2-2h-2"/><path d="M10 17v-1.1"/><path d="M14 17v-1.1"/><circle cx="6" cy="11.5" r="1.5"/><circle cx="18" cy="11.5" r="1.5"/></svg>
        <span>{{ __('header_transport') }}</span>
    </a>
    <button class="nav-action" id="mobile-menu-toggle">
        <div class="hamburger-icon-wrapper">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <span>Menu</span>
    </button>
</div>


{{-- Menu Overlay Fullscreen --}}
<div class="mobile-menu-overlay" id="mobile-menu-overlay">
    <div class="mobile-menu-header">
         <a href="{{ route('home') }}" class="logo">ADI<span>SUTJIPTO</span></a>
         {{-- ↓↓↓ Tambahkan Language Switcher di sini ↓↓↓ --}}
         <div class="offcanvas-lang-switcher">
            <a href="{{ route('lang.switch', 'pt') }}" class="{{ app()->getLocale() == 'pt' ? 'active' : '' }}">
                <img src="{{ asset('assets/flags/pt.svg') }}" width="28" alt="Bendera Portugal">
            </a>
            <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
                <img src="{{ asset('assets/flags/gb.svg') }}" width="28" alt="Bendera Inggris">
            </a>
            <a href="{{ route('lang.switch', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'active' : '' }}">
                <img src="{{ asset('assets/flags/id.svg') }}" width="28" alt="Bendera Indonesia">
            </a>
         </div>
    </div>
    {{-- ↓↓↓ KONTEN MENU MOBILE DITAMBAHKAN KEMBALI ↓↓↓ --}}
    <nav class="mobile-nav">
        <a href="{{ route('home') }}" class="mobile-nav-link">{{ __('header_home') }}</a>
        <div class="mobile-accordion">
            <button class="mobile-accordion-toggle">
                <span class="mobile-nav-link">{{ __('header_flights') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
            </button>
            <div class="mobile-accordion-content">
                <a href="{{ route('flights.index') }}" class="sub-link">{{ __('header_schedule') }}</a>
                <a href="{{ route('airlines.index') }}" class="sub-link">{{ __('header_airlines') }}</a>
                <a href="{{ route('airport-guide') }}" class="sub-link">{{ __('header_airport_guide') }}</a>
            </div>
        </div>
        <a href="#" class="mobile-nav-link">{{ __('header_transport') }}</a>
        <a href="#" class="mobile-nav-link">{{ __('header_news') }}</a>
        <a href="#" class="mobile-nav-link">{{ __('header_contact') }}</a>
    </nav>
    {{-- ↑↑↑ AKHIR KONTEN MENU MOBILE ↑↑↑ --}}
</div>
