{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}



<x-authform>
    <form class="needs-validation" method="post" name="form-userRegister" action="{{ route('register') }}">
        @csrf
        <div class="register">
            <div class="register__left">
                <div class="register__left__wrapper">
                    <div class="register__left__logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('img/image/main-logo.png') }}" alt="logo" /></a>
                    </div>
                    <div class="register__left__form-area">
                        <div class="register__left__texts">
                            <h1 class="register__left__texts__title">Sign Up</h1>
                            <p class="register__left__texts__slogan">
                                Register your account here
                            </p>
                        </div>

                        <div class="register__left__form">
                            <div class="register__left__form__input-area">
                                <div class="input-two-row">
                                    <div class="text-field">

                                        <input id="name" type="text" placeholder=""
                                            class=" @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label>First Name</label>
                                    </div>
                                    {{-- <div class="text-field">
                                        <input name="user[surname]" placeholder="" type="text" value="">
                                        <label>Last Name</label>
                                    </div> --}}
                                </div>
                                <div class="text-field">

                                    <input id="email" type="email" placeholder=""
                                        class=" @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <label>E-mail</label>
                                </div>

                                <div class="text-field">

                                    <input id="password" type="password" placeholder=""
                                        class="id_password @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    <label>Password</label>
                                    <img class="input-icon togglePassword"
                                        src="{{asset('img/icons/eye-on.svg')}}" />
                                </div>
                                <div class="text-field">
                                    {{-- <input name="user[password]" placeholder="" type="password"
                                        autocomplete="confrem-password" class="id_password" value="" required> --}}
                                    <input id="password-confirm" placeholder="" type="password" class="id_password"
                                        name="password_confirmation" required autocomplete="new-password">
                                    <label>Confirm Password</label>
                                    <img class="input-icon togglePassword"
                                        src="{{asset('img/icons/eye-on.svg')}}" />
                                </div>

                                {{-- <div class="register__left__voucher-text">Do you have a referral code?</div>
                                <div class="text-field js-voucher-input" style="display: none">
                                    <input name="user[referral_code]" placeholder="" type="text" value=""
                                        oninput="this.value = this.value.toUpperCase()" maxlength="6">
                                    <label>Referral Code</label>
                                </div> --}}

                            </div>
                            <div class="alert error" style="display: none">
                                <div class="alert__error"></div>
                            </div>

                            <div class="alert success" style="display: none">
                                <div class="alert__success"></div>
                            </div>
                            <button type="submit" class="btn btn-brand-700">Sign Up</button>
                        </div>

                        <div class="register__left__sign-up">Already have an account? <a
                                href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                    {{-- <div class="register__left__terms">
                        By creating account you agree to our
                        <a href="{{ asset('terms-conditions.html') }}" target="_blank">Terms &amp; Conditions</a> and
                        <a href="{{ asset('privacy-cookie-policy.html') }}" target="_blank">Privacy &amp; Cookie
                            Policy</a>
                    </div> --}}
                </div>
            </div>
            <div class="register__right">
                <div class="register__right__container">
                    <div class="register__right__container__image">
                        <div class="register__right__container__image-content">
                            <div class="register__right__container__image-content__text">
                                <span>Wherever your journey takes you,</span><span>It's in your Pocket.</span>
                            </div>
                            <div class="register__right__container__image-content__logo"></div>
                            <div
                                class="register__right__container__image-content__man-image register__right__container__image-content__right-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </form>

</x-authform>
