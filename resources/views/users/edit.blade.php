@extends('layout.app.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Edit User')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">

                            <div class="col-8">
                                <h3 class="mb-0">{{ __('User Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       

                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            {!! Form::model($users, ['method' => 'PATCH', 'enctype' => 'multipart/form-data' ,'route' => ['users.update', $users->id]]) !!}
                            <div class="pl-lg-4">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Company Name:</strong>
                                        {!! Form::text('company_name', null, array('placeholder' => 'Company Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class = "form-group">
                                        <strong>Department:</strong>
                                        <select class="form-control" name="department"  required>
                                            @foreach($getDepartment as $department)
                                                <option value="{{ $department['id'] }}" {{$users->department_id == $department['id']  ? 'selected' : ''}}>{{ $department['department'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>Project Name:</strong>
                                    <select class="form-control" name="project"  required>

                                        @foreach($getprojectName as $projectName)
                                            <option value="{{ $projectName['id'] }}" {{$users->project_id == $projectName['id']  ? 'selected' : ''}}>{{ $projectName['ProjectName'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class = "form-group">
                                        <strong>Currency:</strong>
                                        <select class="form-control" name="currency"  required>
                                            @foreach($getCurrency as $currency)
                                                <option value="{{ $currency['id'] }}" {{$users->currency_id == $currency['id']  ? 'selected' : ''}}>{{ $currency['currency_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Phone:</strong>
                                        {!! Form::text('phone', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Role:</strong>
                                        {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Profile:</strong>
                                        {!! Form::file('image') !!}
                                        <img src="{{ $users->image_url }}" style="max-width:200px; max-height:200px">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                      <select class="form-control" name="is_blocked">
                                        <option value="0">--Status--</option>
                                        <option value="1" @if ($users->is_blocked==1) selected @endif>Active</option>
                                        <option value="0" @if ($users->is_blocked==0) selected  @endif>De-active</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                                
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        
        @include('layout.footers.auth')
    </div>
@endsection