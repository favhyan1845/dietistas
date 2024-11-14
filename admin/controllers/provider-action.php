<?php
function provider_action()
{
    require_once plugin_dir_path(HEALTH_PLUGIN_PATH . ' ') . '/includes/health_profile_admin.php';
    $results = health_profile_admin::health_register_provider($_REQUEST['data']);
    echo json_encode($results);
    wp_die();
}