<div class="col-md-4">
  <form action="" id="customDate" method="post" class="form-horizontal" >
      <div class="form-group">
        <label for="tu-ngay" class="col-md-3 control-label">Tháng:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuThang" type='text' class="form-control" id="tuThang" value=""/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label for="tenQuay_month" class="col-md-3 control-label">Quầy:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
            <select class="form-control" name="tenQuay_month" id="tenQuay_month">
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
            <select class="form-control" name="tenNhom" id="tenNhom_month">
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
  <table class="table table-bordered table-striped" id="month">
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
    var tuThang = $('#tuThang').val();//console.log(tuThang);

    var formValues= $(this).serialize();

    $.ajax({
    url:"ajax-call/month.php",
    method:"POST",
    //data:{'tu-ngay' : tuThang, 'den-ngay' : denNgay},
    data:formValues,
    dataType:"json",
    'beforeSend': function (request) {
        $("#loadingMask").css('visibility', 'visible');
    },
    success:function(output)
      { 
        console.log(output);
        if ($.fn.DataTable.isDataTable("#month")) {
             $("#month").dataTable().fnDestroy();
            // $('#custom_month').DataTable({ 
            //   "destroy": true, //use for reinitialize datatable
            // });

        } 
      
        $('#month tbody').html(output);
     
        $('#month').DataTable({ 
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
   $('#tuThang').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'MMM YYYY',
      //defaultDate:dateNow
   });
});

$(function() {
        
    $("#tenQuay_month").change(function(){
       var tenQuay = $("#tenQuay_month").val();
       $.get('ajax-call/nhom_hang_ban.php?tenQuay=' + tenQuay, function(data)
       {
            $('#tenNhom_month').html(data);
       });
    });
    
});

</script>