<?php

include'connect.inc.php';
include 'core.inc.php';
include 'C:\xampp\htdocs\Shopitv1\instamojo\instamojo.php';
$api = new Instamojo\Instamojo("test_eed23dd23f66ede2db601673e8d", "test_313829e321635886b7fcac41be9", 'https://test.instamojo.com/api/1.1/');
$payid=$_GET['payment_request_id'];
$payment_status=$_GET['payment_status'];
echo $payment_status;
// try{
// 	$response=$api->paymentRequestStatus($payid);
// }
$product_names="";

if($payment_status!="Failed" || $payment_status=="COD"){

// echo $payment_status;
	if(isset($_SESSION['userid'])){
	if(!empty($_SESSION['userid'])){
		$id=@$_SESSION['userid'];
		
		$orderer_email="select email from users where id='$id'";
		$orderer_email=mysqli_query($db,$orderer_email);
		$orderer_email_val=mysqli_fetch_assoc($orderer_email);
		$to=$orderer_email_val['email'];
		
		$cart_product="select prod_id from usercart where id='$id'";
		$cart_product=mysqli_query($db,$cart_product);
		
		
		if ($payment_status!="Failed" && $payment_status!="COD") {
			$order_product="insert into allorders (user_id,paymentdone)values('$id',1)";

		}
		else{
			$order_product="insert into allorders (user_id)values('$id')";
		}



		

		$order_product=mysqli_query($db,$order_product);

		$order_total=0;
		// echo $payment_status;
		while($cart_product_row=mysqli_fetch_assoc($cart_product)){

			// echo $payment_status;
			$prod_id=$cart_product_row['prod_id'];


			


			


			$order_id_row=mysqli_fetch_assoc(mysqli_query($db,"select max(order_id) from allorders where user_id='$id' "));

			$order_id=$order_id_row['max(order_id)'];

			$order_contents=mysqli_query($db,"insert into order_contents values('$order_id',$prod_id,1)");











			$remove_from_cart_query="delete from usercart where id='$id' and prod_id='$prod_id'";

			$remove_from_cart_query_result = mysqli_query ($db,$remove_from_cart_query); 
			
			
			$product_name="select prod_name,prod_price from allproducts where prod_id='$prod_id'";
			$product_name=mysqli_query($db,$product_name);
			$product_name_val=mysqli_fetch_assoc($product_name);

			if($product_names!=""){
				$product_names=$product_names.", ".$product_name_val['prod_name'];
			}
			else{
				$product_names=$product_names." ".$product_name_val['prod_name'];
			}

			$order_total=$order_total+$product_name_val['prod_price'];


			$from = "electravit1@gmail.com";
		//$to = "msinghvi16@gmail.com";
		$subject = " ShopIt : Order confirmed!";
		//$message = "PHP mail works just fine";
		$message = "Your Order for => ".$product_names." has been confirmed! Your order will be deliverd to you within one week. Thank You - Team ShopIt.";
		$headers = "From:" . $from;
		mail($to,$subject,$message, $headers);
		//echo "The email message was sent.";
		// echo $product_names;
		
		header("Location:myorders.php");		
		}



	}
}


}
else{
	echo "HI";
	header("Location:home.php?cart=1");
}

?>