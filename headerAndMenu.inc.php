
<?php


echo'
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="homepage.css" type="text/css">
<link rel="icon" href="myfavicon.png">

<style type="text/css">
  
body{
    margin:0;
    padding:0;
    border:0;
    outline:0;
    font-size:100%;
    vertical-align:baseline;
    background:transparent;
}
@media screen and (max-width: 700px) {
.topnav{
  display:none;
}
.hamburger{
  width:10%;
}

}
</style>

</head>


<img class="hamburger" src="hamburger.png" id="hamburger" style="width:30px;float:left;" onclick="hamburger()">


<div style="width:15%;overflow:hidden;float:left;padding:5px">


<a href="myhome.php"><img src="shopit.png" style="width:100%;"></a>

</div>

<div width=100% style="width:100%;background-color:black;padding:5px;">
';

echo'<div style="width:80%;overflow:hidden;padding:0px;margin:0px">';

include'search.php';

$popular_brand_query="SELECT prod_brand
from allproducts
GROUP by prod_brand
order by count(*)DESC
limit 15";

$brand_res=mysqli_query($db,$popular_brand_query);




echo'
</div>





<div class="topnav" id="topnav">

  <a href="myhome.php" >HOME</a>

  <div class="dropdown">
    <button class="dropbtn">CATEGORIES 
    </button>
    <div class="dropdown-content">
      <a href="home.php?prod_category=shirt">Shirts</a>
      <a href="home.php?prod_category=jeans">Jeans</a>
      <a href="home.php?prod_category=pants">Pants</a>
      <a href="home.php?prod_category=watch">Watches</a>
      <a href="home.php?prod_category=hat">Hats</a>
      <a href="home.php?prod_category=bag">Bags</a>
	<a href="home.php?prod_category=glasses">Glasses</a>
	<a href="home.php?prod_category=bracelet">Bracelets</a>

	

    </div>
  </div>

  <div class="dropdown">
    <button class="dropbtn">TOP BRANDS
    </button>
    <div class="dropdown-content">
    '  ;
  $brand_count=0;

  while(@$row=mysqli_fetch_assoc($brand_res)) {
  		
  		$brand=$row['prod_brand'];
  		if ($brand_count>1){
  		echo'<a href="home.php?prod_brand='.$brand.'">'.$brand.'</a>';
  		}
  		$brand_count+=1;
  }

    echo'  

    </div>
  </div>

  <a href="aboutus.php">ABOUT US</a>
  
';   

	if($log=="loggedin"){
		echo '<div class="dropdown" style="float:right;">
		<button class="dropbtn" >'.strtoupper($userquery).'
		</button>
		<div class="dropdown-content">';
		if($id!=1) {
		  echo'<a href="home.php?cart=1">🛒CART</a>';
		}
		else{
			echo'<a href="productupload.php">UPLOAD PRODUCT</a>';
		}	
		  echo'<a href="http://localhost/shopitv1/myorders.php">ORDERS</a>
		  <a href="#">Account</a>
		  <a href="logout.php">Sign out</a>
		</div>
		</div>';
	}
	else{
		echo '<a href="login2.php" style="float:right; ">Sign in</a>';
	}
	 

	
 
echo'
	
  
  
</div>
</div>
<script>

function hamburger(){
  if(document.getElementById('."'topnav'".').style.display=='."'block')".'{
    document.getElementById('."'topnav'".').style.display='."'none'".'


  }
  else{
    document.getElementById('."'topnav'".').style.display='."'block'".'
  }

}

</script>




';

?>