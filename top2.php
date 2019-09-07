<!DOCTYPE HTML>      <!--刪除語法-->
<?php session_start(); ?>
<?php
include("mysql_connect.inc.php");
	$Account = $_SESSION['Account'];
	$Password = $_SESSION['Password'];
	//搜尋資料庫資料
	$sql = "SELECT * FROM member where Account = '$Account'";
	$sql_S= "SELECT * FROM administrator where Account = '$Account'";
	$result = mysql_query($sql);
	$result_S = mysql_query($sql_S);
	$row = @mysql_fetch_row($result);
	$row_S = @mysql_fetch_row($result_S);
?>

<?php
 if(isset($_SESSION['Account'])) :///假如有留下Session
	if($row_S[0]):///假如是管理員
		
		$MsgNo=$_GET["MsgNo"];
		
			mysql_query("update `message` set `top`='1' where `MsgNo`='$MsgNo' ");
		
		header("Location: mesboard.php");      //跳轉至留言板
		exit;
	endif ;
 endif ;
?>
