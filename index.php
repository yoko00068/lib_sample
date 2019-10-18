<?php
require_once('include/init.php') ;
$result = init_site() ;

require_once('include/function_item.php') ;

if(strlen($_REQUEST['search']) >= 1){
  // 検索
  $result = search_item_list($_REQUEST) ;
}

$smarty = init_smarty() ;
$smarty->assign('request',@array_merge($_REQUEST,(array)$result)) ;
$smarty->display(basename(__FILE__,'.php'). '.tpl') ;

exit ;
?>
