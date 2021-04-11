<?php
require('../datetimepicker-year.php');
?>

<div class="col-xs-12 col-sm-12">
<table class="table table-bordered" id="year">
    <thead>
      <tr>
        <th>Mã hóa đơn</th>
        <th>Ngày bán</th>
        <th>PTTT</th>
        <th>Thu ngân</th>
        <th>Món ăn</th>
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

 //$('#year').DataTable();
    $('form#customYear').on('submit', function (event){
    event.preventDefault();
    var tuNam = $('#tuNam').val();
    var tenQuay = $('form#customYear #tenQuay').val();    
    $('#year').DataTable({
        columns: [
            { data: "MaLichSuPhieu" },
            { data: "NgayCoBill"  },
            { data: "MaLoaiThe" },
            { data: "NVTinhTienMaNV" },
            { data: "TenHangBan" },
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
        "createdRow": function( row, data, dataIndex ) 
            {
                if ( data['TenHangBan'] === null ) 
                { 
                  $(row).css({background:'rgba(242, 242, 242, 0.36)'});
                  $(row).children(":first-child").addClass( 'redText' );
                  $(row).children(":nth-child(2)").addClass( 'borderLessRight' );
                  $(row).children(":nth-child(3)").addClass( 'borderLess' );
                  $(row).children(":nth-child(4)").addClass( 'borderLess' );
                  $(row).children(":nth-child(5)").addClass( 'borderLess' );
                  $(row).children(":nth-child(6)").addClass( 'borderLess' );
                  $(row).children(":nth-child(7)").addClass( 'borderLess' );
                  $(row).children(":nth-child(8)").addClass( 'borderLess' );
                  $(row).children(":nth-child(9)").addClass( 'borderLess' );
                  $(row).children(":nth-child(10)").addClass( 'borderLess' );
                  $(row).children(":nth-child(11)").addClass( 'borderLessLeft' );
                  $(row).children(":last-child").addClass( 'redText' );

                }
                else if( this.api().search().length === 0 )
                {  
                  //let index = this.api().$(row).index();console.log(dataIndex);
                  
                  $(row).children(":first-child").text("");

                }
            }


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