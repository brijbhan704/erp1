@extends('layout.app.app', ['title' => __('Expense Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Edit Expense')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">

                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Expense Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       
                            <h6 class="heading-small text-muted mb-4">{{ __('Expense information') }}</h6>
                            {!! Form::model($expense, ['method' => 'PATCH', 'enctype' => 'multipart/form-data' ,'route' => ['expenses.update', $expense->id]]) !!}
                            <div class="pl-lg-4">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Price:</strong>
                                    {!! Form::number('price', null, array('placeholder' => 'Price','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>Category:</strong>
                                    <select class="form-control" name="category"  required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}" {{$expense->category_id == $category['id']  ? 'selected' : ''}}>{{ $category['category_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>Currency:</strong>
                                    <select class="form-control" name="currency"  required>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency['id'] }}" {{$expense->category_id == $category['id']  ? 'selected' : ''}}>{{ $currency['currency_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Date:</strong>
                                    {!! Form::date('date', null , array('placeholder' => 'Date' ,'class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Time:</strong>
                                    <div class="input-group clockpicker">
                                        {!! Form::text('time', '18:00' , array('placeholder' => 'Time' ,'class' => 'form-control', 'required')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>        
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong>Attachments:</strong>
                                <div class="form-group" style= "margin-top: 5px;"> 
                                        {!! Form::file('image[]') !!}
                                        @foreach($attachments as $files) 
                                             @if($files['attach_link'])   
                                                <div class="col-md-6 col-sm-6 col-xs-6" style= "margin-top: 5px;">
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
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                                
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        
        @include('layout.footers.auth')
    </div>
    <script type="text/javascript">
        $('.clockpicker').clockpicker({
            placement: 'top',
            align: 'left',
            donetext: 'Done'
        });
    </script>
@endsection