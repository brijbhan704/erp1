@extends('layout.app.app', ['title' => __('Expense Management')])

@section('content')
    @include('layout.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-10">
                                <h3 class="mb-0">{{ __('Reject Expense') }}</h3>
                            </div>
                            <!-- <div class="pull-right">
                              <label><input type="search" name="search" id="search" class="form-control input-sm" placeholder="Search by title" aria-controls="eventsData"></label>
                              
                            <a class="btn btn-warning" style="color: white !important;" href="{{ route('home') }}"> Back</a>
                    
                            </div> -->
                            <div class="col-1">
                                <!-- {{url('/') }}/pdfview -->
                               <!--  route('pdfview',['download'=>'pdf']) -->
                                <a href="{{ route('pdfviewReject',['download'=>'pdf']) }}" class="btn btn-sm btn-success" style="margin-left: 36px;">{{ __('PDF') }}</a>
                            </div>
                            <div class="col-1">
                                <a href="{{route('export/rejectexpense')}}" class="btn btn-sm btn-info">{{ __('CSV') }}</a>
                            </div>
                             
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Sr No') }}</th>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                     <th scope="col">{{ __('UserName') }}</th>
                                     <th scope="col">{{ __('Category Name') }}</th>
                                     <th scope="col">{{ __('Currency Name') }}</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                         @foreach ($datas as $expense)
                    
                        <tr>
                        <td>{{ ++$i }}</td>
                        <td><a href="{{ url('rejectexpenses/'.$expense->expenseId.'/RejectExpenseshow')}}">{{ $expense->title }}</a></td>
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
                        <td class="text-right">
                        <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                        </a>
                        
                        </div>
                        </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                   <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                           {!! $datas->render() !!} 
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

       <script type="text/javascript">
      
        $('#search').on('keyup',function(){
            
        $value=$(this).val();
        $.ajax({
        type : 'get',
        url : '{{URL::to('searchApproved')}}',
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
