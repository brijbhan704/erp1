@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<link href="{{ asset('/css/jquery.dm-uploader.min.css') }}" rel="stylesheet">
<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#main">Main</a></li>
        <li><a data-toggle="tab" href="#gallery">Gallery</a></li>
    </ul>
      @foreach($expenseDatas as $expenseData)
        <div class="tab-content">
            <div id="main" class="tab-pane fade in active">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Title: <small>{{$expenseData->title}}</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/expense/update/{{$expenseData->id}}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}


                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">User ID</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" disabled  type="text" name="name" value="{{ $expenseData->user_id }}">
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Expense ID</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" disabled  type="text" name="name" value="{{ $expenseData->id }}">
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Title</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Title" type="text" name="title" value="{{$expenseData->title}}">
                        </div>
                      </div>        
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Price</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Price " type="text" name="price" value="{{$expenseData->price}}">
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">User Name</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" disabled type="text" name="punchline" value="{{$expenseData->userName}}">
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Date</label>
                      </div>
                      <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" type="text" placeholder="Date" name="date" value="{{$expenseData->date}}">
                        </div>
                      </div> 
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Time</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control"  type="text" placeholder="Time" name="time" value="{{$expenseData->time}}">
                        </div>
                      </div> 
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Select Category</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             
                            <select class="form-control" name="category" required id="currency">
                                @foreach($fetchCategory as $category)
                                    <option value="{{ $category['id'] }}" {{$expenseData->category_id == $category['id']  ? 'selected' : ''}}>{{ $category['category_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>     
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Select Currency</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             
                            <select class="form-control" name="currency" required id="currency">
                                @foreach($fetchCurrency as $currency)
                                    <option value="{{ $currency['id'] }}" {{$expenseData->currency_id == $currency['id']  ? 'selected' : ''}}>{{ $currency['currency_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>    
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Attachments</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="file" class="form-control" name="files[]" multiple>
                        </div>
                      </div> 
                        <div class="form-group">      
                            @foreach($attachments as $files)                  
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                  <img src="{{ $files['attach_link'] }}" style="max-width:200px; max-height:200px">
                                </div>
                            @endforeach
                        </div> 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/expense_list'">Cancel</button>
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                    
                  </div>
                </div>
            </div>
            
            <div id="gallery" class="tab-pane fade">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Amenities Gallery: <small>{{$expenseData->name}}</small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">                            
                                <!-- Our markup, the important part here! -->
                                <div id="drag-and-drop-zone" class="dm-uploader p-5">
                                    <h3 class="mb-5 mt-5 text-muted">Drag &amp; drop files here</h3>

                                    <div class="btn btn-primary btn-block mb-5">
                                        <span>Open the file Browser</span>
                                        <input type="file" title='Click to add Files' />
                                    </div>
                                </div><!-- /uploader -->

                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="card h-100">
                                    <div class="card-header">
                                    File List
                                    </div>

                                    <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
                                    <li class="text-muted text-center empty">No files uploaded.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12 col-sm-24">
                                <h3>Uploaded Images</h3>
                            </div>
                            <div class="col-md-12 col-sm-24">                                                            
                                <div id="imagelist">
                                    
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
        </div>

    </div>
      @endforeach
</div>
<script src="{{ url('/') }}/js/jquery.dm-uploader.min.js"></script>
<script src="{{ url('/') }}/js/demo-ui.js"></script>
<script src="{{ url('/') }}/js/demo-config.js"></script>

<!-- File item template -->
<script type="text/html" id="files-template">
    <li class="media">
    <div class="media-body mb-1">
        <p class="mb-2">
        <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
        </p>
        <div class="progress mb-2">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
            role="progressbar"
            style="width: 0%" 
            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        </div>
        </div>
        <hr class="mt-1 mb-1" />
    </div>
    </li>
</script>

<script>

function imagelist(id){
    jQuery.ajax({        
        type : 'POST',
        url : "{{url('/')}}/amenities/imagelist",
        data : {'id':id},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function (data) {
            var output = JSON.parse(data);
            var str = '';
            if(Object.keys(output).length > 0){
                $.each( output, function( key, val ) {
                    var selected = '';
                    if(val.default == 'Y'){
                        selected = 'checked';
                    }
                    str += '<div class="col-md-3 col-sm-6"><div class="polaroid"><img src="'+val.image+'" style="max-width:217px;max-height:250px"><div class="container"><p><input type="radio" name="default" onclick="setDefault('+val.id+')" '+selected+' value="'+val.id+'">&nbsp;Default<i class="fa fa-trash fontcls" onclick="deleteImage('+val.id+')" aria-hidden="true"></i></p></div></div></div>';
                });
                $('#imagelist').html(str);
            }else{
                $('#imagelist').html('No Image Found');    
            }
            
            
            
        },
        error: function(data){
        var output = JSON.parse(data)
        jQuery('#imagelist').html('<span style="color:red">'+output['message']+'</span>');
        }
    })
}

               
function setDefault(id){
    jQuery.ajax({        
        type : 'POST',
        url : "{{url('/')}}/expense/setDefault",
        data : {'id':id},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function (data) {
            imagelist({{$expenseData->id}});            
        },
        error: function(data){
        var output = JSON.parse(data)
        jQuery('#imagelist').html('<span style="color:red">'+output['message']+'</span>');
        }
    })
}
function deleteImage(id){
    if(confirm('Are you sure want to delete image')){
        jQuery.ajax({        
            type : 'POST',
            url : "{{url('/')}}/expense/deleteImage",
            data : {'id':id},
            beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
            success: function (data) {
                imagelist({{$expenseData->id}});            
            },
            error: function(data){
            var output = JSON.parse(data)
            jQuery('#imagelist').html('<span style="color:red">'+output['message']+'</span>');
            }
        })
    }
    
}

$(function(){
  /*
   * For the sake keeping the code clean and the examples simple this file
   * contains only the plugin configuration & callbacks.
   * 
   * UI functions ui_* can be located in: demo-ui.js
   */
  $('#drag-and-drop-zone').dmUploader({ //
    url: "{{url('/')}}/amenities/uploadFiles/{{$expenseData->id}}",
    maxFileSize: 3000000, // 3 Megs 
    headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
    onDragEnter: function(){
      // Happens when dragging something over the DnD area
      this.addClass('active');
    },
    onDragLeave: function(){
      // Happens when dragging something OUT of the DnD area
      this.removeClass('active');
    },
    onInit: function(){
      // Plugin is ready to use
      ui_add_log('Penguin initialized :)', 'info');
    },
    onComplete: function(){
      // All files in the queue are processed (success or error)
      ui_add_log('All pending tranfers finished');
    },
    onNewFile: function(id, file){
      // When a new file is added using the file selector or the DnD area
      ui_add_log('New file added #' + id);
      ui_multi_add_file(id, file);
    },
    onBeforeUpload: function(id){
      // about tho start uploading a file
      ui_add_log('Starting the upload of #' + id);
      ui_multi_update_file_status(id, 'uploading', 'Uploading...');
      ui_multi_update_file_progress(id, 0, '', true);
    },
    onUploadCanceled: function(id) {
      // Happens when a file is directly canceled by the user.
      ui_multi_update_file_status(id, 'warning', 'Canceled by User');
      ui_multi_update_file_progress(id, 0, 'warning', false);
    },
    onUploadProgress: function(id, percent){
      // Updating file progress
      ui_multi_update_file_progress(id, percent);
    },
    onUploadSuccess: function(id, data){
      if(data.status=="error"){
        ui_multi_update_file_status(id, 'danger', data.message);
        ui_multi_update_file_progress(id, 0, 'danger', false);  
      }else{
        // A file was successfully uploaded
        ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
        ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
        ui_multi_update_file_status(id, 'success', 'Upload Complete');
        ui_multi_update_file_progress(id, 100, 'success', false);
        imagelist({{$expenseData->id}});
      }
      
    },
    onUploadError: function(id, xhr, status, message){
      ui_multi_update_file_status(id, 'danger', message);
      ui_multi_update_file_progress(id, 0, 'danger', false);  
    },
    onFallbackMode: function(){
      // When the browser doesn't support this plugin :(
      ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
    },
    onFileSizeError: function(file){
      ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
    }
  });

  imagelist({{$expenseData->id}});

});

</script>
<style>

.dm-uploader {
    border: 0.25rem dashed #A5A5C7;
    text-align: center;
}
.dm-uploader.active {
	border-color: red;

	border-style: solid;
}
.card-header:first-child {
    border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
}

.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125);
}

@media (min-width: 768px)
.col-md-6 {
    /* -webkit-box-flex: 0; */
    -ms-flex: 0 0 50%;
    /* flex: 0 0 50%; */
    max-width: 50%;
}   
#files {
    min-height: 0;
}
#files {
    overflow-y: scroll !important;
    min-height: 320px;
}
.p-2 {
    padding: .5rem!important;
}

.p-5 {
    padding: 3rem!important;
}
.mb-5, .my-5 {
    margin-bottom: 11rem!important;
}
.mt-5, .my-5 {
    margin-top: 3rem!important;
}
.h3, h3 {
    font-size: 1.75rem;
}
#imagelist p {
   margin: 0 0 0px;
}
#imagelist div.polaroid {  
  background-color: white;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  margin-bottom: 25px;
}

#imagelist .fontcls {
    float: right;
    margin: 0 4px 0 0;
    font-size: 16px;
    color: red;
    cursor:pointer;
}

#imagelist div.container {  
  padding: 10px 5px;
}

</style>

@endsection
