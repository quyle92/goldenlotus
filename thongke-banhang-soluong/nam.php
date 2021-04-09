<div class="col-md-4">
  <form action="" id="customDate" method="post" class="form-horizontal" >
      <div class="form-group">
        <label for="tu-ngay" class="col-md-3 control-label">Tháng:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuNam" type='text' class="form-control" id="tuNam" value=""/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label for="tenQuay_year" class="col-md-3 control-label">Quầy:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
            <select class="form-control" name="tenQuay_year" id="tenQuay_year">
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
            <select class="form-control" name="tenNhom" id="tenNhom_year">
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
  <table class="table table-bordered table-striped" id="year">
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
    var tuNam = $('#tuNam').val();//console.log(tuNam);

    var formValues= $(this).serialize();

    $.ajax({
    url:"ajax-call/year.php",
    method:"POST",
    //data:{'tu-ngay' : tuNam, 'den-ngay' : denNgay},
    data:formValues,
    dataType:"json",
    'beforeSend': function (request) {
        $("#loadingMask").css('visibility', 'visible');
    },
    success:function(output)
      { 
        console.log(output);
        if ($.fn.DataTable.isDataTable("#year")) {
             $("#year").dataTable().fnDestroy();
            // $('#custom_year').DataTable({ 
            //   "destroy": true, //use for reinitialize datatable
            // });

        } 
      
        $('#year tbody').html(output);
     
        $('#year').DataTable({ 
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
   $('#tuNam').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'YYYY',
      //defaultDate:dateNow
   });
});

$(function() {
        
    $("#tenQuay_year").change(function(){
       var tenQuay = $("#tenQuay_year").val();
       $.get('ajax-call/nhom_hang_ban.php?tenQuay=' + tenQuay, function(data)
       {
            $('#tenNhom_year').html(data);
       });
    });
    
});

</script>