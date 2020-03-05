@extends('layout.app.app', ['title' => __('Inventory Management')])

@section('content')
    @include('layout.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Show PO Details') }}</h3>
                               
                            </div>
                            <div class="col-1">
                                <!-- {{url('/') }}/pdfview -->
                               <!--  route('pdfview',['download'=>'pdf']) -->
                                <a href="{{  route('pdfviewinventory',['download'=>'pdf']) }}" class="btn btn-sm btn-success" style="margin-left: 36px;">{{ __('PDF') }}</a>
                            </div>
                            <div class="col-1">
                                <button onClick ="$('#table').tableExport({type:'excel',escape:'false'});" class="btn btn-info btn-sm pull-right">CSV</button>
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
                                    <th scope="col">{{ __('User Name') }}</th>
                                     <th scope="col">{{ __('PO InvoiceID') }}</th>
                                    <th scope="col">{{ __('Quantitys') }}</th>
                                    <th scope="col">{{ __('Product Name') }}</th>                      
                                    <th scope="col">{{ __('Category Name') }}</th>
                                    <th scope="col">{{ __('Subcategory Name') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                        @foreach ($datas as $inventory)
                    
                        <tr>
                        <td>{{ ++$i }}</td>
                        <td><a href="{{ url('show/'.$inventory->id.'/showpodetails')}}">{{ \App\User::where(['id' => $inventory->user_id])->pluck('name')->first() }}</a>
                        </td>
                        <td><label class="badge badge-success"><abbr class="" title="PO-InvoiceID-#{{$inventory->invoice_id}}" >#{{ $inventory->invoice_id }}</abbr></label></td>
                        
                        <td>                         
                            {{ $inventory->qty }}
                        </td>
                         <td>{{ $inventory->product_name }}</td>
                        <td>{{ \App\InventoryCategory::where(['id' => $inventory->category_id])->pluck('name')->first() }}</td>
                       
                        <td>{{ \App\InventoryCategory::where(['id' => $inventory->subcategory_id])->pluck('name')->first() }}</td>
                        
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
