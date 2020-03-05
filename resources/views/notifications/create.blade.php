@extends('layout.app.app', ['title' => __('Notification Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Edit Notification')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">

                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Notification Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       
                            <h6 class="heading-small text-muted mb-4">{{ __('Notification information') }}</h6>
                           {!! Form::open(array('route' => 'notifications.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
                            <div class="pl-lg-4">

                                <div class = "form-group">
                                    <strong>Role Name:</strong>
                                    <select class="form-control" name="role"  multiple>

                                        @foreach($roles as $role)
                                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                        @endforeach
                                    </select>
                                
                            </div>

                            
                            <div class = "form-group">
                            <strong>Department:</strong>
                            <select class="form-control" name="department" multiple>
                             @foreach($departments as $department)
                              <option value= "{{ $department['id'] }}">{{ $department['department'] }}</option>
                                        @endforeach
                              </select>
                            
                        </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-success" >Create Notification</button>
                            </div>
                                
                         
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        
        @include('layout.footers.auth')
    </div>
    <script type="text/javascript">
        $('.clockpicker').clockpicker({
            placement: 'top',
            align: 'left',
            donetext: 'Done'
        });
    </script>
@endsection