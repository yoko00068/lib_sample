<?php
define('DB_ADDR'             ,'localhost') ;
define('DB_PORT'             ,'5432') ;
define('DB_NAME'             ,'lib_sample') ;
define('DB_USER'             ,'lib_sample') ;
define('DB_PASS'             ,'lib_sample') ;
define('PG_CONNECT_STRING'   ,sprintf("host=%s port=%s dbname=%s user=%s password=%s",DB_ADDR,DB_PORT,DB_NAME,DB_USER,DB_PASS)) ;
?>
