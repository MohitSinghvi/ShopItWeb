<!-- <?php
// include 'core.inc.php';
// require 'connect.inc.php';
// include 'logincheck.inc.php';
// include 'headerAndMenu.inc.php';

?>
<head>
  <title>HOME</title>
<style>
.homecard{
  height:250px;
  width:250px;
}
.displayimg{
  width:200px;
  height:150px;
}
a{
  text-decoration: none;
  color:black;
}
body{
  font-family: "Times New Roman", Times, serif;
}
</style>
</head>
<div class="fullPage">
  

  <div class="leftcolumn" style="width:20%;float:left;">
    <p>
     </p>
  </div>
  <div class="rightcolumn" align="center" style="width:60%; margin: 5px;padding:5px;">
    
    <p align="center">
      <h1 align="center">TOP BRANDS</h1>
    </p>
  </div>


  <div style="width:100%">
    <a href="home.php?prod_brand=rothco">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    
    <img class="displayimg" src="rothcobrand.png" >
    <p align="center">ROTHCO</p>


    </div>
    </a>



    <a href="home.php?prod_brand=casio">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    
    <img class="displayimg" src="casiobrand.png" >
    <p align="center">CASIO</p>

    </div>
    </a>


    <a href="home.php?prod_brand=elope">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    
    <img class="displayimg" src="elopebrand.png" >
    <p align="center">ELOPE</p>

    </div>
    </a>

    <a href="home.php?prod_category=nike">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    
    <img class="displayimg" src="nikebrand.png" >
    <p align="center">NIKE</p>

    </div>
    </a>

    <a href="home.php?prod_brand=adidas">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    
    <img class="displayimg" src="adidasbrand.png" >
    <p align="center">ADIDAS</p>
    </div>
    </a>

  </div>




  <div></div>
  <div class="leftcolumn" style="width:20%;float:left;">
    <p>
     </p>
  </div>
  <div class="rightcolumn" style="width:60%; margin: 5px;padding:5px;">

    <div>
    <p align="center">
      <h1 align="center">TOP CATEGORIES</h1>
    </p>
    </div>
    <a href="home.php?prod_category=shirt">
    <div class="homecard" style="background-color: white;float:left;padding:10px;margin:10px;
    ">
    <p align="center">SHIRTS</p>
    <img class="displayimg" src="displayshirt.jfif" >

    </div>
    </a>

    <a href="home.php?prod_category=jeans">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    <p align="center">JEANS</p>
    <img class="displayimg" src="displayjeans.jfif" >

    </div>
    </a>


    <a href="home.php?prod_category=watch">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    <p align="center">WATCHES</p>
    <img class="displayimg" src="displaywatches.jfif" >

    </div>
    </a>


    <a href="home.php?prod_category=bag">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    <p align="center">BAGS</p>
    <img class="displayimg" src="displaybags.jfif" >

    </div>
    </a>


    <a href="home.php?prod_category=glasses">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    <p align="center">GLASSES</p>
    <img class="displayimg" src="displayglasses.jpg" >

    </div>
    </a>

    <a href="home.php?prod_category=bracelets">
    <div class="homecard" style="background-color: white;float:left;padding:20px;margin:10px;
    ">
    <p align="center">BRACELETS</p>
    <img class="displayimg" src="displaybracelets.jpg" >

    </div>
    </a>


  </div>
  


  </div>
    

</div> -->

<?php
$pspell_link = pspell_new("en");

if (!pspell_check($pspell_link, "testt")) {
    $suggestions = pspell_suggest($pspell_link, "testt");

    foreach ($suggestions as $suggestion) {
        echo "Possible spelling: $suggestion<br />";
    }
}
?>