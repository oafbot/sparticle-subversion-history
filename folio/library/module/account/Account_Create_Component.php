<?php
    if(!isset(self::init()->autofill))
        include('empty.php');
    else    
        include('autofill.php');
?>
