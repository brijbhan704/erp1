@extends('layout.app.app', ['title' => __('Notification Management')])

@section('content')
    @include('layout.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Show Notification  Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-success">{{ __('Back to list') }}</a>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            
                            <tbody>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            @foreach($users as $user)
                            <strong>Name:</strong>
                            {{\App\User::where(['id' => $user->user_id])->pluck('name')->first()}}
                        </div>
                    </div>
                    

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Department Name:</strong>
                            {{\App\Department::where(['id' => $user->department_id])->pluck('department')->first()}}
                        </div>
                    </div>

                    

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email-ID:</strong>
                            {{\App\User::where(['id' => $user->user_id])->pluck('email')->first()}}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Phone:</strong>
                            {{\App\User::where(['id' => $user->user_id])->pluck('phone')->first()}}
                        </div>
                    </div>

                    

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Company Name:</strong>
                            {{\App\User::where(['id' => $user->user_id])->pluck('company_name')->first()}}
                        </div>
                    </div>
                    @endforeach
                
                     
                            </tbody>
                        </table>
                    </div>
                   
                </div>
            </div>
        </div>
            
        @include('layout.footers.auth')
    </div>


      <style>
        .dataTables_paginate a {
          background-color:#fff !important;
        }
        .dataTables_paginate .pagination>.active>a{
          color: #fff !important;
          background-color: #337ab7 !important;
        }
      </style>

@endsection
