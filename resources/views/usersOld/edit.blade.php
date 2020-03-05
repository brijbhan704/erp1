@extends('layout.app')

@section('content')
<div class="right_col" role="main">
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>{{$users->name}} <small>{{$users->email}}</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/users/update/{{$users->id}}" method="POST" enctype="multipart/form-data" >
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Name" type="text" name="name" value="{{$users->name}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Company</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Last name" type="text" name="company" value="{{$users->company_name}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Last name" type="text" name="phone" value="{{$users->phone}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Role</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="role"  required id="role">
                                @foreach($getRole as $role)
                                    <option value="{{ $role['id'] }}" {{$users->role_id == $role['id']  ? 'selected' : ''}}>{{ $role['role'] }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Department</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="department"  required id="department">
                                @foreach($getDepartment as $department)
                                    <option value="{{ $department['id'] }}" {{$users->depart_id == $department['id']  ? 'selected' : ''}}>{{ $department['depart_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Currency</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="currency"  required id="currency">
                                @foreach($getCurrency as $currency)
                                    <option value="{{ $currency['id'] }}" {{$users->currency_type == $currency['id']  ? 'selected' : ''}}>{{ $currency['currency_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Email" readonly type="text" name="email" value="{{$users->email}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="content" class="control-label col-md-3 col-sm-3 col-xs-12">Profile Image</label>                    
                      <div class="col-md- col-sm-9 col-xs-12">
                            <input class="form-control" type="file" name="image">
                            @if($users->image_url)
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                  <img src="{{ $users->image_url }}" style="max-width:200px; max-height:200px">
                            </div>
                          @else
                            <div class="col-md-6 col-sm-6 col-xs-6">No Image Found</div>
                          @endif
                      </div>
                  </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="is_blocked">
                            <option value="0">--Status--</option>
                            <option value="0" @if ($users->is_blocked==1) selected @endif>Active</option>
                            <option value="1" @if ($users->is_blocked==0) selected  @endif>De-active</option>
                          </select>
                        </div>
                        </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/users'">Cancel</button>
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
