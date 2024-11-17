<x-main>
    @push('css')
        <style>
            @media (max-width: 992px) {
                .footer {
                    margin-bottom: 100px;
                }
            }
        </style>
    @endpush
    <div class="products products-detail">
        <div class="products__header sam" id="headerImg" style="background: url('{{ Storage::url($country->banner) }}'); ">
            <div class="breadcrumbs">
                <a href="{{ url('/') }}" title="Home"><img src="{{ asset('img/icons/home.svg') }}"
                        alt="home"></a>
                <img class="breadcrumbs__arrow" src="{{ asset('img/icons/right-arrow-breadcrumb.svg') }}" alt="arrow">
                <a href="{{ route('show.destinations') }}" title="Destinations">Destinations</a>
                <img class="breadcrumbs__arrow breadcrumbs__arrow__country"
                    src="{{ asset('img/icons/right-arrow-breadcrumb.svg') }}" alt="arrow">
                <div class="breadcrumbs__country">{{ $country->name }}</div>
            </div>
            <div class="detail-card-content">
                <h1 class="country-name">{{ $country->name }} eSIM Packages</h1>
            </div>

        </div>
        <form method="post" action="{{ route('checkout') }}">
            @csrf
            <div class="products-detail-content">
                <h2>{{ $country->name }} Chose Data Plan</h2>
                <div class="card-detail-selection">
                    <div class="card-detail-content">
                        <div class="product-list">
                            @foreach ($plans as $plan)
                                <label class="checkbox js-esimProduct" for="eSim-{{ $plan->id }}">
                                    <label class="checkbox-wrapper">
                                        @if ($plan->salePrice)
                                            <div class="badge">ON SALE</div>
                                        @endif
                                        <input type="radio" class="checkbox-input" name="eSim"
                                            id="eSim-{{ $plan->id }}" value="{{ $plan->id }}"
                                            data-id="{{ $plan->plan_code }}" data-esimCoverage="{{ $country->name }}"
                                            data-esimData="{{ $plan->gb }}"
                                            data-esimValidity="{{ $plan->duration }} Days"
                                            data-esimUnitPrice="{{ $plan->currentPrice() }}" data-esimCurrency="EUR" />
                                        <div class="checkbox-tile">
                                            <div class="checkbox-label">{{ $plan->name }}
                                                <span>{{ $plan->duration }} Days</span></div>
                                            <div class="product-price">
                                                @if ($plan->salePrice)
                                                    <div class="product-price-discount">
                                                        <span class="original-price"
                                                            style="text-decoration: line-through;">{{ $plan->price }}
                                                            EUR</span>
                                                    </div>
                                                    <span class="sale-price">{{ $plan->salePrice }} EUR</span>
                                                @else
                                                    <span>{{ $plan->price }} EUR</span>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                </label>
                            @endforeach

                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ $country->name }} Coverage</h2>
                            <img src="{{ Storage::url($country->flag) }}" style="border-radius: 10px;"
                                alt="{{ $country->name }} flag" />
                        </div>
                        <div class="card-details">
                            <div>
                                <p><i class="icon-pckt-globe"></i> Coverage</p>
                                <p class="js-esimCoverage">-</p>
                            </div>

                            <div>
                                <p><i class="icon-pckt-arrow-up-down"></i> Data</p>
                                <p class="js-esimData">-</p>
                            </div>
                            <div>
                                <p><i class="icon-pckt-calendar"></i> Validity</p>
                                <p class="js-esimValidity">-</p>
                            </div>
                        </div>
                        <div class="card-discount" style="display: none;">
                            <i class="icon-pckt-sparkle"></i>
                        </div>
                        <div class="card-price">
                            <div class="quantity-wrapper">
                                <p>Travellers</p>
                                <div class="qty-input">
                                    <button class="qty-count qty-count--minus" data-action="minus" type="button"><i
                                            class="icon-pckt-minus"></i></button>
                                    <input class="product-qty" type="number" name="quantity" min="1"
                                        max="10" value="1">
                                    <button class="qty-count qty-count--add" data-action="add" type="button"><i
                                            class="icon-pckt-plus"></i></button>
                                </div>
                            </div>
                            <div>
                                <p>Price</p>
                                <div><span class="js-esimUnitPrice">-</span></div>
                            </div>
                            <div>
                                <p>Total Price</p>
                                <div class="total-price">
                                    <div class="total-price-old" style="display: none">
                                        <span>-</span>
                                    </div>
                                    <div class="total-price-current">
                                        <span>-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-bottom-card-detail">
                                <div>
                                    <i class="icon-pckt-arrow-up-down"></i>
                                    <p class="js-esimData">-</p>
                                </div>
                                <div>
                                    <i class="icon-pckt-calendar"></i>
                                    <p class="js-esimValidity">-</p>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-brand-700 js-esimSubmit" style="">Buy
                            Now</button>

                    </div>
                </div>
            </div>
    </div>
    </form>
    <div id="supportedCountries" class="modalDialog modal-xs">
        <div>
            <div class="modal-header">
                <h2>Supported Countries</h2>
                <a href="javascript:;" title="Close" class="close"><i class="icon-pckt-x"></i></a>
            </div>
            <div class="modal-content">
                <div class="search-box-suppoerted-countries">
                    <input type="text" id="countryFilter" placeholder="Search your destination" />
                    <i class="icon-pckt-search search-icon"></i>
                </div>

            </div>
        </div>
    </div>
    <hr style="margin-top: 10px;">
    <x-howitworks></x-howitworks>
    {{-- <x-services></x-services> --}}


</x-main>
