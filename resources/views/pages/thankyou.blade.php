<x-main>
    @push('css')
    <style>
        .text-center{
            display: block;
            width: 50%;
            margin: 0 auto;
            text-align: center;
        }
        .thank-you{
            margin: 50px 0 60px;
        }
        .ty-title{
            font-family: 'Brush Script MT', cursive;
            font-size: 70px
        }
        .ty-text{
            font-family: 'Trebuchet MS', sans-serif;
            margin-top: 10px;
        }
        .ty-image{
            margin: 30px auto 20px;
            height: 150px;
            width: 150px;
        }
        
            </style>     
    @endpush

    <div class="thank-you mb-3">
        <h2 class="text-center ty-title">
            Thank you
        </h2>
        <i class="text-center ty-text">Thank you for your purchase from our website. You will receive an email shortly with your invoice and product details.</i>
        <img src="{{asset('img/image/checked.png')}}" alt="" class="text-center ty-image">
        <p class="text-center   ">Check your Email</p>
        <p class="text-center   ">If you didn'n recive any email please contact <a href="" class="">{{setting('site.email')}}</a></p>
       </div>
</x-main>