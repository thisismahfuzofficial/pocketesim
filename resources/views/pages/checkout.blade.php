<x-main>

    <form id="payment-form">
        @csrf
        <div class="checkout">

            <div class="checkout-area">
                <div class="checkout-label">
                    <div class="checkout-icon">
                        <i class="icon-pckt-cardholder"></i>
                    </div>
                    <div class="checkout-top-title">
                        <h3>Complete Checkout</h3>
                        <span class="checkout-top-desc">You can choose or change the payment method to complete your
                            order.</span>
                    </div>
                </div>
                <div class="checkout-form">
                    <div class="checkout-label">

                        <div class="checkout-form">
                            <div class="checkout-label">
                                <div class="text-field">
                                    <input type="text" name="name" required aria-required="true"
                                        value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                    <label>Name</label>
                                </div>
                                <div class="text-field">
                                    <input type="email" name="email" required aria-required="true"
                                        value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                    <label>Email</label>
                                </div>
                            </div>
                            <div class="text-field">
                                <input type="text" id="card-holder-name" required aria-required="true">
                                <label>Card Holder</label>
                            </div>
                            <div class="text-field">
                                <div
                                    style="border: 1px solid var(--border-secondary);border-radius:12px;padding:14px 16px 0;height:52px">

                                    <div id="card-element">
                                        <!-- Stripe Element will be inserted here -->
                                    </div>
                                </div>
                                <div id="card-errors" role="alert" class="error"></div>
                            </div>
                        </div>
                    </div>


                </div>
                <p id="loading-text" style="display:none;">
                    Order is processing do not leave this window ...... 
                </p>

            </div>
            <div class="checkout-card card">

                <div class="card-details">
                    <div>
                        <p><i class="icon-pckt-globe"></i> Coverage</p>
                        <p>{{ $plan->country->name }}</p>
                    </div>
                    <div>
                        <p><i class="icon-pckt-arrow-up-down"></i> Data</p>
                        <p>{{ $plan->gb }}</p>
                    </div>
                    <div>
                        <p><i class="icon-pckt-calendar"></i> Validity</p>
                        <p>{{ $plan->duration }}</p>
                    </div>
                    <div>
                        <p><i class="icon-pckt-user"></i> Travellers</p>
                        <p>{{ session('quantity') }}</p>
                    </div>
                </div>
                <div class="card-price">
                    <div>
                        <h3>Price Details</h3>
                    </div>
                    <div>
                        <p>{{ $plan->currentPrice() }} EUR x {{ session('quantity') }} Travellers</p>
                        <div><span class="currency">€</span> <span class="js-amount"
                                data-unitamount="{{ session('quantity') * $plan->currentPrice() }} "
                                data-amount="{{ session('quantity') * $plan->currentPrice() }} ">{{ session('quantity') * $plan->currentPrice() }}
                            </span></div>
                    </div>
                    <div class="js-discount" style="display: none;">
                        <p class="js-discountDescription"></p>
                        <div>-$ <span class="js-discountAmount" data-discountamount="0">0</span></div>
                    </div>
                    <div class="total-price-wrapper">
                        <p>Total Price <span class="total-price-currency">(EUR)</span></p>
                        <div class="total-price">
                            <div class="old-price-wrapper" style="display: none;">
                                <span class="currency">€</span> <span class="old-price js-oldAmount"
                                    data-oldamount="{{ session('quantity') * $plan->currentPrice() }} ">{{ session('quantity') * $plan->currentPrice() }}
                                </span>
                            </div>
                            <div class="new-price-wrapper">
                                <span class="currency">€</span> <span class="new-price js-totalAmount"
                                    data-totalamount="{{ session('quantity') * $plan->currentPrice() }} ">{{ session('quantity') * $plan->currentPrice() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-bottom">



                    <button name="productCheckout" type="submit" class="btn btn-brand-700">COMPLETE
                        ORDER</button>
                </div>
            </div>
    </form>

    <form action="{{ route('complete.checkout') }}" id="completecheckout" method="post">
        @csrf
        <input type="hidden" name="cus_name">
        <input type="hidden" name="cus_email">
        <input type="hidden" name="paymentIntentId">
    </form>
    </div>

    @push('javascript')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var stripe = Stripe("{{ env('STRIPE_KEY') }}");
                var elements = stripe.elements();
                var style = {
                    base: {
                        color: '#32325d',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };

                var card = elements.create('card', {
                    style: style,
                    hidePostalCode: true // Add this line to hide the postal code field
                });
                card.mount('#card-element');

                card.addEventListener('change', function(event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });

                var form = document.getElementById('payment-form');
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
          
                    stripe.createPaymentMethod({
                        type: 'card',
                        card: card,
                        billing_details: {
                            name: document.querySelector('input[name="name"]').value,
                            email: document.querySelector('input[name="email"]').value
                        },
                    }).then(function(result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            stripePaymentMethodHandler(result.paymentMethod.id);
                        }
                    });
                });

                function stripePaymentMethodHandler(paymentMethodId) {
                    var clientSecret = "{{ $client_secret }}";

                    stripe.confirmCardPayment(clientSecret, {
                        payment_method: paymentMethodId
                    }).then(function(result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            orderComplete(result.paymentIntent.id);
                        }
                    });
                }

                function orderComplete(paymentIntentId) {
                    document.querySelector('input[name="cus_name"]').value = document.querySelector(
                        'input[name="name"]').value;
                    document.querySelector('input[name="cus_email"]').value = document.querySelector(
                        'input[name="email"]').value;
                    document.querySelector('input[name="paymentIntentId"]').value = paymentIntentId;
                    document.getElementById('completecheckout').submit();
                }
            });
        </script>
    @endpush
</x-main>
