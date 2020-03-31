<?php
include('config/config.inc.php');
$context = Context::getContext();
if(!isset($_REQUEST['controller']))
  header('location:index.php?controller=AdminLogin&token='.Tools::getToken('AdminLogin'));
$controllers = Tools::getValue('controller').'Controller';
$adminControl = new $controllers();
$context->smarty->assign(array(
      'nameController' => $adminControl->name,
      'theme' => $adminControl->theme,
      'title' => $adminControl->title,
      'tools' => new tools(),
      'alert' => $adminControl->alert,
      'email' => 'juan@criadero.com',
));
$content  = $context->smarty->fetch('templates/'.$adminControl->theme.'/header.tpl');
if($adminControl->name != 'AdminLogin'):
  $content .= $context->smarty->fetch('templates/'.$adminControl->theme.'/navbar.tpl');
endif;

$content .= $adminControl->renderForm();
$content .= $context->smarty->fetch('templates/'.$adminControl->theme.'/footer.tpl');
echo $content;
?>
