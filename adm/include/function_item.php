<?php

function query_item_list($request=array()){
  // アイテム一覧検索
  $return = array() ;

  $dbh = db_connect(PG_CONNECT_STRING) ;

  $from_date_sale_start    = $request['from_date_sale_start'] ;
  $to_date_sale_start      = $request['to_date_sale_start'] ;
  $title                   = $request['title'] ;

  if(strlen($from_date_sale_start) === 0){$from_date_sale_start = '1970-01-01' ;}
  if(strlen($to_date_sale_start) === 0)  {$to_date_sale_start   = '2999-12-31' ;}
  if(strlen($title) === 0)               {$title = '%' ;}

  // 日付正規化
  $from_insert_date = date_format_basic($from_insert_date) ;
  $to_insert_date   = date_format_basic($to_insert_date) ;

  // 件数
  $sql = 'SELECT '.
         ' count(i.*) AS count '.
         'FROM m_item AS i '.
         'WHERE i.is_delete = FALSE '.
         '  AND (i.date_sale_start >= $1  AND i.date_sale_start <= $2) '.
         '  AND i.title LIKE $3 ';
  $params = array(
    $from_date_sale_start,
    $to_date_sale_start,
    "%$title%",
  );
  $result = @pg_query_params($dbh,$sql,$params) ;
  $row = pg_fetch_assoc($result) ;
  $return['hit_count'] = $row['count'] ;

  // 1ページ分検索
  $sql = 'SELECT '.
         ' i.item_id,'.
         ' i.title,'.
         ' i.author,'.
         ' i.price,'.
         ' i.date_sale_start,'.
         ' i.date_sale_end,'.
         ' to_char(i.date_sale_start,\'YYYY-MM-DD\') AS date_sale_start_str '.
         'FROM m_item AS i '.
         'WHERE i.is_delete = FALSE '.
         '  AND (i.date_sale_start >= $1  AND i.date_sale_start <= $2) '.
         '  AND i.title LIKE $3 '.
         'ORDER BY i.insert_date DESC ';
  $result = @pg_query_params($dbh,$sql,$params) ;
  if(pg_num_rows($result) === 0){
    return $return ;
  }

  while($row = pg_fetch_assoc($result)){
    $return['list'][] = $row ;
  }

  return $return ;
}

function insert_item($request=array()){
  // アイテム追加
  $return = array() ;

  $dbh = db_connect(PG_CONNECT_STRING) ;

  $title           = $request['title'] ;
  $description     = $request['description'] ;
  $author          = $request['author'] ;
  $price           = (int)$request['price'] ;
  $date_sale_start = $request['date_sale_start'] ;

  if(strlen($date_sale_start) === 0){$date_sale_start = date('Y-m-d') ;}

  pg_query($dbh,'BEGIN') ;

  $sql = 'INSERT INTO m_item ('.
         ' insert_date,'.
         ' item_id,'.
         ' title,'.
         ' description,'.
         ' author,'.
         ' price,'.
         ' is_delete,'.
         ' date_open,'.
         ' date_close,'.
         ' date_sale_start,'.
         ' date_sale_end '.
         ') VALUES ('.
         ' now(),'.
         ' create_unique_id(32),'.
         ' $1,'. // title
         ' $2,'. // description
         ' $3,'. // author
         ' $4,'. // price
         ' FALSE,'. // is_delete
         ' DEFAULT,'. // date_open
         ' DEFAULT,'. // date_close
         ' $5,'. // date_sale_start
         ' DEFAULT '. // date_sale_end
         ')' ;
  $params = array(
    $title,
    $description,
    $author,
    $price,
    $date_sale_start,
  );


  $result = @pg_query_params($dbh,$sql,$params) ;
  if($result == FALSE){
    pg_query($dbh,'ROLLBACK') ;
    return FALSE ;
  }

  pg_query($dbh,'COMMIT') ;

  return TRUE ;
}

function delete_item($request=array()){
  // アイテム削除
  $return = array() ;

  $dbh = db_connect(PG_CONNECT_STRING) ;

  $item_id         = $request['item_id'] ;

  pg_query($dbh,'BEGIN') ;

  $sql = 'UPDATE m_item SET '.
         ' is_delete = TRUE '.
         'WHERE item_id = $1 ' ;
  $params = array(
    $item_id,
  );


  $result = @pg_query_params($dbh,$sql,$params) ;
  if($result == FALSE){
    pg_query($dbh,'ROLLBACK') ;
    return FALSE ;
  }

  pg_query($dbh,'COMMIT') ;

  return TRUE ;
}

function update_item($request=array()){
  // アイテム更新
  $return = array() ;

  $dbh = db_connect(PG_CONNECT_STRING) ;

  $item_id         = $request['item_id'] ;
  $title           = $request['title'] ;
  $description     = $request['description'] ;
  $author          = $request['author'] ;
  $price           = (int)$request['price'] ;
  $date_sale_start = $request['date_sale_start'] ;

  if(strlen($date_sale_start) === 0){$date_sale_start = date('Y-m-d') ;}

  pg_query($dbh,'BEGIN') ;

  $sql = 'UPDATE m_item SET '.
         ' title = $1,'.
         ' description = $2,'.
         ' author = $3,'.
         ' price = $4,'.
         ' date_sale_start = $5 '.
         'WHERE item_id = $6 ' ;
  $params = array(
    $title,
    $description,
    $author,
    $price,
    $date_sale_start,
    $item_id,
  );


  $result = @pg_query_params($dbh,$sql,$params) ;
  if($result == FALSE){
    pg_query($dbh,'ROLLBACK') ;
    return FALSE ;
  }

  pg_query($dbh,'COMMIT') ;

  return TRUE ;
}

function query_item($request=array()){
  // アイテム検索
  $return = array() ;

  $dbh = db_connect(PG_CONNECT_STRING) ;

  $item_id         = $request['item_id'] ;

  $sql = 'SELECT '.
         ' i.insert_date,'.
         ' i.item_id,'.
         ' i.title,'.
         ' i.description,'.
         ' i.author,'.
         ' i.price,'.
         ' i.is_delete,'.
         ' i.date_open,'.
         ' i.date_close,'.
         ' i.date_sale_start,'.
         ' to_char(i.date_sale_start,\'YYYY-MM-DD\') AS date_sale_start_str,'.
         ' i.date_sale_end '.
         'FROM m_item AS i '.
         'WHERE item_id = $1 ' ;
  $params = array(
    $item_id,
  );

  $result = @pg_query_params($dbh,$sql,$params) ;
  if($result == FALSE){
    return FALSE ;
  }

  $row = pg_fetch_assoc($result) ;
  $return = $row ;

  return $return ;
}
?>
