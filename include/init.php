<?php

// PHP config
mb_internal_encoding('UTF-8') ;
date_default_timezone_set('Asia/Tokyo');
error_reporting(E_ALL & ~E_NOTICE);

// 一般サイト用基本設定
define('SITE_NAME'              ,'サンプルサイト') ;
define('SMARTY_TEMPLATE'        ,dirname(__FILE__) . '/smarty/template') ;
define('SMARTY_TEMPLATE_C'      ,dirname(__FILE__) . '/smarty/template_c') ;
define('SMARTY_CONFIG'          ,dirname(__FILE__) . '/smarty/config') ;
define('SMARTY_CACHE'           ,dirname(__FILE__) . '/smarty/cache') ;
define('SMARTY_CLASS_LIB'       ,dirname(__FILE__) . '/lib/smarty/Smarty.class.php') ;

// サーバ環境固有設定
include(dirname(__FILE__) ."/site_config/site_config.php") ;

// 致命的なエラー時にエラー画面を表示する設定
set_error_handler("site_error",E_ALL & ~E_NOTICE) ;

// 全ページ共通設定
function init_site($simple=FALSE){
  $return = array() ;
  require_once(dirname(__FILE__) ."/init_basic_function.php") ;

  return $return ;
}

function site_error($errno,$errstr,$errfile,$errline,$errcontext){
  if(!(error_reporting() & $errno)){
    // error_reporting 設定に含まれていないエラーコードです
    return;
  }

  @ob_clean() ;
  @readfile(dirname(dirname(__FILE__)) . '/error.html') ;

  $log_file = sprintf("/tmp/php_error.%s",date('Ymd')) ;
  $fh = fopen($log_file,'a') ;
  if(filesize($log_file) != TRUE){
    chmod($log_file,0777) ;
  }

  @fwrite($fh,"errno : $errno\n") ;
  @fwrite($fh,"errstr : $errstr\n") ;
  @fwrite($fh,"errfile : $errfile\n") ;
  @fwrite($fh,"errline : $errline\n") ;
  @fwrite($fh,print_r($errcontext,TRUE)) ;
  @fclose($fh) ;
  exit ;
}

function db_connect($connect_string=''){
  // DB接続(冗長化考慮)
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
?>
