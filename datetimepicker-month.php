<div class="col-md-4">
  <form action="" id="customMonth" method="post" class="form-horizontal">
     <div class="form-group">
          <label for="tenQuay" class="col-md-3 control-label">Quầy:</label>
          <div class="input-group col-md-9" >
            <select name="tenQuay" id="tenQuay"  class="form-control" >
              <option selected>Tất cả</option>
                <?php
                $rs = $goldenlotus->getTenQuay();
                foreach ( $rs as $r )
                { ?>
                   <option ><?=$r['TenQuay']?></option>
                <?php 
                }
                ?>
            </select>
          </div>
      </div>

      <div class="form-group">
        <label for="tu-ngay" class="col-md-3 control-label">Ngày:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuThang" type='text' class="form-control" id="tuThang" value="<?=isset($tuThang) ? substr($tuThang,8) . "/" .substr($tuThang,5,2) . "/" .  substr($tuThang,0,4) : date('M y') ?>"/>
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
   $('#tuThang').datetimepicker({
     // viewMode: 'years',
      useCurrent: true,
      format: 'MMM YYYY',
      //defaultDate:dateNow
   });
});



</script>