@extends('layout.app.app', ['title' => __('Category Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Add Category')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Category Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('category.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       {!! Form::open(array('route' => 'category.store','method'=>'POST')) !!}

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Category Name:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Category Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                       
                        {!! Form::close() !!}
                
                    </div>
                </div>
            </div>
        </div>
        
        @include('layout.footers.auth')
    </div>
@endsection