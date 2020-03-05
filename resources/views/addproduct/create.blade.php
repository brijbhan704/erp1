

@extends('layout.app.app', ['title' => __('Request Order Management')])
@section('content')

    @include('layout.headers.cards')
   

    <?php
  /* ///Purchase ID creation
    $boxID = \App\StockPurchase::select('boxID')
        ->orderBy('boxID', 'desc')
        ->get();
    if(sizeof($boxID)==0)
        $invoice_boxID=55005;
    else
        $invoice_boxID= $boxID[0]->boxID+1;
//echo $invoice_boxID;die;
    //var_dump($all_published_brand);
    ?>

    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <?php
    echo Session::put('message','');*/

?>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                     <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add Product ') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('addproduct.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'addproduct.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}

                          
                            <div id="ajaxGetNotification">
                              
                            </div>
                            <table class=" table-hover">
                              <tr>
                                  <td><label class="control-label">PO Invoice ID:</label></td>
                                  <td>                              
                                  <label class="badge badge-success" name="boxID" style="font-size: 18px;">
                                  {{ $invoice_boxID }}
                                  </label>
                                  </td>
                                 
                              </tr>
                            </table>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Product InvoiceID:</strong>
                                    {!! Form::text('product_invoice', null, array('placeholder' => 'Product InvoiceID','class' => 'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Product Name:</strong>
                                    {!! Form::text('product_name', null, array('placeholder' => 'Product Name','class' => 'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left"> <strong>Product Category </strong></label>
                            </div>
                            @if(count($product_categories)>0)
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="message_list" class="form-control" id="messageList">
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
                                    <strong>Product Qty:</strong>
                                    {!! Form::number('quantity', null , array('placeholder' => 'Quantity' ,'class' => 'form-control' ,'required'=>'required')) !!}
                                </div>
                            </div>

                          <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Price:</strong>
                                    {!! Form::number('price', null , array('placeholder' => 'Price' ,'class' => 'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Total Price:</strong>
                                    {!! Form::number('total_price', null , array('placeholder' => 'Total Price' ,'class' => 'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                             <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Product Serial Number:</strong>
                                    {!! Form::text('serial_number', null , array('placeholder' => 'Serial Number' ,'class' => 'form-control','required'=>'required')) !!}
                                </div>
                            </div> -->
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Date:</strong>
                                    {!! Form::date('date', null , array('placeholder' => 'Date' ,'class' => 'form-control','required'=>'required')) !!}
                                </div>
                            </div>
                              <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                   <input type="hidden" id="booking_id" name="booking_id" value="">
                                   <br>
                                  <button type="submit" id="sendNotification" class="btn btn-success" style="margin-top: -50px;" >Submit Product</button>
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
