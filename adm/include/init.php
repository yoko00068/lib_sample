<?php

// PHP config
mb_internal_encoding('UTF-8') ;
date_default_timezone_set('Asia/Tokyo');
error_reporting(E_ALL & ~E_NOTICE);

// 一般サイト用基本設定
define('SITE_NAME'              ,'サンプルサイトadmin') ;
define('SMARTY_TEMPLATE'        ,dirname(__FILE__) . '/smarty/template') ;
define('SMARTY_TEMPLATE_C'      ,dirname(__FILE__) . '/smarty/template_c') ;
define('SMARTY_CONFIG'          ,dirname(__FILE__) . '/smarty/config') ;
define('SMARTY_CACHE'           ,dirname(__FILE__) . '/smarty/cache') ;
define('SMARTY_CLASS_LIB'       ,dirname(__FILE__) . '/../../include/lib/smarty/Smarty.class.php') ;

// サーバ環境固有設定
include(dirname(__FILE__) ."/../../include/site_config/site_config.php") ;

// 全ページ共通設定
function init_site($simple=FALSE){
  $return = array() ;
  require_once(dirname(__FILE__) ."/../../include/init_basic_function.php") ;

  return $return ;
}

function db_connect($connect_string=''){
  // DB接続(必ずマスターに接続)
  global $db ;

  if(pg_connection_status($db) === PGSQL_CONNECTION_OK){
    return $db ;
  }else{
    $db = pg_connect($connect_string) ;
  }

  return $db ;
}

function init_smarty(){
  // smarty オブジェクト生成
  require_once(SMARTY_CLASS_LIB) ;

  $smarty = new Smarty ;
  $smarty->template_dir   = SMARTY_TEMPLATE ;
  $smarty->compile_id     = SMARTY_TEMPLATE ;
  $smarty->compile_dir    = SMARTY_TEMPLATE_C ;
  $smarty->config_dir     = SMARTY_CONFIG ;
  $smarty->cache_dir      = SMARTY_CACHE ;
  $smarty->caching        = 0 ;

  $smarty->assign('title'                    ,SITE_NAME) ;

  return $smarty ;
}

function create_unique_id($n=8){
  // ユニークID生成
  $dbh = db_connect(PG_CONNECT_STRING) ;

  $sql =  "SELECT create_unique_id($n)" ;
  $result = pg_query($dbh,$sql) ;
  $row = pg_fetch_assoc($result) ;

  return $row['create_unique_id'] ;
}

function create_unique_number($n=16){
  // ユニーク数字生成
  $dbh = db_connect(PG_CONNECT_STRING) ;

  $sql =  "SELECT create_unique_number(8)" ;
  $result = pg_query($dbh,$sql) ;
  $row = pg_fetch_assoc($result) ;

  return $row['create_unique_number'] ;
}

?>
