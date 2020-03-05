

@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col" role="main">
  @include('layout/flash')
  <div class="x_panel">
      <div class="x_title">
        <h2>Show List</h2>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" style="color: white !important;" href="{{ route('roles.create') }}"> Create New Role</a>
            @endcan
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">     
          {{ csrf_field() }}             
          <table id="usersData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th>Name: {{ $role->name }}</th>
                      
                  </tr>
              </thead>
              <tbody>
                    <tr>
                        <td>
                           <div class="form-group">
                                <strong>Permissions:</strong>
                                @if(!empty($rolePermissions))
                                    @foreach($rolePermissions as $v)
                                        <label class="label label-success">{{ $v->name }},</label>
                                    @endforeach
                                @endif
                            </div>
                            
                        </td>
                      </tr>
              </tbody>
              <tfoot>
                    <tr> 
                      <th>Name: {{ $role->name }}</th>
                  </tr>
              </tfoot>
          </table>                              
        </div>
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
