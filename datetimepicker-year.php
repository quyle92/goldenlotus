<div class="col-md-4">
  <form action="" id="customYear" method="post" class="form-horizontal">
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
        <label for="tuNam" class="col-md-3 control-label">Ngày:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuNam" type='text' class="form-control" id="tuNam" value="<?=isset($tuNam) ? substr($tuNam,8) . "/" .substr($tuNam,5,2) . "/" .  substr($tuNam,0,4) : date('d-m-y') ?>"/>
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
  //$('#tuNam').val('');console.log($('#tuNam').val());
  var dateNow = new Date();
   $('#tuNam').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'YYYY',
      //defaultDate:dateNow
   });
});



</script>