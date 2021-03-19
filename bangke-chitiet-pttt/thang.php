<?php
require('../datetimepicker-month.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="month">
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
 //$('#month').DataTable();
    $('form#customMonth').on('submit', function (event){
    event.preventDefault();
    var tuThang = $('#tuThang').val();
    var tenQuay = $('#tenQuay').val();
    
    $('#month').DataTable({
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
                "url": "ajax/month.php",
                "data": function ( d ) {
                    //method 1: d.time = time;
                    //method 2: d.custom = $('#myInput').val();
         
                    return $.extend( {}, d, {
                        "tuThang" : tuThang,
                        "tenQuay": tenQuay
                    } );//d is current default data object created by DataTable and "time": is additional data.
                    //ref: https://datatables.net/reference/option/ajax.data
                    //ref: https://stackoverflow.com/questions/4528744/how-does-the-extend-function-work-in-jquery  
                }
            },


        });
    
  });


</script>
