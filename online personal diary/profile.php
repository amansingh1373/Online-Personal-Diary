<!DOCTYPE html>
<html>
	<head>
		<script src="https://kit.fontawesome.com/bcb50b9b1e.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="profile-style.css">
		<title>profile</title>
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

			if(isset($_POST['delete']))
			{
				if(!empty($_POST['u_name']))
				{
					$sql3 = 'DELETE FROM following where u_name_f=:username';
					$stmt3 = $pdo->prepare($sql3);
					$stmt3->execute(array(':username'=>$_POST['u_name']));
				}
			}
		?>
		<div class="container">
			<div class="top-nav">
				<div class="side-menu-direct"><a href="feed.php"><i class="fa-solid fa-arrow-left"></i></a></div>
				<div class="entry-direct"><a href="dairy_entry.php"><i class="fa-solid fa-pencil"></i> write an entry</a></div>
			</div>
			<div class="profile">
				<div class="profile-content">
					<div class="display">
						<div class="pic"><img src="grey.png" class="circle"></div>
						<div class="username"><?=$_SESSION['u_name']?></div>
					</div>
					<div class="followers">
						<div class="heading">following</div>
						<div class="f-list">
							<?php
								$sql1 = 'select * from following where u_name=:username';
								$stmt1 = $pdo->prepare($sql1);
								$stmt1->execute(
									array(
										':username'=>$_SESSION['u_name']
									)
								);
								while($row = $stmt1->fetch(PDO::FETCH_ASSOC))
								{
									echo '<div class="name-box">';
									echo	'<div class="f-uname username">'.$row['u_name_f'].'</div>';
									echo	'<form method="post"><div class="delete"><input type="hidden" name="u_name" value="'.$row['u_name_f'].'"><input type="submit" class="d" name="delete" value="-"></div></form>';
									echo '</div>';
								}
							?>
						</div>
					</div>
				</div>
				<div class="feed-wrapper">
					<div class="wrapper">
						<?php
							$sql2 = 'select * from diary_entry where u_name=:username';
							$stmt2 = $pdo->prepare($sql2);
							$stmt2->execute(
								array(
									':username'=>$_SESSION['u_name']
								)
							);
							while($row1 = $stmt2->fetch(PDO::FETCH_ASSOC))
							{
								echo '<div class="feed-items">';
								echo	'<div class="entry">'.$row1['title'].'<div class="box"><a href="show-entry.php?u_name='.$_SESSION['u_name'].'&d_id='.$row1['d_id'].'" style="text-decoration:none;color:inherit;"><i class="fa-solid fa-location-arrow"></i></a></div></div>';
								echo	'<div class="username">'.$row1['u_name'].'</div>';
								echo'</div>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>