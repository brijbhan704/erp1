@extends('layout.app.app', ['title' => __('Role Management')])

@section('content')
    @include('layout.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Roles') }}</h3>
                               
                            </div>
                            <div class="col-1">
                                <!-- {{url('/') }}/pdfview -->
                               <!--  route('pdfview',['download'=>'pdf']) -->
                                <a href="{{  route('pdfview',['download'=>'pdf']) }}" class="btn btn-sm btn-success" style="margin-left: 36px;">{{ __('PDF') }}</a>
                            </div>
                            <div class="col-1">
                                <a href="{{ route('export') }}" class="btn btn-sm btn-info">{{ __('CSV') }}</a>
                            </div>
                           
                                
                           
                            <div class="col-2 text-right">
                                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">{{ __('Add Role') }}</a>
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
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Sr No') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                     <th scope="col">{{ __('Creation Date') }}</th>                             
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                             <td>{{ $role->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                            </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            @if ($role->id != auth()->id())


                <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                @csrf
                  @method('delete')
                  <button type="submit" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this roles?") }}') ? this.parentElement.submit() : ''">
                      {{ __('Delete') }}
                  </button>
                                                            
                <a class="dropdown-item" href="{{ route('roles.edit',$role->id) }}">{{ __('Edit') }}                               
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
               {!! $roles->render() !!} 
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
