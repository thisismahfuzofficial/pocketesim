<x-main>
    <main>


        <div class="container container-full">
            <div class="account-page">
                <div class="account__header">
                    <div class="breadcrumbs">
                        <a href="/en"><img src="{{ asset('img/icons/home.svg') }}" alt="home"></a>
                        <img class="breadcrumbs__arrow breadcrumbs__account-info"
                            src="{{ asset('img/icons/right-arrow-breadcrumb.svg') }}" alt="arrow">
                        <a href="/en/profile" class="breadcrumbs__account-info">Account Information</a>
                    </div>
                    <div class="account__header__content">
                        <div class="account__header__content__texts">
                            <h1>Account Information</h1>
                        </div>
                    </div>
                </div>

                <div class="account">

                    <x-acountmanu></x-acountmanu>

                    <form name="form-accountInfo" action="{{ route('update.name') }}" method="post">
                        @csrf
                        <div class="account-content">
                            <div class="account-content-row">

                                <div class="text-field">
                                    <input placeholder=" " type="text" value="{{ auth::user()->name }}"
                                        required="" name="name" aria-required="true">
                                    <label>Name</label>
                                </div>

                            </div>
                            <div class="account-content-row">
                                <div class="input-two-row">
                                    <div class="text-field">
                                        <input placeholder=" " type="text" value="{{ auth::user()->email }}"
                                            required="" disabled="" aria-required="true" disabled>
                                        <label>E-mail</label>

                                    </div>
                                    <div class="text-field">
                                        <input placeholder=" " type="text" value="" required=""
                                            disabled="" aria-required="true" disabled>
                                        <label>Current Password</label>
                                        <label for="drawer-check"
                                            class="drawer-open btn btn-brand-outlined-700 password-drawer-btn">
                                            Edit
                                        </label>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="alert error" style="display: none">
                                <div class="alert__error"></div>
                            </div>

                            <div class="alert success" style="display: none">
                                <div class="alert__success"></div>
                            </div>

                            <div class="account-content-row">
                                <button type="submit" class="btn btn-brand-700">Save Changes</button>
                            </div>
                    </form>
                    <div class="account-content-row-divider"></div>
                    <div class="delete-account">
                            <div class="delete-account-left" style="opacity: 0">
                                <i class="icon-pckt-user"></i>
                                <div class="delete-account-title">
                                    About Account
                                    <p>Permanently deleting your account is possible; however, please be aware that
                                        this procedure may require some time to complete and cannot be reversed once
                                        finalized.</p>
                                </div>
                            </div>
                            {{-- <div class="delete-account-right">
                                <a href="#deleteAccount" class="btn btn-red-outlined delete-account-btn">Delete
                                    Account</a>
                                <div id="deleteAccount" class="modalDialog modal-lg">
                                    <div>
                                        <div class="modal-header">
                                            <h2>Delete Your Account</h2>
                                            <a href="#close" title="Close" class="close"><i class="icon-pckt-x"></i></a>
                                        </div>
                                        <div class="modal-content">
                                            <div class="delete-account-modal-top">
                                                <i class="icon-pckt-question"></i>
                                                <div class="delete-account-modal-title">
                                                    <h2>Chose a reason</h2>
                                                    <p>
                                                        You can delete your account permanently after choosing a
                                                        reason and giving more details to tell us why you're
                                                        deleting your account. (Optional)
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="delete-reasons">
                                                <label for="reason-1">
                                                    <div>
                                                        <input type="radio" class="checkbox-input" name="reason"
                                                            id="reason-1" checked="">
                                                        <div class="check-icon"><img
                                                                src="{{ asset('img/icons/payment-checkbox.svg') }}">
                                                        </div>
                                                    </div>
                                                    Incompatible device
                                                </label>
                                                <label for="reason-2">
                                                    <div>
                                                        <input type="radio" class="checkbox-input" name="reason"
                                                            id="reason-2">
                                                        <div class="check-icon"><img
                                                                src="{{ asset('img/icons/payment-checkbox.svg') }}">
                                                        </div>
                                                    </div>
                                                    Digital footprint
                                                </label>
                                                <label for="reason-3">
                                                    <div>
                                                        <input type="radio" class="checkbox-input" name="reason"
                                                            id="reason-3">
                                                        <div class="check-icon"><img
                                                                src="{{ asset('img/icons/payment-checkbox.svg') }}">
                                                        </div>
                                                    </div>
                                                    No longer in need (not traveling anytime soon)
                                                </label>
                                                <label for="reason-4">
                                                    <div>
                                                        <input type="radio" class="checkbox-input" name="reason"
                                                            id="reason-4">
                                                        <div class="check-icon"><img
                                                                src="{{ asset('img/icons/payment-checkbox.svg') }}">
                                                        </div>
                                                    </div>
                                                    Poor customer service
                                                </label>
                                                <label for="reason-5">
                                                    <div>
                                                        <input type="radio" class="checkbox-input" name="reason"
                                                            id="reason-5">
                                                        <div class="check-icon"><img
                                                                src="{{ asset('img/icons/payment-checkbox.svg') }}">
                                                        </div>
                                                    </div>
                                                    Bad user experience
                                                </label>
                                                <label for="reason-6">
                                                    <div>
                                                        <input type="radio" class="checkbox-input" name="reason"
                                                            id="reason-6">
                                                        <div class="check-icon"><img
                                                                src="{{ asset('img/icons/payment-checkbox.svg') }}">
                                                        </div>
                                                    </div>
                                                    Other
                                                </label>
                                            </div>
                                            <div class="text-field">
                                                <textarea rows="4"></textarea>
                                                <label>Additional Comments</label>
                                            </div>
                                            <div class="alert">
                                                <div class="alert__error delete-modal-alert">
                                                    <i class="icon-pckt-info"></i>
                                                    Before you delete your account, please note: Your account
                                                    deletion takes 7 days to process. Logging in during this period
                                                    cancels the deletion. Pocketmoney becomes inaccessible. eSIMs
                                                    and active data are disabled. Personal info, except privacy
                                                    policy-mandated data, is deleted. Account recovery is impossible
                                                    post-deletion.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="delete-account-double-btn">
                                                <a href="#" class="btn btn-brand-outlined-700">Cancel</a>
                                                <a href="#" class="btn btn-red">Delete Account</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                </div>

            </div>


            <div class="drawer">
                <input type="checkbox" id="drawer-check" class="drawer-hidden">
                <nav class="drawer-content">
                    <label for="drawer-check" class="drawer-close">
                        <i class="icon-pckt-x"></i>
                    </label>
                    <div class="drawer-card-header js-show-mail-form">
                        <div class="apply-code">
                            <div class="checkout-top-title checkout-label">
                                <div class="checkout-icon">
                                    <i class="icon-pckt-at"></i>
                                </div>
                                <div class="apply-code-text">
                                    <h3>Change Email</h3>
                                    <label for="drawer-check" class="m-close-drawer">Close</label>
                                    <span class="checkout-top-desc">Kindly input your new email along with your
                                        current password to initiate the change of your current email.</span>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- <form class="mail-form js-show-mail-form" name="form-changeMail" action="javascript:;"
                            novalidate="novalidate">
                            <div class="drawer-account-content">
                                <div class="text-field">
                                    <input placeholder=" " type="text" id="email" name="email[new]"
                                        value="" required="" aria-required="true">
                                    <label>New Email</label>
                                </div>
                                <div class="text-field js-emailConfirmCode" style="display: none;">
                                    <input placeholder=" " type="text" name="email[confirm_code]" required=""
                                        aria-required="true">
                                    <label>Confirm Code</label>
                                </div>

                                <div class="alert error" style="display: none">
                                    <div class="alert__error"></div>
                                </div>

                                <div class="alert success" style="display: none">
                                    <div class="alert__success"></div>
                                </div>

                                <div class="apply-code-btn-wrapper">
                                    <button type="submit" class="btn btn-brand-700 add-new-card-btn"
                                        data-confirmrequesttext="Send Confirm Code"
                                        data-confirmtext="Confirm Code"><span>Send Confirm Code</span></button>
                                </div>
                            </div>
                        </form> --}}
                    {{-- this is the change password  --}}
                    <div class="drawer-card-header js-show-password-form" style="display: none">
                        <div class="apply-code">
                            <div class="checkout-top-title checkout-label">
                                <div class="checkout-icon">
                                    <i class="icon-pckt-password"></i>
                                </div>
                                <div class="apply-code-text">
                                    <h3>Change Password</h3>
                                    <label for="drawer-check" class="m-close-drawer">Close</label>
                                    <span class="checkout-top-desc">To update your password, enter your current
                                        password first, followed by your new password, and retype the new password
                                        for confirmation.</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <form class="password-form js-show-password-form" action="{{ route('update.pass') }}"
                        method="POST" style="display: none">
                        @csrf

                        <div class="drawer-account-content">
                            <div class="text-field">
                                <input placeholder=" " id="update_password_current_password" type="password"
                                    name="current_password" required="" aria-required="true">
                                <label>Current Password</label>
                            </div>
                            <div class="text-field">
                                <input placeholder=" " id="update_password_password" type="password" name="password"
                                    required="" aria-required="true">
                                <label>New Password</label>

                            </div>
                            <div class="text-field">
                                <input placeholder=" " type="password" id="update_password_password_confirmation"
                                    name="password_confirmation" required="" aria-required="true">
                                <label>Confirm New Password</label>
                            </div>

                            <div class="alert error" style="display: none">
                                <div class="alert__error"></div>
                            </div>

                            <div class="alert success" style="display: none">
                                <div class="alert__success"></div>
                            </div>

                            <div class="apply-code-btn-wrapper">
                                <button type="submit" class="btn btn-brand-700 add-new-card-btn"><span>Save
                                        Changes</span></button>
                            </div>
                        </div>
                    </form>

                    {{-- <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-4">
                            @csrf
                            @method('put')
                    
                            <div>
                                <x-input-label class="mt-1 mb-2" for="update_password_current_password" :value="__('Current Password')" />
                                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full " autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                    
                            <div>
                                <x-input-label for="update_password_password" :value="__('New Password')" />
                                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full " autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />
                            </div>
                    
                            <div>
                                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full " autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger "  />
                            </div>
                    
                            <div class="flex mt-2 items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form> --}}
                </nav>
            </div>
        </div>
        <br>




        </div>
    </main>
</x-main>
