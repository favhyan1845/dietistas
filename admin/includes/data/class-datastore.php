<?php

class Data_Store
{
    /******
     *Insert URLs
     * @return array******/
    static public function health_register_url_admin($scope)
    {

        global $wpdb;
        foreach ($scope['url'] as $type => $url) {
            $validation = self::dbURLValidation('healthloft-' . $type . '-response-url', $url, $type);
            if (!$validation['profile_status']) {     
                            
                // Inserting the data for the first time
                $response[$type.'response_url'] = add_option('healthloft-' . $type . '-response-url',$url);
                $response[$type.'response_ttl'] = add_option('healthloft-' . $type . '-response-cache-ttl', $scope['ttl'][$type]);                
                
            } else {
                // Update info
                $response[$type.'response_ttl'] = update_option('healthloft-' . $type . '-response-cache-ttl', $scope['ttl'][$type]);
            }
            
            $response[$type] = self::insertOrUpdateCacheDateTtlResponse($type, $url);
            $response[$type . '_url'] = $url;
        }

        return $response;
    }

    /******
     *Insert & Updates 
        response,Cache date
     * @return array******/
    public static function insertOrUpdateCacheDateTtlResponse($type, $url)
    {

        $validationDateCache = self::dbURLValidation('healthloft-' . $type . '-response-cache-date', $url, $type);

        $now = date('Y-m-d H:i:s');
        $ttll = get_option('healthloft-' . $type . '-response-cache-ttl');
        $response = [];

        if (!$validationDateCache[$type.'_status']) {         
            // Inserting the data for the first time
            $response['status'] = true;
            $response['msg'] = 'The information has been saved in the application';

            add_option('healthloft-' . $type . '-response-cache-date', $now);

            $response[$type . '_cache_date'] = get_option('healthloft-' . $type . '-response-cache-date');
            $response[$type . '_ttl'] = $ttll;

            $response[$type . '_response_api'] = self::apiRequest($url);
            if ($response[$type . '_response_api'] == '') {
                $response[$type . '_response_api'] = 'NOT DATA';
                $response['status'] = false;
                $response['msg'] = 'NOT DATA';
            }

            $response['profile_slug'] = self::getOptions($response['profile_response_api'], true);
            add_option('healthloft-' . $type . '-response-cache', $response[$type . '_response_api']);
            return $response;
        } else {  
            // update the data 
            $response['status'] = true;
            $response['msg'] = 'The information has been updated in the application.';
            $providers = get_option('healthloft-' . $type . '-response-cache');
            $response[$type . '_response'] = self::apiRequest($url);  
            if ($providers != $response[$type . '_response']) {
                $response[$type . '_cache'] = update_option('healthloft-' . $type . '-response-cache', $response[$type . '_response']);
                $response[$type . '_cache_date'] = update_option('healthloft-' . $type . '-response-cache-date', $now);  
            } 
            if ($response[$type . '_response']) {
                $response = self::getDataValidationNowTtl($type);
                if (empty($response[$type . '_status'])) {
                    return $response;
                }
                
                $ttll = get_option('healthloft-' . $type . '-response-cache-ttl');
                $now = date('Y-m-d H:i:s');
                $response[$type . '_cache_date'] = $now;
                $response[$type . '_ttl'] = $ttll;
            }
            return $response;
        }
    }

    
    /******
     *Get Option slug
     * @return array******/

    function getOptions($providers, $process)
	{	
        $option['profile_response'] = [];	
		foreach ($providers as $provider) {			
				$option[$provider['id']] = strtolower(str_replace(' ', '-', $provider['name']));	
		}

        if($process){
            add_option('healthloft-profile-response-cache-slug', $option);
        }
		return $option;
	}
	
    /******
     *Validation same URls
     * @return array******/
    public static function dbURLValidation($value, $url, $type)
    {
        $response = [];
        $response[$type . '_validate'] = get_option($value);
        if ($response[$type . '_validate']) {
            // They are exists
            if (strcasecmp($response, $url) == 0) {
                // They are equal
                $response[$type . '_status'] = true;
                $response[$type . '_msg'] = 'Equal ' . $type;

                return $response;
            }

            $response[$type . '_status'] = true;
            $response[$type . '_msg'] = 'Exists ' . $type;

            return $response;
        } else {
            // They are not exists
            $response[$type . '_status'] = false;
            $response[$type . '_msg'] = 'Not exists ' . $type;

            return $response;
        }
    }

    /******
     *Request API
     * @return array******/
    public static function apiRequest($url)
    {
        $response = wp_remote_get($url);
        if (is_wp_error($response)) {
            echo 'Error en la solicitud: ' . $response->get_error_message();
            return;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        return $data['data'];
    }
    /******
     * Updates table option
        response,Cache date, Ttl
     * @return array******/
    public static function updateResponse($type, $response, $now, $ttll_time)
    {
        // It updates the records 
        $response[$type . '_cache'] = update_option('healthloft-' . $type . '-response-cache', $response);
        $response[$type . '_cache_date'] = update_option('healthloft-' . $type . '-response-cache-date', $now);
        return $response;
    }
    /******
     * Date now & ttl valitation
     * @return array******/
    public static function getDataValidationNowTtl($type)
    {
        $url = get_option('healthloft-' . $type . '-response-url');
        $ttll = get_option('healthloft-' . $type . '-response-cache-ttl');
        $cachedate = get_option('healthloft-' . $type . '-response-cache-date');
        $now = date('Y-m-d H:i:s');

        if ($type) {
            if (strtotime($now) < strtotime($cachedate) + $ttll) {
                // Inserting the data for the first time if the current time is less than the TTL.
                $response[$type . '_url'] = get_option('healthloft-' . $type . '-response-url');
                $response[$type . '_cache'] = get_option('healthloft-' . $type . '-response-cache');
                $response[$type . '_cache_date'] = $cachedate;
                $response[$type . '_ttl'] = $ttll;

                return $response;
            } else {
                // update data for the first time if the current time is major than the TTL.
                $response[$type . '_response'] = self::apiRequest($url);
                if ($response[$type . '_response'] == '') {
                    $response['status'] = false;
                    $response['msg'] = 'NOT DATA';
                    $response[$type . '_response'] = 'NOT DATA';
                }
                return self::updateResponse($type, $response[$type . '_response'], $now, $ttll);

            }
        }
    }
}