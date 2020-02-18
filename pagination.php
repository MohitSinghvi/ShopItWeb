
<style>
    /*.rightcolumn{
      width:50%;
    }*/
    .center {
  text-align: center;
  clear: left;
}

.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
  margin: 0 4px;
}

.pagination a.active {
  background-color: black;
  color: white;
  border: 1px solid grey;
}

.pagination a:hover:not(.active) {background-color: #ddd;}

  </style>

<?php
$url_query=$_GET;
if(isset($_SESSION['url'])) 
    $url = $_SESSION['url'];
if(isset($_GET['pageno'])){

  
  if($url_query['pageno']>1){
    $url_query['pageno']=$pageno-1;
    $url_query_result = http_build_query($url_query);
  }
  else{
    $url_query['pageno']=1;
    $url_query_result = http_build_query($url_query);
    $pageno=1;
  }
}
else{
  $url_query['pageno']=1;
    $url_query_result = http_build_query($url_query);
    $pageno=1;
}

echo'
<div class="center">
  <div class="pagination">';


  echo'<a href="'.$_SERVER['PHP_SELF'].'?'.$url_query_result.'">&laquo;</a>';
  // <a href="#">&laquo;</a>';
  // <a href="#">1</a>
  // <a href="#" class="active">2</a>
  // <a href="#">3</a>
  // <a href="#">4</a>
  // <a href="#">5</a>
  // <a href="#">6</a>

  

  
  


  for($i=1;$i<=$total_pages;$i++){
  	$url_query['pageno']=$i;
  	$url_query_result = http_build_query($url_query);

  	if($i==$pageno){
  		echo"<a href='#' class='active' >$i</a>";
  	}
  	else if(abs($i-$pageno)<2){
  	echo'<a href="'.$_SERVER['PHP_SELF'].'?'.$url_query_result.'">'.($i).'</a>';
  	}
  	else if($i==$total_pages){
  	echo"<a href='#' >..</a>";
  	// echo"<a href='#' >.</a>";
  	echo'<a href="'.$_SERVER['PHP_SELF'].'?'.$url_query_result.'">'.($i).'</a>';
  	}
  	else if($i==1){
  	
  	echo'<a href="'.$_SERVER['PHP_SELF'].'?'.$url_query_result.'">'.($i).'</a>';
  	echo"<a href='#' >..</a>";
  	// echo"<a href='#' >.</a>";
  	}

  }
  if(isset($_SESSION['url'])) 
    $url = $_SESSION['url'];
$url_query=$_GET;



if(isset($_GET['pageno'])){

  
  if($url_query['pageno']>1){
    $url_query['pageno']=$pageno+1;
    $url_query_result = http_build_query($url_query);
  }
}
else{
  $url_query['pageno']=2;
    $url_query_result = http_build_query($url_query);
    $pageno=1;
}

echo'<a href="'.$_SERVER['PHP_SELF'].'?'.$url_query_result.'">&raquo;</a>';
  echo'
 
  </div>
	</div>
	</br>

	';
?>