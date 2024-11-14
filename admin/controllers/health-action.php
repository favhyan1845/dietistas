<?php
function health_action($data)
{
    require_once plugin_dir_path(HEALTH_PLUGIN_PATH . ' ') . '/includes/health_profile_admin.php';

    if ($data) {
        $_REQUEST['data'] = $data['data'];
    }
    
    // Validate URL for errors.
    foreach ($_REQUEST['data']['url'] as $response) {
        $validate = validar_url($response);
        if ($validate != true) {
            $results['status'] = false;
            $results['msg'] = 'It is not a valid URL';
            echo json_encode($results);
            wp_die();
        }
    }
    $results = health_profile_admin::health_register_url($_REQUEST['data']);
    echo json_encode($results);
    wp_die();
}
function validar_url($url)
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        return true;
    } else {
        return false;
    }
}