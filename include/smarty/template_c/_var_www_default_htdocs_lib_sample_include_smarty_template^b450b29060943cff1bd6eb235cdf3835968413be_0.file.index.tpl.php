<?php
/* Smarty version 3.1.33, created on 2019-10-18 13:10:43
  from '/var/www/default/htdocs/lib_sample/include/smarty/template/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5da93b439d6543_40713836',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b450b29060943cff1bd6eb235cdf3835968413be' => 
    array (
      0 => '/var/www/default/htdocs/lib_sample/include/smarty/template/index.tpl',
      1 => 1571371841,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./_doctype.tpl' => 1,
    'file:./_html_head.tpl' => 1,
    'file:./_header.tpl' => 1,
    'file:./_nav.tpl' => 1,
    'file:./_footer.tpl' => 1,
  ),
),false)) {
function content_5da93b439d6543_40713836 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:./_doctype.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<html>
<?php $_smarty_tpl->_subTemplateRender("file:./_html_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body class="home-page">
<?php $_smarty_tpl->_subTemplateRender("file:./_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:./_nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

検索<br>
<form action="./index.php" method="get">
タイトル:<input type="text" name="title" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['title'];?>
"><br>
発売日:
<input type="date" name="from_date_sale_start" value="<?php echo $_smarty_tpl->tpl_vars['request']->value['from_date_sale_start'];?>
"> ～
<input type="date" name="to_date_sale_start"   value="<?php echo $_smarty_tpl->tpl_vars['request']->value['to_date_sale_start'];?>
"><br>
<input type="submit" name="search" value="検索"><br>
</form>

<?php echo $_smarty_tpl->tpl_vars['request']->value['hit_count'];?>
 hits<br />

<table style="width:100%;">
<tr>
<td style="background-color:#EEE;width:80px;">発売日</td>
<td style="background-color:#EEE;">タイトル</td>
<td style="background-color:#EEE;width:100px;">著者</td>
<td style="background-color:#EEE;width:100px;">価格</td>
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
</tr>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>

<?php $_smarty_tpl->_subTemplateRender("file:./_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</body>

</html>
<?php }
}
