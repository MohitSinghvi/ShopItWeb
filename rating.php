<!-- <style>
.star_yellow,.star_empty{
	height:15px;witdh:15px;
}
	
</style>

<script>
var rval=1;
function rate(id){
	var curr_src=document.getElementById(id).getAttribute("src");
	// document.getElementById("demo").innerHTML=curr_src;
	// if(curr_src==="star_yellow.png"){
	// 	document.getElementById(id).src="star_empty.png";
	// }
	// else if(curr_src==="star_empty.png"){
	// 	document.getElementById(id).src="star_yellow.png";
	// }
	if(id=="star5"){
		rval=5;
		document.getElementById("star1").src="star_yellow.png";
		document.getElementById("star2").src="star_yellow.png";
		document.getElementById("star3").src="star_yellow.png";
		document.getElementById("star4").src="star_yellow.png";
		document.getElementById("star5").src="star_yellow.png";
	}
	if(id=="star4"){
		rval=4;
		document.getElementById("star1").src="star_yellow.png";
		document.getElementById("star2").src="star_yellow.png";
		document.getElementById("star3").src="star_yellow.png";
		document.getElementById("star4").src="star_yellow.png";
		document.getElementById("star5").src="star_empty.png";
	}
	if(id=="star3"){
		rval=3
		document.getElementById("star1").src="star_yellow.png";
		document.getElementById("star2").src="star_yellow.png";
		document.getElementById("star3").src="star_yellow.png";
		document.getElementById("star4").src="star_empty.png";
		document.getElementById("star5").src="star_empty.png";
	}
	if(id=="star2"){
		rval=2;
		document.getElementById("star1").src="star_yellow.png";
		document.getElementById("star2").src="star_yellow.png";
		document.getElementById("star3").src="star_empty.png";
		document.getElementById("star4").src="star_empty.png";
		document.getElementById("star5").src="star_empty.png";
	}
	if(id=="star1"){
		rval=1;
		document.getElementById("star1").src="star_yellow.png";
		document.getElementById("star2").src="star_empty.png";
		document.getElementById("star3").src="star_empty.png";
		document.getElementById("star4").src="star_empty.png";
		document.getElementById("star5").src="star_empty.png";
	}

	
}
function show(){
	document.getElementById("demo").innerHTML=rval;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
	  		document.getElementById("demo1").innerHTML =
	  		this.responseText;
		}
  	};
 	xhttp.open("POST", "rating.php?prod_id="+5+"&rating="+rval, true);
 	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	xhttp.send("prod_id=5&rating="+rval);
}

</script> -->
<?php
include "core.inc.php";
include "connect.inc.php";
// echo"HI";
// echo $_SESSION['userid'];
if(isset($_POST["prod_id"]) && isset($_POST["rating"]) && isset($_SESSION['userid'])){
	// echo"HI";

	$user_id=$_SESSION['userid'];
	$prod_id=$_POST["prod_id"];
	$rating=$_POST["rating"];
	// echo $prod_id;
	// echo "RATING: ".$rating;
	$is_rated_query="select * from ratings where prod_id=$prod_id and user_id=$user_id";
	// echo"idhar";
	if($is_rated_result=mysqli_query($db,$is_rated_query)){
		// echo" udhar ";
		$no_of_rows=mysqli_num_rows($is_rated_result);
		if($no_of_rows==0){
			// echo"chupchap";
			$insert_rating_query="insert into ratings (user_id,prod_id,rating)values($user_id,$prod_id,$rating)";
			mysqli_query($db,$insert_rating_query);
		}
		else{
			// echo" udhar bhi";
			$update_rating_query="update ratings set rating = $rating where user_id=$user_id and prod_id=$prod_id;";
			mysqli_query($db,$update_rating_query);
		}
	}


}
?>
