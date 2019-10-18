{include file="./_doctype.tpl"}
<html>
{include file="./_html_head.tpl"}

<body class="home-page">
{include file="./_header.tpl"}
{include file="./_nav.tpl"}

検索<br>
<form action="./index.php" method="get">
タイトル:<input type="text" name="title" value="{$request.title}"><br>
発売日:
<input type="date" name="from_date_sale_start" value="{$request.from_date_sale_start}"> ～
<input type="date" name="to_date_sale_start"   value="{$request.to_date_sale_start}"><br>
<input type="submit" name="search" value="検索"><br>
</form>

{* 商品一覧 *}
{$request.hit_count} hits<br />

<table style="width:100%;">
<tr>
<td style="background-color:#EEE;width:80px;">発売日</td>
<td style="background-color:#EEE;">タイトル</td>
<td style="background-color:#EEE;width:100px;">著者</td>
<td style="background-color:#EEE;width:100px;">価格</td>
</tr>
{foreach from=$request.list item=item}
<tr>
<td>{$item.date_sale_start_str}</td>
<td><a href="./index.php?item_id={$item.item_id}">{$item.title|stripslashes}</a></td>
<td>{$item.author}</td>
<td>\{$item.price|number_format}</td>
</tr>
{/foreach}
</table>

{include file="./_footer.tpl"}
</body>

</html>
