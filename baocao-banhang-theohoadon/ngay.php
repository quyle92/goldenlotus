<?php
require('../datetimepicker-day.php');
?>

<div class="col-xs-12 col-sm-12">
<table class="table table-striped table-bordered" id="day">
    <thead>
      <tr>
        <th>Ngày bán</th>
        <th>PTTT</th>
        <th>Mã hóa đơn</th>
        <th>Thu ngân</th>
        <th>Tầng</th>
        <th>Món ăn</th>
        <th>Ghi chú</th>
        <th>Giá bán</th>
        <th>SL</th>
        <th>Giảm giá</th>
        <th>Chiết khâu</th>
        <th>Phí dịch vụ</th>
        <th>VAT</th>
        <th>Thành tiền</th>
      </tr>
    </thead>
    <tbody>



    </tbody>
</table>
</div>


<script >

 //$('#day').DataTable();
    $('form#customDate').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();
    var tenQuay = $('form#customDate #tenQuay').val();    
    $('#day').DataTable({
        columns: [
            { data: "NgayCoBill"  },
            { data: "MaLoaiThe" },
            { data: "MaLichSuPhieu" },
            { data: "NVTinhTienMaNV" },
            { data: "Floor"  },
            { data: "TenHangBan" },
            { data: "Note" },
            { data: "DonGia" },
            { data: "SoLuong"  },
            { data: "TienGiamGia" },
            { data: "Discount" },
            { data: "SoTienDVPhi" },
            { data: "SoTienVAT"  },
            { data: "ThanhTien" },

        ],
        "destroy": true, //use for reinitialize datatable
        "processing": true,
        "serverSide": true,
        ajax : {
            "url": "ajax/day.php",
            'beforeSend': function (request) {
                $("#loadingMask").css('visibility', 'visible');
            },
            "data": function ( d ) {
                //method 1: d.time = time;
                //method 2: d.custom = $('#myInput').val();
     
                return $.extend( {}, d, {
                    "tuNgay" : tuNgay,
                    "tenQuay": tenQuay
                } );//d is current default data object created by DataTable and "time": is additional data.
                //ref: https://datatables.net/reference/option/ajax.data
                //ref: https://stackoverflow.com/questions/4528744/how-does-the-extend-function-work-in-jquery  
            },
            complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
        },


    });
    
  });
/**
 * Twitter Bootstrap Tabs: Go to Specific Tab on Page Reload or Hyperlink
 */
// Javascript to enable link to tab
// var url = document.location.toString();
// if (url.match('#')) {
//     $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
// } 
// console.log(url);
// // Change hash for page-reload
// $('.nav-tabs a').on('shown.bs.tab', function (e) {
//     window.location.hash = e.target.hash;
// })



</script>