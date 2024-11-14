<?php

class HealthloftProfileAdminPlugin
{

    public function __construct()
    {
        add_action('main', array($this, 'main'));
        do_action('main');

    }


    // Adding a hook to run the function every ttl seconds
    public function add_time_interval()
    {

        $key = ['profile', 'states', 'specialties', 'age_ranges'];

        foreach ($key as $type) {
            $ttl = get_option('healthloft-' . $type . '-response-cache-ttl');
            $schedules['seg'] = array(
                'interval' => $ttl, // seconds ttl
                'display' => __('Each ' . $ttl . ' seconds')
            );
        }
        return $schedules;
    }

    public function set_cronjob()
    {
		// Preparing array to retrieve information from the database.
        $key = ['profile', 'states', 'specialities', 'age_ranges'];

        foreach ($key as $type) {
            $cachedate = get_option('healthloft-' . $type . '-response-cache-date');
            $ttl = get_option('healthloft-' . $type . '-response-cache-ttl');

            $now = date('Y-m-d H:i:s');
            $dateTtl = date('Y-m-d H:i:s', strtotime($cachedate) + $ttl);

            if (!wp_next_scheduled('change_status_posts_events')) {
                wp_schedule_event($cachedate, $dateTtl, 'change_status_posts_events');
                if ($now < $dateTtl) {
                    add_filter('cron_schedules', 'add_time_interval');
                    add_action('change_status_posts_events', 'APIRequest');
                }
            }
        }

    }
    public function main()
    {	
        add_action('admin_menu', array($this, 'health_profile_admin_menu'));
        $string = trim($_SERVER['REQUEST_URI']);
        $pattern = 'health-profile-admin';
        $patternAdminAjax = '/wp-admin/admin-ajax.php';
        if (strpos($string, $pattern)  !== false || strpos($string, $patternAdminAjax)  !== false ) {
            //register styles custom
            wp_enqueue_style('health-css', plugins_url('/assets/css/index.css', __FILE__));
            wp_enqueue_style('bootstrap', plugins_url('/assets/css/bootstrap.min.css', __FILE__));
            // //Register JS custom
            wp_enqueue_script('index-js', plugins_url('assets/js/index.js', __FILE__));
            //JS join
            require_once dirname(__FILE__) . '/controllers/health-action.php';

            add_action('wp_ajax_health_action', 'health_action');
            add_action('wp', array($this, 'set_cronjob'));

            //health_active();
            define('HEALTH_PLUGIN_PATH', plugin_dir_path(__FILE__));
            define('PLUGIN_DIR', dirname(__FILE__) . '/');
            require_once HEALTH_PLUGIN_PATH . 'view/health-admin.php';
        }
    }

    // Create main menu in dashboard
    public function health_profile_admin_menu()
    {
        add_menu_page(
            'Health profiles configuration', // title page
            'Health profile admin',        // menu title
            'manage_options',              // capability
            'health-profile-admin',        // menu slug
            'form_content',                // content function
            'dashicons-list-view',         // Icon
            6                              // Menu position
        );
    }
    public function APIRequest()
    {
        require_once dirname(__FILE__) . '/controllers/health-action.php';

        $key = ['profile', 'states', 'specialties', 'age_ranges'];
        $arr = [];
        add_filter('health_action', 'health_action');

        foreach ($key as $type) {
            $response['data']['url'][$type] = get_option('healthloft-' . $type . '-response-url');
            $response['data']['ttl'][$type] = get_option('healthloft-' . $type . '-response-cache-ttl');
            array_push($arr, $response);
        }
        apply_filters('health_action', end($arr));

    }
}
new HealthloftProfileAdminPlugin;