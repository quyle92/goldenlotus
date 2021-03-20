<?php
require('../datetimepicker-year.php');
?>

<div class="col-xs-12 col-sm-12">
<table class="table table-striped table-bordered" id="year">
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

 //$('#custom_year').DataTable();
    $('form#customYear').on('submit', function (event){
    event.preventDefault();
    var tuNam = $('#tuNam').val();
    var tenQuay = $('form#customYear #tenQuay').val();    
    $('#year').DataTable({
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
            "url": "ajax/year.php",
            "data": function ( d ) {
                //method 1: d.time = time;
                //method 2: d.custom = $('#myInput').val();
     
                return $.extend( {}, d, {
                    "tuNam" : tuNam,
                    "tenQuay": tenQuay
                } );//d is current default data object created by DataTable and "time": is additional data.
                //ref: https://datatables.net/reference/option/ajax.data
                //ref: https://stackoverflow.com/questions/4528744/how-does-the-extend-function-work-in-jquery  
            }
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