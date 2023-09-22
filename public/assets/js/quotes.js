$(document).on('click','#view_quote', function(){
    var datahtml = $(this).closest('td').find('#tbl_dataquote').html();
    $('#modal_html').html(datahtml);
    $('#quoteModalLabel').html('<i class="mdi mdi-comment-processing"></i> Quote');
    $('#loadDataHtml').modal('show');
});

$(document).on('click','#paymentInfo', function(){
    var datahtml = $(this).closest('td').find('#tbl_datapayment').html();
    $('#modal_html').html(datahtml);
    $('#quoteModalLabel').html('<i class="mdi mdi-credit-card-multiple"></i> Payment Details');
    $('#loadDataHtml').modal('show');
});

$(document).on('click','.close', function(){
    $('.modal').modal('hide');
});

$(document).on('click','#sendMail', function(){
    $('#sendEmaiHtml').modal('show');
    var uemail = $(this).data('mail');
    $("#uemail").val(uemail);
});

$(document).on('click','#paylink', function(){
    var pay_link = $(this).data('link').trim();
    $("#frm_sendPayEmail").removeClass('d-none');
    if(!pay_link){
        var uid = $(this).data('id');
        $("#uid").val(uid);
        var uemail = $(this).data('mail');
        $("#uemail").val(uemail);
    } else {
        $("#frm_sendPayEmail").addClass('d-none');
        $("#pay_link").val(pay_link);
        $("#div_payLink").removeClass('d-none');
    }
    $('#sendPayLink').modal('show');
});

$(document).on('click','#btn_sendEmail', function(){
    var sendEmail = true;
    var btn = $(this);
    var uemail = $("#uemail").val();
    var subject = $("#emailSubject").val().trim();
    var message = $("#emailMessage").val().trim();
    $("#emailSubject").removeClass('invalid');
    $("#emailMessage").removeClass('invalid');
    if(subject == ""){
        $("#emailSubject").addClass('invalid');
        sendEmail = false;
    }

    if(message == ""){
        $("#emailMessage").addClass('invalid');
        sendEmail = false;
    }
    if(sendEmail){
        btn.addClass('disabled');
        var ajax_url = $("#ajax").val().trim();
        $.ajax({
            type:'POST',
            url:ajax_url,
            data:{mail: uemail, subject:subject, message:encodeURIComponent(message)},
            dataType: "json",
            success:function(data){
                btn.removeClass('disabled');
                $("#emailSubject").val('');
                $("#emailMessage").val('');
                alert(data.message);
            }
        });
    }
});

$(document).on('click','#btn_generate', function(){
    var ajax_url = $("#pajax").val().trim();
    $("#amount").removeClass('invalid');
    var sendEmail = true;
    var uid = $("#uid").val();
    var amount = $("#amount").val();
    var uemail = $("#uemail").val();
    if(amount == ""){
        $("#amount").addClass('invalid');
        sendEmail = false;
    }
    if(sendEmail){
        var $this = $(this);
        $this.addClass('disabled');
        $.ajax({
            type:'POST',
            url:ajax_url,
            data:{id: uid,amount: amount, mail: uemail},
            dataType: "json",
            success:function(data){
                $this.removeClass('disabled');
                $("#uid").val('');
                $("#pay_link").val(data.link);
                $("#frm_sendPayEmail").html('<div class="alert alert-success">'+data.message+'</div>');
                $("#div_payLink").removeClass('d-none');
            }
        });
    }
});

$(document).on('click','#copyLink', function(){
    var copyInput = document.querySelector('.copy-link');
    copyInput.focus();
    copyInput.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Copying text command was ' + msg);
    } catch (err) {
        console.log('Oops, unable to copy');
    }
});