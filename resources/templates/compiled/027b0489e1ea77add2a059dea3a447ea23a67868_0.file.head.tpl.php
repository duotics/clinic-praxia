<?php
/* Smarty version 4.3.1, created on 2023-04-08 11:25:45
  from '/www/clinic-praxia/resources/templates/head.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_643195896d1497_29264143',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '027b0489e1ea77add2a059dea3a447ea23a67868' => 
    array (
      0 => '/www/clinic-praxia/resources/templates/head.tpl',
      1 => 1680971143,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_643195896d1497_29264143 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
    <meta name="author" content="<?php echo $_smarty_tpl->tpl_vars['author']->value;?>
">
    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
">
    <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['favicon']->value;?>
" type="image/x-icon">
    <?php if ((isset($_smarty_tpl->tpl_vars['bodyBg']->value))) {?>
        <style>
            .body-login {
                background-image: url("<?php echo $_smarty_tpl->tpl_vars['bodyBg']->value;?>
");
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
        </style>
    <?php }
echo $_smarty_tpl->tpl_vars['styles']->value;?>

</head>
<body class="<?php echo $_smarty_tpl->tpl_vars['bodyClass']->value;?>
">
    <?php echo $_smarty_tpl->tpl_vars['scripts']->value;?>

<?php }
}
