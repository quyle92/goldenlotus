<div class="col-md-4">
  <form action="" id="customYear_<?=$r['TenQuay']?>" method="post" class="form-horizontal">
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
        <label  class="col-md-3 control-label">Ngày:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuNam" type='text' class="form-control" id="tuNam" value="<?= date('y') ?>"/>
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

<div class="col-md-12" id="totalQty_<?=$r['TenQuay']?>" style="margin-bottom: 10px">
  <strong class="text-danger"></strong>
</div>

<div class="col-md-12" id="totalRev_<?=$r['TenQuay']?>" style="margin-bottom: 10px">
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
      </tbody>
    </table>
</div>

<script >


$('body').on('submit', 'form#customYear_<?=$r['TenQuay']?>', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    $.ajax({
    url: 'ajax/<?=$tenQuay?>.php',
    method:"POST",
    data:formValues,
    dataType:"json",
    success:function(response)
      { 
   //var result = JSON.parse(response);
        console.log(response);
        var result = response['data'];
        var totalQty = response['totalQty'];
        var totalRev = response['totalRev'];
       
    if ($.fn.DataTable.isDataTable("table#<?=$r['TenQuay']?>")) {
      $("table#<?=$r['TenQuay']?>").dataTable().fnDestroy();
    }
     
    $('table#<?=$r['TenQuay']?> tbody').html(result);
  
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
          // totalRev += parseInt(value);
            $(this).html(addCommas(value));
      });

      $('#totalRev_<?=$r['TenQuay']?> strong').html('Tổng doanh thu: ' + addCommas(totalRev) + '<sup>đ</sup>' );

     //output tổng số lượng
      // $('table#<?=$r['TenQuay']?> tbody tr td:nth-of-type(4)').each( function() {
         
      //   let value = $(this).html(); 
      //     totalQty += parseInt(value);
      // });

      $('#totalQty_<?=$r['TenQuay']?> strong').html('Tổng số lượng: ' + totalQty);



      }
    });
});

</script>

<script>

$(function () {
  //$('#tu-ngay').val('');console.log($('#tu-ngay').val());
  var dateNow = new Date();
   $('form#customYear_<?=$r['TenQuay']?> #tuNam').datetimepicker({
     // viewMode: 'years',
      useCurrent: false,
      format: 'YYYY',
      //defaultDate:dateNow
   });
});

</script>