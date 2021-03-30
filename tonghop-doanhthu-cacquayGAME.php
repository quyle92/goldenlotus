<?php
$tuNgay =  isset( $_POST['tuNgay'] ) ? $_POST['tuNgay'] : '';
 ?>
<div class="col-md-4">
  <form action="" id="customDate_<?=$r['TenQuay']?>" method="post" class="form-horizontal">
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