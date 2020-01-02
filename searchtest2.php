<?php
require 'connect.inc.php';
include 'vendor/autoload.php';
use Skyeng\Lemmatizer;
use Skyeng\Lemma;
require_once __DIR__ . "/vendor/autoload.php";

$lemmatizer = new Lemmatizer();



$stop_words = "a,about,above,after,again,against,all,am,an,and,any,are,aren't,as,at,be,because,been,before,being,below,between,both,but,by,can't,cannot,could,couldn't,did,didn't,do,does,doesn't,doing,don't,down,during,each,few,for,from,further,had,hadn't,has,hasn't,have,haven't,having,he,he'd,he'll,he's,her,here,here's,hers,herself,him,himself,his,how,how's,i,i'd,i'll,i'm,i've,if,in,into,is,isn't,it,it's,its,itself,let's,me,more,most,mustn't,my,myself,no,nor,not,of,off,on,once,only,or,other,ought,our,ours,	ourselves,out,over,own,same,shan't,she,she'd,she'll,she's,should,shouldn't,so,some,such,than,that,that's,the,their,theirs,them,themselves,then,there,there's,these,they,they'd,they'll,they're,they've,this,those,through,to,too,under,until,up,very,was,wasn't,we,we'd,we'll,we're,we've,were,weren't,what,what's,when,when's,where,where's,which,while,who,who's,whom,why,why's,with,won't,would,wouldn't,you,you'd,you'll,you're,you've,your,yours,yourself,yourselves";
$stop_words_array = explode(",", $stop_words);


$comparator="";


$price="";






$comparators=array("less" =>"and prod_price  <= ","under"=>"and prod_price <= ","below"=>"and prod_price  <= ","<"=>"and  prod_price <= ","within"=>"and prod_price <= ","low"=>"and prod_price <= ","above"=>"and prod_price >= ","more"=>"and prod_price >= ","high"=>"and prod_price >= ","great"=>"and prod_price >= ",">"=>"and prod_price >= ","by"=>"and prod_price >= ","by"=>"and prod_price >= ","for"=>"and prod_price ==","in"=>"and prod_price ==","at"=>"and prod_price ==","@"=>"and prod_price == ");


if(isset($_GET['search'])){


	$search_text = $_GET['search'];
	

	$search_array=explode(" ", $search_text); 
// foreach ($search_array as $searchval) {
// 	# code...
// 	echo "idhar dekh".$searchval."  ";
// }

// if (array_key_exists("under", $comparators)){
// 	echo"barabar hai</br>";
// }


for($i =0; $i<sizeof($search_array)-1;$i++){
	// echo $search_array[$i]." ";

		echo $lemmatizer->getOnlyLemmas($search_array[$i])[0];
		if(array_key_exists($lemmatizer->getOnlyLemmas($search_array[$i])[0],$comparators)){

			echo"HIHIHIHIHIHI</br>";

			
// $lemmatizer->getOnlyLemmas('between')[0]


			if(is_numeric($search_array[$i+1])){

				$comparator=$comparators[$lemmatizer->getOnlyLemmas($search_array[$i])[0]];


			unset($search_array[$i]);

				$price=intval($lemmatizer->getOnlyLemmas($search_array[$i+1])[0]);


				unset($search_array[$i+1]);

			}



		}

	}


foreach($search_array as $search_word){


	if (!in_array($search_word, $stop_words_array)) {

			echo "HAHAHAHAH";
			$search_words[] = $lemmatizer->getOnlyLemmas($search_word)[0];
			// echo"idhar bhi";
	}

}

$sentence=implode(', ',$search_words);

echo $sentence."</br>";

$lemmas = $lemmatizer->getOnlyLemmas('between'); 
// $new_sentence=\Nadar\Stemming\Stem::stemPhrase($sentence, 'en');

// echo $new_sentence."</br>";

echo $lemmatizer->getOnlyLemmas('20')[0];

 $product_query="


 SELECT * FROM allproducts
     WHERE MATCH (prod_name,prod_brand,prod_category,prod_description) 
     AGAINST ('$sentence' IN NATURAL LANGUAGE MODE) "
     .$comparator.$price ;
  // $product_query=select * from allproducts;
echo $product_query;
// echo "comprator = ".$comparator;
// echo"</br>";
// echo"price = ".$price;

$result = mysqli_query($db,$product_query);



// $new_result=mysqli_query($db,$product_query);
		
// $result_arr  = mysqli_fetch_array($new_result);



while(@$row=mysqli_fetch_array($result)){
	echo $row["prod_name"]." ".$row["prod_price"];
	echo '</br></br>';
}













	// preg_match_all('!\d+!', $search_array, $numbers);


	










}










?>

<h2>Search :
<form method="get" action="searchtest2.php" >
	<input required="true" name="search" style="width: 400px; font-size: 16px"  />
	<input type="submit" value="

search" style="width:18%;padding:5px;padding-top: 10px;padding-bottom: 10px; background:#333;color:white" >
</form></h2>
