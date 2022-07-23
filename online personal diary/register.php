<!DOCTYPE html>
<html>
	<head>
		<title>register</title>
		<link rel="stylesheet" href="register.css">
	</head>
	<style>
		body{
			margin:0;
			padding:0;
			font-family: sans-serif;
			font-size:1.2vh;
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
	<body>
		<?php
			session_start();

			require_once "pdo.php";

			if(isset($_POST['submit']))
			{
				if(!empty($_POST['u_name']))
				{
					if(!empty($_POST['name']))
					{
						if(!empty($_POST['password']))
						{
							$sql1 = 'INSERT INTO users (u_name,name,password) VALUES (:u_name,:name,:pass)';
							$stmt1 = $pdo->prepare($sql1);
							$stmt1->execute(
								array(
									':u_name'=>$_POST['u_name'],
									':name'=>$_POST['name'],
									':pass'=>$_POST['password']
								)
							);
							$_SESSION['message']='user added';
							$_SESSION['property']='flex';
							$_SESSION['color']='green';
							header("location:index.php");
							return;
						}
						else
						{
							$_SESSION['message']='password empty';
							$_SESSION['property']='flex';
							$_SESSION['color']='red';
						}
					}
					else
					{
						$_SESSION['message']='name empty';
						$_SESSION['property']='flex';
						$_SESSION['color']='red';
					}
				}
				else
				{
					$_SESSION['message']='username empty';
					$_SESSION['property']='flex';
					$_SESSION['color']='red';
				}
				header("location:register.php");
				return;
			}
		?>
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
							<div class="wrapper-label"><label for="name" class="label-style">name</label></div>
							<input type="text" id="name" class="text-field-style" name="name">
						</div>
						<div class="text-field">
							<div class="wrapper-label"><label for="password" class="label-style">password</label></div>
							<input type="text" id="password"  class="text-field-style" name="password">
						</div>
						<div class="button">
							<input type="submit"  class="button-style" name="submit" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>