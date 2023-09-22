$(document).on('click','#btn_addtocart', function(){
    var resize = $('input[name=resize]:checked').val();
    var straighten = $('#straighten').prop('checked');
    var margin = straighten ? 'Yes' : 'No';
    $("#resize_image").html(resize);
    $("#set_margin").html(margin);
    $('#step1').hide();
    $('#step2').show();
});

$(document).on('click', '.prevstep', function(){
    var step = $(this).data('id');
    $('#step1,#step2,#step3,#step4').hide();
    $('#'+step).show();
});

$(document).on('click','#btn_proceed', function(){
    $('#step1,#step2,#step3,#step4').hide();
    $('#step3').show();
});

$(document).on('click','#btn_continue',function(){
    var isValid = true;
    $("#step3 .form-control.required").each(function(){
        $(this).removeClass('in-valid');
        if($(this).closest('div').find('div.validation-error').length > 0){
            $(this).closest('div').find('div.validation-error').remove();
        }
        if($(this).val().trim() == ""){
            $(this).addClass('in-valid');
            if($(this).closest('div').find('div.validation-error').length == 0){
                $(this).closest('div').append('<div class="validation-error">This field is required.</div>');
            }
            isValid = false;
        }
    });
    if(isValid){
        $('#step1,#step2,#step3,#step4').hide();
        $('#step4').show();
    }
    
});

$(document).on('blur',"#step3 .form-control.required,#step4 .form-control.required", function(){
    
    if($(this).val().trim() == ""){
        $(this).addClass('in-valid');
        if($(this).closest('div').find('div.validation-error').length == 0){
            $(this).closest('div').append('<div class="validation-error">This field is required.</div>');
        }
    } else if($(this).val().trim() != ""){
        $(this).removeClass('in-valid');
        if($(this).closest('div').find('div.validation-error').length > 0){
            $(this).closest('div').find('div.validation-error').remove();
        }
    }
});

/****************************** Stripe Payments **********************************/
$(function() {
   
    var $form = $(".require-validation");
   
    $(document).on('click','#makepayment', function(e) {
        e.preventDefault();
        var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        valid         = true;

        $("#step4 .form-control.required").each(function(i, el) {
            var $input = $(el);
            $input.removeClass('in-valid');
            if($input.closest('div').find('div.validation-error').length > 0){
                $input.closest('div').find('div.validation-error').remove();
            }
            if ($input.val() === '') {
                $input.addClass('in-valid');
                if($input.closest('div').find('div.validation-error').length == 0){
                    $input.closest('div').append('<div class="validation-error">This field is required.</div>');
                }
                valid = false;
            }
        });
   
        if (valid) {
            var stcode = atob(wss_code);
            Stripe.setPublishableKey(stcode);
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            alert(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').attr('content')
                }
            });
            var token = response['id'];
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: {
                    key: token,
                    frmd: $("#billingInfo").serialize(),
                    comment: encodeURIComponent($('#addition_comments').val()),
                    straighten: $("#straighten").prop('checked') == true ? 1 : 0,
                    resize: $('input[name="resize"]:checked').val()
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == '200'){
                        window.location.href=response.thankyou;
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    }
   
});