@extends('layout.app.app', ['title' => __('Inventory Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Add Inventory')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Inventory Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      {!! Form::open(array('route' => 'inventory.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}

                     
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Item Name:</strong>
                                    {!! Form::text('item_name', null, array('placeholder' => 'Title','class' => 'form-control','required')) !!}
                                </div>
                            </div>
                          <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left"> <strong>Product Category </strong></label>
                            </div>
                            @if(count($product_categories)>0)
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <select class="form-control" id="messageList" name="category">
                                    <option value="0" required >--Select Category--</option>
                                    @foreach($product_categories as $k=>$v)
                                        <option value="{{$v->id}}">{{$v->name}}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>
                            @endif
                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left"> <strong>Product Subcategory </strong></label>
                            </div>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <select class="form-control"  placeholder="Product Subcategory"  id="subcategory" name="subcategory" required="">
                                 
                                  
                                </select>
                              </div>
                            </div>
                           
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Initial Stock:</strong>
                                    {!! Form::number('quantity', null , array('placeholder' => 'Initial Stock' ,'class' => 'form-control','required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Current Stock:</strong>
                                    {!! Form::number('current_stock', null , array('placeholder' => 'Current Stock' ,'class' => 'form-control','required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Price:</strong>
                                    {!! Form::number('price', null , array('placeholder' => 'Price' ,'class' => 'form-control','required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Serial Number:</strong>
                                    {!! Form::text('serial_number', null , array('placeholder' => 'Serial Number' ,'class' => 'form-control','required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Start Time:</strong>
                                    <div class="input-group clockpicker">
                                        {!! Form::text('start_time', '18:00' , array('placeholder' => 'Start Time' ,'class' => 'form-control','required')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>        
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>End Time:</strong>
                                    <div class="input-group clockpicker">
                                        {!! Form::text('end_time', '18:30' , array('placeholder' => 'End Time' ,'class' => 'form-control','required')) !!}
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>        
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    {!! Form::textarea('description', null , array('placeholder' => 'Description' ,'class' => 'form-control','required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Attachments :</strong>
                                    {!! Form::file('image[]', array('multiple','required')) !!}
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
    <script type="text/javascript">
    $('#messageList').change(function(){
  //alert(kjh) return false;
    var id = $('#messageList').val();
    if(id==0) {return false;}
    $.ajax({
        type: 'POST',
        url:'{{ url("/") }}/getSubcategoryById',
        data: {"id":id},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function (response) {
          //alert(response);
          var data = $.parseJSON(response);
          var str = "";
          $.each(data, function (index, value) {      
            str += '<option  value="'+value.id+'">'+value.name+'</option>';

           });
          //alert (data);
            $('#subcategory').html(str);        
        }
    })

});
    </script>
@endsection