var delete_arr = [];
Dropzone.autoDiscover = false;
var myDropzone = new Dropzone(".dropzone.upload-gallery", {
    url: '/upload-media/'+qid,
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
        this.on('error', function(file, errorMessage) {
            console.log('errorMessage',errorMessage);
            alert('Unable to upload '+file.name+'. '+errorMessage);
        });
        this.on("queuecomplete", function(file, res) {
            console.log('res',res);
            var $this = this;
            if(myDropzone.getQueuedFiles().length <= 1 && myDropzone.files[0].status == Dropzone.SUCCESS){
                
                $.ajax({
                    type : "POST",
                    url : "/send-update",
                    dataType: 'json',
                    data : {
                        quid:qid
                    },
                    success: function(response) {
                        console.log(response);
                        alert('All files uploaded successfully!');
                        $("#upload_modified").removeClass('disabled');
                        window.location.reload();
                    }
                });
            } else {
                $this.removeFile($this.files[0]);
            }
        });
    }
});

function previewImage(input){
    $('.alert').hide();
    let fileReference = input;
    console.log('file',fileReference);
    var filename = fileReference.name;
    if(fileReference){
        var reader = new FileReader();
        reader.onload = (event) => {
            $("#drz_gallery").prepend('<div class="lc-img-container d-inline-flex mr-2"><img src="'+event.target.result+'" class="thumb-lg img-thumbnail mt-3" title="/uploads/media/site_media/'+filename+'" data-type="image"/><a href="javascript:void(0)" id="remove_img" data-file="'+filename+'" data-id="0"><i class="mdi mdi-close-circle"></i></a></div>');
        }
        reader.readAsDataURL(fileReference); 
    }
        
}

$(document).on('click','#remove_img', function(){
    var $this = $(this);
    var filename = $this.data('file');
    if(confirm("Are you sure you want to delete this file?")) {
        if(myDropzone.getQueuedFiles().length > 0){
            myDropzone.getQueuedFiles().forEach(function (file,index) {
                console.log('filename',file);
                if($this.data('file') == file.name){
                    myDropzone.removeFile(myDropzone.files[index]);
                }
            });
        }
        if($this.data('id') != 0){
            delete_arr.push($this.data('id'));
        }
        $this.closest('.lc-img-container').remove();
    }        
});

$(document).on('click',"#upload_modified", function(){
    var btn = $(this);
    btn.addClass('disabled');
    if(delete_arr.length > 0){
        $.ajax({
            type : "POST",
            url : "/delete-image",
            dataType: 'json',
            data : {
                del:delete_arr
            },
            success: function(response) {
                console.log(response);
                if(myDropzone.getQueuedFiles().length > 0){
                    myDropzone.options.autoProcessQueue = true;
                    myDropzone.processQueue();
                } else {
                    alert("Files deleted successfully!");
                    btn.removeClass('disabled');
                    window.location.reload();
                }
            }
        });
    } else {
        if(myDropzone.getQueuedFiles().length > 0){
            myDropzone.options.autoProcessQueue = true;
            myDropzone.processQueue();
        } else {
            alert("There is nothing to upload!");
            btn.removeClass('disabled');
        }
    }
});
