<?php
/*
Plugin Name: Healthloft Profile Divi Extension
Plugin URI:  
Description: 
Version:     1.0.1
Author:      Appspring Technologies S.A.S
Author URI:  https://appspringtech.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: hpde-healthloft-profile-directory-plugin
Domain Path: /languages

Healthloft Profile Divi Extension is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Healthloft Profile Divi Extension is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Healthloft Profile Divi Extension. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if (!function_exists('hpde_initialize_extension')):
	/**
	 * Creates the extension's main class instance.
	 *
	 * @since 1.0.1
	 */
	function hpde_initialize_extension()
	{
		require_once plugin_dir_path(__FILE__) . 'includes/HealthloftProfileDirectoryPlugin.php';
	}
	add_action('divi_extensions_init', 'hpde_initialize_extension');
endif;

if (!function_exists('hpde_initialize_admin')):
	/**
	 * Creates the admin's main class instance.
	 *
	 * @since 1.0.1
	 */
	function hpde_initialize_admin()
	{
		require_once plugin_dir_path(__FILE__) . 'admin/HealthloftProfileAdminPlugin.php';
	}
	add_action('init', 'hpde_initialize_admin');
endif;


if (!function_exists('profile_list_rewrite_rules')):
    /**
     * Dinamic URL.
     *
     * @since 1.0.1
     */
	function profile_list_rewrite_rules()
	{       
		add_rewrite_rule(
			'^find-nutritionists-dietitians/?$',
			'index.php?pagename=find-nutritionists-dietitians',
			'top'
		);

		add_rewrite_rule(
			'^find-nutritionists-dietitians/page/([0-9]+)/?$',
			'index.php?pagename=find-nutritionists-dietitians&paged=$matches[1]',
			'top'
		);

		add_rewrite_rule(
			'^find-nutritionists-dietitians/page/([0-9]+)/age/([^/]+)/state/([^/]+)/tags/([^/]+)/?$',
			'index.php?pagename=find-nutritionists-dietitians&paged=$matches[1]&age=$matches[2]&state=$matches[3]&tags=$matches[4]',
			'top'
		);

		add_rewrite_rule(
			'^find-nutritionists-dietitians/age/([^/]+)/state/([^/]+)/tags/([^/]+)/?$',
			'index.php?pagename=find-nutritionists-dietitians&age=$matches[1]&state=$matches[2]&tags=$matches[3]',
			'top'
		);

		add_rewrite_rule('^find-nutritionists-dietitians/([^/]*)/?$', 'index.php?profile_name=$matches[1]', 'top');

		add_rewrite_rule('^find-nutritionists-dietitians/([^/]*)/?$', 'index.php?profile_slug=$matches[1]', 'top');
		flush_rewrite_rules(); 
	}

    add_action('init', 'profile_list_rewrite_rules');

    function profile_list_query_vars($query_vars)
    {
        $query_vars[] = 'profile_name';
        $query_vars[] = 'profile_slug';
        $query_vars[] = 'page';
		$query_vars[] = 'state'; 
		$query_vars[] = 'ageRange';
		$query_vars[] = 'tags'; 
        return $query_vars;
    }
    add_filter('query_vars', 'profile_list_query_vars');

	
	function load_custom_template($template) {
		// Get the custom query vars
		$profile_slug = get_query_var('profile_slug');
		$paged = get_query_var('paged');
		$state = get_query_var('state');
		$ageRanges = get_query_var('ageRanges');
		$tags = get_query_var('tags'); // Get the tags[] parameter
	
		// Check if the profile_slug exists to load a custom template
		if ($profile_slug) {
			$plugin_template = plugin_dir_path(__FILE__) . 'views/profile/template-custom-profile.php';
			if (file_exists($plugin_template)) {
				return $plugin_template;
			}
		}
	
		// Check if we need to redirect (only if query params are not already in the current URL)
		if (($state || $ageRanges || $tags) && !is_redirected_url()) {
			// Build the query string for the redirection
			$query_string = '?';
	
			// Add the state to the query string if it's present
			if ($state) {
				$query_string .= 'state=' . urlencode($state);
			}
	
			// Add the ageRanges to the query string if it's present
			if ($ageRanges) {
				$query_string .= ($query_string == '?' ? '' : '&') . 'ageRanges=' . urlencode($ageRanges);
			}
	
			// Add the tags to the query string if it's an array
			if (is_array($tags) && !empty($tags)) {
				foreach ($tags as $tag) {
					$query_string .= '&tags[]=' . urlencode($tag);
				}
			}
	
			// Build the full URL for redirection
			$redirect_url = home_url('/find-nutritionists-dietitians') . $query_string;
	
			// Perform the redirection if necessary
			wp_safe_redirect($redirect_url);
			exit;
		}
	
		return $template;
	}
	
	add_filter('theme_page_templates', 'add_custom_template', 10, 4);
	/******
	 *Add template
		* @Show in Divi builder edtor ******/
		function add_custom_template($templates) {
			$templates[plugin_dir_path(__FILE__) . 'views/profile/template-custom-profile.php'] = 'Directory Cards';
			return $templates;
		}
	
	
	add_filter('template_include', 'load_custom_template');
	
	// Helper function to check if the current URL already contains the correct query string
	function is_redirected_url() {
		$current_url = home_url(add_query_arg(null, null));
		$parsed_url = parse_url($current_url);
	
		// Extract the query string from the current URL
		$current_query = isset($parsed_url['query']) ? $parsed_url['query'] : '';
	
		// Compare the current query with the request
		$expected_query = $_SERVER['QUERY_STRING'];
	
		// Return true if the current URL already has the correct query string
		return $current_query === $expected_query;
	}
	
endif;

if (!function_exists('healthloft_scripts')):
function healthloft_scripts() {
    // Registrar el script
    wp_enqueue_script(
        'showMore', // Handle del script
        plugins_url('scripts/buttons-more.js', __FILE__) , // URL del script
        array('jquery'), // Dependencias (opcional)
        '1.0.0', // Versión
        true // Cargar en el pie de página
    );
}
add_action('wp_enqueue_scripts', 'healthloft_scripts');
endif;