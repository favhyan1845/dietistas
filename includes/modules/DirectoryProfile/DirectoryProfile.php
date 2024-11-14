<?php

class HPDE_DirectoryProfile extends ET_Builder_Module
{

    public $slug = 'hpde_directory_profile';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => '',
        'author' => 'Appspring Technologies S.A.S',
        'author_uri' => 'https://appspringtech.com',
    );

    public function init()
    {
        $this->name = esc_html__('Directory Profile', 'hpde-healthloft-profile-directory-plugin');
    }

    function get_fields()
    {

        // Preparing array to retrieve information from the database.
        $types = [
            'states' => 'states',
            'ages' => 'age_ranges',
            'specialities' => 'specialities',
            // 'providers' => 'providers'
        ];

        // Send to function as false to return the data in an array.
        $options = $this->getOptions($types, true);

        // Array of filters for when the component is requested in the Divi builder.
        return array(
            'state' => array(
                'label' => esc_html__('State', 'et_builder'),
                'type' => 'select',
                'options' => $options['states_response'],
                'default' => 'all',
                'description' => esc_html__('Select a state.', 'et_builder'),
            ),
            'ages' => array(
                'label' => esc_html__('Age', 'et_builder'),
                'type' => 'select',
                'default' => 'all',
                'options' => $options['age_ranges_response'],
                'description' => esc_html__('Select an age range.', 'et_builder'),
            ),
            'specialities' => array(
                'label' => esc_html__('Specialities', 'et_builder'),
                'type' => 'select',
                'default' => 'all',
                'options' => $options['specialities_response'],
                'description' => esc_html__('Select a speciality.', 'et_builder'),
            ),
            'page_size' => array(
                'label' => esc_html__('Page size', 'et_builder'),
                'type' => 'select',
                'default' => '20',
                'options' => array(
                    10 => '10',
                    20 => '20',
                    30 => '30',
                    40 => '40',
                    50 => '50',
                    60 => '60',
                ),
                'description' => esc_html__('Select a page size.', 'et_builder'),
            ),
        );
    }
    
    /***
     * Function to retrieve information from the database,
     * when set to true, it organizes the data for the 
     * builder process; when set to false, it only sends 
     * the information.*/
    function getOptions($types, $process)
    {
        $arr = [];
        foreach ($types as $type) {
            $option[$type . '_response'] = get_option('healthloft-' . $type . '-response-cache');
            if ($process === true) {
                $arr[$type . '_response'] = $this->orderOption($option[$type . '_response']);
            } else {
                $arr[$type . '_response'] = $option[$type . '_response'];

            }
        }
        return $arr;
    }

    // Array organization to display them in the builder.
    function orderOption($arrOption)
    {
        $arr = [];
        foreach ($arrOption as $item) {
            $arr[$item['name']] = $item['value'];
        }
        return $arr;

    }

    // Function to generate a select dropdown with options based on the provided type and options array
    public function selectOptions($options, $type, $props)
    {
        if ($type == 'states') {
            // Initialize the response with the opening select tag and set its name and class attributes
            $response[$type . '_response'] = '<div class="select"><select name="' . $type . '" class="select-directory" id="' . $type . '">';
            if($props == 'all'){
                $response[$type . '_response'] .= '<option value="all">All</option>';
            }
            // Loop through the options array and create option elements
            foreach ($options as $option) {
                $response[$type . '_response'] .= sprintf(
                    // Create an option element with value and name, and select it if it matches the current state
                    '<option value="%1$s" %2$s>%3$s</option>',
                    esc_html(strtolower($option['value'])), // Sanitize and set the option value
                    selected($props, $option['value'], false), // Mark as selected if it matches the current state
                    esc_html($option['name']) // Sanitize and display the option name
                );
            }

            // Close the select tag and return the complete HTML string
            $response[$type . '_response'] .= '</select></div>';
        }
        
        if($type == 'ages'){
            $agesCode = $this->agesCode();
            // Initialize the response with the opening select tag and set its name and class attributes
            $response[$type . '_response'] = '<div class="select"><select name="' . $type . '" class="select-directory" id="' . $type . '">';
            if($props == 'all'){
                $response[$type . '_response'] .= '<option value="all">All</option>';
            }
            // Loop through the options array and create option elements
            foreach ($agesCode as $key => $option) {
                $response[$type . '_response'] .= sprintf(
                    // Create an option element with value and name, and select it if it matches the current state
                    '<option value="%1$s" %2$s>%3$s</option></div>',
                    esc_html($key),
                    selected($props, $option, false), 
                    esc_html($option) 
                );
            }

            // Close the select tag and return the complete HTML string
            $response[$type . '_response'] .= '</select>';
        }
        
        if ($type == 'specialities') {

            // Specialities options
            if($_GET['tags'] !== 'all'){
                $response[$type . '_response'] = '<div class="dropdown select-directory" id="Dropdown"><div class="selected-items" id="selectedItems"><div class="selected-item" id="item_'.$props.'"><span>'.$props.'</span><button role="button" class="select__multi-value__remove css-1wegy39" aria-label="Remove '.$props.'" data-value="'.$props.'"><svg height="14" width="14" viewBox="0 0 20 20" aria-hidden="true" focusable="false" class="css-8mmkcg"><path fill="white" d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.029c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"></path></svg></button></div></div>';
            }else{                       
                $response[$type . '_response'] .= '<div class="dropdown select-directory" id="Dropdown"><div ><div><span style="padding: 0px 0.4%;top: 7px;position: relative;">All</span><button role="button" class="select__multi-value__remove css-1wegy39" aria-label="Remove all" data-value="all"><svg height="14" width="14" viewBox="0 0 20 20" aria-hidden="true" focusable="false" class="css-8mmkcg"><path fill="white" d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.029c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"></path></svg></button></div></div>';
            }
            
            $response[$type . '_response'] .= '<div class="dropdown-content" id="dropdownContent">';

                                    foreach ($options as $option) {
                                        $response[$type . '_response'] .= sprintf(
                                            '<a href="#" data-value="%1$s" value="%1$s" %2$s>%3$s</a>',
                                            esc_html( str_replace(' ', '-', strtolower($option['value']))),
                                            selected($props,str_replace(' ', '-', strtolower($option['value'])), false),
                                            esc_html($option['name'])
                                        );
                                    }
            $response[$type . '_response'] .= '</div>';

        }
        return $response[$type . '_response'];
    }

    // Function to generate HTML for displaying a list of age profiles as styled tags
    public function ageProfile($items)
    {
        $item = '';

        // Loop through the age profile items and create a div for each with custom styles
        foreach ($items as $ageProfile) {
            $item .=
                // Create a div with specific styling to represent each age profile
                '<div class="mb-2 mr-2 rounded-full px-3 py-1 text-xs font-semibold text-white bg-[#15435a66]">'
                . esc_html($ageProfile['name']) . // Sanitize and display the age profile name
                '</div>';
        }

        return $item; // Return the concatenated HTML string for the age profiles
    }

    // Function to generate HTML for displaying a limited number of tags
    public function tagsProfile($items)
    {
        $item = '';
        $count = 0;

        // Loop through the tag items and create a div for each tag, up to 8 tags maximum
        foreach ($items as $tag) {
            if ($count < 8) { // Limit to 8 tags
                $item .=
                    // Create a div with specific styling to represent each tag
                    '<div class="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1.5 text-xs font-semibold text-white tag-item">'
                    . esc_html($tag['name']) . // Sanitize and display the tag name
                    '</div>';
                $count++; // Increment the count
            } else {
                break; // Stop adding tags if the count reaches 8
            }
        }

        return $item; // Return the concatenated HTML string for the tags
    }


    // Function to get the API response and store it in cache
    function apiResponse($url)
    {
        // Generate a unique key for this URL using a hash
        $cache_key = 'profile_api_' . md5($url);

        // Try to get data from the transient cache
        $cached_data = get_transient($cache_key);

        if (!empty($cached_data)) {
            // If there is already a value in the cache, return it
            if ($cached_data !== false) {
                return $cached_data;
            }
        }
        // If no cached data, make the request
        $response = wp_remote_get($url);

        // Check if there was an error in the request
        if (is_wp_error($response)) {
            echo 'Error in the request: ' . $response->get_error_message();
            return;
        }

        // Get the body of the response
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // Store the result in cache for 12 hours (43200 seconds)
        set_transient($cache_key, $data['data']['ageRanges'], 12 * HOUR_IN_SECONDS);

        return $data['data']['ageRanges']; // Return the data
    }

    // Function to generate HTML for a profile
    public function profileDOM($profile) {
        // Ensure that the profile data is safely outputted
        $avatarUrl = htmlspecialchars($profile['avatarUrl']);
        $name = htmlspecialchars($profile['name']);
        $slug = htmlspecialchars($profile['slug']);
        $ageRanges = $profile['ageRanges']; // Assuming this is already formatted for display
        $tagsData = $profile['tags_data']; // Assuming this is already formatted for display
        $jsonString = json_encode($profile['tags']);
        $base64String = base64_encode($jsonString);

        $id = htmlspecialchars($profile['id']);
        // Get the base URL of the current page
        $current_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        // Remove any existing "page" segments
        $current_url = preg_replace('/\/page\/[0-9]+/', '', $current_url);

        // Remove query parameters if they exist
        $current_url = strtok($current_url, '?');  
        $profiles_content = '';
		// Format the HTML for displaying the profile content
		$profiles_content .='<div class="flex flex-col justify-between sm:flex-row mb-4 p-4 bg-white rounded-xl">
			<div class="hidden w-medium min-w-fit items-center justify-center pr-4 sm:flex w-20 sm:items-start">
				<img class="h-40 mt-1 rounded-full w-40 object-cover" src="'.esc_url($avatarUrl).'" alt="%2$s" />
			</div>
			<div class="flex w-full flex-col w-75 w-80">
				<div class="mb-4 mt-4 flex flex-row items-center justify-start sm:mb-0 sm:mt-0 sm:h-[100px] sm:justify-between sm:pr-6">
					<div class="flex w-full gap-6">
						<img class="mt-1 block h-24 w-24 rounded-full object-cover sm:hidden sm:h-40 sm:w-40" src="'.esc_url($avatarUrl).'" alt="'.esc_attr($name).'">
						<div class="flex flex-col justify-center">
							<p class="font-manrope text-xl font-bold text-gray-900 sm:text-2xl">'.esc_attr($name).'</p>
							<p class="text-base font-light uppercase text-gray-500 sm:text-lg"></p>
						</div>
					</div>
					<a href="' . esc_url($current_url) . esc_html($slug).'" class="btn-see-profile hidden h-fit w-fit items-center gap-1 rounded-lg border py-1 pl-2 pr-1 text-sm font-semibold text-cobalt sm:flex sm:gap-3 sm:py-2 sm:pl-4 sm:pr-2 sm:text-base">
					See profile
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
					</svg>
					</a>
				</div>
				<a href="./'.esc_html($slug).'" class="btn-see-profile mt-2 flex h-fit w-full items-center justify-center gap-1 rounded-lg border py-1 pl-2 pr-1 text-base font-semibold text-cobalt sm:hidden sm:gap-3 sm:py-2 sm:pl-4 sm:pr-2 sm:text-base">
					See profile
				</a>
				<div class="mt-4 flex flex-col">
					<h2 class="mb-2 font-manrope text-base font-bold">Age ranges</h2>
					<div class="flex flex-wrap">'.$ageRanges.'</div>
				</div>
				<div class="mt-4 flex flex-col">
					<h2 class="mb-2 font-manrope text-base font-bold">Specialities</h2>
					<div class="flex flex-wrap" id="tags-container-'.$id.'">'.$tagsData.'
						<a class="flex cursor-pointer items-center text-sm text-gray-500 underline hover:opacity-80" id="show-more-btn-'.$id.'" style="color: #666;" href="javascript:showMore('.$id.')">Show more</a>
                        <input type="hidden" id="tags-text-'.$id.'" value="'.$base64String.'"/>						
					</div>
				</div>
			</div>
		</div>';
	return $profiles_content;
    }

    public function statesCode(){
        return  [
			'AL' => 'alabama',
			'AK' => 'alaska',
			'AZ' => 'arizona',
			'AR' => 'arkansas',
			'CA' => 'california',
			'CO' => 'colorado',
			'CT' => 'connecticut',
			'DE' => 'delaware',
			'FL' => 'florida',
			'GA' => 'georgia',
			'HI' => 'hawaii',
			'ID' => 'idaho',
			'IL' => 'illinois',
			'IN' => 'indiana',
			'IA' => 'iowa',
			'KS' => 'kansas',
			'KY' => 'kentucky',
			'LA' => 'louisiana',
			'ME' => 'maine',
			'MD' => 'maryland',
			'MA' => 'massachusetts',
			'MI' => 'michigan',
			'MN' => 'minnesota',
			'MS' => 'mississippi',
			'MO' => 'new Jersey',
			'NM' => 'new México',
			'NY' => 'missouri',
			'MT' => 'montana',
			'NE' => 'nebraska',
			'NV' => 'nevada',
			'NH' => 'new Hampshire',
			'NJ' => 'new York',
			'NC' => 'north Carolina',
			'ND' => 'north Dakota',
			'OH' => 'ohio',
			'OK' => 'oklahoma',
			'OR' => 'oregon',
			'PA' => 'pennsylvania',
			'RI' => 'rhode Island',
			'SC' => 'south Carolina',
			'SD' => 'south Dakota',
			'TN' => 'tennessee',
			'TX' => 'texas',
			'UT' => 'utah',
			'VT' => 'vermont',
			'VA' => 'virginia',
			'WA' => 'washington',
			'WV' => 'west Virginia',
			'WI' => 'wisconsin',
			'WY' => 'wyoming',
		];
    }
    public function agesCode(){
        return [
            1 => 'Infant (0-24 months)',
            3 => 'Pediatric (2-11)',
            13 => 'Adolescent (12-18)',
            20 => 'Adult (19-69)',
            70 => 'Older Adult (70+)',
        ];
    }

    public function filterProvider($provider){
        // Get query variables (query vars)
        $profile_slug = get_query_var('profile_slug');
        $paged = get_query_var('paged');
        $state = get_query_var('state'); 
        $ageRange = get_query_var('ageRange');
        $tags = get_query_var('tags'); // This should handle multiple tags

        // Decode the parameters if necessary
        $state = $state ? urldecode($state) : null;
        // $ageRange = $ageRange ? urldecode($ageRange) : null;

        
        $tags = $tags ? explode(',', urldecode($tags)) : []; // Split tags into an array
        $stateCode = []; //Change value to zip code
        $ageCode = [];  //change string to code          
        $card = [];
        $card_provider = [];
        $urlDB = get_option('healthloft-profile-response-url'); // Base URL for profiles from database
        $urlProvider = $urlDB . '/' . $provider['id'];
        // Fetch additional profile data from the API
        $provider['ageRanges'] = $this->apiResponse($urlProvider);
        $provider['slug'] = strtolower(str_replace(' ', '-', $provider['name']));

            // Initialize flags
            $stateMatched = false; 
            $ageMatched = false;
            $tagsMatched = false;

            // Check for state condition
            if ($state) {   
                $state_name = $this->statesCode();  // Get the mapping of state codes to names    

                foreach ($state_name as $code => $name) {
                    if ($name === $state) {
                        $stateCode = $code;
                        break; 
                    }
                }

                // Check if the provider's states match the given state
                foreach ($provider['states'] as $stateCodeProvider) {
                    if ($stateCodeProvider == $stateCode) {
                        $stateMatched = true; // State matched
                        break; // Exit loop as we found a match
                    }
                }
            }

            // Check for age range condition
            if ($ageRange) {                  
                $age_name = $this->agesCode();  // Get the age ranges 
                foreach ($age_name as $code => $name) {                
                    if ($code == $ageRange) {
                        $ageCode['name'] = $name;
                        $ageCode['code'] = $code;
                        break; 
                    }
                }   

                // Check if the provider's age ranges match the given age range
                foreach ($provider['ageRanges'] as $ageCodeProvider) {
                    if ($ageCodeProvider['name'] == $ageCode['name']) {
                        $ageMatched = true; // Age matched
                        break; // Exit loop as we found a match
                    }
                }
            }

            
            if($tags){   
                // Check if any tag matches the tags from the URL
                foreach ($tags as $tagsArr) {    
                    $textTagConversion = ucwords(trim(str_replace('-', ' ', $tagsArr))); 
                    foreach ($provider['tags'] as $tag) {
                        $normalizedTag = ucwords(trim(str_replace('-', ' ', $tag['name']))); 
                        if ($normalizedTag === $textTagConversion) {
                            $tagsMatched = true;
                        }
                    }
                }
            } 

            // Validate conditions based on inputs
            if ($state != 'all' && $ageRange != 'all' && $tags != 'all') {   
                if ($stateMatched && $ageMatched && $tagsMatched) {  
                    $card_provider = $provider;
                }
            }
            if ($state != 'all' && $ageRange == 'all' && $tags != 'all') {    
                if($stateMatched && empty($ageMatched) && $tagsMatched){  
                    $card_provider = $provider;
                }
            }
            if ($state != 'all' &&  $ageRange == 'all' &&  $tags[0] == 'all' ) { 
                if($stateMatched && empty($ageMatched) && empty($tagsMatched)){  
                    $card_provider = $provider;
                }
            }
            if ($state == 'all' && $ageRange != 'all' && $tags != 'all') {   
                if($ageMatched && empty($stateMatched) && $tagsMatched){  
                    $card_provider = $provider;
                }
            }
            if ($state == 'all' && $ageRange != 'all' && $tags[0] == 'all') {   
                if($ageMatched && empty($stateMatched) && empty($tagsMatched)){  
                    $card_provider = $provider;
                }
            }

            if ($state == 'all' &&  $ageRange == 'all' && $tags != 'all') {   
                if(empty($ageMatched) && empty($stateMatched) && $tagsMatched){  
                    $card_provider = $provider;
                }
            }

            if ($state != 'all' && $ageRange != 'all' && $tags[0] == 'all') {   
                if($ageMatched && $stateMatched && empty($tagsMatched)){  
                    $card_provider = $provider;
                }
            }
            if (!empty($card_provider)) {
            // Add the profile to the filtered results
                return $card_provider;
            }
        
    }
    
        
    public function profileContents($providers, $pageSizeProviders, $currentPage = 1) {

        // Set the current page, ensuring it defaults to 1 if no page is set
        $currentPage = max(1, get_query_var('paged', 1));
        
        $profile_cards = []; // Array to store profile cards
        $provider_cards = []; // Array to store provider cards
        $batch_size = $pageSizeProviders; // Set batch size for pagination

        // Iterate over the providers (profiles)
        $state = get_query_var('state'); 
        $ageRange = get_query_var('ageRange');
        $tags = get_query_var('tags'); // This should handle multiple tags

        
        if($state == 'all' && $ageRange == 'all' && $tags == 'all'){ 
            $urlDB = get_option('healthloft-profile-response-url'); // Base URL for profiles from database

            foreach ($providers as $provider) {  
                $urlProvider = $urlDB . '/' . $provider['id'];
                // Fetch additional profile data from the API
                $provider['ageRanges'] = $this->apiResponse($urlProvider);
                $provider['slug'] = strtolower(str_replace(' ', '-', $provider['name']));
                $profile_cards[] = $provider;
            } 
        }else{   
            foreach ($providers as $provider) {            
                $provider_cards[] = $this->filterProvider($provider);
            }
            foreach ($provider_cards as $card) {    
            
            if (!empty($card)) {
                $profile_cards[] = $card;
                }
            } 
        }

        
        // Calculate the total number of pages for pagination
        $totalPages = ceil(count($profile_cards) / $pageSizeProviders);
        
        // Ensure the current page is within bounds
        $currentPage = max(1, min($currentPage, $totalPages));
        
        // Slice the array to get the profiles for the current page
        $currentProfiles = array_slice($profile_cards, ($currentPage - 1) * $pageSizeProviders, $pageSizeProviders);
        // Check if there are any profiles after filtering
        if (empty($profile_cards)) {
            return '<div class="flex flex-col gap-4"><div class="mt-4 w-full rounded-md bg-yellow-50 p-4"><div class="flex"><div class="flex-shrink-0"><svg width="15" height="18" viewBox="0 0 296 259" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M147.989 0C156.199 0 163.773 4.33594 167.936 11.4469L292.82 224.197C297.041 231.366 297.041 240.211 292.936 247.38C288.831 254.548 281.141 259 272.873 259H23.1053C14.8375 259 7.14792 254.548 3.04294 247.38C-1.06204 240.211 -1.00422 231.308 3.15857 224.197L128.043 11.4469C132.205 4.33594 139.779 0 147.989 0ZM147.989 74C140.3 74 134.113 80.1859 134.113 87.875V152.625C134.113 160.314 140.3 166.5 147.989 166.5C155.679 166.5 161.865 160.314 161.865 152.625V87.875C161.865 80.1859 155.679 74 147.989 74ZM166.491 203.5C166.491 198.593 164.541 193.888 161.072 190.419C157.602 186.949 152.896 185 147.989 185C143.082 185 138.377 186.949 134.907 190.419C131.437 193.888 129.488 198.593 129.488 203.5C129.488 208.407 131.437 213.112 134.907 216.581C138.377 220.051 143.082 222 147.989 222C152.896 222 157.602 220.051 161.072 216.581C164.541 213.112 166.491 208.407 166.491 203.5Z" fill="#FACC14"></path></svg></div><div class="ml-3"><h3 class="text-sm font-medium text-yellow-800">We\'re sorry, but no providers match your current filter criteria. We\'re here to help!</h3><div class="mt-2 text-sm text-yellow-700"><p class="mb-2">Change your filter options:</p><p>• Email us at <a href="mailto:appointments@healthloftco.com" class="text-blue-600 underline hover:text-blue-800">appointments@healthloftco.com</a></p><p class="mt-1">• Or call us at <a href="tel:+18555525557" class="text-blue-600 underline hover:text-blue-800">(855) 552-5557</a></p><p class="mt-2">We\'ll do our best to assist you in finding the right provider for your needs.</p></div></div></div></div></div>'; // Return a message if no profiles are found
        }
        // Render the profiles and pagination controls
        return $this->renderProfilesInitial($totalPages, $currentProfiles, $currentPage, $pageSizeProviders);
    }
    
    // Function to render profiles
    public function renderProfilesInitial($totalPages, $currentProfiles, $currentPage, $pageSizeProviders) {
    
        $profilesContainer = '<div id="profile-list">';

        // Render the list of profiles
        foreach ($currentProfiles as $profileData) {
            // Access individual properties
            $id = htmlspecialchars($profileData['id']);
            $name = htmlspecialchars($profileData['name']);
            $email = htmlspecialchars($profileData['email']);
            $avatarUrl = htmlspecialchars($profileData['avatarUrl']);
            $education = htmlspecialchars($profileData['education']);
            $tags = implode(', ', array_map('htmlspecialchars', array_column($profileData['tags'], 'name')));
    
            // Generate HTML for each provider
            $generatedHTML = $this->profileDOM([
                'id' => $id,
                'name' => $name,
                'avatarUrl' => $avatarUrl,
                'ageRanges' => $this->ageProfile($profileData['ageRanges']),
                'tags' => $profileData['tags'],
                'tags_data' => $this->tagsProfile($profileData['tags']),
                'slug' => $profileData['slug']
            ]);
            $profilesContainer .= $generatedHTML;
        }
    
        $profilesContainer .= '</div>';
        $profilesContainer .= $this->paginator($totalPages, $currentPage); // Pass the current page to paginator
    
        return $profilesContainer;
    }
    
    // Function to generate URL with pagination and query string
    function generate_pagination_url($base_url, $page, $query_string) {
        return esc_url(trailingslashit($base_url) . 'page/' . $page . '/' . (!empty($query_string) ? '?' . $query_string : ''));
    }

    // Function to render pagination
    public function paginator($total_pages, $current_page) {
        // Get the base URL of the current page, removing any query string initially
        $current_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');

        // Remove any existing "page" segments
        $current_url = preg_replace('/\/page\/[0-9]+/', '', $current_url);

        // Get existing query parameters for state, ageRange, and tags
        $state = isset($_GET['state']) ? $_GET['state'] : '';
        $ageRange = isset($_GET['ageRange']) ? $_GET['ageRange'] : '';
        $tags = isset($_GET['tags']) ? $_GET['tags'] : '';

        // Build the query string with the additional filters if they exist
        $query_params = [];
        if (!empty($state)) $query_params['state'] = $state;
        if (!empty($ageRange)) $query_params['ageRange'] = $ageRange;
        if (!empty($tags)) $query_params['tags'] = $tags;
        $query_string = http_build_query($query_params);

        $pagination = '<div class="pagination">';

        // Previous button
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            $pagination .= '<a href="' . $this->generate_pagination_url($current_url, $prev_page, $query_string) . '" class="page-link" data-page="' . $prev_page . '" id="previous-page" style="display: flex;"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" focusable="false" aria-hidden="true" style="margin-right: 5px;margin-top: 5px;"><path d="M5.874.35a1.28 1.28 0 011.761 0 1.165 1.165 0 010 1.695L3.522 6l4.113 3.955a1.165 1.165 0 010 1.694 1.28 1.28 0 01-1.76 0L0 6 5.874.35z"></path></svg> Previous</a>';
        }

        if($total_pages != 4){
        // Always show the first page
            if ($current_page > 2) {
                
                $pagination .= '<a href="' . $this->generate_pagination_url($current_url, 1, $query_string) . '" class="page-link" data-page="1">1</a>';
                if ($current_page > 3) {
                    $pagination .= '<span class="ellipsis">...</span>';
                }
            }
        }

        // Define start and end range for dynamic pages
        $start_page = max(1, $current_page - 1);
        $end_page = min($current_page + 1, $total_pages);

        // Make sure we show a total of 3 pages in the range around the current page
        if ($current_page == 1) $end_page = min(4, $total_pages);
        if ($current_page == $total_pages) $start_page = max(1, $total_pages - 3);

        // Generate page number links for the middle range
        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $current_page) {
                // No link for the current page, just a span with the active class
                $pagination .= '<span class="page-link active" data-page="' . $i . '">' . $i . '</span>';
            } else {
                $pagination .= '<a href="' . $this->generate_pagination_url($current_url, $i, $query_string) . '" class="page-link" data-page="' . $i . '">' . $i . '</a>';
            }
        }
        

        if($total_pages != 4){
            // Show last page link with ellipsis if needed
            if ($current_page < $total_pages - 2) {
                if ($current_page < $total_pages - 2 || $current_page < $total_pages - 1 || $current_page < $total_pages - 3) {
                    $pagination .= '<span class="ellipsis">...</span>';
                }
                $pagination .= '<a href="' . $this->generate_pagination_url($current_url, $total_pages, $query_string) . '" class="page-link" data-page="' . $total_pages . '">' . $total_pages . '</a>';
            }
        }
        // Next button
        if ($current_page < $total_pages) {
            $next_page = $current_page + 1;
            $pagination .= '<a href="' . $this->generate_pagination_url($current_url, $next_page, $query_string) . '" class="page-link" data-page="' . $next_page . '" id="next-page">Next <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" focusable="false" aria-hidden="true" style="display: inline-block;"><path d="M2.126.35a1.28 1.28 0 00-1.761 0 1.165 1.165 0 000 1.695L4.478 6 .365 9.955a1.165 1.165 0 000 1.694 1.28 1.28 0 001.76 0L8 6 2.126.35z" ></path></svg></a>';
        }

        $pagination .= '</div>';

        return $pagination;
    }

        
    public function render($attrs, $content = null, $render_slug)
    {
        // Preparing array to retrieve information from the database.
        $types = [
            'states' => 'states',
            'ages' => 'age_ranges',
            'specialities' => 'specialities',
            'profile' => 'profile'
        ];
        // Send to function as false to return the data in an array.
        $options = $this->getOptions($types, false);
        $state = $this->props['state'];
        $age = $this->props['ages'];
        $specialities_selected = $this->props['specialities'];
        $pageSizeProviders = $this->props['page_size'];

        // Get html
        $state_options = $this->selectOptions($options['states_response'], "states", $state);
        $age_options = $this->selectOptions($options['age_ranges_response'], "ages", $age);
        $specialities_options = $this->selectOptions($options['specialities_response'], "specialities", $specialities_selected);
        $profilesContainer = $this->profileContents($options['profile_response'], $pageSizeProviders);

        // Get the current page number from the URL (if it doesn't exist, default to the first page)
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        // Total number of pages based on the number of batches 
        $total_pages = count($options['profile_response'][0]);

        return sprintf(
            '<section class="row selects-content mb-8 mt-4 flex flex-col items-center gap-2">
                <div class="flex w-full flex-col items-start">
                    <label for="states">States</label>
                    %1$s
                </div>
                <div class="flex w-full flex-col items-start">
                    <label for="ages">Ages</label>
                    %2$s
                </div>
                <div class="flex w-full flex-col items-start">
                    <label for="specialities">Specialities</label>
                    %3$s
                </div>
            </section>
            <section class="flex flex-col gap-4" id="providers-content">
                %4$s
            </section>',
            $state_options,
            $age_options,
            $specialities_options,
            $profilesContainer
        );
    }

}

new HPDE_DirectoryProfile;