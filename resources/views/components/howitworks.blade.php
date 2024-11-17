@section('css')
    <style>
.how-to-image{
    height: 600px;
}
    </style>
@endsection
<div class="how-pocket-esim">
    <div class="how-pocket-esim-left">
        <h2>Aktivizimi i eSIM në iPhone</h2>
        <div class="how-pocket-esim-tabs">
            <ul class="tabs-nav">
                <li data-target="tab-how-data-plan" data-tab="home-faq-tab" class="tab-btn how-pocket-esim-tab-item">
                    <i data-target="tab-how-data-plan" data-tab="home-faq-tab" class="icon-pckt-gear"></i>
                    <div class="how-pocket-esim-item-title" data-target="tab-how-data-plan" data-tab="home-faq-tab">
                        <h3 data-target="tab-how-data-plan" data-tab="home-faq-tab">Hapi i parë</h3>
                        <p data-target="tab-how-data-plan" data-tab="home-faq-tab">Shkoni tek Settings dhe pastaj tek Mobile Data</p>
                    </div>
                </li>
                <li data-target="tab-how-install-esim" data-tab="home-faq-tab" class="tab-btn how-pocket-esim-tab-item">
                    <i data-target="tab-how-install-esim" data-tab="home-faq-tab" class="icon-pckt-sim-card"></i>
                    <div data-target="tab-how-install-esim" data-tab="home-faq-tab" class="how-pocket-esim-item-title">
                        <h3 data-target="tab-how-install-esim" data-tab="home-faq-tab">Hapi i dytë</h3>
                        <p data-target="tab-how-install-esim" data-tab="home-faq-tab">Zgjedheni opsionin Add eSIM</p>
                    </div>
                </li>
                <li data-target="tab-how-your-plan" data-tab="home-faq-tab" class="tab-btn how-pocket-esim-tab-item">
                    <i data-target="tab-how-your-plan" data-tab="home-faq-tab" class="icon-pckt-qr-code"></i>
                    <div data-target="tab-how-your-plan" data-tab="home-faq-tab" class="how-pocket-esim-item-title">
                        <h3 data-target="tab-how-your-plan" data-tab="home-faq-tab">Hapi i tretë</h3>
                        <p data-target="tab-how-your-plan" data-tab="home-faq-tab">Skanoni kodin QR që ju është dërguar në email</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="how-pocket-esim-right">
        <div class="tabs-stage">
            <div id="tab-how-data-plan" data-set="12" class="tabs-stage__list js-slider-img">
                <img class="how-pocket-img  how-to-image" src="{{asset('img/image/how-to-1.png')}}" alt="Buy a data plan" />
            </div>
            <div id="tab-how-install-esim" data-set="12" class="tabs-stage__list js-slider-img" style="display:none">
                <img class="how-pocket-img how-to-image" src="{{asset('img/image/how-to-2.png')}}" alt="Install the eSIM" />
            </div>
            <div id="tab-how-your-plan" data-set="12" class="tabs-stage__list js-slider-img" style="display:none">
                <img class="how-pocket-img how-to-image" src="{{asset('img/image/how-to-3.png')}}" alt="Start your plan" />
            </div>
        </div>

    </div>
</div>
