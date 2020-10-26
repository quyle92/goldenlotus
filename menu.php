<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
                
        <a class="navbar-brand"><?php echo $trungtam; ?></a> 
    </div>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse collapse" aria-expanded="false"> 
   
            <button class="dropdown-btn"  data-report="BieuDoDoanhThu"><i class="fas fa-columns"></i> Biểu đồ
                <span class="fa fa-caret-down"></span>
            </button> 
            <div class="dropdown-container">

                <li style="list-style-type: none;">
                    <a class="menu-level2" href="doanhthu-theonam.php"><i class="fa fa-signal nav_icon"></i>Doanh thu theo năm</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="doanhthu-theothang.php"><i class="fas fa-chart-area"></i>  Doanh thu theo tháng</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="dophu.php"><i class="fas fa-chart-pie"></i>Độ phủ</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="doanhthu-nhom-monan.php"><i class="fas fa-chart-line"></i>Doanh thu nhóm món ăn</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="baocao-gio.php"><i class="far fa-clock"></i>Báo cáo giờ</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="baocao-hoadon.php"><i class="fas fa-file-invoice-dollar"></i>Báo cáo hóa đơn</a>
                </li>
            </div>
            <button class="dropdown-btn" data-report="BaoCaoBanHang"><i class="fas fa-utensils"></i></i> Báo cáo bán hàng
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="tonghop-monan-theothang.php"><i class="fas fa-apple-alt"></i>
                    Tổng hợp món ăn bán theo tháng</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="tonghop-monan-theongay.php"><i class="fas fa-cookie"></i>
                    Tổng hợp món ăn bán theo ngày</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="bangke-chitiet-pttt.php"><i class="fas fa-money-bill-alt"></i>
                    Bảng kê chi tiết phương thức thanh toán</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="baocao-banhang-theohoadon.php"><i class="fas fa-menorah"></i>
                    Báo cáo bán hàng chi tiết món theo từng hóa đơn</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="tonghop-monan-xemtheo-nhanvien.php"><i class="fas fa-user-tie"></i>
                    Tổng hợp món ăn bán theo ngày (Xem theo nhân viên)</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="tonghop-monan-ban.php"><i class="fas fa-cloud-meatball"></i>
                    Tổng hợp món ăn bán</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="bangke-chitiet-hoadon.php"><i class="fas fa-file-alt"></i>
                    Bảng kê chi tiết hóa đơn bán hàng</a>
                </li>
                
            </div>
            <button class="dropdown-btn"  data-report="BaoCaoQuanTri"><i class="fab fa-acquisitions-incorporated"></i> Báo cáo quản trị 
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="doichieu-soluong-bangoi.php"><i class="fas fa-file-csv"></i>
                    Đối chiếu số lượng giữa bán và gọi</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="baocao-tiente.php"><i class="fas fa-funnel-dollar"></i>
                    Báo cáo tiền tệ</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="bangke-suahoadon.php"><i class="fas fa-receipt"></i>
                    Bảng kê sửa hóa đơn</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="bangke-nhatky-bomon.php"><i class="fas fa-trash-alt"></i>
                    Bảng kê nhật ký bỏ món</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="tonghop-dobo.php"><i class="fas fa-recycle"></i>
                    Tổng hợp đồ bỏ</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="danhsach-ban-doanhthu.php"><i class="fas fa-table"></i>
                    Danh sách bàn - doanh thu</a>
                </li>
            </div>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="account.php"><i class="fas fa-key"></i> Đổi mật khẩu</a>
            </li>
            <?php 
            $maNV = (isset($_SESSION['MaNV'])?$_SESSION['MaNV']:"");
            if($_SESSION['MaNV'] == 'HDQT')
             echo '<li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="signup.php"><i class="fa fa-sign-out nav_icon"></i>Signup</a>
            </li>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="users.php"><i class="fa fa-users nav_icon"></i>Users</a>
            </li>';
            ?>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="logout.php"><i class="fas fa-external-link-alt"></i> Thoát</a>
            </li>
        </div>
    </div>
    <!-- New menu -->
    <div class="navbar-header pc-only pull-right">
        <button type="button" class="navbar-toggle pc-only"  >
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
                
        <a class="navbar-brand"><?php echo $trungtam; ?></a> 
    </div>
    <div class="navbar-default sidebar pc-only" role="navigation">
        <div class="sidebar-nav navbar-collapse collaps pc-only" > 
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="home.php"><i class="fa fa-home nav_icon"></i>Home</a>
            </li>
            <button class="dropdown-btn"  data-report="BieuDoDoanhThu"><i class="fa fa-money nav_icon"></i>Biểu đồ doanh thu/ độ phủ
                <span class="fa fa-caret-down"></span>
            </button> 
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="doanhthu-theonam.php"><i class="fa fa-signal nav_icon"></i>Doanh thu theo năm</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="doanhthu-theothang.php"><i class="fa fa-tags nav_icon"></i>Doanh thu theo tháng</a>
                </li>
            </div>

    <!-- End New menu-->
</nav>

<?php
$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
//var_dump($bao_cao_duoc_xem);
?>
<script>
   // var baoCaoDuocXem ="";
    var baoCaoDuocXem= <?=json_encode($bao_cao_duoc_xem);?>;

    var bieuDoDoanhThu = $('button[data-report="BieuDoDoanhThu"]').attr('data-report');
    var baoCaoBanHang = $('button[data-report="BaoCaoBanHang"]').attr('data-report');
    var baoCaoQuanTri = $('button[data-report="BaoCaoQuanTri"]').attr('data-report');
    var admin = '<?=$_SESSION['MaNV']?>';

    var reportArr = []; 
    reportArr = [bieuDoDoanhThu, baoCaoBanHang, baoCaoQuanTri];
    console.log(baoCaoDuocXem);
    var i;
    var k;
    for ( i = 0; i < baoCaoDuocXem.length; i++ )
    {
        if( admin != 'HDQT' && jQuery.inArray( baoCaoDuocXem,  reportArr) == -1){
            for( k = 0; k < reportArr.length; k++ )
            {
                if( baoCaoDuocXem != reportArr[k] )
                { 
                    $('button[data-report="' + reportArr[k] + '"]').css({display:'none'});
                    $('button[data-report="' + reportArr[k] + '"] + div.dropdown-container').html('');
                }
            }
        }
    }


</script>

