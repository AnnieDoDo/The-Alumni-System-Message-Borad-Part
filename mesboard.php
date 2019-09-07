<?php session_start(); ?>
<?php
//連接資料庫
//只要此頁面上有用到連接MySQL就要include它
include("mysql_connect.inc.php");
$data=mysql_query("select m.MsgNo,m.MsgContent,m.MsgTo,m.MsgTime,me.Name
from msgboard m,member me,message mes
where mes.Account=me.Account
order by MsgNo");
if(isset($_SESSION['Account'])){
	$Account = $_SESSION['Account'];
	$Password = $_SESSION['Password'];
	//搜尋資料庫資料
	$sql = "SELECT * FROM `member` where Account = '$Account'";
	$sql2 = "SELECT * FROM `student` where Account = '$Account'";
	$sql3 = "SELECT * FROM `teacher` where Account = '$Account'";
	$sql4 = "SELECT * FROM `graduate` where Account = '$Account'";
	$sql_S= "SELECT * FROM administrator where Account = '$Account'";
	$result = mysql_query($sql);
	$result2 = mysql_query($sql2);
	$result3 = mysql_query($sql3);
	$result4 = mysql_query($sql4);
	$result_S = mysql_query($sql_S);
	$row = @mysql_fetch_row($result);	
	$row2 = @mysql_fetch_row($result2);
	$row3 = @mysql_fetch_row($result3);
	$row4 = @mysql_fetch_row($result4);
	$row_S = @mysql_fetch_row($result_S);
	date_default_timezone_set ("ASIA/Taipei");
}
?>
<!--html-->
<!DOCTYPE html>
<html lang="zh-Hant">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>高大校友資訊網</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	
  </head>
  
  <body>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12">	
			<img src="image/TopBar.png" class="img-responsive" alt="Responsive image">
		</div>
	</div>
	<div class="row">
	  <div class="col-xs-12 col-sm-12">	
			<!--選單-->
			<ul class="nav nav-tabs">
			<li role="presentation"><a href="homepage2.php">首頁</a></li>
			<li role="presentation"><a href="publish.php?Page=1">公告</a></li>	
			<?php if(isset($_SESSION['Account'])) : ?> 	<!--假如有留下session-->
	  
				<?php if($row[0] == $Account && $row[1] == $Password) :?><!--有登入的話-->	
			<li role="presentation"><a href="activity.php?Page=1">活動記錄</a></li>			
			<li role="presentation"  class="active"><a href="mesboard.php">留言版</a></li>
			<li role="presentation" class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
				  系友資訊 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">
				  	<li role="presentation"><a href="Alumnus.php">畢業校友</a></li>
					<li role="presentation"><a href="teacher.php">教師</a></li>					
				</ul>
			</li>			
			<li role="presentation" class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
				  個人資料 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">
				  	<li role="presentation"><a href="showinfo.php">基本資訊</a></li>
					<li role="presentation"><a href="member.php">更換頭像</a></li>					
				</ul>
			</li>
			<?php if($row_S[0]!=null) : ?>
				<li role="presentation"><a href="register.php">修改會員資料</a></li>
			<?php endif ?>
				<?php endif; ?>
			<?php endif; ?>
			
			</ul>
		</div>
	  <!-- 選項：如果他們內容有不符合的高度，清除 XS column -->
	   <?php if(isset($_SESSION['Account'])) : ?> 	<!--假如有留下session-->
	  
				<?php if($row[0] == $Account && $row[1] == $Password) :?><!--有登入的話-->	
	  <div class="clearfix visible-xs-block"></div>
	<div class="row">
	  <div class="col-xs-1 col-sm-1">
	  </div>	
	  <div class="col-xs-6 col-sm-6">	 
	 
		<?php 
	$AllMsg=mysql_query("select ms.MsgNo,MsgContent,MsgTo,MsgTime,Name,Account,top
						from msgboard ms natural join message me natural join member m						
						order by `top`,`MsgNo");
	for($i=1 ; $i<=mysql_num_rows($AllMsg) ; $i++){
		$rs=mysql_fetch_assoc($AllMsg); 
	?>
		<table border=1>
		<tbody>
		　 <tr>
			
			<?php if(isset($_SESSION['Account'])) : ?><!--假如有留下session-->
				<?php if($row_S[0]): ?>
				<th>留言編號</th>
				<th>留言來自</th>
		　　	<th>留言對象</th>		　　        
				<th>留言時間</th>
				<th><a href = "top.php?MsgNo=<?php echo $rs["MsgNo"];?>">置頂</a></th><br>
				<th><a href = "top2.php?MsgNo=<?php echo $rs["MsgNo"];?>">取消置頂</a></th><br>
				<th><a href = "blacklist.php?MsgNo=<?php echo $rs["MsgNo"];?>">Black</a></th>
				<th><a href = "blacklist2.php?MsgNo=<?php echo $rs["MsgNo"];?>">Cancel</a></th>
				<th><a href = "del.php?MsgNo=<?php echo $rs["MsgNo"];?>">刪除留言</a></th>	
				
				<?php endif ;?>
			<?php endif ;?>
		　</tr>
		  <tr>
		  <?php if(isset($_SESSION['Account'])) : ?><!--假如有留下session-->
				<?php if($row_S[0]): ?>
						<td><?php echo $rs["MsgNo"];?></td>
						<td><?php echo $rs["Name"];?></td>
		　　			<td><?php echo $rs["MsgTo"];?></td>					
						<td><?php echo $rs["MsgTime"];?></td>
					<?php endif ;?>
			<?php endif ;?>
		  </tr>
		  <tr>
		   <?php if(isset($_SESSION['Account'])) : ?><!--假如有留下session-->
				<?php if($row_S[0]): ?>
			<th colspan="4">留言內容</th>
				<?php endif ;?>
			<?php endif ;?>			
		  </tr>
		  <tr>
		  <?php if(isset($_SESSION['Account'])) : ?><!--假如有留下session-->
				<?php if($row_S[0]): ?>
			<?php $text =$rs["MsgContent"];?>
		　　<td colspan="4"><?php echo nl2br("$text");?></td>	
			<?php endif ;?>
			<?php endif ;?>
			</tr>
	
		<tr>
		<?php if(!$row_S[0] && substr($rs["Account"],0,4)== substr($_SESSION['Account'],0,4)): ?>
				<th>留言編號</th>
				<th>留言來自</th>
		　　	<th>留言對象</th>		　　        
				<th>留言時間</th>
		<?php endif ;?>
		</tr>
		<tr>		
		<?php if(!$row_S[0] && substr($rs["Account"],0,4)== substr($_SESSION['Account'],0,4)): ?>
						<td><?php echo $rs["MsgNo"];?></td>
						<td><?php echo $rs["Name"];?></td>
		　　			<td><?php echo $rs["MsgTo"];?></td>					
						<td><?php echo $rs["MsgTime"];?></td>
		<?php endif ;?>
		</tr>	
		<tr>
		<?php if(!$row_S[0] && substr($rs["Account"],0,4)== substr($_SESSION['Account'],0,4)): ?>
			<th colspan="4">留言內容</th>
				<?php endif ;?>
		</tr>
		<tr>
		<?php if(!$row_S[0] && substr($rs["Account"],0,4)== substr($_SESSION['Account'],0,4)): ?>
			<?php $text =$rs["MsgContent"];?>
		　　<td colspan="4"><?php echo nl2br("$text");?></td>	
			<?php endif ;?>
			
			</tr>
		</tbody>
		</table>
	<?php }?>				
		</div>
		
		<!--頁碼-->
	  
	  <div class="col-xs-2 col-sm-2">
		
		</br><div style="text-align:right;"><a href="mes1.php" class="btn btn-primary" role="button">新增留言</a></div>	  
		
	  </div>	
	  
			<?php endif; ?>
		
		<?php endif; ?>
		<!--頁碼-->
	  <div class="col-xs-3 col-sm-3">
		  <!--右欄位-->
		  
		  <table class="table">
		  <tr><td>
		  <br><a href="http://www.nuk.edu.tw/bin/home.php"><img src="image/logo.jpg" class="img-responsive" alt="Responsive image"></a><br>
		  </td><tr>
		  
		  
		  <!--登入-->
		  <tr><td>
		  <?php if(isset($_SESSION['Account'])) : ?><!--假如有留下session-->
			<h3>hi!<?php echo $_SESSION['Account']?></h3>
			<?php if($row_S[0]!=null) : ?>
				<h4>尊爵高貴不凡的管理員<?php echo $row_S[1] ?>號</h4>
			<?php endif ?>
			<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="location.href='logout.php'">
			  登出
			</button>
			<br><br>
		  <?php else : ?><!--假如沒有，顯示登入頁面-->
			<form name="form" method="post" action="connect.php">
			  <div class="form-group">
				<label for="exampleInputEmail1">帳號</label>
				<input type="text" class="form-control" name="id" placeholder="輸入帳號">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">密碼</label>
				<input type="Password" class="form-control" name="pw" placeholder="Password">
			  </div>
			  <button type="submit" class="btn btn-primary">送出</button>		
			  <!--button type="botton" class="btn btn-default" onClick="fun()">註冊</button-->
				<script language="javascript"> 
					function fun(){				
						document.forms[0].action='register.php'; 
					}          
				</script>				  
			</form>			
			
		  <br>
		  <?php endif; ?>
		  </td></tr>
		  
			<!--動態圖片-->
		  <tr><td>
		  <br>
		  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			  </ol>
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
				<div class="item active">
				  <img src="image/聖誕節.jpg" alt="聖誕節">
				  <div class="carousel-caption">
					...
				  </div>
				</div>
				<div class="item">
				  <img src="image/聖誕節2.jpg" alt="聖誕節2">
				  <div class="carousel-caption">
					...
				  </div>
				</div>
				...
			  </div>  
			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			  </a>
		  </div>
		  </td></tr>
		   </table>
	  </div>  
	<div class="row">	
	  <div class="col-xs-12 col-sm-12">
		<br>
		<img src="image/BottomBar.png" class="img-responsive" alt="Responsive image">
	  </div>
		  
	  </div>
	</div>
</div>
    

    <!-- jQuery (Bootstrap 所有外掛均需要使用) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- 依需要參考已編譯外掛版本（如下），或各自獨立的外掛版本 -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

