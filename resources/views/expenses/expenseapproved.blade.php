<script>
$(document).ready(function(){
    getNofication();
})
    jQuery('#sendNotification').click(function(){
        var booking_id = 'Hello';
        alert (booking_id);return false;
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
    
    
    </script>