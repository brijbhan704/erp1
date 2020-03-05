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
                                <h3 class="mb-0">{{ __('Show PO  Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ url('/') }}/showdetails" class="btn btn-sm btn-success">{{ __('Back to list') }}</a>
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
                           <mark> User Name:</mark>
                           {{ \App\User::where(['id' => $tblProduct->user_id])->pluck('name')->first() }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <mark> PO InvoiceID:</mark>
                            <label class="badge badge-success">#{{ $tblProduct->invoice_id }}</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                         <mark> Product Name:</mark>
                             {{ $tblProduct->product_name }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <mark>Comment:</mark>
                            {{ $tblProduct->comment }}
                        </div>
                    </div>
                    
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <mark> Quantity:</mark>
                           <label class="badge badge-success">  {{ $tblProduct->qty }}</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>Symbole:</mark>
                            <label class="badge badge-success" style="font-size: 20px;"> {{ $tblProduct->symbol }}</label>
                        </div>
                    </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <mark> Category:</mark>
                           {{ \App\InventoryCategory::where(['parent_id' => $tblProduct->category_id])->pluck('name')->first() }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <mark> Sub Category:</mark>
                            {{ \App\InventoryCategory::where(['id' => $tblProduct->subcategory_id])->pluck('name')->first() }}
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
