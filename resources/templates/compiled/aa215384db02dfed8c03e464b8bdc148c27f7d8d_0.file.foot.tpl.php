<?php
/* Smarty version 4.3.1, created on 2023-04-08 11:11:25
  from '/www/clinic-praxia/resources/templates/foot.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6431922d24d874_75128892',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aa215384db02dfed8c03e464b8bdc148c27f7d8d' => 
    array (
      0 => '/www/clinic-praxia/resources/templates/foot.tpl',
      1 => 1680970203,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6431922d24d874_75128892 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['showBottom']->value) {?>
<nav class="navbar bg-light mt-3">
    <div class="container-fluid">
        <small class="badge bg-light"><?php echo $_smarty_tpl->tpl_vars['APP_COPY']->value;?>
</small>
        <small class="badge bg-light">TEMA: <?php echo $_smarty_tpl->tpl_vars['bsTheme']->value;?>
</small>
    </div>
</nav>
<?php }?>
</body>
</html><?php }
}
