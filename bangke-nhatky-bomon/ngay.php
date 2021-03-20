<?php
require('../datetimepicker-day.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="day">
    <thead>
      <tr>
        <th>Ngày gọi</th>
        <th>NV</th>
        <th>Món</th>
        <th>Vị trí</th>
        <th>Giờ gọi</th>
        <th>SL</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
 </table>
</div>

<script>
 $('form#customDate').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();
    var tenQuay = $('form#customDate #tenQuay').val();

    $.ajax({
      url:"ajax/day.php",
      method:"POST",
      data:{'tuNgay' : tuNgay, 'tenQuay' : tenQuay},
      dataType:"json",
      beforeSend :function(){
            $("#loadingMask").css('visibility', 'visible');
        },
        success:function(output)
        {console.log(output)
        if ($.fn.DataTable.isDataTable("#day")) 
        {
         $("table#day").dataTable().fnDestroy();
        }
        
          $('table#day  tbody').html(output);
        
          $('table#day').DataTable({
              "order": [],
              "columnDefs": [ {
                "targets"  : 0,
                "orderable": false,
              }]
            });

        },
      complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
      })
  });


</script>
