<?php

class HPDE_HealthloftProfileDirectoryPlugin extends DiviExtension
{

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'hpde-healthloft-profile-directory-plugin';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'healthloft-profile-directory-plugin';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * HPDE_HealthloftProfileDiviExtension constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct($name = 'healthloft-profile-directory-plugin', $args = array())
	{
		$this->plugin_dir = plugin_dir_path(__FILE__);
		$this->plugin_dir_url = plugin_dir_url($this->plugin_dir);

		parent::__construct($name, $args);
	}


}

new HPDE_HealthloftProfileDirectoryPlugin;
