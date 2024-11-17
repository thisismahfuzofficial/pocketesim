


<x-authform>
    <div class="login">
        <div class="login__left">
            <div class="login__left__wrapper">
                <div class="login__left__logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('img/image/main-logo.png') }}" alt="logo" /></a>
                </div>
                <div class="login__left__form-area">
                    <div class="login__left__texts">
                        <h1 class="login__left__texts__title">Login</h1>
                        <p class="login__left__texts__slogan">
                            Glad to see you again Login to your account below.
                        </p>
                    </div>
                    <form class="login__left__form needs-validation" name="form-userLogin" method="POST"
                        action="{{ route('login') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="login__left__form__input-area">
                            <div class="text-field">
                                <input id="email" type="email" placeholder=""
                                    class=" @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                <label>E-mail</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="login__left__form__password-area">
                                <div class="text-field">

                                    <input id="password" type="password" placeholder=""
                                        class=" @error('password') is-invalid @enderror" name="password" required
                                        autocomplete="current-password">
                                    <label>Password</label>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <img class="input-icon togglePassword"
                                        src="{{asset('img/icons/eye-on.svg')}}" />
                                </div>
                                <div class="login__left__form__forgot-password">
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>

                                </div>
                            </div>
                        </div>

                        <div class="alert error" style="display: none">
                            <div class="alert__error"></div>
                        </div>
                        <div class="alert success" style="display: none">
                            <div class="alert__success"></div>
                        </div>

                        <input name="referrer" type="hidden" value="" class="form-control">
                        <button type="submit" class="btn btn-brand-700">Login</button>
                    </form>



                    <div class="login__left__sign-up">You don’t have an account yet? <a
                            href="{{ route('register') }}">Sign
                            Up</a></div>
                </div>
                {{-- <div class="login__left__terms">
                    By creating account you agree to our <a href="../terms-conditions.html"
                        target="_blank">Terms &amp; Conditions</a> and <a href="../privacy-cookie-policy.html"
                        target="_blank">Privacy &amp; Cookie Policy</a>
                </div> --}}
            </div>
        </div>
        <div class="login__right">
            <div class="login__right__container">
                <div class="login__right__container__image">
                    <div class="login__right__container__image-content">
                        <div class="login__right__container__image-content__text">
                            <span>Wherever your journey takes you,</span><span>It's in your Pocket.</span>
                        </div>
                        <div class="login__right__container__image-content__logo"></div>
                        <div
                            class="login__right__container__image-content__woman-image register__right__container__image-content__right-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-authform>
