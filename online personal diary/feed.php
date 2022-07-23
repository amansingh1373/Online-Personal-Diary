<!DOCTYPE html>
<html>
	<head>
		<title>feed</title>
		<script src="https://kit.fontawesome.com/bcb50b9b1e.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="feed-style.css">
		
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
				$_SESSION['message']='invalid login';
				$_SESSION['property']="flex";
				$_SESSION['color']="red";
				header("location:index.php");
				return;
			}
			
		?>
		<div class="container">
			<div class="top-nav">
				<div class="side-menu-direct"><label for="on-off"><i class="fa-solid fa-bars"></i></label></div>
				<div class="entry-direct"><a href="dairy_entry.php"><i class="fa-solid fa-pencil"></i> write an entry</a></div>
			</div>
			<div class="feed-wrapper">
				<input type="checkbox" id="on-off">
				<div class="side-bar">
					<div class="back">menu-items</div>
					<div class="menu-items"><a href="profile.php">Profile</a></div>
					<div class="menu-items"><a href="logout.php">Sign out</a></div>
				</div>
				<div class="wrapper">
					<?php 
						$sql1 = 'select * from following where u_name=:username';
						$sql2 = 'select * from diary_entry where u_name=:username and status=0';
						$stmt1 = $pdo->prepare($sql1);
						$stmt1->execute(
							array(
								':username'=>$_SESSION['u_name']
							)
						);
						while($row = $stmt1->fetch(PDO::FETCH_ASSOC))
						{
							echo "<br>";
							$stmt2 = $pdo->prepare($sql2);
							$stmt2->execute(
								array(
									':username'=>$row['u_name_f']
								)
							);
							while($row1 = $stmt2->fetch(PDO::FETCH_ASSOC))
							{
								echo '<div class="feed-items">';
								echo	'<div class="entry">'.$row1['title'].'<div class="box"><a href="show-entry.php?u_name='.$row['u_name_f'].'&d_id='.$row1['d_id'].'" style="text-decoration:none;color:inherit;"><i class="fa-solid fa-location-arrow"></i></a></div></div>';
								echo	'<div class="username">'.$row1['u_name'].'</div>';
								echo'</div>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>