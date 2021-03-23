<?php
require('../datetimepicker-day.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="day">
    <thead>
      <tr>
        <th></th>
        <th>Tổng số key</th>
        <th>Tổng số vé</th>
        <th>Chênh lệch</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Khu nam</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Khu nữ</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
 </table>
</div>

<script>

$('form#customDate').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();
    var tenQuay = $('form#customDate #tenQuay').val();
    
    $.ajax({
      url: "ajax/day.php",
      method:"POST",
      data:{'tuNgay' : tuNgay, 'tenQuay' : tenQuay},
      dataType:"json",
      beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(output)
      { 

       if ($.fn.DataTable.isDataTable("table#day")) {
             $("table#day").dataTable().fnDestroy();
        } 
       //console.log(output);

        $('table#day tbody').html(output);
        $('table#day').DataTable({
            "order": [],
            "columnDefs": [ {
            "targets"  : 0,
            "orderable": false,
            }]
         });

      },
      complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
    });
  });

</script>
