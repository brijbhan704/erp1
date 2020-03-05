@extends('layout.app.app', ['title' => __('Expense Management')])

@section('content')
    @include('layout.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Show Expense  Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-success">{{ __('Back to list') }}</a>
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
                            <strong>Title:</strong>
                            {{ $expense->title }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Price:</strong>
                            {{ $expense->price }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>User:</strong>
                            <label class="badge badge-success">{{ $expense->user->name }}</label>
                        </div>
                    </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Category:</strong>
                            {{ $expense->category_name }}
                        </div>
                    </div>
                    <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Currency:</strong>
                            {{ $expense->currency_name }}
                        </div>
                    </div> -->
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Date:</strong>
                            {{ $expense->date }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Time:</strong>
                            {{ $expense->time }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Attachments:</strong>
                        <div class="form-group"> 
                                
                                @foreach($attachments as $files) 
                                     @if($files['attach_link'])   
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                          <img src="{{ $files['attach_link'] }}" style="max-width:100px; max-height:100px">
                                        </div>
                                    @else
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                              No Image Found.
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                      </div>
                     
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
