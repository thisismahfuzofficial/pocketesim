<x-mail::message>
    # Dear {{ $order->name }} ,

    Thank you for choosing our eSim data services. 
    Below are the details of your purchase:



<x-mail::table>
| Order Information : | |
| :------------- | :----------- |
| Plan : | **{{ $order->plan_information->name }}** |
| Coverage : | **{{ $order->plan_information->country->name }}** |
| Data : | **{{ $order->plan_information->data }} MB** |
| ICCID : | **{{ implode(', ', $order->iccid) }}** |
| Unit Price : | **{{ $order->plan_information->price }} EUR** |
| Travlers : | **{{ $order->quantity }}** |
| Total : | **{{ $order->total }} EUR** |

</x-mail::table>


<x-mail::table>
| Qr Codes     |
|:----:|
    @foreach ($order->order_info as $qr)
       | ![{{ $qr }}](https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $qr }}"{{ $qr }}") |
    @endforeach
</x-mail::table>

Thanks,<br>
merr5G
</x-mail::message>
