<?php
class ContextCore
{
	/**
	 * @var Context
	 */
	protected static $instance;

	/**
	 * @var Cart
	 */
	public $cart;

	/**
	 * @var Customer
	 */
	public $customer;

	/**
	 * @var Cookie
	 */
	public $cookie;

	/**
	 * @var Link
	 */
	public $link;

	/**
	 * @var Country
	 */
	public $country;

	/**
	 * @var Employee
	 */
	public $employee;

	/**
	 * @var Controller
	 */
	public $controller;

	/**
	 * @var string
	 */
	public $override_controller_name_for_translations;

	/**
	 * @var Language
	 */
	public $language;

	/**
	 * @var Currency
	 */
	public $currency;

	/**
	 * @var AdminTab
	 */
	public $tab;

	/**
	 * @var Shop
	 */
	public $shop;

	/**
	 * @var Theme
	 */
	public $theme;

	/**
	 * @var Smarty
	 */
	public $smarty;

	/**
	 * @ var Mobile Detect
	 */
	public $mobile_detect;

	public $mode;

	/**
	 * @var boolean|string mobile device of the customer
	 */
	protected $mobile_device = null;

	protected $is_mobile = null;

	protected $is_tablet = null;

	const DEVICE_COMPUTER = 1;

	const DEVICE_TABLET = 2;

	const DEVICE_MOBILE = 4;

	const MODE_STD = 1;

	const MODE_STD_CONTRIB = 2;

	const MODE_HOST_CONTRIB = 4;

	const MODE_HOST = 8;

	public function getMobileDetect()
	{
		if ($this->mobile_detect === null)
		{
			require_once(_PS_TOOL_DIR_.'mobile_Detect/Mobile_Detect.php');
			$this->mobile_detect = new Mobile_Detect();
		}
		return $this->mobile_detect;
	}

	public function isMobile()
	{
		if ($this->is_mobile === null)
		{
			$mobile_detect = $this->getMobileDetect();
			$this->is_mobile = $mobile_detect->isMobile();
		}
		return $this->is_mobile;
	}

	public function isTablet()
	{
		if ($this->is_tablet === null)
		{
			$mobile_detect = $this->getMobileDetect();
			$this->is_tablet = $mobile_detect->isTablet();
		}
		return $this->is_tablet;
	}

	public function getMobileDevice()
	{
		if ($this->mobile_device === null)
		{
			$this->mobile_device = false;
			if ($this->checkMobileContext())
			{
				if (isset(Context::getContext()->cookie->no_mobile) && Context::getContext()->cookie->no_mobile == false && (int)Configuration::get('PS_ALLOW_MOBILE_DEVICE') != 0)
					$this->mobile_device = true;
				else
				{
					$mobile_detect = $this->getMobileDetect();
					switch ((int)Configuration::get('PS_ALLOW_MOBILE_DEVICE'))
					{
						case 1: // Only for mobile device
							if ($this->isMobile() && !$this->isTablet())
								$this->mobile_device = true;
							break;
						case 2: // Only for touchpads
							if ($this->isTablet() && !$this->isMobile())
								$this->mobile_device = true;
							break;
						case 3: // For touchpad or mobile devices
							if ($this->isMobile() || $this->isTablet())
								$this->mobile_device = true;
							break;
					}
				}
			}
		}
		return $this->mobile_device;
	}

	public function getDevice()
	{
		static $device = null;

		if ($device === null)
		{
			$mobile_detect = $this->getMobileDetect();
			if ($this->isTablet())
				$device = Context::DEVICE_TABLET;
			elseif ($this->isMobile())
				$device = Context::DEVICE_MOBILE;
			else
				$device = Context::DEVICE_COMPUTER;
		}
		return $device;
	}

	protected function checkMobileContext()
	{
		// Check mobile context
		if (Tools::isSubmit('no_mobile_theme'))
		{
			Context::getContext()->cookie->no_mobile = true;
			if (Context::getContext()->cookie->id_guest)
			{
				$guest = new Guest(Context::getContext()->cookie->id_guest);
				$guest->mobile_theme = false;
				$guest->update();
			}
		}
		elseif (Tools::isSubmit('mobile_theme_ok'))
		{
			Context::getContext()->cookie->no_mobile = false;
			if (Context::getContext()->cookie->id_guest)
			{
				$guest = new Guest(Context::getContext()->cookie->id_guest);
				$guest->mobile_theme = true;
				$guest->update();
			}
		}

		return isset($_SERVER['HTTP_USER_AGENT'])
			&& isset(Context::getContext()->cookie)
			&& (bool)Configuration::get('PS_ALLOW_MOBILE_DEVICE')
			&& @filemtime(_PS_THEME_MOBILE_DIR_)
			&& !Context::getContext()->cookie->no_mobile;
	}

	/**
	 * Get a singleton context
	 *
	 * @return Context
	 */
	public static function getContext()
	{
		if (!isset(self::$instance))
			self::$instance = new Context();
		return self::$instance;
	}

	/**
	 * Clone current context
	 *
	 * @return Context
	 */
	public function cloneContext()
	{
		return clone($this);
	}
}
