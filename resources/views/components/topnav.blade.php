{{-- custom function  --}}
<?php
$countries = App\Models\Country::all();
?>

<nav class="nav">
    <div class="nav__left">
        <a href="{{ route('home') }}" class="logo" title="merr5G"><img src="{{ asset('img/image/main-logo.png') }}"></a>

        <ul class="nav-links">
            <i class="uil uil-times navCloseBtn"></i>
            @foreach (menu('frontend', '_json') as $item)
                <li><a href="{{ $item->link() }}" title="{{ $item->title }}">{{ $item->title }}</a></li>
            @endforeach
        </ul>
    </div>



    <div class="nav__right">
        <div class="nav__right__btns">

            @guest
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-brand-outlined-700" title="Log In">Kyçu</a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-brand-700" title="Sign Up">Regjistrohu</a>
                @endif
            @else
                <div class="nav__right__btns">

                    <div class="popover">
                        <a href="javascript:;" class="btn btn-brand-700 header-user-btn popover__trigger" title="merr5G">
                            <i class="icon-pckt-hamburger-menu"></i>
                            <div class="mobile-user-menu-avatar">
                                {{ auth()->user()->firstLatter() }}
                            </div>
                        </a>
                        <ul class="popover__menu">
                            <div class="mobile-user-menu">
                                <a href="{{ route('show.profile') }}" class="mobile-user-menu-top js-mobile-account">
                                    <div class="mobile-user-menu-info">
                                        <div class="mobile-user-menu-avatar">
                                            {{ auth()->user()->firstLatter() }}
                                        </div>
                                        <dive class="mobile-user-menu-name" style="text-transform: capitalize">
                                            {{ Auth::user()->name }}
                                            <span></span>
                                        </dive>
                                    </div>
                                </a>

                            </div>
                            <li class="popover__menu-item"><a href="{{ route('show.profile') }}"
                                    title="Account Information"><i class="icon-pckt-user"></i>Informatat</a></li>

                            <li class="popover__menu-item"><a href="{{ route('show.orders') }}" title="Orders"><i
                                        class="icon-pckt-orders"></i> Porositë</a></li>
                            <li class="popover__menu-item"><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"
                                    title="Logout"><i class="icon-pckt-logout"></i> Dil</a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- <a href="" class="fw-bold ">{{ Auth::user()->name }}</a>


                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a> --}}

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>


            @endguest
        </div>
    </div>

    <div id="hamburger">
        <div class="line" id="one"></div>
        <div class="line" id="two"></div>
        <div class="line" id="three"></div>
    </div>
    <div class="mobile-menu">
        <div class="mobile-menu">
            <div class="mobile-menu__items">
                <div class="search-box-mobile">
                    <form id="searchForm" action="{{ route('search.destinations') }}">
                        <i class="icon-pckt-search search-icon"></i>
                        <input type="text" id="search" name="q"
                            placeholder="Kërkoni destinacionin" autocomplete="off"
                            value="{{ request()->q }}">
                        <i class="icon-pckt-x-circle close-search" role="presentation"></i>
                        <ul id="searchResult"></ul>
                    </form>
                </div>

                <div class="nav__right__btns">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-brand-outlined-700" title="Log In">Kyçu</a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-brand-700" title="Sign Up">Regjistrohu</a>
                        @endif
                    @else
                    </div>



                    <div class="mobile-user-menu">
                        <a href="{{ route('show.profile') }}" class="mobile-user-menu-top js-mobile-account">
                            <div class="mobile-user-menu-info">
                                <div class="mobile-user-menu-avatar">
                                    {{ auth()->user()->firstLatter() }}</div>
                                <div class="mobile-user-menu-name " style="text-transform: capitalize">
                                    {{ Auth::user()->name }}

                                </div>
                            </div>
                        </a>
                    </div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"
                        title="Logout" class="btn btn-brand-outlined-700 header-my-eSims-btn m-header-esims-btn">Dil<i
                            class="icon-pckt-logout"></i></a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                @endguest

                <div class="mobile-menu-links">
                    <ul class="">
                    @foreach (menu('frontend', '_json') as $item)
                <li class=""><a href="{{ $item->link() }}"  title="{{ $item->title }}">{{ $item->title }}</a></li>
                <br><br>
            @endforeach
        </ul>
                </div>
            </div>

        </div>
    </div>
</nav>
@push('javascript')
<script>
      const contrysearchapiMain = "{{ route('api.countries.search') }}";

    $(document).ready(function() {
        $("#search").keyup(function() {
            let query = $('#search').val();
            if (query.length >= 3) {
                fetch(contrysearchapiMain + '?q=' + query) // API for the GET request
                    .then(response => response.json())
                    .then(data => populateSugesstionMain(data));
            } else {
                $('#searchResultMain').css('display', 'none');
                $('#searchResultMain').html('');
            }
        })
    })

    const populateSugesstionMain = countries => {
        $('#searchResult').html('');
        if (countries.length > 0) {
            $('#searchResult').css('display', 'flex');
            console.log(countries.length);
        } else {
            $('#searchResult').css('display', 'none');
        }
        countries.forEach(country => {
            $('#searchResult').append(
                `<li><a href="${country.link}"><img src="${country.flag}"> ${country.name}</a></li>`
            );
        });
    }
</script>
@endpush
