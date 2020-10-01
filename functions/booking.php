<?php

function TaoBooking($conn,$orderid,$manv,$malichsuphieu,$mahangban,$madvt,$soluong,$dongia,$thanhtien,$tenhangban)
{

try 
	{
	$sql = "Insert into tblOrder(OrderID,MaNV,MaLichSuPhieu,ThoiGian,TrangThai,TenNV) values('";
	$sql = $sql.$orderid."','".$manv."','".$malichsuphieu."',GETDATE(),'1','')";
	$rs=sqlsrv_query($conn,$sql);
	
	$sql = "Insert into tblOrderChiTiet(OrderID,MaHangBan,MaDVT,SoLuong,DonGia,YeuCauThem,ThoiGian,MaSuCo,TenHangBan,LyDo,MaNVLienQuan,GhiChuKMHB,KeyString) values('";
	$sql = $sql.$orderid."','".$mahangban."','".$madvt."','".$soluong."','".$dongia."','',GETDATE(),'','".$tenhangban."','','".$manv."','','')";
	$rs=sqlsrv_query($conn,$sql);
	
	$sql = "Insert into tblLSPhieu_HangBan(ID,MaLichSuPhieu,MaHangBan,TenHangBan,SoLuong,MaDVT,DonGia,ThanhTien,MaNhanVien,ThoiGianBan,MaSuCo,LyDo,
		DaXuLy,OrderID,DonGiaTT,MaTienTe,ThanhTienTT,GhiChuKMHB) values('";
	$id_hangban = $malichsuphieu."-".$mahangban."-".(string)date('His');
	$sql = $sql.$id_hangban."','".$malichsuphieu."','".$mahangban."','".$tenhangban."','".$soluong."','".$madvt."','".$dongia."','".$thanhtien."','".$manv."',GETDATE(),'','','1','".$orderid."','".$dongia."','VND','".$thanhtien."','')";
	
	$rs=sqlsrv_query($conn,$sql);
	} 
catch (Exception $e) 
	{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}
	
?>
	
		
	