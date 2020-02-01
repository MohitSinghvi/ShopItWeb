<html>
<head>
	<style>
	table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

</style>
<head>
<?php
require 'connect.inc.php';
include 'core.inc.php';
include 'logincheck.inc.php';
include 'headerAndMenu.inc.php';

$_SESSION['url'] = $_SERVER['REQUEST_URI'];
$id=@$_SESSION['userid'];



if($id!=1){
	$order_ids="select order_id,paymentdone from allorders where user_id='$id' order by order_id desc ";

}
else if($id==1){
	$order_ids="select order_id,paymentdone from allorders order by order_id desc ";

}

$order_ids=mysqli_query($db,$order_ids);

?>





<div class=full_content>

<div class="left_part" style="width:25%;float:left;height:50px">
	
</br>
</div>
<div class="middle_part" style="width:50%;float:left;"">
<?php

while(@$row=mysqli_fetch_assoc($order_ids)){


	$prod_price_total=0;

	echo'
	<div style="background-color:white " align="center">
	<p>';


	$order_id=$row["order_id"];

	$paymentdone=$row['paymentdone'];



	echo "Order_id : ".$order_id."</p>";


	$order_query="select a.prod_id,a.prod_name, a.prod_price, a.prod_image
				  from allproducts a
				  where prod_id in ( select product_id 
				  					 from order_contents 
				  					 where order_id ='$order_id')

	";

	$order_query=mysqli_query($db,$order_query);
	$order_date_query=mysqli_query($db,"select order_date from allorders where order_id='$order_id'");
	$order_date_result=mysqli_fetch_assoc($order_date_query);
	$order_date=$order_date_result['order_date'];





	echo $order_date;



	if($id==1){
		$orderer_query="select * from users where id = (select user_id from allorders where order_id=$order_id)";

		$orderer_query=mysqli_query($db,$orderer_query);
		$orderer_result=mysqli_fetch_assoc($orderer_query);
		$orderer_id=$orderer_result['id'];
		$orderer_name=$orderer_result['username'];
		$orderer_email=$orderer_result['email'];
		$orderer_address=$orderer_result['address'];

		echo
			" <br>ORDERED BY:". $orderer_name." Address: ".$orderer_address
		;

	}




	echo"<table style='width:100%;border: 1px solid black'>

			<tr style='background-color: black; color:white'><th colspan='2'>ITEM(s)</th>
			<th>Price</th></tr>


		";







	while (@$ordered_products=mysqli_fetch_assoc($order_query)){

		$prod_id=$ordered_products['prod_id'];
		// echo"HIHIHIHI";
		$prod_image=$ordered_products['prod_image'];
		
		// echo $ordered_products['prod_image'];

		echo "<tr>
		<td> <img src='$prod_image' style='height:100px;width:100p;float:left;'> </td><td><a href='http://localhost/Shopitv1/home.php?prod_id= $prod_id  "; 


		echo"   ";
		echo"   '>".$ordered_products["prod_name"]."</a></td><td>";
		echo $ordered_products["prod_price"]."</td></tr>";

		$prod_price_total+=$ordered_products["prod_price"];




	}



	echo"<tr style='border: 2px solid black;background-color:black; color:white'>
		<td>TOTAL:</td>
		<td colspan='2'>".$prod_price_total."";

		if($paymentdone==1){
			echo" - ✓Paid online";
		}
	echo '</td>
	</tr></table>


			


	</div>







	';


}




?>
</div>
<div class=right_part>
	</div>
</div>
</html>
