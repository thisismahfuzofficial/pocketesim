@component('mail::message')
# Thank You for Your Order!

Hello,

Thank you for your order! We appreciate your business.

## Order Details
**Order Number:** {{ $order->id }}  
**Order Date:** {{ $order->created_at->format('F j, Y') }}

## Login Information
You can log in to your account using the following credentials:

**Email:** {{ $user->email }}  
**Password:** {{$password}}

@component('mail::button', ['url' => url('/login')])
Login to Your Account
@endcomponent

If you have any questions, feel free to [contact us](mailto:{{setting('site.email')}}).

Thanks,<br>
merr5G
@endcomponent