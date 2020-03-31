<?php
class AdminControllerCore
{
	
	public function __construct()
	{
		
	}

	/**
	 * Function used to render the form for this controller
	 */
	public function renderForm()
	{
		
	}

	/**
	 * Add a new javascript file in page header.
	 *
	 * @param      $name
	 * @param null $folder
	 * @param bool $css
	 */
	public function addJqueryPlugin($name, $folder = null, $css = true)
	{
		if (!is_array($name))
			$name = array($name);
		if (is_array($name))
		{
			foreach ($name as $plugin)
			{
				$plugin_path = Media::getJqueryPluginPath($plugin, $folder);

				if (!empty($plugin_path['js']))
					$this->addJS($plugin_path['js'], false);
				if ($css && !empty($plugin_path['css']))
					$this->addCSS(key($plugin_path['css']), 'all', null, false);
			}
		}
	}

}
