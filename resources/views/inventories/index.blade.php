@extends('layout.app.app', ['title' => __('Inventory Management')])

@section('content')
    @include('layout.headers.cards')
    <script>
        function getInfo(r) {
            $.ajax({
                url: '/view-product/'+r,
                type: 'GET',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                   // alert (response);
                    document.getElementById("item_name").value = response.item_name;
                    document.getElementById("ID").value = response.id;
                    //document.getElementById("subcategory").value = response.subcategory_id;
                   /* document.getElementById("balance").value = response.total_balance;
                    document.getElementById("paid").value = response.paid;*/    
                }
            });

        }
    </script>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
    input,select,textarea {
      border-top-style: hidden;
      border-right-style: hidden;
      border-left-style: hidden;
      border-bottom-style: groove;
      
      }
       .no-outline:focus {
      outline: none;
      }
    </style>
</head>
<body>


    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Manage Inventory') }}</h3>
                               
                            </div>
                            <div class="col-1">
                                <!-- {{url('/') }}/pdfview -->
                               <!--  route('pdfview',['download'=>'pdf']) -->
                                <a href="{{  route('pdfviewinventory',['download'=>'pdf']) }}" class="btn btn-sm btn-success" style="margin-left: 36px;">{{ __('PDF') }}</a>
                            </div>
                            <div class="col-1">
                                <button onClick ="$('#table').tableExport({type:'excel',escape:'false'});" class="btn btn-info btn-sm pull-right">CSV</button>
                            </div>
                           
                                
                           
                            <div class="col-2 text-right">
                                <a href="{{ route('inventory.create') }}" class="btn btn-sm btn-primary">{{ __('Add Inventory') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('#') }}</th>
                                    <th scope="col">{{ __('Item Name') }}</th>
                                    <th scope="col">{{ __('Initial Stock') }}</th>
                                    <th scope="col">{{ __('Current Stock') }}</th>
                                     <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Category Name') }}</th>
                                    <th scope="col">{{ __('Subcategory Name') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                        @foreach ($datas as $inventory)
                    
                        <tr>
                        <td>{{ ++$i }}</td>
                        <td><a href="{{ route('inventory.show',$inventory->id) }}">{{ $inventory->item_name }}</a></td>
                        <td>{{ $inventory->quantity }}</td>
                         <td>{{ $inventory->current_stock }}</td>
                        <td>                         
                            <label class="badge badge-success">Rs {{ $inventory->price }}.00</label>
                        </td>
                        <td>{{ \App\InventoryCategory::where(['id' => $inventory->category_id])->pluck('name')->first() }}</td>
                       
                        <td>{{ \App\InventoryCategory::where(['id' => $inventory->subcategory_id])->pluck('name')->first() }}</td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#invoiceModal" onclick="getInfo('{{$inventory->id}}');">+</button>

                        <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        @if ($inventory->id != auth()->id())
                        <form action="{{ route('inventory.destroy', $inventory->id) }}" method="post">
                        @csrf
                  @method('delete')
                  <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this Inventory?") }}') ? this.parentElement.submit() : ''">
                      {{ __('Delete') }}
                  </button>                                                       
                    <a class="dropdown-item" href="{{ route('inventory.edit',$inventory->id) }}">{{ __('Edit') }} </a>                            
                 </form>    
                @else
                <a class="dropdown-item" href=""></a>
                @endif
                    </div>
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
     <div class="modal fade" id="invoiceModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                          
                         <form method="get" action= "/updateproduct">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-red">Update product details</h4>
                        </div>
                        <div class="modal-body">                         
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>PO Invoice ID</td>
                                        <td><input type="text" id="invoice"  name="invoice" class="no-outline" id="invoice"  style="width: 80%;" required/></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>You Want To</td>
                                        <td>
                                            <select class=" no-outline" id="plus" name="symbol" style="width: 80%;" required>
                                                <option value="">You Want To ?</option> <option value="+">+</option> <option value="-">-</option>
                                            </select>
                                        </td>
                                    </tr>                                 
                                    <tr>
                                        <td></td>
                                        <td><label class="control-label"> Quantity:</label></td>
                                        <td><input onkeyup="checkValidation()"  class="no-outline" type="number" id="qtyIN" name="qty" style="width: 80%;" required/></td>
                                       
                                    </tr>

                                     <tr>
                                        <td></td>
                                        <td><label class="control-label"> Product Name:</label></td>
                                        <td><input type="text"  name="product_name" class="no-outline" id="item_name" style="width: 80%;" required/></td>
                                         <input id="ID" name="ID" type="hidden"  required/>
                                    </tr>
                                    
                                     <tr>
                                        <td></td>
                                        <td><label class="control-label">Comment:</label></td>
                                        <td><textarea name="comment" rows="2" resize="none" class="no-outline" id="comment" style="width: 80%;"></textarea></td>
                                    </tr>
                                 <tr>
                                        <td></td>
                                        <td>Product Category</td>
                                        <td>
                                            <select name="message_list" class=" no-outline" id="messageList" style="width: 80%;">
                                            <option value="0" required >--Select Category--</option>
                                            @foreach($product_categories as $k=>$v)
                                                <option value="{{$v->id}}">{{$v->name}}</option>
                                            @endforeach
                                        </select>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td>Product SubCategory</td>
                                        <td>
                                            <select class="no-outline"  placeholder="Product Subcategory"  id="subcategory" name="subcategory" required="" style="width: 80%;">

                                                </select>
                                        </td>
                                    </tr>

                                    

                                </tbody>

                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>                             
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>

                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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
     <script>

        /*function saveData() {
            alert(jhggjhg);
            var item_name = document.getElementById("item_name").value;
            var invoice = document.getElementById("invoice").value;
            var qty = document.getElementById("qtyIN").value;
            var plus = document.getElementById("plus").value;
            var price = document.getElementById("price").value;
            var category = document.getElementById("messageList").value;
           var subcategory = document.getElementById("subcategory").value;

            var productInfo = {
                
                item_name: item_name,
                invoice: invoice,
                qty: qty,
                price: price,
                category_id: category_id,
                subcategory_id: subcategory_id,
                plus: plus,
                };
            console.log(productInfo);
            $.ajax({
                data: {
                    data: productInfo
                },
                url: '/update-product-details',
                type: 'POST',
                beforeSend: function(request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(response) {
                    window.location = "/stock-manage";

                }
            })
        }*/
</script>
@endsection
