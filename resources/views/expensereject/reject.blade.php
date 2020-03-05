
@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col" role="main">
  @include('layout/flash')
  <div class="x_panel">
      <div class="x_title">
        <h2>Rejected Expense List</h2>
    <div class="pull-right">
      <label><input type="text" id="search" name="search" class="form-control input-sm" placeholder="Search" aria-controls="eventsData"></label>
      
    <a class="btn btn-warning" style="color: white !important;" href="{{ route('home') }}"> Back</a>
                    
        </div>
        <div class="clearfix"></div>
    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
    @endif
      </div>
      <div class="x_content">     
          {{ csrf_field() }}             
          <table id="usersData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th>S.No</th>
                      <th>Title</th>
                      <th>Price</th>
                      <th>UserName</th>
                      <th>Category</th>
                      <th>Currency</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>


                    @foreach ($search as $expense)
                    
            <tr>
            <td>{{ ++$i }}</td>

            <td>{{ $expense->title }}</td>
            <td>{{ $expense->price }}</td>
           
            <td>
                          
                  
                           
                              <label class="badge badge-success">fg</label>   
                          
                        </td>
            <td>{{ $expense->category }}</td>
                        <td>{{ $expense->currency }}</td>
            <td>
               <a class="btn btn-info" style="color: white !important" href="">Show</a>
              
            
            </td>
            </tr>
           @endforeach      
              </tbody>
              <tfoot>
                    <tr> 
            <th>S.No</th>
                      <th>Title</th>
                      <th>Price</th>
                      <th>UserName</th>
                      <th>Category</th>
                      <th>Currency</th>
                      <th>Action</th>
                  </tr>
              </tfoot>
          </table>                              
        </div>
</div>
<script type="text/javascript">
        $('#search').on('keyup',function(){
        $value=$(this).val();
        $.ajax({
        type : 'get',
        url : '{{URL::to('search')}}',
        data:{'search':$value},
        success:function(data){
        $('tbody').html(data);
        }
        });
        })
    </script>
        <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        </script>

   
@endsection

//message controller


@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col" role="main">
  @include('layout/flash')
  <div class="x_panel">
      <div class="x_title">
        <h2>Rejected Expense List</h2>
    <div class="pull-right">
      <label><input type="text" name="search" id="search" class="form-control input-sm" placeholder="Search" aria-controls="eventsData"></label>
      
    <a class="btn btn-warning" style="color: white !important;" href="{{ route('home') }}"> Back</a>
                    
        </div>
        <div class="clearfix"></div>
    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
    @endif
      </div>
      <div class="x_content">     
          {{ csrf_field() }}             
          <table id="usersData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th>S.No</th>
                      <th>Title</th>
                      <th>Price</th>
                      <th>UserName</th>
                      <th>Category</th>
                      <th>Currency</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>

                    @foreach ($datas as $expense)
                    
            <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $expense->title }}</td>
            <td>{{ $expense->price }}</td>
            <td>
                            @if($expense->name)
                  <label class="badge badge-success">{{ $expense->name }}</label>
                            @else
                              <label class="badge badge-success">{{ $expense->user->name }}</label>   
                            @endif
                        </td>
            <td>{{ $expense->category_name }}</td>
                        <td>{{ $expense->currency_name }}</td>
            <td>
               <a class="btn btn-info" style="color: white !important" href="{{ url('rejectexpenses/'.$expense->expenseId.'/RejectExpenseshow')}}">Show</a>
              
            
            </td>
            </tr>
           @endforeach      
              </tbody>
              <tfoot>
                    <tr> 
            <th>S.No</th>
                      <th>Title</th>
                      <th>Price</th>
                      <th>UserName</th>
                      <th>Category</th>
                      <th>Currency</th>
                      <th>Action</th>
                  </tr>
              </tfoot>
          </table>                              
        </div>
</div>
{!! $datas->render() !!}        
      <style>
        .dataTables_paginate a {
          background-color:#fff !important;
        }
        .dataTables_paginate .pagination>.active>a{
          color: #fff !important;
          background-color: #337ab7 !important;
        }
      </style>

      <script type="text/javascript">
       
        $('#search').on('keyup',function(){
        $value=$(this).val();
        $.ajax({
        type : 'get',
        url : '{{URL::to('search')}}',
        data:{'search':$value},
        success:function(data){
        $('tbody').html(data);
        }
        });
            
          });   
            
      </script>
   
   </script>
        <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        </script>
@endsection
