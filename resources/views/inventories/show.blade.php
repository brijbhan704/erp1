@extends('layout.app.app', ['title' => __('Inventory Management')])

@section('content')
    @include('layout.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Show Inventory  Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-success">{{ __('Back to list') }}</a>
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
                         <mark> Item Name:</mark>
                            <small> {{ $inventory->item_name }}</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <mark> Serial Number:</mark>
                           <small> {{ $inventory->serial_number }}</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>Price:</mark>
                            <label class="badge badge-success">{{ $inventory->price }}</label>
                        </div>
                    </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <mark> Category:</mark>
                            <small>{{ \App\InventoryCategory::where(['parent_id' => $inventory->category_id])->pluck('name')->first() }}</small>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <mark> Sub Category:</mark>
                            <small> {{ \App\InventoryCategory::where(['id' => $inventory->subcategory_id])->pluck('name')->first() }}</small>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <mark> Quantity:</mark>
                             <small>{{ $inventory->quantity }}</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <mark> Start Time:</mark>
                           <small> {{ $inventory->start_time }}</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>End Time:</mark>
                           <small> {{ $inventory->end_time }}</small>
                        </div>
                    </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <mark> Description:</mark>
                           <small> {{ $inventory->description }}</small>
                        </div>
                    </div>
                  
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <mark>Image:</mark>
                        <div class="form-group"> 
                              
                            <div class="col-md-3 col-sm-3 col-xs-3">
                              <img src="{{ $inventory->item_image }}" style="max-width:150px !important;">
                            </div>
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
