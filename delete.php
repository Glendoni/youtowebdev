<?php 


$data = 'I was called by Auto Pilot on;' .date('Y-m-d H:i:s')  ;

file_put_contents('hook.txt', $data. PHP_EOL  , FILE_APPEND);