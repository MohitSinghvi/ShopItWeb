
<head>
	
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
</head>
<?php



//include'search.php';
//----------------------------------------------------------------------------
// //showItems();
// echo"</br>";
// echo'<div style="width:20%;float:left ;background-color:black;color:white; text-align:center">
// 	<a>Brands</a>


// </div>';

// echo '<div style="width:80%; float:left">';

include 'headerAndMenu.inc.php';

if($showing=="one"){
	showCurrentItem();
}
else{
	showItems();
	
}
// echo '</div>';





function showCurrentItem(){

	// require 'ml-latest-small/phpandpythoncollab.php';
	$prod_id=$_GET['prod_id'];
	$command = escapeshellcmd('recommenderScript.py '.$prod_id);
	// echo"HI";
    // $result=exec("C:\xampp\htdocs\Shopitv1\ml-latest-small\recommenderScript.py /tmp");
    // echo $output;

    $output=shell_exec($command);
	// echo $output ;
// echo"HI";

	global $show,$db,$product_query,$cart_total,$id,$log;

	$product_query=mysqli_query($db,$product_query);
	while(@$row=mysqli_fetch_assoc($product_query)){
		
		
		
		$prod_id=$row['prod_id'];
		$is_added_to_cart="select id from usercart where id='$id' and prod_id='$prod_id'";
		$is_added_to_cart1=mysqli_query($db,$is_added_to_cart);
		$is_added_to_cartcount=mysqli_num_rows($is_added_to_cart1);
		
		if($log=="loggedin"){
			if($is_added_to_cartcount!=0 ){
				$cart_message= "✓ ADDED";
			}
			elseif($is_added_to_cartcount==0){
				$cart_message= "🛒 Add to cart";
			}
		}
		else {$cart_message= "🛒 Add to cart";	}
		echo'<div class=card style="width:100% " >
		  
		  <h2>'.$row['prod_name'].'</h2>
		  <h4>by '.strtoupper($row['prod_brand']).'</h4>
		  <div  style="max-width:300px;">
		  <img class="prod_image" src ='.$row['prod_image'].' style="float: left;width:100%">
		  </div>
		  <div style="padding:20px;padding-right:20px"  > '. $row['prod_description'].'</div>
		  <h2>$'.$row['prod_price'].'/- only</h2>
		  
		  ';
		if($show!="YOUR CART" and $id!=1){
			  echo'	
			  <div style="clear:both;" align="center" >

			  	<button id='.$prod_id.' type="button" onclick="addToCart('.$prod_id.')"  style="width:200px;background-color: #333;color:white;height:50px;" >'.$cart_message.'</button>

				</div>';	
		}


		
	
		echo'    </div>';
		
	   
		
	 }  
	echo '<p>RECOMMENDED: </p>'; 
	$file = fopen("recommendations.csv","r"); 
	$start_row = 2; //define start row
$i = 1; //define row count flag

while (($row1 = fgetcsv($file)) !== FALSE) {
    if($i > $start_row) {
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
	
}








function showItems(){	
	global $show,$db,$product_query,$cart_total,$id,$log;
	if($show!=""){
	echo'   
	
	<p align=center style="width:100%;background-color:#333;color:white;padding:10px;">'.$show.'</p>';
	}
	if($show=="YOUR CART"){
		if(!empty($cart_total)){
			echo'
			<div align=center>
				<p>TOTAL AMOUNT: $ '.number_format($cart_total).'</p><div>
				<a href="getAddress.php?payment_mode=online" style="background-color:black;padding:10px;margin:10px;color:white;text-decoration:none;">Payment Options</a>
				<a href="getAddress.php?payment_mode=COD" style="background-color:black;padding:10px;color:white;text-decoration:none;">Pay on delivery</a>
				<div><br>
			</div>
			';
		}
		else{
			echo'<div align=center>
				<p>Your 🛒cart is empty! <a href="home.php">Start shopping</a>!!</p>	
			</div>';
		}	
	}









	if (isset($_GET['pageno'])) {
	    $pageno = $_GET['pageno'];
	}
	else {
	    $pageno = 1;
	}
	// echo $pageno;
	$no_of_products_per_page=20;
	$offset=($pageno-1)*$no_of_products_per_page;

	$total_products_query="select count(*) from (".$product_query.") as query_result";
	$total_products_result=mysqli_query($db,$total_products_query);
	$total_rows=mysqli_fetch_array($total_products_result)[0];
	$total_pages=ceil($total_rows/$no_of_products_per_page);


	$product_query = $product_query." LIMIT $offset, $no_of_products_per_page";
	$product_query=mysqli_query($db,$product_query);


	include "pagination.php";






$gender_checked=array("men"=>"","women"=>"");
if(isset($_GET["gender"])){
		
		$mygender=$_GET["gender"];
		$gender_checked[$mygender]=" checked"	;	
	}



	$url_query1=$_GET;
	$url_query2=$_GET;
	$url_male_query="";
	$url_female_query="";
	// if(isset($_GET['gender'])){
	$url_query1['gender']="men";
	$url_query2['gender']="women";
	$url_male_query = http_build_query($url_query1);
	$url_female_query = http_build_query($url_query2);
	// }

	echo'
		<div class="leftcolumn" style="width:19%; float: left;padding: 20px;margin 10px;position:sticky;"><p></p>';
	
	if($show!="YOUR CART"){
	echo'<p><b>GENDER</b></p>
		<p>
		<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url_male_query."'".')'.$gender_checked["men"].'
		>Men
			
		</p>
		<p>
		<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url_female_query."'".')'.$gender_checked["women"].'>Women
			
		</p>
		
	';





$orderby_checked=array("asc"=>"","desc"=>"");
if(isset($_GET["orderby"])){
		
		$myorderby=$_GET["orderby"];
		$orderby_checked[$myorderby]=" checked"	;	
	}



	$url_query1=$_GET;
	$url_query2=$_GET;
	$url_asc_query="";
	$url_desc_query="";
	// if(isset($_GET['gender'])){
	$url_query1['orderby']="asc";
	$url_query2['orderby']="desc";
	$url_asc_query = http_build_query($url_query1);
	$url_desc_query = http_build_query($url_query2);

	echo'<p><b>SORT </b></p>
		<p>
			<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url_asc_query."'".')'.$orderby_checked["asc"].'


			>Price: low to high
			
		</p>
		<p>

		<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url_desc_query."'".')'.$orderby_checked["desc"].'>Price: high to low

			
		</p>
		
	';
	$color_checked=array("black"=>"","white"=>"","blue"=>"","red"=>"","yellow"=>"","green"=>"");
	if(isset($_GET["color"])){
		
		$mycolor=$_GET["color"];
		$color_checked[$mycolor]=" checked"	;	
	}






	$url_query1=$_GET;
	$url_query2=$_GET;
	$url_query3=$_GET;
	$url_query4=$_GET;
	$url_query5=$_GET;
	$url_query6=$_GET;
	$url1_query="";
	$url2_query="";
	$url3_query="";
	$url4_query="";
	$url5_query="";
	$url6_query="";
	// if(isset($_GET['gender'])){
	$url_query1['color']="black";
	$url_query2['color']="white";
	$url_query3['color']="blue";
	$url_query4['color']="red";
	$url_query5['color']="yellow";
	$url_query6['color']="green";
	$url1_query = http_build_query($url_query1);
	$url2_query = http_build_query($url_query2);
	$url3_query = http_build_query($url_query3);
	$url4_query = http_build_query($url_query4);
	$url5_query = http_build_query($url_query5);
	$url6_query = http_build_query($url_query6);
	
	echo'<p><b>COLOR</b></p>
		<p>

			<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url1_query."'".')'.$color_checked["black"].'>Black
			
		</p>
		<p>
			<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url2_query."'".')'.$color_checked["white"].'>White
		</p>
		<p>
			<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url3_query."'".')'.$color_checked["blue"].'>Blue
			
		</p>
		<p>
			<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url4_query."'".')'.$color_checked["red"].'>Red
		</p>
		<p>
			<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url5_query."'".')'.$color_checked["yellow"].'>Yellow
			
		</p>
		<p>
			<input type = "checkbox" onclick=window.location.assign('."'".$_SERVER["PHP_SELF"].'?'.$url6_query."'".')>Green
		</p>
		

	';


	}
	echo "</div>";
	echo' <div class="rightcolumn" style="width:62%;float:left;">
	';
	







	
	

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
		elseif($show=="YOUR CART" and $id!=1){
			  $cart_message="REMOVE FROM CART";
			  echo'<form method="GET" action="removefromcart.php"?>
			  <input type="hidden" name="prod_id" value='.$row['prod_id'].' >
			  <input type="submit" style="width:100%;background-color: #333;color:white;height:50px;" value="'.$cart_message.'" >
				</form>';
			  
		}
		elseif(@isset($_GET['order']) and $id==1){
			$orderer_id=@$row['id'];
			$get_orderer="select username,address from users where id= $orderer_id";
			$get_orderer=mysqli_query($db,$get_orderer);
			$get_orderer=mysqli_fetch_assoc($get_orderer);
			echo"Ordered by - ".$get_orderer['username']."<br>address : ".$get_orderer['address'];
			
		}
		elseif($id==1 and !@isset($_GET['order']) ){
			$cart_message="REMOVE FROM STORE";
			 echo'	  
			  <form method="GET" action="removeproduct.php?'.$prod_id.'">
			  <input type="hidden" name="prod_id" value='.$row['prod_id'].' >
			  <input type="submit" style="width:100%;background-color: #333;color:white;height:50px;" value="'.$cart_message.'" >
				
				</form>';
		}
		
		
			
		echo'    </div>';
		echo'';
	   
		
	 }  

	echo'</div></br>
</br>';



	
include "pagination.php";

}

echo"
<script>
function addToCart(prod_id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText==''){
      	window.location.href ='login2.php';
      }

      document.getElementById(prod_id).innerHTML =
      this.responseText;
    }
  };
  xhttp.open('GET', 'addtocart.php?prod_id='+prod_id, true);
  xhttp.send();
}

function removeFromCart(prod_id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText==''){
      	window.location.href ='login2.php';
      }

      document.getElementById(prod_id).innerHTML =
      this.responseText;
    }
  };
  xhttp.open('GET', 'removefromcart.php?prod_id='+prod_id, true);
  xhttp.send();
}




</script>
</body>
</html>";


?>
