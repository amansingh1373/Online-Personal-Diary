<!DOCTYPE html>
<html>
	<head>
		<title>login</title>
		<link rel="stylesheet" href="login-style.css">
	</head>
	<style>
		body{
			margin:0;
			padding:0;
			font-family: sans-serif;
			font-size:1.2vw;
		}
		.container{
			height:100vh;
			background-color:#e3e3e3ad;
			display:flex;
			align-items: center;
			justify-content: center;
			flex-direction:column;
		}
	</style>
	<?php
		session_start();

		require_once "pdo.php";
		$flag=0;
		if(isset($_POST['submit']))
		{
			if(!empty($_POST['u_name']))
			{
				if(!empty($_POST['password']))
				{
					$sql1='select * from users';
					$stmt1=$pdo->query($sql1);
					while($row = $stmt1->fetch(PDO::FETCH_ASSOC))
					{
						if($row['u_name']==$_POST['u_name']&&$row['password']==$_POST['password'])
						{
							$_SESSION['u_name']=$_POST['u_name'];
							header("location:feed.php");
							return;
						}
						else
						{
							$flag=1;
						}
					}
					if($flag==1)
					{
						$_SESSION['message']='username not found or password is incorrect';
						$_SESSION['property']='flex';
						$_SESSION['color']='red';
					}
				}
				else
				{
					$_SESSION['message']='Password missing';
					$_SESSION['property']='flex';
					$_SESSION['color']='red';
				}
			}
			else
			{
				$_SESSION['message']='Username missing';
				$_SESSION['property']='flex';
				$_SESSION['color']='red';
			}
			header("location:index.php");
			return;
		}
	?>
	<body>
		<div class="container">
			<div class="message" style="display:<?php if(!empty($_SESSION['property']))echo $_SESSION['property'];else echo 'none';?>;color:<?php if(!empty($_SESSION['color']))echo $_SESSION['color'];else echo 'red';?>;"><?php 
																				if(!empty($_SESSION['message']))
																				{
																					echo $_SESSION['message'];
																					unset($_SESSION['message']);
																					unset($_SESSION['property']);
																				}
																				else{echo "";}
																			?></div>
			<div class="login-window">
				<div class="l_form">
					<form method="post">
						<div class="text-field">
							<div class="wrapper-label"><label for="u_name" class="label-style">username</label></div>
							<input type="text" id="u_name" class="text-field-style" name="u_name">
						</div>
						<div class="text-field">
							<div class="wrapper-label"><label for="password" class="label-style">password</label></div>
							<input type="password" id="password"  class="text-field-style" name="password">
						</div>
						<div class="button">
							<input type="submit"  class="button-style" name="submit" value="login">
						</div>
						<div class="register-direct">
							<a href="register.php">Register here</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>