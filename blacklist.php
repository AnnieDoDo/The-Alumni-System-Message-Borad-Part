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
		//$ACC=$_GET["Account"];
		$sql_B= "SELECT Account FROM message natural join member where MsgNo = '$MsgNo'";
		$result_B = mysql_query($sql_B);
		$row_B = @mysql_fetch_row($result_B);
		
		$BlackMem=$row_B[0];
		mysql_query("update `member` SET `blacklist`='1' where Account='$BlackMem'");
		/*if($_SESSION['Account']==$ACC):
		{
		mysql_query("update `member` SET `blacklist`='1' ");
		}*/
		
		header("Location: mesboard.php");      //跳轉至留言板
		exit;
		//endif ;
	endif ;
 endif ;
?>
