<?php session_start();

// ADD TO RECIEVE TRIP ID FOR THE USER
$tripId = 2;
//$_GET['tripId'];
$userId = 1;

include("../includes/db-config.php");

?>

<h1> ADD GROUP MEMBER</h1>

<form action="group-add-process.php" method="POST">
	 PIN: <input name="uniqueId" type="text" >
	 <input name="tripId" type="hidden" value="<?php echo($tripId); ?>" >
  <br>
  <br>
	<input type="submit" value="Join"/>
</form>
