<?php

class health_profile_admin
{
    public $scope;
    static public function health_register_url($scope = null)
    {
        require_once plugin_dir_path(HEALTH_PLUGIN_PATH . ' ') . '/includes/data/class-datastore.php';
        $response = Data_Store::health_register_url_admin($scope);
        return $response;
        ;
    }
}