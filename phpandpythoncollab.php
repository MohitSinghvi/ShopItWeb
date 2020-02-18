<?php
	$output=1;
    $command = escapeshellcmd('ml-latest-small\recommenderScript.py');

    // $result=exec("C:\xampp\htdocs\Shopitv1\ml-latest-small\recommenderScript.py /tmp");
    // echo $output;

    $output=shell_exec($command);
    
    echo $output ;

?>