

@extends('layout.app.app', ['title' => __('Expense Management')])
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
                                <h3 class="mb-0">{{ __('Reject Expense Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>

  
         
               <!--  <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#main">Main</a></li>
                    <li class="active"><a data-toggle="tab" href="#gallery">Notification</a></li>
                </ul> -->
                <div class="tab-content">
                    
                   
                       <form class="form-horizontal form-label-left" action="" method="POST" enctype="multipart/form-data">
                          
                            <div id="ajaxGetNotification">
                              
                            </div>
                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Message List</label>
                            </div>
                            @if(count($message)>0)
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="message_list" class="form-control" id="messageList">
                                    <option value="0">--Select Message--</option>
                                    @foreach($message as $k=>$v)
                                        <option value="{{$v->id}}">{{$v->title}}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>
                            @endif
                            <div class="form-group">
                              <label for="content" class="col-sm-12" style="float:left">Notifications</label>
                            </div>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <textarea class="form-control" rows="3" placeholder="Notification" id="booking_msg" name="booking_msg" resize="none"></textarea>
                              </div>
                            </div>
                            
                              
                              <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                   <input type="hidden" id="booking_id" name="booking_id" value="{{$id}}">
                                   <br>
                                  <button type="button" id="sendNotification" class="btn btn-success" style="margin-top: -60px;">Sent Notification</button>
                                </div>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                         
                    </div>
                

<script>
$(document).ready(function(){
    getNofication();
})
function getNofication(){
    var booking_id = jQuery('#booking_id').val();
    $.ajax({
        url:'{{ url("/") }}/expenses/getNotification',
        type: 'POST',
        data: {"booking_id":booking_id},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function(res){
            res = $.parseJSON(res);
            var str = '<table id="eventsData" class="table align-items-center table-flush table-striped table-bordered">';
            str += '<tr><th>S. No</th><th>Notification</th><th>Sent date</th></tr>';
            $.each(res, function( index, value ) {
                
              str += '<tr>';        
                str += '<td>' + (index+1) + '</td><td>' + value.notification + '</td><td>' + value.created_at + '</td>';
              str += '</tr>';
            });                      
            str += '</table>';
            $('#ajaxGetNotification').html(str);
        }
    })
}

    jQuery('#sendNotification').click(function(){
    var booking_id = jQuery('#booking_id').val();
    var booking_msg = jQuery('#booking_msg').val();
   //alert(booking_id + '     --      '+booking_msg)
    jQuery.ajax({
        type: 'POST',
        url:'{{ url("/") }}/expenses/sendNotification',
        data: {"booking_id":booking_id,"booking_msg":booking_msg},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function (data) {
             getNofication();
                    
        },
        error: function(data){
            
        }
        //alert('gfj');return false;
    })
})

$('#messageList').change(function(){
  //alert(kjh) return false;
    var id = $('#messageList').val();
    if(id==0) {return false;}
    $.ajax({
        type: 'POST',
        url:'{{ url("/") }}/messages/getMessageById',
        data: {"id":id},
        beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));},
        success: function (data) {
            $('#booking_msg').html(data);        
        },
        error: function(data){
            
        }
    })
});
</script>

<!-- <script>
$(document).ready(function() {
  $('#messageList').on('change', function() {
      var category_id = this.value;
      $.ajax({
        url: "{{ url("/") }}/messages/getMessageById",
        type: "POST",
        data: {
         "id":id
        },
        cache: false,
        success: function(dataResult){
          $("#booking_msg").html(dataResult);
        }
      });
    
    
  });
});
</script> -->

@endsection
