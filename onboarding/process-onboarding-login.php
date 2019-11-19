<?php session_start();
//process-login.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include("../includes/header.php");
    ?>
    <title>Register</title>
</head>
<body>

    <header>
        <!-- TOP NAVIGATION -->
    </header>
<?php

$email = $_POST['email'];
$password = $_POST['password'];

include("../includes/db-config.php");


$stmt = $pdo->prepare("SELECT * FROM `users` 
	WHERE `email` = '$email'
	AND `password` = '$password'
	");

$stmt->execute();

$row = $stmt->fetch();
if($stmt->rowCount()==1){
	// header("Location: dashboard.php");
	$_SESSION['userId'] = $row['userId'];
	$_SESSION['fullName'] = $row['fullName'];
	$_SESSION['status'] = $row['status'];
	
	if($_SESSION['type'] == 1){ 
		$randomNum = rand(1000,5000); 
		$stmt = $pdo->prepare("SELECT * FROM `trips` 
			WHERE `uniqueId` = ?");
		$stmt->execute([$randomNum]);
		$row = $stmt->fetchAll();
		while ($stmt->rowCount() > 0){
			$randomNum = rand(1000,5000); 
		}
	
		// echo($randomNum);
	
		$stmt = $pdo->prepare("INSERT INTO `trips` 
		(`tripName`, `destination`, `fromDate`, `toDate`, `type`, `uniqueId`) 
		VALUES (?, ?, ?, ?, ?, ?)");
	
		$stmt->execute([$_SESSION['tripName'], $_SESSION['destination'], $_SESSION['fromDate'], $_SESSION['toDate'], $_SESSION['type'], $randomNum]);
		if($stmt->rowCount() ==1 ){
			header("Location: onboarding-group.php?gid=".$randomNum);
		}
		
		
	}elseif($_SESSION['type'] == 0){

    $stmt = $pdo->prepare("INSERT INTO `trips` 
	(`tripName`, `destination`, `fromDate`, `toDate`, `type`) 
	VALUES (?, ?, ?, ?, ?)");

    $stmt->execute([$_SESSION['tripName'], $_SESSION['destination'], $_SESSION['fromDate'], $_SESSION['toDate'], $_SESSION['type']]);


	// 


}else{
	?>
		<main>
			<div class="container">

				<h1>Login</h1>
				<p>You have entered an invalid username or password, please <a href="onboarding-login.php">try again</a></p>
			</div>
		</main>

<?php
}
}
?>