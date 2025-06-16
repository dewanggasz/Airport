<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-logo-section">
                <h3>ADI<span>SUTJIPTO</span></h3>
                <p>{{ __('footer_desc') }}</p>
            </div>
            <div>
                <h4>{{ __('footer_nav_title') }}</h4>
                <nav>
                    <a href="#">{{ __('footer_nav_schedule') }}</a>
                    <a href="#">{{ __('footer_nav_info') }}</a>
                    <a href="#">{{ __('footer_nav_news') }}</a>
                </nav>
            </div>
            <div>
                <h4>{{ __('footer_help_title') }}</h4>
                <nav>
                    <a href="#">{{ __('footer_help_contact') }}</a>
                    <a href="#">{{ __('footer_help_faq') }}</a>
                </nav>
            </div>
            <div>
                 <h4>{{ __('footer_social_title') }}</h4>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} PT Angkasa Pura I. {{ __('footer_copyright') }}</p>
        </div>
    </div>
</footer>
