<?php

function unlink_dir_tree($dir=''){
  // ディレクトリとその中身を削除する
  if(is_dir($dir) === FALSE){
    if(is_file($dir) === TRUE or is_link($dir)){
      unlink($dir) ;
      return ;
    }
  }

  $files = array_diff(scandir($dir), array('.','..')) ;
  foreach($files as $file){
    unlink_dir_tree("$dir/$file") ;
  }
  rmdir($dir);
}

function finddir_tree($dir='',$file_only=FALSE){
  // ディレクトリツリーを配列返す
  // $file_only に TRUE を指定すると通常ファイルのみの配列を返す
  $return = array() ;

  $files = array_diff(scandir($dir), array('.','..')) ;
  foreach($files as $file){
    if(is_dir("$dir/$file") === TRUE){
      if($file_only === TRUE){
        $return[] = "$dir/$file" ;
      }
      $return = array_merge($return,finddir_tree("$dir/$file")) ;
    }elseif(is_file("$dir/$file") === TRUE){
      $return[] = "$dir/$file" ;
    }
  }

  return $return ;
}

function get_browser_type(){
  // 端末判定
  $return = array() ;

  $user_agent = $_SERVER['HTTP_USER_AGENT'] ;
  if(preg_match('/Android /i',$user_agent) >= 1){
    $return = 'sp' ;
  }elseif(preg_match('/iPhone /i',$user_agent) >= 1){
    $return = 'sp' ;
  }else{
    $return = 'pc' ;
  }

  return $return ;
}

function file_exists_url($url=''){
  // URLにHEADリクエストを投げて存在を確認

  $stream_opts = array('http' => array('method' => 'HEAD'));
  $context     = stream_context_create($stream_opts) ;
  $result      = @fopen($url,'r',false,$context) ;
  if($result === FALSE){
    return FALSE ;
  }
  return TRUE ;
}

function check_mail_addr($email){
  // メールアドレスが正しいかチェックする
  $mail_regex =
    '(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\' .
    '\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][' .
    '^\\\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x' .
    '80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-' .
    '\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*"))*@(?:[^(' .
    '\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\0' .
    '00-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*' .
    '\])(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,' .
    ';:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[' .
    '^\x80-\xff])*\]))' ;
  if(preg_match("/^$mail_regex/",$email)){
    return TRUE ;
  }else{
    return FALSE ;
  }
}

function check_cc_digit($card_no = ''){
  // クレジット番号が正しいかチェックする
  $card_no         = preg_replace('/\D/','',$card_no) ;
  $num_body        = substr($card_no,0,strlen($card_no) -1) ;
  $num_check_digit = substr($card_no,-1) ;
  $num_body_len    = strlen($num_body) ;
  unset($sum) ;
  unset($check_sum) ;
  if(strlen($card_no) < 13 or strlen($card_no) > 19){
    return FALSE ;
  }
  for($i = 0;$i <= $num_body_len -1;$i++){
    $p = $num_body{($num_body_len - $i -1)} ;
    if($i % 2 == 0){
      if($p * 2 >= 10){
        $sum += intval((($p * 2) / 10)) + (($p * 2) % 10) ;
      }else{
        $sum += $p *2 ;
      }
    }else{
      $sum += $p ;
    }
  }
  $check_sum = 10 - ($sum % 10) ;
  if($check_sum == 10){
    $check_sum = 0 ;
  }
  if($check_sum == $num_check_digit){
    return TRUE ;
  }else{
    return FALSE ;
  }
}

function get_date_this_month_1st(){
  // 今月の1日(YYYY-MM-DD形式)
  return date('Y-m-01') ;
}

function get_date_this_month_end(){
  // 今月の末日(YYYY-MM-DD形式)
  return date('Y-m-t') ;
}

function get_date_last_month_1st(){
  // 先月の1日(YYYY-MM-DD形式)
  return date('Y-m-01',mktime(0,0,0,date('m')-1,1,date('Y'))) ;
}

function get_date_last_month_end(){
  // 先月の末日(YYYY-MM-DD形式)
  return date('Y-m-t',mktime(0,0,0,date('m')-1,1,date('Y'))) ;
}

function get_date_next_month_1st(){
  // 翌月の1日(YYYY-MM-DD形式)
  return date('Y-m-01',mktime(0,0,0,date('m')+1,1,date('Y'))) ;
}

function get_date_next_month_end(){
  // 翌月の末日(YYYY-MM-DD形式)
  return date('Y-m-t',mktime(0,0,0,date('m')+1,1,date('Y'))) ;
}

function get_date_afternext_month_1st(){
  // 翌々月の1日(YYYY-MM-DD形式)
  return date('Y-m-01',mktime(0,0,0,date('m')+2,1,date('Y'))) ;
}

function get_date_afternext_month_end(){
  // 翌々月の末日(YYYY-MM-DD形式)
  return date('Y-m-t',mktime(0,0,0,date('m')+2,1,date('Y'))) ;
}

function get_time_this_month_1st(){
  // 今月の1日(time値)
  return strtotime(get_date_this_month_1st()) ;
}

function get_time_this_month_end(){
  // 今月の末日(time値)
  return strtotime(get_date_this_month_end()) ;
}

function get_time_last_month_1st(){
  // 先月の1日(time値)
  return strtotime(get_date_last_month_1st()) ;
}

function get_time_last_month_end(){
  // 先月の末日(time値)
  return strtotime(get_date_last_month_end()) ;
}

function get_time_next_month_1st(){
  // 翌月の1日(time値)
  return strtotime(get_date_next_month_1st()) ;
}

function get_time_next_month_end(){
  // 翌月の末日(time値)
  return strtotime(get_date_next_month_end()) ;
}

function get_time_afternext_month_1st(){
  // 翌々月の1日(time値)
  return strtotime(get_date_afternext_month_1st()) ;
}

function get_time_afternext_month_end(){
  // 翌々月の末日(time値)
  return strtotime(get_date_afternext_month_end()) ;
}

function date_format_basic($date=''){
  // 正しい "YYYY-MM-DD" または "YYY-MM-DD hh:mm:ss" にする
  $return = '' ;
  preg_match('/(\d+)[\/\-](\d+)[\/\-](\d+)\s*(\d*):*(\d*):*(\d*)/',$date,$matches) ;
  $yyyy = (int)$matches[1] ;
  $mm   = (int)$matches[2] ;
  $dd   = (int)$matches[3] ;
  $hh   = (int)$matches[4] ;
  $ii   = (int)$matches[5] ;
  $ss   = (int)$matches[6] ;

  if(strlen($matches[4]) >= 1){
    $return = date('Y-m-d H:i:s',mktime($hh,$ii,$ss,$mm,$dd,$yyyy)) ;
  }else{
    $return = date('Y-m-d',mktime($hh,$ii,$ss,$mm,$dd,$yyyy)) ;
  }
  return $return ;
}

function page_list($page_max=0){
  // GETリクエストのURLからページングリスト作成
  // ベージパラメータは "p"
  // 最初のページはp=0 ページ番号は1
  // 
  // 返却パラメータ
  // $return['page_max'] int   最大ページ数
  // $return['now_page'] int   現在のページ番号
  // $return['list']     array queryの配列(添字がページ番号)
  $return = array() ;

  $query_string = $_SERVER['QUERY_STRING'] ;

  // page_max の指定がないということは1ページしか無い
  if((int)$page_max <= 1){$page_max = 1 ;}

  // リクエストから「p=」パラメータを省いたqueryを作る
  $result = preg_match('/(?:^|\&)p=(\d+)(?:\&|$)/',$query_string,$matches) ;
  if($result >= 1){
    $p = $matches[1] ;
    $query_array = array() ;
    foreach(explode('&',$query_string) as $query){
      list($key,$value) = explode('=',$query) ;
      if($key != 'p'){
        $query_array[] = $query ;
      }
    }
    $query_string_without_page = implode('&',$query_array) ;
  }else{
    $p = 0 ;
    $query_string_without_page = $query_string ;
  }
  $return['query_string_without_page'] = $query_string_without_page ;

  // 最大ページ数と現在のページ
  $return['page_max'] = $page_max ;
  $return['now_page'] = $p +1 ;

  // ページ一覧作成
  $i = 1 ;
  foreach(range(0,$page_max -1) as $page){
    $return['list'][$i] = sprintf("p=%d&%s",$page,$query_string_without_page) ;
    $i++ ;
  }

  // 戻る
  if($p >= 1){
    $return['prev'] = sprintf("p=%d&%s",$p -1,$query_string_without_page) ;
  }

  // 進む
  if($p < $page_max -1){
    $return['next'] = sprintf("p=%d&%s",$p +1,$query_string_without_page) ;
  }

  // 最初
  $return['first'] = $query_string_without_page ;

  // 最後
  $return['last'] = sprintf("p=%d&%s",$page_max -1,$query_string_without_page) ;

  return $return ;
}

?>
