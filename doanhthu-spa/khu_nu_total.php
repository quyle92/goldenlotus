
<!-- Custom Time Filter -->

<form action="" method="post" class="" id="khu_nu">

  <div class="row">
    <div class="col-md-4 form-inline">
      <label for="tu-ngay" class="control-label">Từ:</label>
      <div class="input-group date" style="margin-bottom:5px">
        <input name="tuNgay" type='text' class="form-control" class="tu-ngay" />
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>

    <div class="col-md-4 col-md-offset-2 form-inline">
      <label for="den-ngay" class="control-label">Đến:</label>
      <div class="input-group date" style="margin-bottom:5px">
        <input name="denNgay" type='text' class="form-control" class="den-ngay" />
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-info">Submit</button>

</form>
<br>
<h3 id="total_rev_women" style="color:#337AB7"><strong>Tổng doanh thu:</strong></h3>
<h4 style="color:#337AB7"><strong></strong></h4>
<table class="table table-striped table-bordered" id="custom_month_women">
  <thead>
    <tr>
      <th>Mã lịch sử phiếu</th>
      <th>Nhân viên</th>
      <th>Ngày vào</th>
      <th>Tên hàng bán</th>
      <th>Đơn giá</th>
      <th>Số lượng</th>
      <th>Thành tiền</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<script type="text/javascript">

$('form#khu_nu').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('form#khu_nu input[name="tuNgay"]').val();
    var denNgay = $('form#khu_nu input[name="denNgay"]').val();
    var maKhu =  $('form#khu_nu select[name="maKhu"]').val();


    $('#custom_month_women').DataTable({
            columns: [
                { data: "MaLichSuPhieu"  },
                { data: "MaNhanVien" },
                { data: "GioVao" },
                { data: "TenHangBan" },
                { data: "DonGia" },
                { data: "SoLuong" },
                { data: "ThanhTien" } 
            ],
            "order": [[ 0, "desc" ]],
            "destroy": true, //use for reinitialize datatable
            "processing": true,
            "serverSide": true,
            ajax : {
                "url": "ajax/women.php",
                'beforeSend': function (request) {
                    $("#loadingMask").css('visibility', 'visible');
                },
                "data": function ( d ) {
                    //method 1: d.time = time;
                    //method 2: d.custom = $('#myInput').val();
         
                    return $.extend( {}, d, {
                       "tuNgay" : tuNgay,
                       "denNgay": denNgay,
                       'maKhu' : maKhu
                    } );//d is current default data object created by DataTable and "time": is additional data.
                    //ref: https://datatables.net/reference/option/ajax.data
                    //ref: https://stackoverflow.com/questions/4528744/how-does-the-extend-function-work-in-jquery  
                },
                complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
            },
          /**
           * call a function in success of datatable ajax call
           * ref: https://stackoverflow.com/questions/15786572/call-a-function-in-success-of-datatable-ajax-call
           */
         "drawCallback":function( settings, json){
          var api = this.api();
          var data =  JSON.parse(JSON.stringify( api.rows( {page:'current'} ).data() ));//console.log( data  );//ref: https://stackoverflow.com/questions/17546953/cant-access-object-property-even-though-it-shows-up-in-a-console-log
          var dataArr = Object.values(data);//convert obj to array

          //ref: https://www.javascripttutorial.net/javascript-array-filter/
          var thanhTien = [];
          for (var i = 0; i < dataArr.length; i++) {
              if (dataArr[i].MaLichSuPhieu == "totalFilter") {
                  thanhTien.push(dataArr[i].ThanhTien);
              }
          }//End ref

          var totalFilter = thanhTien.join("");// join the array elements into a string
         
          if (totalFilter.length > 0)
          {
            $('h3#total_rev_women + h4').html('Tổng doanh thu (Lọc): ' + totalFilter + "<sup>đ</sup>");
              if( $('table#custom_month_women tbody tr').length <= 10 ){
                $('table#custom_month_women tbody tr:last-child').css({"display": "none"});
              }
              else
              {
                $('table#custom_month_women tbody tr:nth-child(11)').css({"display": "none"});
              }
          }
          else
          {
            $('h3#total_rev_women + h4').html("");
          }
        },
        "createdRow": function( row, data, dataIndex ) {
            if ( data['MaNhanVien'] === null ) 
            { 
              $(row).css({background:'rgba(242, 242, 242, 0.36)'});
              $(row).children(":first-child").addClass( 'red' );
              $(row).children(":first-child").addClass( 'borderLessRight' );
              $(row).children(":nth-child(2)").addClass( 'borderLess' );
              $(row).children(":nth-child(3)").addClass( 'borderLess' );
              $(row).children(":nth-child(4)").addClass( 'borderLess' );
              $(row).children(":nth-child(5)").addClass( 'borderLessLeft' );
              $(row).children(":nth-child(6)").addClass( 'red' );
              $(row).children(":last-child").addClass( 'red' );

            }
            else
            {  
              //let index = this.api().$(row).index();console.log(dataIndex);

              $(row).children(":first-child").text("");

            }
        },
        // Note: this only fires once (first ajax cal only), not fire on every next ajax call
        "initcomplete ":function( settings, json){
            console.log(json);
        }



        });

    var formValues= $(this).serialize();
    $.ajax({
      url:"ajax/total_rev_women.php",
      method:"post",
      data: formValues,
      dataType:"json",
      success:function(output)
      {
        console.log(output);
        //$(output).appendTo('h3#total_rev_men strong');
        $("h3#total_rev_women strong").html(output);
      }
    });

     //total rev including men + women
       $.ajax({
        url:"ajax/grand_total.php",
        method:"post",
        data:formValues,
        dataType:"json",
        success:function(output)
        {
          console.log(output);
          //$(output).appendTo('h3#total_rev_men strong');
          $("#grandTotal").html(output);
        }
      });
    
  });

</script>
				            	