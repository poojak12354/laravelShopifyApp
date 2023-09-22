var arrComplex = {'easy': '2.50', 'hard': '5.00'};
var qid = Math.floor((Math.random() * 99999) + 1);
$(document).ready(function() {
    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });
});

/*** ADD REMOVE CLASS ***/
$('#resize').click(function(){
    if($('.resize-image-information-wrapper').hasClass('show-pixels')){
        $('.resize-image-information-wrapper').removeClass('show-pixels');
    }else{
        $('.resize-image-information-wrapper').addClass('show-pixels');
    }
});

$(document).on('click','#btn_prev',function(){
    $('.step-button[aria-expanded="true"]').closest('.step-item').prev().find('button.step-button').trigger('click');
});


function submitForm(){
    $('body').append('<div class="wss-processing"><div class="wss-processigne"><div class="process-msg"><span class="load-message">Please wait while we are processing</span></div></div></div>');
    $("#add_next").attr('disabled','disabled');
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: $("#frm_quote").serialize(),
    };

    var cartContents = fetch("https://www.bigturn.io/api/postQuotes", requestOptions).then(response => response.text())
    .then((response) => {
        qid = response;
        console.log('res qid',qid);
        if(myDropzone.getQueuedFiles().length > 0) {
            myDropzone.options.autoProcessQueue = true;
            myDropzone.processQueue();
            $('.wss-progress').css('display','block');
        } else {
            $("#add_next").removeAttr('disabled');
            $('.wss-processing').remove();
            $('.content-right-inn').html('<div class="alert-success">Thank you for submitting your pictures! Our team will now look at your pictures and prepare a final quote for you on the editing costs.<br>In the meantime, if you have any questions at all, email us at info@bigturntables.com. Thanks again!</div>');
        }
    })
    .catch(err => {
        $("#add_next").removeAttr('disabled');
        $('.wss-processing').remove();
        console.log(err);
    });
}

/**************************** File Upload *****************************/

Dropzone.autoDiscover = false;
var myDropzone = new Dropzone(".dropzone.upload-gallery", {
    url: 'https://www.bigturn.io/api/clientImages',
    autoProcessQueue: false,
    uploadMultiple: true,
    createImageThumbnails:false,
    disablePreviews: true,
    acceptedFiles: 'image/*',
    renameFile: function (file) {
        let newName = new Date().getTime() + '_' + file.name;
        return newName;
    },
    init: function(file) {
        this.on("sending", function(file, xhr, formData){
            //console.log('qid',qid);
            formData.append("data", qid);
        });
        this.on("addedfile", function(file) {
            var $this = this;
            setTimeout(function () {
                if(file.status == "error"){
                    $this.removeFile($this.files[0]);
                } else {
                    previewImage(file);
                }
            }, 10);
        });
        this.on("addedfiles", function(files) {
            $('#images_count').val(files.length);
            var complexity = $('input[name="complexity"]:checked').val();
            var total = arrComplex[complexity]*files.length;
            $('span.price-total').html("$"+total.toFixed(2));
       })
        this.on('error', function(file, errorMessage) {
            $("#add_next").removeAttr('disabled');
            $('.wss-processing').remove();
            console.log('file',file);
            console.log('errorMessage',errorMessage);
            alert('Unable to upload '+file.name+'. '+errorMessage);
        });
        this.on("queuecomplete", function(file, res) {
            var $this = this;
            if(myDropzone.getQueuedFiles().length <= 1 && myDropzone.files[0].status == Dropzone.SUCCESS){
                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/json");
                myHeaders.append("Access-Control-Allow-Origin", "*");
                var requestOptions = {
                    method: 'GET',
                    headers: myHeaders,
                    mode: 'no-cors'
                };
                 fetch("https://www.bigturn.io/api/notify/"+qid, requestOptions).then(response => response.text())
                 .then((response) => {
                     $("#add_next").removeAttr('disabled');
                     $('.wss-processing').remove();
                     console.log(response);
                     $('.content-right-inn').html('<div class="alert-success">Thank you for submitting your pictures! Our team will now look at your pictures and prepare a final quote for you on the editing costs.<br>In the meantime, if you have any questions at all, email us at info@bigturntables.com. Thanks again!</div>');
                     $('.wss-progress').css('display','none');
                 })
                 .catch(err => {
                     console.log(err)
                     $("#add_next").removeAttr('disabled');
                     $('.wss-processing').remove();
                     $('.wss-progress').css('display','none');
                 });
            } else {
                $("#add_next").removeAttr('disabled');
                $('.wss-processing').remove();
                $this.removeFile($this.files[0]);
                $('.wss-progress').css('display','none');
            }
        });
    }
});

myDropzone.on("totaluploadprogress", function (progress) {
    var updatedProgress = Math.ceil(progress);
    $("#the-progress-div").css('width',updatedProgress + '%');
    $(".the-progress-text").text('Uploading '+updatedProgress + '%');
});

function previewImage(input){
    $('.alert').hide();
    let fileReference = input;
    //console.log('file',fileReference);
    var filename = fileReference.name;
    if(fileReference){
        var reader = new FileReader();
        reader.onload = (event) => {
            $("#drz_gallery").prepend('<div class="lc-img-container d-inline-flex mr-2"><img src="'+event.target.result+'" class="thumb-lg img-thumbnail mt-3" title="/uploads/media/site_media/'+filename+'" data-type="image"/><a href="javascript:void(0)" id="remove_img" data-file="'+filename+'" data-id="0"><i class="fa fa-times-circle"></i></a></div>');
        }
        reader.readAsDataURL(fileReference);
    }
}

$(document).on('click','#remove_img', function(){
    var $this = $(this);
    if(confirm("Are you sure you want to delete this file?")) {
        if(myDropzone.getQueuedFiles().length > 0){
            myDropzone.getQueuedFiles().forEach(function (file,index) {
                if($this.data('file') == file.name){
                    myDropzone.removeFile(myDropzone.files[index]);
                    $this.closest('.lc-img-container').remove();
                    var complexity = $('input[name="complexity"]:checked').val();
                    var total = arrComplex[complexity]*myDropzone.getQueuedFiles().length;
                    $('span.price-total').html("$"+total.toFixed(2));
                    $('#images_count').val(myDropzone.getQueuedFiles().length);
                }
            });
        }
    }
});


$(document).on('click', 'input[name="complexity"]', function(){
    var $selectedval = $(this).val();
    var total = arrComplex[$selectedval]*myDropzone.getQueuedFiles().length;
    $('span.price-total').html("$"+total);
});

/********************** Add Info code ************************/
$(document).on('click','#add_next',function(){
    var target = $('.step-button[aria-expanded="true"]').data("target");
    console.log(target)
    switch(target){
        case "#collapseOne":
            if($('input[name=complexity]:checked').length > 0){
                $("#err_complexity").css("display","none");
                $('.step-button[aria-expanded="true"]').closest('.step-item').next().find('button.step-button').trigger('click');
            } else {
                $("#err_complexity").css("display","block");
            }
        break;
        case "#collapseTwo":
            var valid = true;
            if(($('#resize').prop('checked') == true && ($("#image_width").val() !== "" || $("#image_height").val() !== "")) || $('#resize').prop('checked') == false){
                $("#err_resize_dim").css("display","none");
            } else {
                valid = false;
                $("#err_resize_dim").css("display","block");
            }

            if($("#file_format").val() !== ""){
                $("#err_file_format").css("display","none");
            } else {
                valid = false;
                $("#err_file_format").css("display","block");
            }
            
            if(valid) {
                $('.step-button[aria-expanded="true"]').closest('.step-item').next().find('button.step-button').trigger('click');
            }
        break;
        case "#collapseThree":
            if($("#images_count").val() > 0 && myDropzone.getQueuedFiles().length > 0){
                $("#err_image_count").css("display","none");
                $("#err_upload_files").css("display","none");
                $('.step-button[aria-expanded="true"]').closest('.step-item').next().find('button.step-button').trigger('click');
            } else if(myDropzone.getQueuedFiles().length == 0) {
                console.log('2');
                $("#err_upload_files").html('Please uplaod at least 1 file.');
                $("#err_upload_files").css("display","block");
            } else {
                console.log('3');
                $("#err_image_count").css("display","block");
            }
            
        break;
        case "#collapseFour":
            var is_valid = true;
            if($("#images_count").val() > 0 && myDropzone.getQueuedFiles().length > 0){
                $("#err_fname").css("display","none");
                $("#err_lname").css("display","none");
                $("#err_email").css("display","none");
                var fname = $("#fname").val();
                var lname = $("#lname").val();
                var email = $("#email").val();
                if(fname.trim() == ""){
                    $("#err_fname").css("display","block");
                    is_valid = false;
                }
                if(lname.trim() == ""){
                    $("#err_lname").css("display","block");
                    is_valid = false;
                }
                console.log('emai',email);
                if(email.trim() == ""){
                    console.log('sdfsf');
                    $("#err_email").css("display","block");
                    is_valid = false;
                }
            } else {
                is_valid = false;
                $('.step-button[aria-expanded="true"]').closest('.step-item').prev().find('button.step-button').trigger('click');
                $("#err_upload_files").html('Please uplaod at least 1 file.');
                $("#err_upload_files").css("display","block");
            }
            

            if(is_valid){
                submitForm();
            }
        break;
    }
});

$("button.step-button").click(function() {
    if($(window).width() <= 767) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".content-right").offset().top
        }, 2000);   
    }
});

$(document).on('click','#trigger_uploader', function(){
    //myDropzone.hiddenFileInput.click()
    document.getElementsByClassName("dropzone")[0].click();
    $('.loader-logo').css('display','none');
});