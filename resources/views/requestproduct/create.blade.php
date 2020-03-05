

@extends('layout.app.app', ['title' => __('Request Order Management')])
@section('content')

    @include('layout.headers.cards')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">

                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Request Order Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('requestproduct.index')}}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>

  
         
               <!--  <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#main">Main</a></li>
                    <li class="active"><a data-toggle="tab" href="#gallery">Notification</a></li>
                </ul> -->
                <div class="tab-content">
                    
                   
                      {!! Form::open(array('route' => 'requestproduct.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
                          
                            <div id="ajaxGetNotification">
                              
                            </div>
                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Product Category</label>
                            </div>
                            @if(count($product_categories)>0)
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="message_list" class="form-control" id="messageList">
                                    <option value="0">--Select Category--</option>
                                    @foreach($product_categories as $k=>$v)
                                        <option value="{{$v->id}}">{{$v->name}}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>
                            @endif
                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Product Subcategory</label>
                            </div>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <select class="form-control"  placeholder="Product Subcategory"  id="subcategory" name="subcategory">
                                 
                                  
                                </select>
                              </div>
                            </div>


                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Product Quantity</label>
                            </div>

                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="number" name="product_quantity" id="input-product_quantity" class="form-control form-control-alternative{{ $errors->has('product_quantity') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Quantity') }}"  required>
                              </div>
                            </div>

                          
                              <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                   <input type="hidden" id="booking_id" name="booking_id" value="">
                                   <br>
                                  <button type="submit" id="sendNotification" class="btn btn-success" style="margin-top: -50px;">Request Purchase Order</button>
                                </div>
                              </div>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                         
                    </div>
                

<script>
/*$(document).ready(function(){
    getNofication();
})

   jQuery('#sendNotification').click(function(){
    var booking_id = jQuery('#booking_id').val();
    var booking_msg = jQuery('#subcategory').val();
   alert(booking_id + '     --      '+booking_msg);
    jQuery.ajax({
        type: 'POST',
        url:'{{ url("/") }}/sendOrderNotification',
        data: {"booking_id":booking_id,"booking_msg":booking_msg},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function (data) {
             getNofication();
                    
        },
        error: function(data){
            
        }
        //alert('gfj');return false;
    })
})*/

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
