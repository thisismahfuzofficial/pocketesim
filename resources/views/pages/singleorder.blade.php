{{-- @dd($order) --}}
<x-main>
    <style>
        .single-order {
            padding: 10px
        }

        .iv-title {
            font-size: 25px;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        span {
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">





    <div class="account-page">
        <div class="account__header">
            <div class="breadcrumbs">
                <a href="/en"><img src="/img/icons/home.svg" alt="home"></a>
                <img class="breadcrumbs__arrow breadcrumbs__account-info" src="/img/icons/right-arrow-breadcrumb.svg"
                    alt="arrow">
                <a href="/en/profile/order" class="breadcrumbs__account-info">Orders</a>
            </div>
            <div class="account__header__content">
                <div class="account__header__content__texts">
                    <h1>Orders</h1>
                </div>
            </div>
        </div>
        <div class="account">
            <x-acountmanu></x-acountmanu>

            <div>
                <h2 class="products__list__title" style="text-align: left">
                    Plan Information
                </h2>
               
                <div class="card">
                    <ul>
                        <li><strong>Plan Code :</strong> {{ $order->plan_information->plan_code }}</li>
                        <li><strong>Plan Name :</strong> {{ $order->plan_information->name }}</li>
                        <li><strong>Data :</strong> {{ $order->plan_information->data }}</li>
                        <li><strong>Duration :</strong> {{ $order->plan_information->duration }} Days</li>
                        <li>
                            <strong>Country :</strong> {{ $order->plan_information->country->name }} ({{ $order->plan_information->country->code }})
                        </li>
                    </ul>
                </div>
                
                <h2 class="products__list__title" style="text-align: left">
                    QR Codes
                </h2>
                <br>
                <div style="display: flex;gap:10px;flex-wrap:wrap;">
                    @foreach ($order->order_info as $key => $item)
                        <div class="card" style="border: 4px solid #000;width:auto;">

                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={!! $item !!}"
                                alt="QR Code" style=" height:150px;width:150px;margin:0px auto;">
                            <p style="margin:0px auto;">Iccid: {{ $order->iccid[$key] }}</p>
                        </div>
                    @endforeach
                </div>
                {{-- <table class="table">
                        <tr>
                            <td>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={!! $item !!}"
                                    alt="QR Code" style=" height:150px;width:150px">
                            </td>
                            <td>
                                <p>Iccid: {{ $order->iccid[$key] }}</p>
                                <br>
                                <a class="btn btn-brand-700" href="">Check Balance</a>
                            </td>
                        </tr>
                </table> --}}
            </div>
        </div>

        </ul>
    </div>


    </div>
    </div>

    <br>



</x-main>
