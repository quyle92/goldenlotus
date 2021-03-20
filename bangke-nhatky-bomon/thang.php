<?php
require('../datetimepicker-month.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="month">
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
 $('form#customMonth').on('submit', function (event){
    event.preventDefault();
    var tuThang = $('#tuThang').val();
    var tenQuay = $('form#customMonth #tenQuay').val();

    $.ajax({
      url:"ajax/month.php",
      method:"POST",
      data:{'tuThang' : tuThang, 'tenQuay' : tenQuay},
      dataType:"json",
      beforeSend :function(){
            $("#loadingMask").css('visibility', 'visible');
        },
        success:function(output)
        {console.log(output)
        if ($.fn.DataTable.isDataTable("#month")) 
        {
         $("table#month").dataTable().fnDestroy();
        }
        
          $('table#month  tbody').html(output);
        
          $('table#month').DataTable({
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
