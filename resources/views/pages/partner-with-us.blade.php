<x-main>
    <div class="account__header">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}"></a>
            <img class="breadcrumbs__arrow breadcrumbs__account-info"
                src="{{ asset('img/icons/right-arrow-breadcrumb.svg') }}" alt="arrow">
            <a href="{{ route('show.partner.us') }}" class="breadcrumbs__account-info">Partner with Us</a>
        </div>
        <div class="account__header__content">
            <div class="account__header__content__texts">
                <h1>Partner with Us</h1>
            </div>
        </div>
    </div>
    <div class="static-pages-content partner-with-us">
        <div class="partner-with-us-content">
            <div class="partner-detail">
                <i class="icon-pckt-users-three"></i>
                <h3>Affiliate Partners</h3>
                <a href="#">Coming Soon</a>
            </div>
            <div class="partner-detail">
                <i class="icon-pckt-cloud"></i>
                <h3>API Partners</h3>
                <a href="#">Coming Soon</a>
            </div>
            <div class="partner-detail">
                <i class="icon-pckt-handshake"></i>
                <h3>Partner Platform</h3>
                <a href="#">Coming Soon</a>
            </div>
        </div>
        <div class="partner-with-us-contact">
            <div class="partner-detail">
                <i class="icon-pckt-chat"></i>
                <h3>merr5G for Corporates for inquiries</h3>
                <a href="mailto:info@merr5G.com" class="mail-btn">info@merr5G.com</a>
            </div>
        </div>
    </div>



    {{-- <x-appdownload></x-appdownload> --}}
    {{-- <x-faq :faqs="$faqs"></x-faq> --}}
</x-main>
