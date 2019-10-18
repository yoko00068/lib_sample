{include file="./_doctype.tpl"}
<html>
{include file="./_html_head.tpl"}

<body class="home-page">
{include file="./_header.tpl"}

<div id="content">
<form action="./index.php" method="post">
タイトル:<input type="text" name="title" value="{$request.item.title}"><br>
説明:<textarea name="description">{$request.item.description}</textarea><br>
著者:<input type="text" name="author" value="{$request.item.author}"><br>
価格:<input type="text" name="price" value="{$request.item.price}"><br>
発売日:<input type="date" name="date_sale_start" value="{$request.item.date_sale_start_str}"><br>
{if strlen($request.item_id) >= 1}
<input type="submit" name="update" value="更新">
<input type="hidden" name="item_id" value="{$request.item.item_id}">
{else}
<input type="submit" name="insert" value="追加">
{/if}
</form>

{* 商品一覧 *}
{$request.hit_count} hits<br />

<table style="width:100%;">
<tr>
<td style="background-color:#EEE;width:80px;">発売日</td>
<td style="background-color:#EEE;">タイトル</td>
<td style="background-color:#EEE;width:100px;">著者</td>
<td style="background-color:#EEE;width:100px;">価格</td>
<td style="background-color:#EEE;width:100px;">削除</td>
</tr>
{foreach from=$request.list item=item}
<tr>
<td>{$item.date_sale_start_str}</td>
<td><a href="./index.php?item_id={$item.item_id}">{$item.title|stripslashes}</a></td>
<td>{$item.author}</td>
<td>\{$item.price|number_format}</td>
<td><a href="./index.php?delete=t&item_id={$item.item_id}" onclick="return confirm('削除してよろしいですか?');">[削除]</a></td>
</tr>
{/foreach}
</table>


</div> {* /content *}

{include file="./_footer.tpl"}
</body>

</html>
