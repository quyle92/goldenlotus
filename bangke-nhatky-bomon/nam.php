<?php
require('../datetimepicker-year.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="year">
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
 $('form#customYear').on('submit', function (event){
    event.preventDefault();
    var tuNam = $('#tuNam').val();
    var tenQuay = $('form#customYear #tenQuay').val();

    $.ajax({
      url:"ajax/year.php",
      method:"POST",
      data:{'tuNam' : tuNam, 'tenQuay' : tenQuay},
      dataType:"json",
      beforeSend :function(){
            $("#loadingMask").css('visibility', 'visible');
        },
        success:function(output)
        {console.log(output)
        if ($.fn.DataTable.isDataTable("#year")) 
        {
         $("table#year").dataTable().fnDestroy();
        }
        
          $('table#year  tbody').html(output);
        
          $('table#year').DataTable({
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
