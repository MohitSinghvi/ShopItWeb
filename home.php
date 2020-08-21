<?php
require 'connect.inc.php';
include 'core.inc.php';
?>

<html>
<head>
<title>Home</title>
<link rel="icon" href="myfavicon.png">
<style type="text/css">
	
/*body{
    margin:0;
    padding:0;
    border:0;
    outline:0;
    font-size:100%;
    vertical-align:baseline;
    background:transparent;
}*/

</style>
</head>
</html>
<?php



use Skyeng\Lemmatizer;
use Skyeng\Lemma;
require_once __DIR__ . "/vendor/autoload.php";
// require_once __DIR__ . "/PHP-Stanford-NLP-master/autoload.php";
$lemmatizer = new Lemmatizer();


$pos = new \StanfordTagger\POSTagger();
 
// echo $pos->tag('white cup within men');


// $pos = new \StanfordNLP\POSTagger(
//   '/path/to/stanford-postagger-2017-06-09/models/english-left3words-distsim.tagger',
//   '/path/to/stanford-postagger-2017-06-09/stanford-postagger-3.8.0.jar'
// );

// $result = $pos->tag(explode(' ', "What does the fox say?"));
// var_dump($result);


if(isset($_GET['orderby'])){
			$orderby_query=" order by prod_price ".$_GET['orderby'];
}
else{
	$orderby_query="";
}
if(isset($_GET['color'])){
	$color="'%".$_GET['color']."%'";
	$color_query=" and prod_name like $color";
}
else{
	$color_query="";
}

$_SESSION['url'] = $_SERVER['REQUEST_URI'];
$id=@$_SESSION['userid'];

if(isset($_GET['prod_id'])){
	$showing="one";
	$prod_id=$_GET['prod_id'];
	$product_query="select *from allproducts where prod_id='$prod_id'";
	$show="CATEGORY : ".strtoupper("Specifications");
}
else{
	$showing="many";
	if(isset($_GET['prod_category'])){
		$gender="";
		if(isset($_GET['gender'])){
			$gender="\'".$_GET["gender"]."\'"."%";
		}
		$prod_category=$_GET['prod_category'];



		$product_query="select * from allproducts where prod_category like '%$prod_category%$gender'".$color_query.$orderby_query;

		// echo $product_query;
		$show="CATEGORY : ".strtoupper($prod_category);
	}
	elseif(isset($_GET['prod_brand'])){
		$prod_brand=$_GET['prod_brand'];
		$product_query="select * from allproducts where prod_brand='$prod_brand' ";
		$gender="";
		if(isset($_GET['gender'])){
			$gender=" and prod_category like '%\'".$_GET["gender"]."\'%'";
		}

		$product_query=$product_query.$gender.$color_query.$orderby_query;
		// echo $product_query;

		$show="BRAND : ".strtoupper($prod_brand);
	}
	elseif(isset($_GET['cart']) and isset($_SESSION['userid'])){
	//	$prod_brand=$_GET['prod_brand'];
		$product_query="select * from allproducts where prod_id in (select prod_id from usercart where id = '$id')";
		// $product_query="select * from allproducts p,order o  where p.prod_id=o.prod_id and o.id='$id' limit 25";


		$cart_total=mysqli_query($db,"select sum(prod_price) from allproducts where prod_id in (select prod_id from usercart where id='$id')");
		$cart_total=mysqli_fetch_assoc($cart_total);
		$cart_total=$cart_total['sum(prod_price)'];
		$show="YOUR CART";
	}
	elseif(isset($_GET['order'])){
		if($id!=1){

			$product_query="select * from allproducts  where prod_id in (select prod_id from orders where id=$id)";
			


			$bill_total=mysqli_query($db,"select sum(prod_price) from allproducts where prod_id in (select prod_id from orders where id='$id')");
			$bill_total=mysqli_fetch_assoc($bill_total);
			$bill_amount=$bill_total['sum(prod_price)'];
		}
		else{
			$product_query="select p.prod_id,prod_name,prod_price,prod_image,prod_description,prod_brand,prod_category,id from allproducts as p ,orders as o  where p.prod_id =o.prod_id ";
			$bill_total=mysqli_query($db,"select sum(prod_price) from allproducts where prod_id in (select prod_id from orders) ");
			$bill_total=mysqli_fetch_assoc($bill_total);
			$bill_amount=$bill_total['sum(prod_price)'];
			
			
		}
		if($bill_amount){
			$show="ORDERS : TOTAL AMOUNT : ".$bill_amount;
		}
		else{
			if($id!=1){
				$show="You have not ordered anything yet.";
			}
			else{
				$show="You don't have any orders.";
			}
		}


	}



	elseif(isset($_GET['search']) and !empty($_GET['search'])){
		// $search_item=$_GET['search'];
		// //echo $search_item;
		// $search_category="select prod_id from allproducts where prod_category='$search_item' limit 25";
		// $search_category=mysqli_query($db,$search_category);
		// $search_brand="select prod_id from allproducts where prod_brand='$search_item' limit 25";
		// $search_brand=mysqli_query($db,$search_brand);
		// $search_product="select prod_id from allproducts where prod_name='$search_item' limit 25";
		// $search_product=mysqli_query($db,$search_product);
		
		// if(mysqli_num_rows($search_category)!=0){
		// 	$product_query="select *from allproducts where prod_category='$search_item' limit 25";
		// }
		// elseif(mysqli_num_rows($search_brand)!=0){
		// 	$product_query="select *from allproducts where prod_brand='$search_item limit 25'";
		// }
		// elseif(mysqli_num_rows($search_product)!=0){
		// 	$product_query="select *from allproducts where prod_name='$search_item' limit 25";
		// }
		// else{
		// 	$product_query="select * from allproducts limit 25";
		// }
		




		$stop_words = "a,about,above,after,again,against,all,am,an,and,any,are,aren't,as,at,be,because,been,before,being,below,between,both,but,by,can't,cannot,could,couldn't,did,didn't,do,does,doesn't,doing,don't,down,during,each,few,for,from,further,had,hadn't,has,hasn't,have,haven't,having,he,he'd,he'll,he's,her,here,here's,hers,herself,him,himself,his,how,how's,i,i'd,i'll,i'm,i've,if,in,into,is,isn't,it,it's,its,itself,let's,me,more,most,mustn't,my,myself,no,nor,not,of,off,on,once,only,or,other,ought,our,ours,	ourselves,out,over,own,same,shan't,she,she'd,she'll,she's,should,shouldn't,so,some,such,than,that,that's,the,their,theirs,them,themselves,then,there,there's,these,they,they'd,they'll,they're,they've,this,those,through,to,too,under,until,up,very,was,wasn't,we,we'd,we'll,we're,we've,were,weren't,what,what's,when,when's,where,where's,which,while,who,who's,whom,why,why's,with,won't,would,wouldn't,you,you'd,you'll,you're,you've,your,yours,yourself,yourselves";
		
		$stop_words_array = explode(",", $stop_words);


		$comparator="";


		$price="";









		$comparators=array("less" =>"and prod_price  <= ","under"=>"and prod_price <= ","below"=>"and prod_price  <= ","<"=>"and  prod_price <= ","within"=>"and prod_price <= ","low"=>"and prod_price <= ","above"=>"and prod_price >= ","more"=>"and prod_price >= ","high"=>"and prod_price >= ","great"=>"and prod_price >= ",">"=>"and prod_price >= ","by"=>"and prod_price <= ","for"=>"and prod_price =","in"=>"and prod_price <=","at"=>"and prod_price <=","@"=>"and prod_price = ","over"=>"and prod_price >= ","cheap"=>"and prod_price  <=");

		$gender=array("men"=>"and prod_category like '%\'men\'%'","man"=>"and prod_category like '%\'men\'%'","boy"=>"and prod_category like '%\'men\'%'" ,"male"=>"and prod_category like '%\'men\'%'","boys"=>"and prod_category like '%\'men\'%'" ,"women"=>"and prod_category like '%\'women\'%'" ,"woman"=>"and prod_category like '%women%'" ,"girl"=>"and prod_category like '%women%'" ,"girls"=>"and prod_category like '%women%'","female"=>"and prod_category like '%women%'","unisex"=>"and prod_category like '%unisex%'"  );

		$colors=array("blue"=>"and prod_name like '% blue%'","black"=>"and prod_name like '% black%'","brown"=>"and prod_name like '% brown%'","red"=>"and prod_name like '% red%'","white"=>"and prod_name like '% white%'","green"=>"and prod_name like '% green%'","yellow"=>"and prod_name like '% yellow%'","pink"=>"and prod_name like '% pink%'","purple"=>"and prod_name like '% purple%'","violet"=>"and prod_name like '% violet%'","orange"=>"and prod_name like '% orange%'","golden"=>"and prod_name like '% gold%'","gold"=>"and prod_name like '% gold%'","silver"=>"and prod_name like '% silver%'");








		$search_text = $_GET['search'];
	

	$search_array=explode(" ", $search_text); 
// foreach ($search_array as $searchval) {
// 	# code...
// 	echo "idhar dekh".$searchval."  ";
// }

// if (array_key_exists("under", $comparators)){
// 	echo"barabar hai</br>";
// }

$gender_query="";

$color_query="";
$size_of_search_query=sizeof($search_array);
if(isset($_GET["gender"])){
	if(@array_key_exists($_GET["gender"],$gender)){
		$gender_query=$gender[$_GET["gender"]];
	}
}
if(isset($_GET["color"])){
	if(@array_key_exists($_GET["color"],$colors)){
		$color_query=$colors[$_GET["color"]];
	}
}
for($i =0; $i<$size_of_search_query;$i++){
	// echo $search_array[$i]." </br>";
	// echo sizeof($search_array);


		if(@array_key_exists($lemmatizer->getOnlyLemmas($search_array[$i])[0],$comparators)){

			// echo"kem Palty</br>";

			



			if(@is_numeric($search_array[$i+1])){

				// echo"hellolololoooooooo";

				$comparator=$comparators[$lemmatizer->getOnlyLemmas($search_array[$i])[0]];


			unset($search_array[$i]);
				
				$price=intval($search_array[$i+1]);


				unset($search_array[$i+1]);
				// $i-=1;

			}
			else if(@is_numeric($search_array[$i+2])){

				$comparator=$comparators[$lemmatizer->getOnlyLemmas($search_array[$i])[0]];


			unset($search_array[$i]);
				
				$price=intval($search_array[$i+2]);


				unset($search_array[$i+2]);
				// $i-=1;



			}





		}
		elseif(@array_key_exists(($search_array[$i]),$gender)){

			$gender_query=$gender[$search_array[$i]];
			unset($search_array[$i]);
			// echo"HIHIHIHIHIHI</br>";
			// echo"HIHIHIHIHIHI</br>";
			// echo"HIHIHIHIHIHI</br>";
			// echo"HIHIHIHIHIHI</br>";
			// $i-=1;

		}
		elseif(@array_key_exists(($search_array[$i]),$colors)){

			$color_query=$colors[$search_array[$i]];
			unset($search_array[$i]);

			// echo"HIHIHIHIHIHI</br>";
			// echo"HIHIHIHIHIHI</br>";
			// echo"HIHIHIHIHIHI</br>";
			// echo"HIHIHIHIHIHI</br>";
			// $i-=1;

		}
		elseif(@$search_array[$i]=="tshirt"){
			$search_array[$i]="t-shirt";
		}

		


}


foreach($search_array as $search_word){


	if (!in_array($search_word, $stop_words_array)) {

			$search_words[]=$search_word;
			// $search_words[] =$lemmatizer->getOnlyLemmas($search_word)[0];
			// echo"idhar bhi";
	}

}

$sentence=@implode(', ',$search_words);

// foreach($search_words as $word){
// 	echo "</br>".$word;
// 	echo "</br>".$comparator;
// 	echo "</br>".$price;
// 	echo"</br>";
// }

 $product_query="


 SELECT * FROM allproducts


     WHERE MATCH (prod_name,prod_brand,prod_description) 
     AGAINST ('$sentence' IN NATURAL LANGUAGE MODE) "
     .$comparator.$price." ".$gender_query." ".$color_query.$orderby_query;

// echo $product_query;     




	}
	else{
		$product_query="select * from allproducts limit 25
		";
		$show="";
	}
// echo $product_query;  	
}
include 'logincheck.inc.php';
include'hometest.php';
?>

<script>

</script>

