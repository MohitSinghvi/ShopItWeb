<?php
// require 'connect.inc.php';
// include 'core.inc.php';
// include 'logincheck.inc.php';
// include 'headerAndMenu.inc.php';


$prod_id_query="select product_id from order_contents where order_id in (select order_id from allorders where user_id = ".$id.")";
$prod_id_result=mysqli_query($db,$prod_id_query);
$count=0;
$prod_ids="";
while(@$prod_ids_table=mysqli_fetch_assoc($prod_id_result) and $count<3){
	$prod_ids=$prod_ids." ".$prod_ids_table['product_id'];
	$count+=1;
	// print("HI");

}
// echo $prod_ids;
$command = escapeshellcmd('recommenderScript2.py '.$prod_ids);
$output = shell_exec($command);
// echo $output;

echo '<div style="background-color: #f1f1f1;clear: left"><h1 align="center" style="padding:10px;">Recommended for you:</h3>'; 
	$file = fopen("personal_recommendations.csv","r"); 
	$start_row = 2; //define start row
$i = 1; //define row count flag

$count=0;
while (($row1 = fgetcsv($file)) !== FALSE and $count<6) {
    $count+=1;
    if($i >= $start_row) {
        $prod_id = $row1[1];

	global $show,$db,$cart_total,$log,$id;
  
    $product_query = "select * from allproducts where prod_id='$prod_id'"; 

	$product_query=mysqli_query($db,$product_query);
	
	while(@$row=mysqli_fetch_assoc($product_query)){
		
		$prod_id=$row['prod_id'];
		if($log=="loggedin"){
			// $prod_id=$row['prod_id'];
			$is_added_to_cart="select id from usercart where id='$id' and prod_id='$prod_id'";
			$is_added_to_cart1=mysqli_query($db,$is_added_to_cart);
			$is_added_to_cartcount=mysqli_num_rows($is_added_to_cart1);
		
			if($is_added_to_cartcount!=0 and $log="loggedin"){
				$cart_message= "✓ ADDED";
			}
			else{
				$cart_message= "🛒Add to cart";
			}
		}
		else{
			$cart_message="🛒Add to cart";
		}
		
		echo'<a class="card_anchor">';
		
		echo'<div class=card align=center style="height:450px">
		
			
		
		  <div style="overflow:hidden;height:50px"><h2>'.$row['prod_name'].'</h2></div>
		  <div style="overflow:hidden;height:50px"
		  <h6>'.strtoupper($row['prod_brand']).'</h6>
		  </div>
		  <a  href="home.php?prod_id='.$row['prod_id'].'">
		  <div width=100% style="height:200px"><img class="prod_image" src ='.$row['prod_image'].' style="width:100%;height:100%">
		 </div>
		 </a>
		  <h4>$'.number_format($row['prod_price']).'</h4>
		  
		 ';
		 /* if($id==1){
			 echo"by ".$row['id'];
			 
		 } */
		 
		if($show!="YOUR CART" and $id!=1 and !isset($_GET['order'])){
			
			  echo'	  
			  <button id='.$prod_id.' type="button" onclick="addToCart('.$prod_id.')"  style="width:100%;background-color: #333;color:white;height:50px;" >'.$cart_message.'</button>


				';
		}
		
	
		echo'    </div>';
		
	   
		
	 }  	

	 } 

    $i++;
}

fclose($file);
	

?>