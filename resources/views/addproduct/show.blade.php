@extends('layout.app.app', ['title' => __('PO Management')])

@section('content')
    @include('layout.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Show PO.  Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('addproduct.index') }}" class="btn btn-sm btn-success">{{ __('Back to list') }}</a>
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
                           <mark> Product Name:</mark>
                           <small> {{ $product->product_name }}</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>PO-Invoice ID:</mark>
                           <small>#{{ $product->boxID }}</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>Product InvoiceID:</mark>
                            <small>{{ $product->product_invoice }}</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>Price:</<mark>
                            <label class="badge badge-success">Rs. {{ $product->price }}.00</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>Total Price:</<mark>
                            <label class="badge badge-success">Rs. {{ $product->total_price }}.00</label>
                        </div>
                    </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>Category:</mark>
                            <small>
                            {{ \App\InventoryCategory::where(['parent_id' => $product->category_id])->pluck('name')->first() }}</small>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <mark>Sub Category:</mark>
                           <small> {{ \App\InventoryCategory::where(['id' => $product->subcategory_id])->pluck('name')->first() }}</small>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                             <mark>Quantity: </mark>
                           <small> {{ $product->quantity }}</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                             <mark>Date: </mark>
                            <small>{{ $product->date }}</small>
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
