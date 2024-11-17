<div class="tabs-stage">
    <div class="products__list">
        @foreach ($countries as $country)
            <a href="{{ route('show.products', $country) }}" title="{{ $country->name }} eSIM">
                <div class="products__list__countries">
                    <div class="products__list__countries__name">
                        <img src="{{ Storage::url($country->flag) }}" alt="{{ $country->name }} eSIM">
                        <div class="products__list__countries__info" title="{{ $country->name }} eSIM">
                            <h3>{{ $country->name }}</h3>
                            <span>
                                From <span class='products__list__countries__info__price'>{{ $country->startAt}}</span>
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
