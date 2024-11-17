<div class="faq">
    <h2 class="products__list__title">Pyetjet e shpeshta</h2>
    <div class="faq-wrapper">
       

        <div class="accordion">
            @foreach ($faqs as $faq)
                <div class="accordion__item">
                    <div class="accordion__title">
                        <span class="accordion__title-text">{{ $faq->qustion }}</span>
                        <div class="accordion__arrow"><span class="accordion__arrow-item "><i
                                    class="icon-pckt-caret-down"></i></span></div>
                    </div>
                    <div class="accordion__content">
                        {!! $faq->answer !!}
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</div>
