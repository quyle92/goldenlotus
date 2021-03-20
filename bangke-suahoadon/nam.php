<?php
require('../datetimepicker-year.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="year">
    <thead>
      <tr>
        <th>Ngày sửa</th>
        <th>NV sửa</th>
        <th>Giờ</th>
        <th>Nội dung sửa</th>
        <th>Ngày HĐ sửa</th>
        <th>Số HĐ sửa</th>
        <th>Giá trị trước khi sửa</th>
        <th>Giá trị sau  khi sửa</th>
        <th>Chênh lệch</th>
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
      url: "ajax/year.php",
      method:"POST",
      data:{'tuNam' : tuNam, 'tenQuay' : tenQuay},
      dataType:"json",
      beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(output)
      { 

       if ($.fn.DataTable.isDataTable("table#year")) {
             $("table#year").dataTable().fnDestroy();
        } 
       //console.log(output);

        $('table#year tbody').html(output);
        $('table#year').DataTable({
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
