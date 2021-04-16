<?php
require('../datetimepicker-year.php');
?>

<div class="col-xs-12 col-sm-12">
  <table class="table table-striped table-bordered" id="year">
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
 //$('#year').DataTable();
    $('form#customYear').on('submit', function (event){
    event.preventDefault();
    var tuNam = $('#tuNam').val();console.log(tuNam)
    var tenQuay = $('form#customYear #tenQuay').val();
    
    $('#year').DataTable({
            columns: [
                { data: "MaLoaiThe"  },
                { data: "GioVao" },
                { data: "MaLichSuPhieu" },
                { data: "TienThucTra" }
            ],
            "dom": '<"top"l<"clear">>rtp<"bottom"i<"clear">>',
            "destroy": true, //use for reinitialize datatable
            "processing": true,
            "serverSide": true,
            ajax : {
                "url": "ajax/year.php",
                'beforeSend': function (request) {
                    $("#loadingMask").css('visibility', 'visible');
                },
                "data": function ( d ) {
                    //method 1: d.time = time;
                    //method 2: d.custom = $('#myInput').val();
         
                    return $.extend( {}, d, {
                        "tuNam" : tuNam,
                        "tenQuay": tenQuay
                    } );//d is current default data object created by DataTable and "time": is additional data.
                    //ref: https://datatables.net/reference/option/ajax.data
                    //ref: https://stackoverflow.com/questions/4528744/how-does-the-extend-function-work-in-jquery  
                },
                complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
            },


        });
    
  });


</script>
