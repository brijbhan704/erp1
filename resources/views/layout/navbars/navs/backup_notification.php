<form class=" navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="form-group mb-0">
                <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                        <i class="fa fa-bell" style="font-size: 25px; color:white;"></i>
                            <span class="label-count">{{ (\DB::table('notifications')->count()) + (\DB::table('tbl_products')->count())  }}</span>
                        </a>
                       
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0 text-center">{{ __('Notifications!') }}</h6>
                    </div>
                    <a href="" data-toggle="modal" data-target="#invoiceModal"class="dropdown-item" onclick="getInfo();">
                        <i class="ni ni-single-02" style="background-color: #d3d5d8;
                     border-radius: 50%;
                     border: 1x solid black;
                     padding:10px;"></i>
                     <span class="label-count1">{{ \DB::table('notifications')->count()  }}</span>
                        <span class="text">{{ __('Request Orders Notifications') }}</span>
                    </a>
                   
                    <a href="{{url('/')}}/potNotification" class="dropdown-item">
                        <i class="ni ni-single-02" style="background-color: #d3d5d8;
                         border-radius: 50%;
                         border: 1x solid grey;
                         padding:10px;"></i>
                          <span class="label-count2">{{ \DB::table('tbl_products')->count()  }}</span>
                        <span class="text">{{ __('Purchase Orders Notifications') }}</span>
                    </a>
                </div>
            </li>
            </div>
        </form>
<script type="text/javascript">
        function getInfo() {
            $.ajax({
                url: '/requestNotification/',
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
         <style type="text/css">
   
    .label-count {
    position: absolute;
    top: -7px;
    right: 15px;
    font-size: 12px;
    line-height: 15px;
    background-color: #7d3443;
    color: white;
    padding: 1px 4px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    border-radius: 29px !important;

}

.dropdown-menu .header {
    font-size: 13px;
    font-weight: bold;
    min-width: 270px;
    border-bottom: 1px solid #eee;
    text-align: center;
    padding: 4px 0 6px 0;
}
.allnotification{
    text-align: center !important;
    border-top: 1px solid #eee;
    padding: 5px 0 5px 0;
    font-size: 12px;
    margin-left: 80px;

}
.label-count1{
     position: absolute;
    top: 41px;
    right: 211px;
   font-size: 13px;
    line-height: 15px;
    background-color:#8898aa;
    color: white;
    padding: 2px 6px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    border-radius: 29px !important;
    
}
.label-count2{
     position: absolute;
     top: 95px;
    right: 211px;
    font-size: 13px;
   font-size: 13px;
    line-height: 15px;
    background-color:#8898aa;
    color: white;
    padding: 2px 6px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    border-radius: 29px !important;
    
}
.text{
    font-size: 13px;
}
</style>