@extends('layout.app.app', ['title' => __('Request Order Management')])

@section('content')
    @include('layout.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Request Order') }}</h3>
                               
                            </div>
                            <div class="col-1">
                                <button onClick ="$('#table').tableExport({type:'pdf',escape:'false',pdfFontSize:12,separator: ','});" class="btn btn-success btn-sm pull-right" style="    margin-right: -37px;">PDF</button>
                            </div>
                            <div class="col-1">
                                <button onClick ="$('#table').tableExport({type:'excel',escape:'false'});" class="btn btn-info btn-sm pull-right">CSV</button>
                            </div>
                              
                            <div class="col-2 text-right">
                                <a href="{{ route('requestproduct.create') }}" class="btn btn-sm btn-primary">{{ __('Add New Requested') }}</a>
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
                        <table class="table align-items-center table-flush" data-ride="datatables" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Sr No') }}</th>
                                    <th scope="col">{{ __('User Name') }}</th>
                                    <th scope="col">{{ __('Category Name') }}</th>
                                     <th scope="col">{{ __('Subcategory Name') }}</th>
                                    <th scope="col">{{ __('Quantity') }}</th>
                                    
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                        @foreach ($products as $product)
                    
                        <tr>
                        <td>{{ ++$i }}</td>
                        <td><label class="badge badge-success">{{ \App\User::where(['id' => $product->user_id])->pluck('name')->first() }}</label></td>

                        <td>{{ \App\InventoryCategory::where(['parent_id' => $product->category_id])->pluck('name')->first() }}</td>
                       
                        <td>{{ \App\InventoryCategory::where(['id' => $product->subcategory_id])->pluck('name')->first() }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td class="text-right">
                        <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        @if ($product->id != auth()->id())
                        <form action="{{ route('requestproduct.destroy', $product->id) }}" method="post">
                        @csrf
                  @method('delete')
                  <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this Product?") }}') ? this.parentElement.submit() : ''">
                      {{ __('Delete') }}
                  </button>                                                       
                    <a class="dropdown-item" href="{{ route('requestproduct.edit',$product->id) }}">{{ __('Edit') }} </a>                            
                 </form>    
                @else
                <a class="dropdown-item" href="{{ url('/') }}/profile">{{ __('Edit') }}</a>
                @endif
                    </div>
                        </div>
                        </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                   <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                           {!! $products->render() !!} 
                        </nav>
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
