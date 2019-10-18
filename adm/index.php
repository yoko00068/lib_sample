<?php
require_once('include/init.php') ;
$result = init_site() ;

require_once('include/function_item.php') ;

if(strlen($_REQUEST['insert']) >= 1){
  // アイテム追加
  $result = insert_item($_REQUEST) ;
  header("Location: ./") ;
  exit ;
}

if(strlen($_REQUEST['delete']) >= 1){
  // アイテム削除
  $result = delete_item($_REQUEST) ;
  header("Location: ./") ;
  exit ;
}

if(strlen($_REQUEST['update']) >= 1){
  // アイテム更新
  $result = update_item($_REQUEST) ;
  header("Location: ./") ;
  exit ;
}

$result = query_item_list($_REQUEST) ;

if(strlen($_REQUEST['item_id']) >= 1){
  // アイテム更新用パラメータセット
  $result['item'] = query_item($_REQUEST) ;
}

$smarty = init_smarty() ;
$smarty->assign('request',@array_merge($_REQUEST,(array)$result)) ;
$smarty->display(basename(__FILE__,'.php'). '.tpl') ;
exit ;
?>
