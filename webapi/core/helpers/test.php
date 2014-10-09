<?php
include('HTMLDecrypt.php');
$html = new HTMLDecrypt("http://videoegitim.com");
$html->compile('spider');
print_r($html->toArray());
?>
