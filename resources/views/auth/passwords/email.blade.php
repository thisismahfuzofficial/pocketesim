{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
    <div class="login">
        <div class="login__left">
            <div class="login__left__wrapper">
                <div class="login__left__logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('img/image/main-logo.png') }}" alt="logo" /></a>
                </div>
                <div class="login__left__form-area">
                    <div class="login__left__texts">
                        <h1 class="login__left__texts__title"> {{ __('Reset Password') }}</h1>
                    
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                    <form class="login__left__form needs-validation" name="form-userLogin" method="POST"
                        action="{{ route('password.email') }}" enctype="multipart/form-data">
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
                
                        </div>

                       
                        <input name="referrer" type="hidden" value="" class="form-control">
                        <button type="submit" class="btn btn-brand-700">{{ __('Send Password Reset Link') }}</button>
                    </form>



                   
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
