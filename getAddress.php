<?php
include 'connect.inc.php';
include 'core.inc.php';
if(isset($_GET['payment_mode'])){
	$payment_mode=$_GET['payment_mode'];
	
	// if ($payment_mode=="online"){
	// 	echo "Online purchase";

	// // header("Location:orders.php?id=$id");
	// }	
	// else{
	// 	echo"COD purchase";
	// 	// header("Location:orderdone.php?payment_status=COD");
	// }
}

if(isset($_POST['user_address'])){
	// echo "Online purchase";
	$id=@$_SESSION['userid'];
	$user_address=$_POST['user_address'];
	// $address_query=mysqli_query($db,"update users set address='$user_address' where id='$id'");
	if(isset($_POST['payment_mode'])){
	$payment_mode=$_POST['payment_mode'];
	
	if ($payment_mode=="online"){
		echo "Online purchase";

		header("Location:orders.php?id=$id");
	}	
	else{
		echo"COD purchase";
		header("Location:orderdone.php?payment_status=COD");
	}
}
	
	
}

?>


<link rel="stylesheet" href="signup.css">




<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="border:1px solid #ccc" method="POST">
  <div class="container" align="center">
    <div class="form" align="left">
	<h1>Enter your Address</h1>
	
    <hr>
    
    <label for="user_address"><b>Address</b></label>
    <input type="text" placeholder="Enter Address" name="user_address" required >
    <input type="hidden" name="payment_mode" value = <?php echo $payment_mode; ?>>
	

    <div class="clearfix" align=center>
      <button type="submit" class="signupbtn" name="submit">Confirm Order</button>



    </div>
	
	</div>
  </div>
</form>
</button>
