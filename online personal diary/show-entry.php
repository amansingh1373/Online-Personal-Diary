<!DOCTYPE html>
<html>
	<head>
		<title>dairy entry page</title>
		<script src="https://kit.fontawesome.com/bcb50b9b1e.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="show-entry-style.css">
		<style>
			body{
				margin:0;
				padding:0;
				font-family: sans-serif;
				font-size:1.2vw;
			}
			.container{
				background-color:#e3e3e3ad;
				min-height:100vh;
			}
		</style>
	</head>
	<body>
		<?php
			session_start();

			require_once "pdo.php";

			if(!isset($_SESSION['u_name']))
			{
				$_SESSION['message']="invalid login";
				$_SESSION['property']="flex";
				$_SESSION['color']="red";
				header("location:index.php");
				return;
			}
			if(isset($_GET['u_name'])&&isset($_GET['d_id']))
			{
				$val=$_GET['u_name'];
				$d_id=$_GET['d_id'];
			}
		?>
		<div class="container">
			<div class="top-nav">
				<div class="side-menu-direct"><a href="feed.php"><i class="fa-solid fa-arrow-left"></i></a></div>
			</div>
			<div class="diary-entry">
				<?php
					$sql1 = "select * from diary_entry where u_name=:username AND d_id=:id";
					$stmt1 = $pdo->prepare($sql1);
					$stmt1->execute(array(':username'=>$val,'id'=>$d_id));
					$row = $stmt1->fetch(PDO::FETCH_ASSOC);
					echo 	'<div class="title">';
					echo		'<div class="title-content">'.$row['title'].'</div>';
					echo 	'</div>';
					echo	'<div class="entry" style="font-style:'.$row['font_style'].';color:rgb('.$row['font_color_r'].','.$row['font_color_g'].','.$row['font_color_b'].');font-size:'.$row['font_size'].';">';
					echo    	$row['entry'];
					echo 	'</div>';
				?>
			</div>
		</div>
	</body>
</html>