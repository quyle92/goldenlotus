<?php
require('../datetimepicker-month.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="month">
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

$('form#customMonth').on('submit', function (event){
    event.preventDefault();
    var tuThang = $('#tuThang').val();
    var tenQuay = $('form#customMonth #tenQuay').val();
    
    $.ajax({
      url: "ajax/month.php",
      method:"POST",
      data:{'tuThang' : tuThang, 'tenQuay' : tenQuay},
      dataType:"json",
      beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(output)
      { 

       if ($.fn.DataTable.isDataTable("table#month")) {
             $("table#month").dataTable().fnDestroy();
        } 
       //console.log(output);

        $('table#month tbody').html(output);
        $('table#month').DataTable({
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
