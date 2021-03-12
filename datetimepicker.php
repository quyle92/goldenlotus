<form action="" method="post">

        <div class="col-md-4">
          <label for="tu-ngay">Từ:</label>
          <div class="input-group date" style="margin-bottom:5px">
            <input name="tuNgay" type='text' class="form-control" id="tu-ngay" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>

        <div class="col-md-4 col-md-offset-1">
          <label for="den-ngay">Đến:</label>
          <div class="input-group date" style="margin-bottom:5px">
            <input name="denNgay" type='text' class="form-control" id="den-ngay" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
	<button type="submit" class="btn btn-info" style="margin:21px auto">Submit</button>

    

    
</form>

<script>

$(function () {
   $('#tu-ngay').datetimepicker({
     // viewMode: 'years',
      format: 'DD/MM/YYYY'
   });
});

$(function () {
   $('#den-ngay').datetimepicker({
     // viewMode: 'years',
      format: 'DD/MM/YYYY',
	  useCurrent: false
   });

$("#tu-ngay").on("dp.change", function (e) {
   
       $('#den-ngay').data("DateTimePicker").minDate(e.date.add(1, 'day'));//(1)
});

$("#den-ngay").on("dp.change", function (e) {
       $('#tu-ngay').data("DateTimePicker").maxDate(e.date.subtract(1, 'day'));
});
	
});
	
	

</script>