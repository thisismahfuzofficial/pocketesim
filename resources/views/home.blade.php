<x-main>
    <div class="homepage">
        <div class="products">
            <div class="products__header">
                <div class="products__header__content">
                    <div class="products__header__content__texts">
                        <h1 style="display: none;">merr5G eSIM</h1>
                        <img src="{{ asset('img/home/right-hero.png') }}" class="header-woman-img" alt="merr5G eSIM" />
                        <h2>LIDHUNI EKSPLORONI PËRJETONI</h2>
                        <div class="header-slogan">
                           

                            <p>merr5G eSIM ju mundëson të jeni gjithmonë të lidhur gjatë aventurave tuaja, pa u shqetësuar për shpenzimet e larta të roaming.</p>
                        </div>
                        <img src="{{ asset('img/home/left-hero.png') }}" class="header-man-img" alt="merr5G eSIM" />
                    </div>
                    <div class="products__header__content__search-box">
                        <div class="products__header__content__search-box">
                            <x-search></x-search>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products__tab">
                <ul class="tabs-nav">
                    <li><a class="tab-btn tab-active" data-target="tab-esim-country-home"
                            data-tab="home-esim-tab">Top shtetet</a></li>
                    <li><a class="tab-btn" data-target="tab-esim-regional-home" data-tab="home-esim-tab">Pakot regjionale</a></li>

                </ul>
                <div class="tabs-stage">
                    <div id="tab-esim-country-home" data-set="9" class="tabs-stage__list">
                        <h2 class="products__list__title">Top shtetet</h2>

                        <x-localsim :countries="$countries" />
                        <a href="{{ route('show.destinations') }}" class="btn btn-brand-700"
                            title="View All Destinations">
                            Destinacionet</a>
                    </div>
                    <div id="tab-esim-regional-home" data-set="9" class="tabs-stage__list" style="display:none">
                        <h2 class="products__list__title">Pakot regjionale</h2>
                        <x-regional :regions="$regions"/>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <x-howitworks></x-howitworks>
    <x-services></x-services>
    <x-faq :faqs="$faqs"></x-faq>
</x-main>
