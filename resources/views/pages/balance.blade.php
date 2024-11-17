<x-main>
    @push('css')
        <style>
            .custom-alert {
                position: relative;
                padding: 1rem 1rem;
                margin-bottom: 1rem;
                border: 1px solid transparent;
                border-radius: .25rem;
                background-color: #cce5ff;
                border-color: #b8daff;
                color: #004085;
            }

            .custom-alert-heading {
                margin-top: 0;
                margin-bottom: .5rem;
                font-size: 1.5rem;
                color: inherit;
            }

            .custom-alert p {
                margin-bottom: 1rem;
            }

            .custom-alert hr {
                border-top-color: #b8daff;
            }

            .custom-alert .mb-0 {
                margin-bottom: 0;
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
                    <h1>Check your balance</h1>
                    <p>Please enter your ICCID below to check your balance.</p>
                </div>

                <div class="products__header__content__search-box">
                    <form action="{{ url('check-balance') }}">
                        <div style="display: flex">
                            <input type="text" name="iccid" value="{{ request()->iccid }}"
                                placeholder="Enter your iccid to check current balance">
                            <button class="btn btn-brand-700">Check Balance</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="" style="display:flex;justify-content:center;gap:10px;">

            @if ($balance)
                @if ($balance['status'] == 'false')
                    <div class="custom-alert">

                        <h3 style="text-align: center">Something went wrong</h3>

                    </div>
                @else
                    <div class="card" style="height: 250px">
                        <h2 class="products__list__title">
                            Balance Information
                        </h2>
                        <br>
                        <ul>
                            <li>
                                <strong> Total data : </strong> {{ $balance['mbTotal'] }} mb
                            </li>
                            <li>
                                <strong> Total used data : </strong> {{ $balance['mbUsed'] }} mb
                            </li>
                            <li>
                                <strong> Total remaining data : </strong> {{ $balance['mbRemaining'] }} mb
                            </li>

                        </ul>
                    </div>
                @endif
            @else
            @endif
        </div>
    </div>








</x-main>
