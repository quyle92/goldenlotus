<?php
require('../datetimepicker-month.php');
?>

<div class="col-xs-12 col-sm-12">
<h3 id="grandTotal_Month" style="color:#337AB7">Tổng doanh thu: <strong></strong></h3>
<table class="table table-bordered" id="month" >
    <thead>
      <tr>
        <th>Mã hóa đơn</th>
        <th>Ngày bán</th>
        <th>PTTT</th>
        <th>Check In</th>
        <th>Check Out</th>
        <th>Thu ngân</th>
        <th>Món ăn</th>
        <th>Giá bán</th>
        <th>SL</th>
        <th>Giảm giá</th>
        <th>Chiết khâu</th>
        <th>Phí dịch vụ</th>
        <th>VAT</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>



    </tbody>
</table>
</div>


<script >

 //$('#month').DataTable();
    $('form#customMonth').on('submit', function (event){
    event.preventDefault();
    $('#month').css({'transform': 'translate(-2%, 0%)'});
    var tuThang = $('#tuThang').val();
    var tenQuay = $('form#customMonth #tenQuay').val();    
    $('#month').DataTable({
        columns: [
            { data: "MaLichSuPhieu" },
            { data: "NgayCoBill"  },
            { data: "MaLoaiThe"  },
            { data: "CheckIn"  },
            { data: "CheckOut"  },
            { data: "NVTinhTienMaNV" },
            { data: "TenHangBan" },
            { data: "DonGia" },
            { data: "SoLuong"  },
            { data: "TienGiamGia" },
            { data: "Discount" },
            { data: "SoTienDVPhi" },
            { data: "SoTienVAT"  },
            { data: "ThanhTien",  render: $.fn.dataTable.render.number( '.', ',', 0, '','<sup>đ<//sup>' ) }//add currency postfix to figure

        ],
        "destroy": true, //use for reinitialize datatable
        "processing": true,
        "serverSide": true,
        ajax : {
            "url": "ajax/month.php",
            dataSrc: function ( json ) 
            {
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\đ.]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };  
            
               $('#grandTotal_Month strong').html(json.grandTotal);
               return json.data;//must return like this, else error will be thrown.
            },
            'beforeSend': function (request) {
                $("#loadingMask").css('visibility', 'visible');
            },
            "data": function ( d ) {
                //method 1: d.time = time;
                //method 2: d.custom = $('#myInput').val();
     
                return $.extend( {}, d, {
                    "tuThang" : tuThang,
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
            },
            "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\đ.]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
                //console.log(api.column(1, {search: 'applied'}).data())
                // Total over all pages 
                total = api.column( 13 ).data().reduce(function(a, b, idx) {
                   if (api.column(1, {search: 'applied'}).data()[idx] !== '' ) {
                      return  intVal(a) + intVal(b);
                   } 
                   else {
                      return intVal(a);
                   }
                }, 0);

                //render Tổng doanh thu (lọc): khi search có value, ko thì hide()
                if( this.api().search().length !== 0 )
                {
                    $('#grandTotal_Month').after('<h3 style="color:#337AB7">Tổng doanh thu (lọc): <strong>' + addCommas( total ) + '<sup>đ</sup> </strong></h3>');
                }
                else
                {
                    $('#grandTotal_Month + h3').hide();
                }
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 13 ).footer() ).html(
                '$'+pageTotal +' ( $'+ total +' total)'
            );


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