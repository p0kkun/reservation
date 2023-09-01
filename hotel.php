<?php
$pdo = new PDO('mysql:host=localhost;dbname=practice;charset=utf8','root','mariadb');
foreach ($pdo->query('select * from user') as $row) {
	echo '<p>';
	echo $row['id'], ':';
	echo $row['username'],' ';
	echo $row['pass'],':';
	echo '</p>';
}
?>