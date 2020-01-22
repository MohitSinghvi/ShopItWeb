<?php
if(isset($_SESSION['userid'])&&!empty($_SESSION['userid'])){
	$id=$_SESSION['userid'];
	$userquery="select username from users where id= '$id' ";
	$userquery=mysqli_query($db,$userquery);
	$userquery=mysqli_fetch_array($userquery,MYSQLI_ASSOC);
	$userquery=$userquery['username'];
	$log="loggedin";

}
else{
	
	$log="loggedout";
	
}

?>