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
		$prod_image=$ordered_products['prod_image'];

		
		echo "<tr>
		<td> <img src='$prod_image' style='height:100px;width:100p;'> ";
// echo $prod_id;
		$rating_query="select rating from ratings where user_id=$id and prod_id=$prod_id";
		$rating_result=mysqli_query($db,$rating_query);
		if(mysqli_num_rows($rating_result)!=0){
			
			$rating_val=mysqli_fetch_assoc($rating_result)['rating'];
			
// 			echo $rating_val;



			echo "

			<div id='YEHWALA' >

				

				<img src='star_empty.png' id='".$prod_id."star1' onclick='rate(this.id,".$prod_id.")' class='star_empty'>
				<img src='star_empty.png' id='".$prod_id."star2' onclick='rate(this.id,".$prod_id.")' class='star_empty'>
				<img src='star_empty.png' id='".$prod_id."star3' onclick='rate(this.id,".$prod_id.")' class='star_empty'>
				<img src='star_empty.png' id='".$prod_id."star4' onclick='rate(this.id,".$prod_id.")' class='star_empty'>
				<img src='star_empty.png' id='".$prod_id."star5' onclick='rate(this.id,".$prod_id.")' class='star_empty'  >

				<img src onerror=rate("."'".$prod_id."star".$rating_val."'".",".$prod_id.")>

				

				<button onclick='show(".$prod_id.")'' > Submit Rating </button>
				<p id='demo1' ></p>
			</div>
			
			";
		}
		else{
			echo "

		<div>
<img src='star_empty.png' id='".$prod_id."star1' onclick='rate(this.id,".$prod_id.")' class='star_empty'>
<img src='star_empty.png' id='".$prod_id."star2' onclick='rate(this.id,".$prod_id.")' class='star_empty'>
<img src='star_empty.png' id='".$prod_id."star3' onclick='rate(this.id,".$prod_id.")' class='star_empty'>
<img src='star_empty.png' id='".$prod_id."star4' onclick='rate(this.id,".$prod_id.")' class='star_empty'>
<img src='star_empty.png' id='".$prod_id."star5' onclick='rate(this.id,".$prod_id.")' class='star_empty'>

<button onclick='show(".$prod_id.")''> Submit Rating </button>
<p id='demo1'></p>
</div>";
		}


// 		echo"<p ></p>";

		// echo"HIHIHIHI";
		
		
		// echo $ordered_products['prod_image'];

		




		echo"

		</td><td><a href='http://localhost/Shopitv1/home.php?prod_id= $prod_id  "; 


		echo"   ";
		echo"   '> ".$ordered_products["prod_name"]."</a></td><td>";
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




<script>
var rval=1;
function rate(id,prod_id){
	var curr_src=document.getElementById(id).getAttribute('src');
	//document.getElementById('demo1').innerHTML=rval;*/
	// if(curr_src==='star_yellow.png'){
	// 	document.getElementById(id).src='star_empty.png';
	// }
	// else if(curr_src==='star_empty.png'){
	// 	document.getElementById(id).src='star_yellow.png';
	// }
	if(id==(prod_id+'star5')){
		rval=5;
		document.getElementById(prod_id+'star1').src='star_yellow.png';
		document.getElementById(prod_id+'star2').src='star_yellow.png';
		document.getElementById(prod_id+'star3').src='star_yellow.png';
		document.getElementById(prod_id+'star4').src='star_yellow.png';
		document.getElementById(prod_id+'star5').src='star_yellow.png';
	}
	if(id==prod_id+'star4'){
		rval=4;
		document.getElementById(prod_id+'star1').src='star_yellow.png';
		document.getElementById(prod_id+'star2').src='star_yellow.png';
		document.getElementById(prod_id+'star3').src='star_yellow.png';
		document.getElementById(prod_id+'star4').src='star_yellow.png';
		document.getElementById(prod_id+'star5').src='star_empty.png';
	}
	if(id==prod_id+'star3'){
		rval=3;
		document.getElementById(prod_id+'star1').src='star_yellow.png';
		document.getElementById(prod_id+'star2').src='star_yellow.png';
		document.getElementById(prod_id+'star3').src='star_yellow.png';
		document.getElementById(prod_id+'star4').src='star_empty.png';
		document.getElementById(prod_id+'star5').src='star_empty.png';
	}
	if(id==prod_id+'star2'){
		rval=2;
		document.getElementById(prod_id+'star1').src='star_yellow.png';
		document.getElementById(prod_id+'star2').src='star_yellow.png';
		document.getElementById(prod_id+'star3').src='star_empty.png';
		document.getElementById(prod_id+'star4').src='star_empty.png';
		document.getElementById(prod_id+'star5').src='star_empty.png';
	}
	if(id==prod_id+'star1'){
		rval=1;
		document.getElementById(prod_id+'star1').src='star_yellow.png';
		document.getElementById(prod_id+'star2').src='star_empty.png';
		document.getElementById(prod_id+'star3').src='star_empty.png';
		document.getElementById(prod_id+'star4').src='star_empty.png';
		document.getElementById(prod_id+'star5').src='star_empty.png';
	}


	
}
function show(prod_id){
	// document.getElementById('demo1').innerHTML=rval;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
	  		document.getElementById('demo1').innerHTML =
	  		this.responseText;
		}
  	};
 	xhttp.open('POST', 'rating.php', true);
 	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
 	xhttp.send('prod_id='+prod_id+'&rating='+rval);
}
</script>
</html>
