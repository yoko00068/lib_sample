<?php

function search_item_list($request=array()){
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
?>
