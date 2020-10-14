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
        <div class="sidebar-nav navbar-collapse"> 
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
            <button class="dropdown-btn"><i class="fa fa-users nav_icon"></i>Báo cáo bán hàng
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="khachhang_chart.php"><i class="fa fa-signal nav_icon"></i>Thống kê số lượng</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="khachhang.php"><i class="fa fa-users nav_icon"></i>Tổng hợp món ăn bán theo tháng</a>
                </li>

                <li style="list-style-type: none;">
                    <a class="menu-level2" href="khachhang_lichhen.php"><i class="fa fa-phone nav_icon"></i>
                    Lịch sử chăm sóc</a>
                </li>
            </div>
<!--             <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="booking.php"><i class="fa fa-calendar nav_icon"></i>
                    Lịch hẹn</a>
            </li> -->
            <button class="dropdown-btn"><i class="fa fa-table nav_icon"></i>Báo cáo nhập hàng 
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="licenseNoCustomer.php"><i class="fa fa-calculator nav_icon"></i>Doanh thu nhân viên</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="licenseNoCustomer.php"><i class="fa fa-building nav_icon"></i>Hoa hồng kỹ thuật viên</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="licenseNoCustomer.php"><i class="fa fa-edit nav_icon"></i>Hoa hồng đối tác</a>
                </li>
            </div>
            <button class="dropdown-btn"><i class="fa fa-archive nav_icon"></i>SMS Marketing 
                <span class="fa fa-caret-down"></span>
            </button>
            <div class="dropdown-container">
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="smsAccount.php"><i class="fa fa-archive nav_icon"></i>Tài khoản SMS</a>
                </li>
                <li style="list-style-type: none;">
                    <a class="menu-level2" href="smsHistory.php"><i class="fa fa-table nav_icon"></i>Lịch sử gửi SMS</a>
                </li>
            </div>
            <li style="list-style-type: none;" class="li-level1">
                <a class="menu-level1" href="account.php"><i class="fa fa-user nav_icon"></i>Đổi mật khẩu</a>
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
                <a class="menu-level1" href="logout.php"><i class="fa fa-sign-out nav_icon"></i>Thoát</a>
            </li>
        </div>
    </div>
</nav>

<?php
$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
//var_dump($bao_cao_duoc_xem);
?>
<script>
   // var baoCaoDuocXem ="";
    var baoCaoDuocXem= <?=json_encode($bao_cao_duoc_xem);?>;
    var bieuDoDoanhThu = $('button[data-report="BieuDoDoanhThu"]').attr('data-report');
    var admin = '<?=$_SESSION['MaNV']?>';
    //console.log(baoCaoDuocXem);console.log(bieuDoDoanhThu);console.log(admin);
    if( admin != 'HDQT' && jQuery.inArray( bieuDoDoanhThu, baoCaoDuocXem ) == -1){
        $('button[data-report="BieuDoDoanhThu"]').css({display:'none'});
        $('button[data-report="BieuDoDoanhThu"] + div.dropdown-container').html('');
    }
</script>