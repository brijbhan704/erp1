@extends('layout.app.app', ['title' => __('Expense Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Add Expense')])   

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
                       {!! Form::open(array('route' => 'expenses.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
                       <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Price:</strong>
                                    {!! Form::number('price', null, array('placeholder' => 'Price','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>Category:</strong>
                                    <select class="form-control" name="category">
                                        @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['category_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>Currency:</strong>
                                    <select class="form-control" name="currency">
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency['id'] }}">{{ $currency['currency_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>Project Name:</strong>
                                    <select class="form-control" name="project">
                                        @foreach($projects as $project)
                                            <option value="{{ $project['id'] }}">{{ $project['ProjectName'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                             <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>Department Name:</strong>
                                    <select class="form-control" name="department">
                                        @foreach($departments as $department)
                                            <option value="{{ $department['id'] }}">{{ $department['department'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Date:</strong>
                                    {!! Form::date('date', null , array('placeholder' => 'Date' ,'class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Time:</strong>
                                    <div class="input-group clockpicker">
                                        {!! Form::text('time', '18:00' , array('placeholder' => 'Time' ,'class' => 'form-control')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>        
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Attachments :</strong>
                                    {!! Form::file('image[]', array('multiple')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit Expense</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                
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