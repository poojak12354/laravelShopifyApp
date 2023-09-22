@extends('layouts.app')

@section('content')

<link href="{{ url('assets/vendors/dropzone/dropzone.min.css') }}" rel="stylesheet">
    
<script src="{{ url('assets/vendors/dropzone/dropzone.min.js') }}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card image-card">
                <div class="card-body">
                    <a href="{{ url('get-quotes') }}" class="btn btn-gradient-danger btn-fw link-btn-cmn"><i class="mdi mdi-arrow-left-bold-circle-outline"></i> Back to Listing</a>
                    <h4 class="card-title">Quote Images</h4>
                    
                    <h6>Client Uploaded </h6>
                    <div class="client-previews" id="drz_client_gallery">
                        @if(count($client) > 0)
                            @foreach($client as $img)
                                <div class="lc-img-container d-inline-flex mr-2">
                                    <a class="download_file" href="{{url('images/'.$img->quote_id.'/'.$img->url)}}" download><i class="mdi mdi-download"></i></a>
                                    <img src="{{url('images/'.$img->quote_id.'/'.$img->url)}}" class="thumb-lg img-thumbnail mt-3" title="{{$img->url}}" data-type="image"/>
                                </div>
                            @endforeach
                        @else
                            <div class="alert">No client media found!</div>
                        @endif
                    </div>
                    <hr/>
                    <h6>Modified Upload</h6>
                    <form action="" method="post" enctype="multipart/form-data" id="image_upload">
                        @csrf
                        <div class="dropzone wss-hidepreview upload-gallery">
                            <div class="fallback">
                                <input name="file[]" type="file" multiple="multiple">
                            </div>
                        </div>
                        <div class="dropzone-previews" id="drz_gallery">
                            @if(count($gallery) > 0)
                                @foreach($gallery as $gal)
                                    <div class="lc-img-container d-inline-flex mr-2">
                                        <a class="download_file" href="{{url('images/'.$gal->quote_id.'/'.$gal->url)}}" download><i class="mdi mdi-download"></i></a>
                                        <img src="{{url('images/'.$gal->quote_id.'/'.$gal->url)}}" class="thumb-lg img-thumbnail mt-3" title="{{$gal->url}}" data-type="image"/>
                                        <a href="javascript:void(0)" id="remove_img" data-file="{{$gal->url}}" data-id="{{$gal->id}}"><i class="mdi mdi-close-circle"></i></a>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert">No modified media found!</div>
                            @endif
                        </div>
                    </form>
                    <button type="button" id="upload_modified" class="btn btn-gradient-danger btn-fw link-btn__cmn"><i class="mdi mdi-floppy"></i> Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var qid = <?php echo $qid;?>;
</script>
<script src="{{ url('assets/js/media.js?123211') }}" defer></script>
@endsection