<?php
$tuNgay =  isset( $_POST['tuNgay'] ) ? $_POST['tuNgay'] : '';
 ?>
<div class="col-md-4">
  <form action="" id="customDate_<?=$r['TenQuay']?>" method="post" class="form-horizontal">
    <input type="hidden" name="tenQuay" id="input" class="form-control" value="<?=$tenQuay?>" required="required" pattern="" title="">
     <div class="form-group"> 
          <label for="tenNhomHB" class="col-md-3 control-label">Nhóm Hàng Bán:</label>
          <div class="input-group col-md-9" >
            <select name="tenNhomHB" id="tenNhomHB"  class="form-control" >
              <?=($tenQuay === 'SPA' || $tenQuay === 'RESTAURANT' ) ? "<option selected value=''>Tất cả</option>" : '' ?>
                <?php
                $tenQuay = isset( $r['TenQuay'] ) ? $r['TenQuay'] : "";
                $rs = $goldenlotus->getDMNhomHangBan( $tenQuay );
                foreach ( $rs as $r )
                { ?>
                   <option <?=isset( $_POST['tenNhomHB'] ) && $r['Ten'] == $_POST['tenNhomHB'] ? "selected" : "" ?>><?=$r['Ten']?></option>
                <?php 
                }
                ?>
            </select>
          </div>
      </div>

      <div class="form-group">
        <label for="tu-ngay" class="col-md-3 control-label">Ngày:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuNgay" type='text' class="form-control" id="tu-ngay" value="<?=!empty($tuNgay) ? $tuNgay : date('d-m-y') ?>"/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
          <button class="btn btn-primary" type="submit" >
           Submit</button>
        </div>
      </div>
    
  </form>
</div>

<div class="col-md-12" id="total_<?=$r['TenQuay']?>" style="margin-bottom: 10px">
  <strong class="text-danger"></strong>
</div>

<div class="col-md-12"></div><div class="col-md-12">
    <table class="table" id="<?=$r['TenQuay']?>">
      <thead>
        <tr>
          <th>Mã hàng bán</th>           
          <th>Tên hàng bán</th>    
          <th>Đơn vị</th>
          <th>Số lượng</th>
          <th>Thành tiền</th>
        </tr>
      </thead>
      <tbody>

      <tbody>
    </table>
</div>

<script >


$('body').on('submit', 'form#customDate_<?=$r['TenQuay']?>', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    $.ajax({
    url: 'ajax/<?=$tenQuay?>.php',
    method:"POST",
    data:formValues,
    // dataType:"json",
    success:function(response)
      { 
        var result = JSON.parse(response);
        var total = 0;
        console.log(result)
        
       
    if ($.fn.DataTable.isDataTable("table#<?=$r['TenQuay']?>")) {
      $("table#<?=$r['TenQuay']?>").dataTable().fnDestroy();
    }
     
    $('table#<?=$r['TenQuay']?> tbody').html(result);
    $('#total_<?=$r['TenQuay']?>').html(result);
  
    $('table#<?=$r['TenQuay']?>').DataTable({
            "order": [],
            "columnDefs": [ {
              "targets"  : 0,
              "orderable": false,
            }]
          });

    //format number cho column ThanhTien
     $('table#<?=$r['TenQuay']?> tbody tr td:nth-of-type(5)').each( function() {
           
          let value = $(this).html(); 
            $(this).html(addCommas(value));
      });

     //output tổng số lượng
      $('table#<?=$r['TenQuay']?> tbody tr td:nth-of-type(4)').each( function() {
         
        let value = $(this).html(); 
          total += parseInt(value);

          //format number cho column ThanhTien
          $(this).html(addCommas(value));
      });

      $('#total_<?=$r['TenQuay']?> strong').html('Tổng số lượng: ' + total);



      }
    });
});

</script>

<script>

$(function () {
  //$('#tu-ngay').val('');console.log($('#tu-ngay').val());
  var dateNow = new Date();
   $('form#customDate_<?=$r['TenQuay']?> #tu-ngay').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'DD-MM-YYYY',
      //defaultDate:dateNow
   });
});

</script>