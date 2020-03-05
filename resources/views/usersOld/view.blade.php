@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<link href="{{ asset('/css/jquery.dm-uploader.min.css') }}" rel="stylesheet">
<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

     
        <div class="tab-content">
            <div id="main" class="tab-pane fade in active">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Title: <small>{{$user->name}}</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}

                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Name</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Title" type="text" name="title" value="{{$user->name}}">
                        </div>
                      </div>        
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Phone</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" placeholder="Price " type="text" name="price" value="{{$user->phone}}">
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Company</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" disabled type="text" name="punchline" value="{{$user->company_name}}">
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Role</label>
                      </div>
                      <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" type="text" placeholder="Role" name="role" value="{{ $user->role->role }}">
                        </div>
                      </div>
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Currency</label>
                      </div>
                      <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control" type="text" placeholder="Currency" name="currency" value="{{ $user->currency->currency_name }}">
                        </div>
                      </div>    
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Department</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control"  type="text" placeholder="Department" name="department" value="{{$user->depart_id }}">
                        </div>
                      </div> 
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Email</label>
                      </div>
                      <div class="form-group">                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input class="form-control"  type="text" placeholder="Time" name="time" value="{{$user->email}}">
                        </div>
                      </div>     
                      <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Attachments</label>
                      </div> 
                        
                      <div class="form-group">      
        
                                 @if($user->image_url)   
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                      <img src="{{ $user->image_url }}" style="max-width:200px; max-height:200px">
                                    </div>
                                @else
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                          No Image Found.
                                    </div>
                                @endif
                       </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/expense_list'">Back</button>
                        </div>
                      </div>

                    </form>
                    
                  </div>
                </div>
            </div>
    </div>
      
</div>
<script src="{{ url('/') }}/js/jquery.dm-uploader.min.js"></script>
<script src="{{ url('/') }}/js/demo-ui.js"></script>
<script src="{{ url('/') }}/js/demo-config.js"></script>


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
