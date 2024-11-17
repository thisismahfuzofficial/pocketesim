<div class="products__regions">
    @foreach ($regions as $region)
        <?php
        $regioncount = App\Models\Plan::where('country_id', $region->id)->count();
        ?>
        <a href="{{ route('show.products', $region) }}" title="{{ $region->name }} eSIM">
            <div class="products__regions__name">
                <div class="products__regions__info">
                    <img src="{{ asset('img/icons/regions/south-america.svg') }}"
                        alt="{{ $region->name }} eSIM">
                    <div>
                        <h3>{{ $region->name }}</h3>
                        <span>{{$regioncount}} Plans</span>
                    </div>
                </div>
                <i class="icon-pckt-right-arrow"> </i>
            </div>
            
        </a>
        
    @endforeach

</div>