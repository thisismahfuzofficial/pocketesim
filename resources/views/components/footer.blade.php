<?php
$countries = App\Models\Country::topCountries()->get();
?>
<footer class="footer">
    <div class="container">
        <div class="footer__addr">
            <div class="footer__logo"><a href="{{ route('home') }}"><img src="{{ asset('img/image/main-logo.png') }}"
                        alt="merr5G" /></a></div>
            <p>
                Shijoni çdo pjesë të udhëtimeve tuaja.
            </p>
            <div class="footer__social-media">

                <a href="#" target="_blank">
                    <i class="icon-pckt-facebook"></i>
                </a>

                <a href="#" target="_blank">
                    <i class="icon-pckt-instagram"></i>
                </a>
            </div>
        </div>

        <ul class="footer__nav">
            <li class="nav__item">
                <h2 class="nav__title">Top shtetet</h2>

                <ul class="nav__ul">
                    @foreach ($countries as $country)
                        <li>
                            <a href="{{ route('show.products', $country) }}">{{ $country->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>

            <li class="nav__item">
                <h2 class="nav__title">merr5G</h2>

                <ul class="nav__ul">
                    @foreach (menu('frontend', '_json') as $item)
                        <li><a href="{{ $item->link() }}" title="{{ $item->title }}">{{ $item->title }}</a></li>
                    @endforeach

                </ul>
            </li>
        </ul>
    </div>
</footer>
