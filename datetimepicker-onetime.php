<form action="" method="post">

        <div class="col-md-4 form-group">
          <label for="tu-ngay">Từ:</label><!--2020/12/01 -->
          <div class="input-group date" style="margin-bottom:5px">
            <input name="tuNgay" type='text' class="form-control" id="tu-ngay" value="<?=isset($tuNgay) ? substr($tuNgay,8) . "/" .substr($tuNgay,5,2) . "/" .  substr($tuNgay,0,4) : "" ?>"/>
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>

  <button type="submit" class="btn btn-info" style="margin:21px auto">Submit</button>
 
</form>

<script>

$(function () {
  //$('#tu-ngay').val('');console.log($('#tu-ngay').val());
  var dateNow = new Date();
   $('#tu-ngay').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'DD/MM/YYYY',
      //defaultDate:dateNow
   });
});



</script>