<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

require_once(dirname(__FILE__).'/defines.inc.php');
$start_time = microtime(true);

/* SSL configuration */
define('_PS_SSL_PORT_', 443);

/* Improve PHP configuration to prevent issues */
ini_set('default_charset', 'utf-8');
ini_set('magic_quotes_runtime', 0);
ini_set('magic_quotes_sybase', 0);

/* correct Apache charset (except if it's too late */
if (!headers_sent())
	header('Content-Type: text/html; charset=utf-8');

/* No settings file? goto installer... */
if (!file_exists(_PS_ROOT_DIR_.'/config/settings.inc.php'))
{
	if (file_exists(dirname(__FILE__).'/../install'))
		header('Location: install/');
	elseif (file_exists(dirname(__FILE__).'/../install-dev'))
		header('Location: install-dev/');
	else
		die('Error: "install" directory is missing');
	exit;
}

/* include settings file only if we are not in multi-tenancy mode */
require_once(_PS_ROOT_DIR_.'/config/settings.inc.php');
require_once(_PS_CONFIG_DIR_.'autoload.php');

if (_PS_DEBUG_PROFILING_)
{
	include_once(_PS_TOOL_DIR_.'profiling/Controller.php');
	include_once(_PS_TOOL_DIR_.'profiling/ObjectModel.php');
	include_once(_PS_TOOL_DIR_.'profiling/Hook.php');
	include_once(_PS_TOOL_DIR_.'profiling/Db.php');
	include_once(_PS_TOOL_DIR_.'profiling/Tools.php');
}

if (Tools::convertBytes(ini_get('upload_max_filesize')) < Tools::convertBytes('100M'))
	ini_set('upload_max_filesize', '100M');

if (Tools::isPHPCLI() && isset($argc) && isset($argv))
	Tools::argvToGET($argc, $argv);

/* Redefine REQUEST_URI if empty (on some webservers...) */
if (!isset($_SERVER['REQUEST_URI']) || empty($_SERVER['REQUEST_URI']))
{
	if (!isset($_SERVER['SCRIPT_NAME']) && isset($_SERVER['SCRIPT_FILENAME']))
		$_SERVER['SCRIPT_NAME'] = $_SERVER['SCRIPT_FILENAME'];
	if (isset($_SERVER['SCRIPT_NAME']))
	{
		if (basename($_SERVER['SCRIPT_NAME']) == 'index.php' && empty($_SERVER['QUERY_STRING']))
			$_SERVER['REQUEST_URI'] = dirname($_SERVER['SCRIPT_NAME']).'/';
		else
		{
			$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
			if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
				$_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
		}
	}
}

/* Trying to redefine HTTP_HOST if empty (on some webservers...) */
if (!isset($_SERVER['HTTP_HOST']) || empty($_SERVER['HTTP_HOST']))
	$_SERVER['HTTP_HOST'] = @getenv('HTTP_HOST');

$context = Context::getContext();

/* Get smarty */
require_once(dirname(__FILE__).'/smarty.config.inc.php');
$context->smarty = $smarty;
