@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<link href="{{ asset('/css/jquery.dm-uploader.min.css') }}" rel="stylesheet">
<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

      <div class="x_panel">
        <div class="x_title">
          <h2>Add User</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
                <form class="form-horizontal form-label-left" action="{{ url('/') }}/users/add" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}


                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">User Name</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input class="form-control" placeholder="User Name" type="text" name="name">
                      </div>
                  </div>
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Phone</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input class="form-control" placeholder="Phone Number" type="text" name="phone">
                      </div>
                  </div>
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Company Name</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input class="form-control" placeholder="Company Name" type="text" name="company">
                      </div>
                  </div> 
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Profile Image</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input class="form-control" type="file" name="image">
                      </div>
                  </div>
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Choose Role</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="role"  required id="role">
                                <option value="">--Role--</option>
                                @foreach($getRole as $role)
                                    <option value="{{ $role['id'] }}" >{{ $role['role'] }}</option>
                                @endforeach
                            </select>
                      </div>
                  </div>
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Choose Department</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="department"  required id="department">
                                <option value="">--Department--</option>
                                @foreach($getDepartment as $department)
                                    <option value="{{ $department['id'] }}">{{ $department['depart_name'] }}</option>
                                @endforeach
                            </select>
                      </div>
                  </div>
                    <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Choose Department</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="currency"  required id="currency">
                                <option value="">--Currency--</option>
                                @foreach($getCurrency as $currency)
                                    <option value="{{ $currency['id'] }}">{{ $currency['Currency_name'] }}</option>
                                @endforeach
                            </select>
                      </div>
                  </div>
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Email</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input class="form-control" placeholder="Email" type="text" name="email">
                      </div>
                  </div>
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Password</label>
                  </div>
                  <div class="form-group">                        
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input class="form-control" placeholder="Password" type="text" name="password">
                      </div>
                  </div>    
                  <div class="form-group" style="float:left">
                        <label for="content" class="col-sm-12 control-label">Status</label>
                  </div>    
                  <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="is_blocked">
                            <option value="0">--Status--</option>
                            <option value="0">Active</option>
                            <option value="1">De-active</option>
                          </select>
                        </div>
                  </div>    
                  <div class="ln_solid"></div>
                  <div class="form-group">
                  <div class="col-md-12 col-sm-12 col-xs-12 ">
                  <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/category'">Cancel</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>

          </div>
        </div>
    </div>
</div>
@endsection
