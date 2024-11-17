$(document).ready(function () {

    $.modal = function (id, status) {
        if (status === "show") {
            $(id).css({
                'opacity': '1',
                'pointer-events': 'all'
            });
        } else if (status === "hide") {
            location.hash = '';
            $('#eSimRenameModal').css({
                'opacity': '',
                'pointer-events': ''
            });
            $(id).css({
                'opacity': '',
                'pointer-events': ''
            });
        }
        $('.close').click(function () {
            $('#eSimRenameModal').css({
                'opacity': '',
                'pointer-events': ''
            });
            $(id).css({
                'opacity': '',
                'pointer-events': ''
            });
            location.hash = '';
        })
    };

    $.esimQuantityChange = function () {

        var quantity = $('input[name=quantity]').val();
        var esimUnitPrice = $('input[name=eSim]:checked').attr('data-esimUnitPrice');
        var esimCurrency = $('input[name=eSim]:checked').attr('data-esimCurrency');

        var totalPriceOld = (esimUnitPrice * quantity);
        var totalPriceCurrent = (esimUnitPrice * quantity);


        $('div.total-price-old span').html(totalPriceOld.toFixed(2) + ' ' + esimCurrency);
        $('div.total-price-current span').html(totalPriceCurrent.toFixed(2) + ' ' + esimCurrency);

    };

    $.esimPriceCalculate = function () {

        var esimAmount = $('span.js-amount').attr('data-amount');
        var promotionCodeType = $('input[name=promotionCode]').attr('data-discountType');
        var promotionCodeValue = $('input[name=promotionCode]').attr('data-discountValue');

        var discountAmount = 0;

        $('span.js-discountAmount').attr('data-discountAmount', discountAmount);
        $('span.js-discountAmount').html(discountAmount);
        $('div.old-price-wrapper').css('display', 'none');

        if (promotionCodeType == 'PER') {
            discountAmount = (esimAmount * promotionCodeValue / 100).toFixed(2);
        } else if (promotionCodeType == 'FIX') {
            discountAmount = parseFloat(promotionCodeValue).toFixed(2);
        }

        if (discountAmount != 0) {
            $('p.js-discountDescription').html(promotionCodeValue + '% Code Discount');
            $('div.js-discount').css('display', 'flex');
            $('span.js-discountAmount').attr('data-discountAmount', discountAmount);
            $('span.js-discountAmount').html(discountAmount);
            $('div.old-price-wrapper').css('display', 'flex');

            var newTotalAmount = (esimAmount - discountAmount).toFixed(2);
            $('span.js-totalAmount').html(newTotalAmount);

        }

    };

    $(document).on('submit', 'form[name=form-userRegister]', function () {

        var form = $(this);
        var formUrl = $(this).data('url');
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();
        var divContainer = 'register';
        var codes = [];

        if (formUrl == '/user/confirm') {
            divContainer = 'register';
        }

        if (formUrl == '/user/confirmCheck') {
            divContainer = 'code-verification';
        }

        $.each($('input.js-code'), function (index, value) {
            codes.push($(this).val());
        });

        $('input[name=confirmCode]').val(codes.join(""));

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + formUrl,
            dataType: 'json',
            data: form.serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
                form.find('div.alert.error').css('display', 'none');
                form.find('div.alert.success').css('display', 'none');
            },
            success: function (dataJson) {

                if (dataJson.status) {

                    form.find('div.alert.success div').html(dataJson.message);
                    form.find('div.alert.success').css('display', 'block');

                    if (formUrl == '/user/confirm') {

                        $('div.register').css('display', 'none');
                        $('div.code-verification').css('display', 'flex');

                        $('input[name=confirmToken]').val(dataJson.data.confirmToken);

                        form.data('url', '/user/confirmCheck');

                        form.removeClass('was-validated');
                        $.each($('input.js-code'), function (index, value) {
                            $(this).attr('required', 'required');
                        });

                    }

                    if (formUrl == '/user/confirmCheck') {
                        if (dataJson.referrer) {
                            location.href = dataJson.referrer;
                        } else {
                            location.href = "/";
                        }

                    }

                } else {

                    $.each($('input.js-code'), function (index, value) {
                        $(this).val('');
                    });

                    form.find('div.alert.error div').html(dataJson.message);
                    form.find('div.alert.error').css('display', 'block');

                    //form.find('div.' + divContainer + ' div.alert').html(dataJson.message);
                    //form.find('div.' + divContainer + ' div.alert').removeClass('d-none');

                }
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('submit', 'form[name=form-userLogin]', function () {

        var form = $(this);
        var formUrl = $(this).data('url');
        var referrer = form.find('input[name=referrer]').val();
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + formUrl,
            dataType: 'json',
            data: form.serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
                form.find('div.alert').removeClass('d-none').addClass('d-none');
            },
            success: function (dataJson) {

                if (dataJson.status) {

                    if (referrer !== '') {
                        location.href = referrer;
                    } else {
                        location.href = "/" + currentLanguageCode;
                    }

                } else {
                    form.find('div.alert.error div').html(dataJson.message);
                    form.find('div.alert.error').css('display', 'block');
                }
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    //PasswordReset #1
    $(document).on('submit', 'form[name=form-userChangePasswordVerification]', function () {

        var form = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();

        $.ajax({
            type: 'POST',
            url: '/' + currentLanguageCode + '/user/password-reset',
            dataType: 'json',
            data: form.serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
                form.find('div.alert').removeClass('d-none').addClass('d-none');
            },
            success: function (dataJson) {

                if (dataJson.status) {

                    $('div.divUserPasswordResetRequest').css('display', 'none');
                    $('div.divUserPasswordReset').css('display', 'block');

                    $('form[name=form-userChangePassword]').find('input[name=email]').val(form.find('input[name=email]').val());

                } else {
                    form.find('div.alert.error div').html(dataJson.message);
                    form.find('div.alert.error').css('display', 'block');
                }
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    //PasswordReset #2
    $(document).on('submit', 'form[name=form-userChangePassword]', function () {

        var form = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();

        $.ajax({
            type: 'POST',
            url: '/' + currentLanguageCode + '/user/password-reset',
            dataType: 'json',
            data: form.serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
                form.find('div.alert').removeClass('d-none').addClass('d-none');
            },
            success: function (dataJson) {

                if (dataJson.status) {

                    $('div.divUserPasswordReset').css('display', 'none');
                    $('div.divUserPasswordResetSuccess').css('display', 'grid');

                } else {
                    form.find('div.alert.error div').html(dataJson.message);
                    form.find('div.alert.error').css('display', 'block');
                }
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('click', 'a.js-language', function () {

        var thisButton = $(this);
        var localeCode = thisButton.attr('hreflang');
        var noneLanguageUrl = $('input[name=noneLanguageUrl]').val();

        $.ajax({
            type: 'GET',
            url: '/locale/' + localeCode,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
            },
            success: function (dataJson) {
                location.href = "/" + localeCode + noneLanguageUrl;
            },
            error: function (xhr, ajaxOptions, thrownError) {

            }
        });

    });

    $(document).on('change', 'input[name=eSim]', function () {

        var thisButton = $(this);
        var id = thisButton.attr('data-id');
        var quantity = $('input[name=quantity]').val();
        var esimCoverage = thisButton.attr('data-esimCoverage');
        var esimData = thisButton.attr('data-esimData');
        var esimValidity = thisButton.attr('data-esimValidity');
        var esimUnitPrice = thisButton.attr('data-esimUnitPrice');
        var esimCurrency = thisButton.attr('data-esimCurrency');

        var totalPriceOld = (esimUnitPrice * quantity);
        var totalPriceCurrent = (esimUnitPrice * quantity);

        $('p.js-esimCoverage').html(esimCoverage);
        $('p.js-esimData').html(esimData);
        $('p.js-esimValidity').html(esimValidity);
        $('span.js-esimUnitPrice').html(esimUnitPrice + ' ' + esimCurrency);

        $('div.total-price-old span').html(totalPriceOld.toFixed(2) + ' ' + esimCurrency);
        $('div.total-price-current span').html(totalPriceCurrent.toFixed(2) + ' ' + esimCurrency);


    });

    $(document).on('click', 'button.js-esimSubmit', function () {

        var button = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();
        var productId = $('input[name=eSim]:checked').attr('data-id');
        var quantity = $('input[name=quantity]').val();
        var price = $('input[name=eSim]:checked').attr('data-esimUnitPrice');
        var currency = $('input[name=eSim]:checked').attr('data-esimCurrency');

        var data = new Object();
        data.productId = productId;
        data.quantity = quantity;
        data.price = price;
        data.currency = currency;

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/checkout-product',
            dataType: 'json',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    location.href = '/' + currentLanguageCode + '/checkout/' + dataJson.data.checkoutProductKey
                } else {
                    alert(dataJson.message);
                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('click', 'button.js-esimTopUp', function () {

        var button = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();
        var productId = $(this).attr('data-id');
        var iccid = $(this).attr('data-iccid');
        var quantity = 1;

        var data = new Object();
        data.productId = productId;
        data.quantity = quantity;
        data.iccid = iccid;

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/checkout-product',
            dataType: 'json',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.modal('#topUpInfo', 'hide');
                $.blockUI({message: null});
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    location.href = '/' + currentLanguageCode + '/checkout/' + dataJson.data.checkoutProductKey
                } else {
                    alert(dataJson.message);
                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('click', 'button[name=promotionCodeButton]', function () {

        var button = $(this);
        var promotionCode = $('input[name=promotionCode]').val();
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();

        $('input[name=promotionCode]').attr('data-discountType', '');
        $('input[name=promotionCode]').attr('data-discountValue', '');
        $('input[name=promotionCode]').attr('data-promotionCode', '');

        if (promotionCode.length <= 0) {
            return false;
        }

        var data = new Object();
        data.promotionCode = promotionCode;

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/promotion-check',
            dataType: 'json',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
                $('div.apply-code').find('div.alert__error').html('');
                $('div.apply-code').find('div.alert').css('display', 'none');
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    $('input[name=promotionCode]').attr('data-discountType', dataJson.data.type);
                    $('input[name=promotionCode]').attr('data-discountValue', dataJson.data.value);
                    $('input[name=promotionCode]').attr('data-promotionCode', promotionCode);
                    $('div.apply-code-input').css('display', 'none');
                    $('span.coupon-code').html(promotionCode);
                    $('div.coupon-code-wrapper').css('display', 'flex');
                    $('div.apply-code-btn-wrapper').css('display', 'none');

                    $.esimPriceCalculate();
                } else {

                    $('div.apply-code').find('div.alert__error').html(dataJson.message);
                    $('div.apply-code').find('div.alert').css('display', 'block');

                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('click', 'button[name=applyCodeButton]', function () {

        var button = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();
        var checkoutProductKey = $('input[name=checkoutProductKey]').val();
        var promotionCode = $('input[name=promotionCode]').val();

        if (promotionCode.length > 0) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/apply-pocketmoney/' + checkoutProductKey,
            dataType: 'json',
            data: null,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
                $('div.use-pocketmoney').find('div.alert__error').html('');
                $('div.use-pocketmoney').find('div.alert').css('display', 'none');
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    location.reload();
                } else {
                    $('div.use-pocketmoney').find('div.alert__error').html(dataJson.message);
                    $('div.use-pocketmoney').find('div.alert').css('display', 'block');
                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('click', 'button[name=productCheckout]', function () {

        var button = $(this);
        var form = $('form[name=credit-card-form]')
        var promotionCode = $('input[name=promotionCode]').attr('data-promotionCode');
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();
        var quantity = $('input[name=quantity]').val();
        var productId = $('input[name=productId]').val();
        var checkoutProductKey = $('input[name=checkoutProductKey]').val();


        var data = new Object();
        var creditCard = new Object();
        creditCard.holder = form.find('input[name=name]').val();
        creditCard.number = form.find('input[name=number]').val();
        creditCard.expiry = form.find('input[name=expiry]').val();
        creditCard.cvc = form.find('input[name=cvc]').val();

        data.creditCard = creditCard;
        data.promotionCode = promotionCode;
        data.currentLanguageCode = currentLanguageCode;
        data.quantity = quantity;
        data.productId = productId;

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/checkout/' + checkoutProductKey,
            dataType: 'json',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    if (dataJson.type == 'form') {
                        $('div.js-threeDForm').html(dataJson.data);
                        $('div.js-threeDForm form').submit();
                    } else if (dataJson.type == 'redirect') {
                        location.href = dataJson.data;
                    }
                } else {
                    alert(dataJson.message);
                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $('ul').on('click', 'li.js-eSimRenameModal', function () {
        var button = $(this);
        var name = $(this).attr('data-name');
        var code = $(this).attr('data-code');

        $.modal("#eSimRenameModal", "show");

        $('#eSimRenameModal input[name=name]').val(name);
        $('#eSimRenameModal input[name=code]').val(code);
    });

    $('ul').on('click', 'li.js-eSimArchive', function () {

        var button = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();
        var code = $(this).attr('data-code');


        var data = new Object();
        data.code = code;

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/profile/esim/archive',
            dataType: 'json',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $.blockUI({message: null});
            },
            success: function (dataJson) {
                location.reload();
            },
            complete: function () {

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('click', 'a.card-name', function () {

        var button = $(this);
        var name = $(this).attr('data-name');
        var code = $(this).attr('data-code');

        $.modal("#eSimRenameModal", "show");

        $('#eSimRenameModal input[name=name]').val(name);
        $('#eSimRenameModal input[name=code]').val(code);

    });

    $(document).on('click', 'a.js-eSimRename', function () {

        var button = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();
        var name = $('#eSimRenameModal input[name=name]').val();
        var code = $('#eSimRenameModal input[name=code]').val();


        var data = new Object();
        data.name = name;
        data.code = code;

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/profile/esim/rename',
            dataType: 'json',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#eSimRenameModal').find('div.alert').css('display', 'none');
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    $.modal("#eSimRenameModal", "hide");
                    $('a[data-code=' + code + ']').html(name);
                    $('a[data-code=' + code + ']').attr('data-name', name);

                    $('div.detail-card-holder').html(name);
                    $('a.breadcrumbs__country').html(name);

                } else {
                    $('#eSimRenameModal').find('div.alert.error div').html(dataJson.message);
                    $('#eSimRenameModal').find('div.alert.error').css('display', 'block');
                }

            },
            complete: function () {

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('submit', 'form[name=form-accountInfo]', function () {

        var form = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/profile',
            dataType: 'json',
            data: form.serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                form.find('div.alert').css('display', 'none');
                $.blockUI({message: null});
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    form.find('div.alert.success div').html(dataJson.message);
                    form.find('div.alert.success').css('display', 'flex');
                } else {
                    form.find('div.alert.error div').html(dataJson.message);
                    form.find('div.alert.error').css('display', 'flex');
                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('submit', 'form[name=form-changePassword]', function () {

        var form = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/profile/password',
            dataType: 'json',
            data: form.serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                form.find('div.alert').css('display', 'none');
                $.blockUI({message: null});
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    form.find('div.alert.success div').html(dataJson.message);
                    form.find('div.alert.success').css('display', 'flex');
                } else {
                    form.find('div.alert.error div').html(dataJson.message);
                    form.find('div.alert.error').css('display', 'flex');
                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    $(document).on('submit', 'form[name=form-changeMail]', function () {

        var form = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();
        var confirmCode = $('input[name="email[confirm_code]"]').val();
        var confirmText = form.find('button[type=submit]').attr('data-confirmText');
        var confirmRequestText = form.find('button[type=submit]').attr('data-confirmRequestText');

        form.find('button[type=submit] span').html(confirmRequestText);

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/profile/email',
            dataType: 'json',
            data: form.serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                form.find('div.alert').css('display', 'none');
                $.blockUI({message: null});
            },
            success: function (dataJson) {

                if (dataJson.status) {

                    form.find('div.alert.success div').html(dataJson.message);
                    form.find('div.alert.success').css('display', 'block');

                    if (confirmCode == "") {
                        $('div.js-emailConfirmCode').css('display', 'block');
                        form.find('button[type=submit] span').html(confirmText);
                    } else {
                        location.reload()
                    }

                } else {
                    form.find('div.alert.error div').html(dataJson.message);
                    form.find('div.alert.error').css('display', 'block');
                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });


    $(document).on('keyup', 'input[name=search]', function (e) {
        e.preventDefault();
        var input = $(this);
        var currentLanguageCode = $('input[name=currentLanguageCode]').val();

        data = new Object();
        data.keyword = input.val();

        if (data.keyword.length < 3) {
            return false;
        }


        const show = (result) => {
            $(this).next('.item-content').toggle();
            var input = document.getElementById("search");
            if (result) {
                $(this).parent().find("#searchResult").css('display', 'flex');
                $(this).parent().find("#searchResult").html(result);

                $(input).click(function (event) {
                    event.stopPropagation();
                });

            } else {
                $(this).parent().find("#searchResult").css('display', 'none');
            }
        }

        $(window).click(function () {
            $('body #searchResult').css('display', 'none');
        });

        $.ajax({
            type: 'POST',
            url: "/" + currentLanguageCode + '/search',
            dataType: 'json',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                //$.blockUI({message: null});
            },
            success: function (dataJson) {

                if (dataJson.status) {
                    show(dataJson.data)
                }

            },
            complete: function () {

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("error");
            }
        });

    });

    if ($(".products").hasClass("products-detail")) {
        $("input[name=eSim]").first().trigger("click");
    }

});
