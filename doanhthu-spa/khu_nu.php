	<!-- Full Clickable Panel Heading -->
<div class="panel panel-parent panel-info"> 
<div class="panel-heading panel-heading-child clickable">
  <h3 class="panel-title">
    <dl style="margin-bottom: 0px;" >
        <dt> Woman 1 </dt>
          <small class="text-info">
            <dd> - Tổng Doanh Thu : <?=number_format($woman_1->TongDoanhThu,0,",",".")?><sup>đ</sup></dd>
            <dd> - Tổng số người: <?=number_format($total_bills_woman_1,0,",",".")?></dd>
          </small>
    </dl> 
  </h3>
<span class="pull-right " style="margin-top: 7px;"><i class="glyphicon glyphicon-minus"></i></span>
</div>
<div class="panel-body">
<table class="table table-hover table-bordred table-striped " class="bill_table">
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
		<?php
		$total_th = 7;
		$subtotal = 0;
		$k = 0;//var_dump( $woman_1->MaNhanVien[3] ) ;//die;
		foreach( $woman_1->MaLichSuPhieu as $bill )
		{ 
			if($k !=0 && $bill != " ") {?>

                  <tr data-total="total">
                    <td>Tổng</td>
                    <?php
                    for( $i=0; $i < $total_th-2; $i++)
                      echo "<td></td>";
                    ?>
                    <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                  </tr>
                  <tr  >
                     <?php
                    for( $i=0; $i < $total_th ; $i++)
                      echo "<td class=\"h2-bg\"></td>";
                    ?>
                  </tr>
                <?php $subtotal = 0;
                } ?>
			<tr data-bill="<?=$bill?>" >
				<td><?=$bill?></td><?php //if($k == 1) { var_dump($woman_1->MaNhanVien[3]);die; };  ?>
				<td><?=$woman_1->MaNhanVien[$k]?></td>
				<td><?=substr( $woman_1->GioVao[$k],0 ,10)?></td>
				<td><?=$woman_1->TenHangBan[$k]?></td>
				<td><?=number_format($woman_1->DonGia[$k],0,",",".")?><sup>đ</sup></td>
				<td><?=$woman_1->SoLuong[$k]?></td>
				<td><?php echo number_format($woman_1->ThanhTien[$k],0,",","."); $subtotal += $woman_1->ThanhTien[$k]?><sup>đ</sup></td>
			</tr>
		<?php $k++; 
			if( $k == sizeof($woman_1->MaLichSuPhieu) ){ ?> 
                <tr data-total="total">
                  <td  >Tổng</td>
                  <?php
                for( $i=0; $i < $total_th-2 ; $i++)
                  echo "<td></td>";
                ?>
                   <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                </tr>

              <?php } 
		} ?>
		</tbody>
	</table> 
    
</div>
</div>
<!--End Full Clickable Panel Heading -->

<!-- Full Clickable Panel Heading -->
<div class="panel panel-parent panel-warning"> 
<div class="panel-heading panel-heading-child clickable">
  <h3 class="panel-title">
      <dl style="margin-bottom: 0px;" >
          <dt> Woman 2 </dt>
           <small style="color: #fff;">
              <dd> - Tổng Doanh Thu : <?=number_format($woman_2->TongDoanhThu,0,",",".")?><sup>đ</sup></dd>
              <dd> - Tổng số người: <?=number_format($total_bills_woman_2,0,",",".")?></dd>
            </small>
      </dl> 
  </h3>
<span class="pull-right" style="margin-top: 7px;"><i class="glyphicon glyphicon-minus"></i></span>
</div>
<div class="panel-body">
<table class="table table-hover table-bordred table-striped " class="bill_table">
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
		<?php
		$total_th = 7;
		$subtotal = 0;
		$k = 0;//var_dump( $woman_1->MaNhanVien[3] ) ;//die;
		foreach( $woman_2->MaLichSuPhieu as $bill )
		{ 
			if($k !=0 && $bill != " ") {?>

                  <tr data-total="total">
                    <td>Tổng</td>
                    <?php
                    for( $i=0; $i < $total_th-2; $i++)
                      echo "<td></td>";
                    ?>
                    <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                  </tr>
                  <tr  >
                     <?php
                    for( $i=0; $i < $total_th ; $i++)
                      echo "<td class=\"h2-bg\"></td>";
                    ?>
                  </tr>
                <?php $subtotal = 0;
                } ?>
			<tr data-bill="<?=$bill?>" >
				<td><?=$bill?></td><?php //if($k == 1) { var_dump($woman_2->MaNhanVien[3]);die; };  ?>
				<td><?=$woman_2->MaNhanVien[$k]?></td>
				<td><?=substr( $woman_2->GioVao[$k],0 ,10)?></td>
				<td><?=$woman_2->TenHangBan[$k]?></td>
				<td><?=number_format($woman_2->DonGia[$k],0,",",".")?><sup>đ</sup></td>
				<td><?=$woman_2->SoLuong[$k]?></td>
				<td><?php echo number_format($woman_2->ThanhTien[$k],0,",","."); $subtotal += $woman_2->ThanhTien[$k]?><sup>đ</sup></td>
			</tr>
		<?php $k++; 
			if( $k == sizeof($woman_2->MaLichSuPhieu) ){ ?> 
                <tr data-total="total">
                  <td  >Tổng</td>
                  <?php
                for( $i=0; $i < $total_th-2 ; $i++)
                  echo "<td></td>";
                ?>
                   <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                </tr>

              <?php } 
		} ?>
		</tbody>
	</table> 
    
</div>
</div>
<!--End Full Clickable Panel Heading -->

<!-- Full Clickable Panel Heading -->
<div class="panel panel-parent panel-success"> 
<div class="panel-heading panel-heading-child clickable">
  <h3 class="panel-title">
    <dl style="margin-bottom: 0px;" >
        <dt> Woman 3 </dt>
          <small class="text-success">
            <dd> - Tổng Doanh Thu : <?=number_format($woman_3->TongDoanhThu,0,",",".")?><sup>đ</sup></dd>
            <dd> - Tổng số người: <?=number_format($total_bills_woman_3,0,",",".")?></dd>
          </small>
    </dl> 
  </h3>
<span class="pull-right " style="margin-top: 7px;"><i class="glyphicon glyphicon-minus"></i></span>
</div>
<div class="panel-body">
<table class="table table-hover table-bordred table-striped " class="bill_table">
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
		<?php
		$total_th = 7;
		$subtotal = 0;
		$k = 0;//var_dump( $woman_3->MaNhanVien[3] ) ;//die;
		foreach( $woman_3->MaLichSuPhieu as $bill )
		{ 
			if($k !=0 && $bill != " ") {?>

                  <tr data-total="total">
                    <td>Tổng</td>
                    <?php
                    for( $i=0; $i < $total_th-2; $i++)
                      echo "<td></td>";
                    ?>
                    <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                  </tr>
                  <tr  >
                     <?php
                    for( $i=0; $i < $total_th ; $i++)
                      echo "<td class=\"h2-bg\"></td>";
                    ?>
                  </tr>
                <?php $subtotal = 0;
                } ?>
			<tr data-bill="<?=$bill?>" >
				<td><?=$bill?></td><?php //if($k == 1) { var_dump($woman_3->MaNhanVien[3]);die; };  ?>
				<td><?=$woman_3->MaNhanVien[$k]?></td>
				<td><?=substr( $woman_3->GioVao[$k],0 ,10)?></td>
				<td><?=$woman_3->TenHangBan[$k]?></td>
				<td><?=number_format($woman_3->DonGia[$k],0,",",".")?><sup>đ</sup></td>
				<td><?=$woman_3->SoLuong[$k]?></td>
				<td><?php echo number_format($woman_3->ThanhTien[$k],0,",","."); $subtotal += $woman_3->ThanhTien[$k]?><sup>đ</sup></td>
			</tr>
		<?php $k++; 
			if( $k == sizeof($woman_3->MaLichSuPhieu) ){ ?> 
                <tr data-total="total">
                  <td  >Tổng</td>
                  <?php
                for( $i=0; $i < $total_th-2 ; $i++)
                  echo "<td></td>";
                ?>
                   <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                </tr>

              <?php } 
		} ?>
		</tbody>
	</table> 
    
</div>
</div>
<!--End Full Clickable Panel Heading -->
<hr>
<!-- Custom Time Filter -->

<form action="" method="post" class="" id="khu_nu">

  <div class="row">
    <div class="col-md-3 form-inline">
      <label for="ma_khu" class="control-label">Khu:</label>
      <select class="form-control"  name="maKhu">
        <option>03-NH4</option>
        <option>03-NH5</option>
        <option>03-NH6</option>

      </select>
    </div>  
  </div>
  <br>
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
    var tuNgay = $('form#khu_nu input[name="tuNgay"]').val();console.log(tuNgay);
    var denNgay = $('form#khu_nu input[name="denNgay"]').val();console.log(denNgay);
    var maKhu =  $('form#khu_nu select[name="maKhu"]').val();console.log(maKhu);


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
                }
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
    
  });

</script>
				            	