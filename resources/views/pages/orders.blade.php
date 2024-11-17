<x-main>

    <link rel="stylesheet" href="{{ asset('css/table.css') }}">





    <div class="account-page">
        <div class="account__header">
            <div class="breadcrumbs">
                <a href="{{ route('home') }}"><img src="{{ asset('/img/icons/home.svg') }}" alt="home"></a>
                <img class="breadcrumbs__arrow breadcrumbs__account-info" src="/img/icons/right-arrow-breadcrumb.svg"
                    alt="arrow">
                <a href="{{ route('show.orders') }}" class="breadcrumbs__account-info">Orders</a>
            </div>
            <div class="account__header__content">
                <div class="account__header__content__texts">
                    <h1>Orders</h1>
                </div>
            </div>
        </div>
        <div class="account">
            <x-acountmanu></x-acountmanu>

            <div class="" style="width: 100%; ">

                @if ($orders->count())

                    <div style="width:95%;overflow:scroll;margin:0px auto">
                        <table class="table">
                            <tr>
                                <th>Plan</th>

                                <th>Travlers</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <p title="{{ $order->plan_information->name }}">
                                            {{ Str::limit($order->plan_information->name, 10) }} </p>
                                    </td>
                                    <td>{{ $order->quantity }} </td>
                                    <td>{{ $order->total }} EUR</td>
                                    <td>
                                        <a href="{{ route('single.order', $order->id) }}" class="btn btn-warning"
                                            style="font-size: 14px">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="account-empty-item-img" style="text-align: center">
                        <img src="{{ asset('/img/panjabis.jpg1.svg') }}">
                    </div>
                    <div class="account-empty-item-content">
                        You don’t have any orders yet.
                        <span>Upon acquiring an eSIM or purchasing a top-up package, your order details will be
                            visible in this section.</span>
                    </div>

                @endif

            </div>


        </div>
    </div>

    <br>



</x-main>
