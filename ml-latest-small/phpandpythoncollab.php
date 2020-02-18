<?php
	$output='Toy Story (1995)';
    $command = escapeshellcmd('recommenderScript.py '.$output);

    // $result=exec("C:\xampp\htdocs\Shopitv1\ml-latest-small\recommenderScript.py /tmp");
    // echo $output;

    $output=shell_exec($command);
    
    echo $output ;

?>