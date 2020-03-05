@extends('layout.app.app', ['title' => __('PO Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Edit Inventory')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">

                            <div class="col-8">
                                <h3 class="mb-0">{{ __('PO Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('addproduct.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       
                            <h6 class="heading-small text-muted mb-4">{{ __('PO information') }}</h6>
                           {!! Form::model($Products, ['method' => 'PATCH', 'enctype' => 'multipart/form-data' ,'route' => ['addproduct.update', $Products->id]]) !!}
                            <div class="pl-lg-4">
                                
                          <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Product Name:</strong>
                                    {!! Form::text('product_name', null, array('placeholder' => 'Product Name','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>Category:</strong>
                                    <select class="form-control" name="category" id="category">
                                        <option value="">Select</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}" {{$Products->category_id == $category['id']  ? 'selected' : ''}}>{{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class = "form-group">
                                    <strong>SubCategory:</strong>
                                    <select class="form-control" name="subcategory" id="subcategory">
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory['id'] }}" {{$Products->subcategory_id == $subcategory['id']  ? 'selected' : ''}}>{{ $subcategory['name'] }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Quantity:</strong>
                                    {!! Form::number('quantity', null , array('placeholder' => 'Quantity' ,'class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Price:</strong>
                                    {!! Form::number('price', null, array('placeholder' => 'Price','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Serial Number:</strong>
                                    {!! Form::text('serial_number', null , array('placeholder' => 'Serial Number' ,'class' => 'form-control')) !!}
                                </div>
                            </div>
                           
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Date:</strong>
                                    {!! Form::text('date', null , array('placeholder' => 'Date' ,'class' => 'form-control')) !!}
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style= "margin-top: 5px;">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    $('#category').change(function(){
    var categoryID = $(this).val();    
    if(categoryID){
        $.ajax({
           type:"GET",
           url:"{{url('subcategorylist')}}/"+categoryID,
           success:function(res){               
            if(res){
                $("#subcategory").empty();
                $("#subcategory").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#subcategory").append('<option value="'+key+'">'+value+'</option>');
                });
           
            }else{
               $("#subcategory").empty();
            }
           }
        });
    }else{
        $("#subcategory").empty();
    }      
   });
    
</script>
@endsection