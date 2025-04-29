<?php
    $testGD = get_extension_funcs("gd"); // Grab function list 
    if (!$testGD){
        echo "GD not even installed.";
        phpinfo();  // Display the php configuration for the web server
        exit;
    }
    echo"<pre>".print_r($testGD,true)."</pre>";  //display GD function list