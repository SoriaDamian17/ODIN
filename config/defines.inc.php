<?php
/**
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

/* Debug only */
if (!defined('_PS_MODE_DEV_'))
define('_PS_MODE_DEV_', true);
/* Compatibility warning */
define('_PS_DISPLAY_COMPATIBILITY_WARNING_', false);
if (_PS_MODE_DEV_ === true)
{
	@ini_set('display_errors', 'on');
	@error_reporting(E_ALL | E_STRICT);
	define('_PS_DEBUG_SQL_', true);
}
else
{
	@ini_set('display_errors', 'off');
	define('_PS_DEBUG_SQL_', false);
}

define('_PS_DEBUG_PROFILING_', false);
define('_PS_MODE_DEMO_', false);

$currentDir = dirname(__FILE__);

if (!defined('PHP_VERSION_ID'))
{
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

if (!defined('_PS_VERSION_') && (getenv('_PS_VERSION_') || getenv('REDIRECT__PS_VERSION_')))
	define('_PS_VERSION_', getenv('_PS_VERSION_') ? getenv('_PS_VERSION_') : getenv('REDIRECT__PS_VERSION_'));

if (!defined('_PS_HOST_MODE_') && (getenv('_PS_HOST_MODE_') || getenv('REDIRECT__PS_HOST_MODE_')))
	define('_PS_HOST_MODE_', getenv('_PS_HOST_MODE_') ? getenv('_PS_HOST_MODE_') : getenv('REDIRECT__PS_HOST_MODE_'));

if (!defined('_PS_ROOT_DIR_') && (getenv('_PS_ROOT_DIR_') || getenv('REDIRECT__PS_ROOT_DIR_')))
	define('_PS_ROOT_DIR_', getenv('_PS_ROOT_DIR_') ? getenv('_PS_ROOT_DIR_') : getenv('REDIRECT__PS_ROOT_DIR_'));

/* Directories */
if (!defined('_PS_ROOT_DIR_'))
	define('_PS_ROOT_DIR_', realpath($currentDir.'/..'));

if (!defined('_PS_CORE_DIR_'))
	define('_PS_CORE_DIR_', realpath($currentDir.'/..'));

define('_PS_ALL_THEMES_DIR_',        _PS_ROOT_DIR_.'/themes/');
define('_PS_CACHE_DIR_',			 _PS_ROOT_DIR_.'/cache/');
define('_PS_CONFIG_DIR_',			 _PS_CORE_DIR_.'/config/');
define('_PS_CLASS_DIR_',             _PS_CORE_DIR_.'/classes/');
define('_PS_CONTROLLER_DIR_',        _PS_CORE_DIR_.'/controllers/');
define('_PS_ADMIN_CONTROLLER_DIR_',  _PS_CORE_DIR_.'/controllers/');
define('_PS_TOOL_DIR_',              _PS_CORE_DIR_.'/tools/');
define('_PS_IMG_DIR_',               _PS_ROOT_DIR_.'/img/');

if (!defined('_PS_HOST_MODE_'))
	define('_PS_CORE_IMG_DIR_',      _PS_CORE_DIR_.'/img/');
else
	define('_PS_CORE_IMG_DIR_',      _PS_ROOT_DIR_.'/img/');

/* SQL Replication management */
define('_PS_USE_SQL_SLAVE_', 0);

define('_PS_SMARTY_NO_COMPILE_', 0);
define('_PS_SMARTY_CHECK_COMPILE_', 0);
define('_PS_SMARTY_FORCE_COMPILE_', 0);

define('_PS_SMARTY_CONSOLE_CLOSE_', 0);
define('_PS_SMARTY_CONSOLE_OPEN_BY_URL_', 1);
define('_PS_SMARTY_CONSOLE_OPEN_', 2);

define('_PS_JQUERY_VERSION_', '1.11.0');
