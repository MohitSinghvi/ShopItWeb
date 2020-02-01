<?php
 include 'connect.inc.php';
 include 'core.inc.php';
 $url=$_SESSION['url'];
 $_SESSION['url'] = $_SERVER['REQUEST_URI'];
 if(isset($_SESSION['userid'])&&!empty($_SESSION['userid'])){
	$user_id=$_SESSION['userid'];

	$prod_id=$_GET["prod_id"];
	$add_to_cart_query="insert into usercart values('$user_id','$prod_id',1)";
	$add_to_cart_query_result = mysqli_query ($db,$add_to_cart_query); 
	echo"✓ Added";
	// echo $prod_id;
	$url2=$_SESSION['url'];

	// echo $url;
	// echo $url2;
	if($url=='/Shopitv1/addtocart.php?prod_id='.$prod_id){
		header('Location:home.php?cart=1');
	}

	// header('Location:home.php');
 }
else{
	// header('Location:login2.php');
	// exit;
	
}

?>