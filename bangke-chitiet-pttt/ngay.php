<?php
require('../datetimepicker-day.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="day">
      <thead>
        <tr>
          <th>PTTT</th>
          <th>Ngày</th>
          <th>Mã hóa đơn</th>
          <th>Thành tiền</th>
        </tr>
      </thead>
      <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
   </table>
</div>

<script>
 //$('#custom_month').DataTable();
    $('form#customDate').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();
    var tenQuay = $('#tenQuay').val();
    
    $('#day').DataTable({
            columns: [
                { data: "MaLoaiThe"  },
                { data: "GioVao" },
                { data: "MaLichSuPhieu" },
                { data: "TienThucTra" }
            ],
            "destroy": true, //use for reinitialize datatable
            "processing": true,
            "serverSide": true,
            ajax : {
                "url": "ajax/day.php",
                "data": function ( d ) {
                    //method 1: d.time = time;
                    //method 2: d.custom = $('#myInput').val();
         
                    return $.extend( {}, d, {
                        "tuNgay" : tuNgay,
                        "tenQuay": tenQuay
                    } );//d is current default data object created by DataTable and "time": is additional data.
                    //ref: https://datatables.net/reference/option/ajax.data
                    //ref: https://stackoverflow.com/questions/4528744/how-does-the-extend-function-work-in-jquery  
                }
            },


        });
    
  });


</script>