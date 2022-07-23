<?php
  $id="aman";
  $password="aman";
  $pdo = new PDO('mysql:host=localhost;dbname=infobase',$id,$password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>