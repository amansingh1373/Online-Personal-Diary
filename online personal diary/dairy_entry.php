<!DOCTYPE html>
<html>
	<head>
		<title>dairy entry page</title>
		<script src="https://kit.fontawesome.com/bcb50b9b1e.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="diary_entry-style.css">
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

			if(!!empty($_SESSION['u_name']))
			{
				$_SESSION['message']="invalid login";
				$_SESSION['property']="flex";
				$_SESSION['color']="red";
				header("location:index.php");
				return;
			}

			if(!empty($_POST['submit']))
			{
				if((!empty($_POST['f_style']))&&(!empty($_POST['f_color_r']))&&(!empty($_POST['f_color_g']))&&(!empty($_POST['f_color_b']))&&(!empty($_POST['f_size']))&&(!empty($_POST['status']))&&(!empty($_POST['title'])&&(!empty($_POST['d_content']))))
				{
					$date = getdate();
					$hour = $date['hours'];
					$min = $date['minutes'];
					$sec = $date['seconds'];
					$year = $date['year'];
					$month = $date['mon'];
					$dat = $date['mday'];
					$val = $hour.$min.$sec;
					$val1 = $year.$month.$dat;
					if($_POST['status']="public")
					{
						$_POST['status']=0;
					}
					else
					{
						$_POST['status']=1;
					}
					$sql1 = "INSERT INTO diary_entry (u_id,u_name,name,entry_date,entry_time,font_style,font_color_r,font_color_g,font_color_b,font_size,status,title,entry) VALUES (:u_id,:u_name,:name,:entry_date,:entry_time,:font_style,:font_color_r,:font_color_g,:font_color_b,:font_size,:status,:title,:entry)";
					$stmt1 = $pdo->prepare($sql1);
					$sql2 = "select * from users where u_name=:username";
					$stmt2 = $pdo->prepare($sql2);
					$stmt2->execute(array(':username'=>$_SESSION['u_name']));
					$row = $stmt2->fetch(PDO::FETCH_ASSOC);
					$stmt1->execute(
						array(
							':u_id'=>$row['u_id'],
							':u_name'=>$_SESSION['u_name'],
							':name'=>$row['name'],
							':entry_date'=>$val1,
							':entry_time'=>$val,
							':font_style'=>$_POST['f_style'],
							':font_color_r'=>$_POST['f_color_r'],
							':font_color_g'=>$_POST['f_color_g'],
							':font_color_b'=>$_POST['f_color_b'],
							':font_size'=>$_POST['f_size'],
							':status'=>$_POST['status'],
							':title'=>$_POST['title'],
							':entry'=>$_POST['d_content']
						)
					);
					
					$_SESSION['message']="entry added";
					$_SESSION['property']="flex";
					$_SESSION['color']="green";
					header("location:dairy_entry.php");
					return;
				}
				else
				{
					$_SESSION['message']="there is a feild missing please check";
					$_SESSION['property']="flex";
					$_SESSION['color']="red";
				}
				header("location:dairy_entry.php");
				return;
			}
		?>
		<div class="container">
			<form method="post">
				<div class="top-nav">
					<div class="side-menu-direct"><a href="feed.php"><i class="fa-solid fa-arrow-left"></i></a></div>
					<div class="entry-direct"><input type="submit" class="button-style" name="submit" value="Save"></div>
				</div>
				<div class="message-wrapper">
					<div class="message" style="display:<?php if(!empty($_SESSION['property']))echo $_SESSION['property'];else echo 'none';?>;color:<?php if(!empty($_SESSION['color']))echo $_SESSION['color'];else echo 'red'; ?>;">
						<?php 
							if(!empty($_SESSION['message']))
							{
								echo $_SESSION['message'];
								unset($_SESSION['message']);
								unset($_SESSION['property']);
								unset($_SESSION['color']);
							}
							else
								echo '';
						?>
					</div>
				</div>
				<div class="diary-entry">
					<div class="styling-entry">
						<div class="font-style">
							<div class="label-wrapper">
								<label for="f_style" class="label-style">font-style</label>
							</div>
							<div class="input-wrapper">
								<input name="f_style" id="f_style" class="text-field-style" type="text">
							</div>
						</div>
						<div class="font-color">
							<div class="label-wrapper">
								<label for="f_color_r" class="label-style">font-color</label>
							</div>
							<div class="f_color-wrapper">
								<div class="input-wrapper f_color-t">
									<input name="f_color_r" id="f_color_r" class="text-field-style" style="margin-left:2%;margin-right:2%;" type="text">
								</div>
								<div class="input-wrapper f_color-t">
									<input name="f_color_g" id="f_color_g " class="text-field-style" type="text">
								</div>
								<div class="input-wrapper f_color-t">
									<input name="f_color_b" id="f_color_b" class="text-field-style" type="text">
								</div>
							</div>
						</div>
						<div class="font-size">
							<div class="label-wrapper">
								<label for="f_size" class="label-style">font-size</label>
							</div>
							<div class="input-wrapper">
								<input name="f_size" id="f_size" class="text-field-style" type="text">
							</div>
						</div>
						<div class="status">
							<div class="label-wrapper">
								<label for="status" class="label-style">status</label>
							</div>
							<div class="input-wrapper">
								<input name="status" id="status" class="text-field-style" type="text">
							</div>
						</div>
					</div>
					<div class="entry">
						<div class="title">
							<div class="label-wrapper">
								<label for="title" class="label-style">Title</label>
							</div>
							<div class="input-wrapper">
								<input name="title" id="title" class="text-field-style title_t" type="text">
							</div>
						</div>
						<div class="diary-content">
							<textarea class="text-area-style"  name="d_content"></textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>