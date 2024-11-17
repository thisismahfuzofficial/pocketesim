<x-main>
    @push('css')
        <style>
            .d-flex {
                display: flex;
            }

            .justify-items-center {
                justify-content: center;
            }

            .justify-content-between {
                justify-content: space-between;
            }

            .pagination {
                display: flex;
                margin-top: 20px;
            }

            .d-sm-none {
                display: none;
            }

            .page-item .page-link {
                color: #007bff;
                /* Primary color for links */
                border: 1px solid #dee2e6;
                /* Border for links */
                margin: 0 2px;
                /* Space between page links */
                transition: background-color 0.3s, color 0.3s;
                /* Smooth transition for background and color */
            }

            .page-item:hover .page-link {
                background-color: #e9ecef;
                /* Hover background color */
            }

            .page-item.active .page-link {
                background-color: #007bff;
                /* Background color for active page */
                color: white;
                /* Text color for active page */
                border-color: #007bff;
                /* Border color for active page */
            }

            .page-item.disabled .page-link {
                color: #6c757d;
                /* Disabled link color */
            }

            .page-item:first-child .page-link {
                border-top-left-radius: 0.25rem;
                /* Rounded corners for first link */
                border-bottom-left-radius: 0.25rem;
                /* Rounded corners for first link */
            }

            .page-item:last-child .page-link {
                border-top-right-radius: 0.25rem;
                /* Rounded corners for last link */
                border-bottom-right-radius: 0.25rem;
                /* Rounded corners for last link */
            }

            .page-link {
                display: flex;
                /* Flexbox for aligning items */
                align-items: center;
                /* Center align items vertically */
                justify-content: center;
                /* Center align items horizontally */
                width: 40px;
                /* Fixed width for pagination links */
                height: 40px;
                /* Fixed height for pagination links */
            }
        </style>
    @endpush
    <div class="products">
        <div class="products__header">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}"><img src="../img/icons/home.svg" alt="home" /></a>
                <img class="breadcrumbs__arrow" src="../img/icons/right-arrow-breadcrumb.svg" alt="arrow" />
                <a href="{{ route('show.destinations') }}">Destinations</a>
            </div>
            <div class="products__header__content">
                <div class="products__header__content__texts h1">
                    <h1>Search a Destination</h1>
                    <p>Discover and purchase top-tier prepaid eSIMs online for your travels. Connect to the
                        internet within minutes in over 160 destinations worldwide, with unlimited data in
                        Europe, Mexico, China, Türkiye, Japan, and the United States.</p>
                </div>
                <style>
                    .products__header__content #searchResult li {
                        display: flex;
                    }

                    .products__header__content #searchResult div {
                        display: flex;
                    }
                </style>
                <div class="products__header__content__search-box">
                    <x-search />
                </div>
            </div>
        </div>
        <div class="products__tab">
            <ul class="tabs-nav">
                <li><a class="tab-btn tab-active" data-target="tab-esim-country-home" data-tab="home-esim-tab">Popular
                        eSIMs</a></li>
                <li><a class="tab-btn" data-target="tab-esim-regional-home" data-tab="home-esim-tab">Regional
                        eSIMs</a></li>

            </ul>
            <div class="tabs-stage">
                <div id="tab-esim-country-home" data-set="9" class="tabs-stage__list">
                    <h2 class="products__list__title">Popular eSIMs</h2>

                    <div class="tabs-stage">
                        <div class="products__list">
                    @foreach ($countries as $country)
                        <a href="{{ route('show.products', $country) }}" title=Turkey eSIM">
                            <div class="products__list__countries">
                                <div class="products__list__countries__name">

                                    <img src="{{ Storage::url($country->flag) }}" alt="Turkey eSIM"
                                        onerror="this.onerror=null;this.src='https://cdn.pocketesim.com/img/icons/flags/default-flag.svg';">
                                    <div class="products__list__countries__info" title="Turkey eSIM">
                                        <h3>{{ $country->name }}</h3>
                                        <span>
                                            From <span
                                                class='products__list__countries__info__price'>{{ $country->startAt }}</span>
                                            EUR
                                        </span>
                                    </div>
                                </div>
                                <i class="icon-pckt-right-arrow"> </i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
                    @if (request()->filled('view') == false)
                        <a href="{{ route('show.destinations', ['view' => 'all']) }}">Shiko më shumë</a>
                    @endif
                </div>
                <div id="tab-esim-regional-home" data-set="9" class="tabs-stage__list" style="display:none">
                    <h2 class="products__list__title">Regional eSIMs</h2>
                    <x-regional :regions="$regions" />
                </div>

            </div>
        </div>
       
    </div>
    <x-howitworks />







</x-main>
