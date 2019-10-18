<?php
/* Smarty version 3.1.33, created on 2019-10-18 12:56:31
  from '/var/www/default/htdocs/lib_sample/adm/include/smarty/template/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5da937efbfec72_89210273',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7c2f6174c4fbd10e7c6fdc670bd921168f23920b' => 
    array (
      0 => '/var/www/default/htdocs/lib_sample/adm/include/smarty/template/index.tpl',
      1 => 1571370986,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./_doctype.tpl' => 1,
    'file:./_html_head.tpl' => 1,
    'file:./_header.tpl' => 1,
    'file:./_footer.tpl' => 1,
  ),
),false)) {
function content_5da937efbfec72_89210273 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:./_doctype.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<html>
<?php $_smarty_tpl->_subTemplateRender("file:./_html_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body class="home-page">
<?php $_smarty_tpl->_subTemplateRender("file:./_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div id="content">
<form action="./index.php" method="post">
タイトル:<input type="text" name="title" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['item']['title'];?>
"><br>
説明:<textarea name="description"><?php echo $_smarty_tpl->tpl_vars['request']->value['item']['description'];?>
</textarea><br>
著者:<input type="text" name="author" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['item']['author'];?>
"><br>
価格:<input type="text" name="price" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['item']['price'];?>
"><br>
発売日:<input type="date" name="date_sale_start" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['item']['date_sale_start_str'];?>
"><br>
<?php if (strlen($_smarty_tpl->tpl_vars['request']->value['item_id']) >= 1) {?>
<input type="submit" name="update" value="更新">
<input type="hidden" name="item_id" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['item']['item_id'];?>
">
<?php } else { ?>
<input type="submit" name="insert" value="追加">
<?php }?>
</form>

<?php echo $_smarty_tpl->tpl_vars['request']->value['hit_count'];?>
 hits<br />

<table style="width:100%;">
<tr>
<td style="background-color:#EEE;width:80px;">発売日</td>
<td style="background-color:#EEE;">タイトル</td>
<td style="background-color:#EEE;width:100px;">著者</td>
<td style="background-color:#EEE;width:100px;">価格</td>
<td style="background-color:#EEE;width:100px;">削除</td>
</tr>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['request']->value['list'], 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
<tr>
<td><?php echo $_smarty_tpl->tpl_vars['item']->value['date_sale_start_str'];?>
</td>
<td><a href="./index.php?item_id=<?php echo $_smarty_tpl->tpl_vars['item']->value['item_id'];?>
"><?php echo stripslashes($_smarty_tpl->tpl_vars['item']->value['title']);?>
</a></td>
<td><?php echo $_smarty_tpl->tpl_vars['item']->value['author'];?>
</td>
<td>\<?php echo number_format($_smarty_tpl->tpl_vars['item']->value['price']);?>
</td>
<td><a href="./index.php?delete=t&item_id=<?php echo $_smarty_tpl->tpl_vars['item']->value['item_id'];?>
" onclick="return confirm('削除してよろしいですか?');">[削除]</a></td>
</tr>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>


</div> 
<?php $_smarty_tpl->_subTemplateRender("file:./_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</body>

</html>
<?php }
}
