<div class="col-md-4">
  <form action="" id="customDate" method="post" class="form-horizontal" >
      <div class="form-group">
        <label for="tu-ngay" class="col-md-3 control-label">Ngày:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuNgay" type='text' class="form-control" id="tuNgay" value="<?=date('d-m-y')?>"/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label for="tenQuay" class="col-md-3 control-label">Quầy:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
            <select class="form-control" name="tenQuay" id="tenQuay">
                <option  disabled selected>Select...</option>
                <?php
                $rs = $goldenlotus->getTenQuay();
                foreach ( $rs as $r ) { ?> 
                  <option value="<?=$r['TenQuay']?>"><?=$r['TenQuay']?></option>

                <?php }
                

                ?>
            </select>
        </div>
      </div>

      <div class="form-group">
        <label for="tenNhom" class="col-md-3 control-label">Nhóm hàng bán:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
            <select class="form-control" name="tenNhom" id="tenNhom">
                <option  disabled selected>Select...</option>

            </select>
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

<div class="container-fluid">
  <table class="table table-bordered table-striped" id="day">
    <thead>
      <tr>
        <th>Mã hàng bán</th>
        <th>Tên hàng bán</th>
        <th>Số lượng</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>

<script>
var myPieChart;
  $('form#customDate').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tuNgay').val();//console.log(tuNgay);

    var formValues= $(this).serialize();

    $.ajax({
    url:"ajax-call/day.php",
    method:"POST",
    //data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
    data:formValues,
    dataType:"json",
    'beforeSend': function (request) {
        $("#loadingMask").css('visibility', 'visible');
    },
    success:function(output)
      { 
        console.log(output);
        if ($.fn.DataTable.isDataTable("#day")) {
             $("#day").dataTable().fnDestroy();
            // $('#custom_month').DataTable({ 
            //   "destroy": true, //use for reinitialize datatable
            // });

        } 
      
        $('#day tbody').html(output);
     
        $('#day').DataTable({ 
              "order": [],
              "columnDefs": [ {
                "targets"  : 0,
                "orderable": false,
              }]
            });
    
      },
    complete: function() { $("#loadingMask").css('visibility', 'hidden'); }    
    })
  });


</script>

<script>

$(function () {
  //$('#tu-ngay').val('');console.log($('#tu-ngay').val());
  var dateNow = new Date();
   $('#tuNgay').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'DD-MM-YYYY',
      //defaultDate:dateNow
   });
});

$(function() {
        
    $("#tenQuay").change(function(){
       var tenQuay = $("#tenQuay").val();
       $.get('ajax-call/nhom_hang_ban.php?tenQuay=' + tenQuay, function(data)
       {
            $('#tenNhom').html(data);
       });
    });
    
});

</script>