
jQuery(document).ready(function() {
  jQuery("#healthloft-profile-response-cache").attr("readonly","readonly")
  jQuery("#healthloft-profile-response-cache-date").attr("readonly","readonly")
  jQuery("#healthloft-states-response-cache").attr("readonly","readonly")
  jQuery("#healthloft-states-response-cache-date").attr("readonly","readonly")
  jQuery("#healthloft-specialities-response-cache").attr("readonly","readonly")
  jQuery("#healthloft-specialities-response-cache-date").attr("readonly","readonly")
  jQuery("#healthloft-age_ranges-response-cache").attr("readonly","readonly")
  jQuery("#healthloft-age_ranges-response-cache-date").attr("readonly","readonly")

  jQuery('#formProfile').submit(function(event) {
    jQuery(".alert").css("display", "block");
    event.preventDefault();
    jQuery.ajax({
      url: ajaxurl,  
      method: 'POST',
      data: {
          action: 'health_action', 
          data: {
            url:{
              profile: jQuery('#healthloft-profile-response-url').val(),
              states: jQuery('#healthloft-states-response-url').val(),
              specialities: jQuery('#healthloft-specialities-response-url').val(),
              age_ranges: jQuery('#healthloft-age_ranges-response-url').val()
            },
            ttl:{
              profile: jQuery('#healthloft-profile-response-cache-ttl').val(),
              states: jQuery('#healthloft-states-response-cache-ttl').val(),
              specialities: jQuery('#healthloft-specialities-response-cache-ttl').val(),
              age_ranges: jQuery('#healthloft-age_ranges-response-cache-ttl').val()
            }
          }
      },
      success: function(response) {  

        let status = jQuery.parseJSON(response)['profile']['status'];

        if(status === true){
        console.log( jQuery.parseJSON(response)['profile'])
          let profile_data = jQuery.parseJSON(response)['profile']['profile_response_api'];
          jQuery('#healthloft-profile-response-url').val(jQuery.parseJSON(response)['profile_url'])
          jQuery('#healthloft-profile-response-cache').val(JSON.stringify(profile_data))
          jQuery('#healthloft-profile-response-cache-date').val(jQuery.parseJSON(response)['profile']['profile_cache_date'])
          jQuery('#healthloft-profile-response-cache-ttl').val(jQuery.parseJSON(response)['profile']['profile_ttl'])
          
          let states_data = jQuery.parseJSON(response)['states']['states_response_api'];
          jQuery('#healthloft-states-response-url').val(jQuery.parseJSON(response)['states_url'])
          jQuery('#healthloft-states-response-cache').val(JSON.stringify(states_data))
          jQuery('#healthloft-states-response-cache-date').val(jQuery.parseJSON(response)['states']['states_cache_date'])
          jQuery('#healthloft-states-response-cache-ttl').val(jQuery.parseJSON(response)['states']['states_ttl'])

          let specialities_data = jQuery.parseJSON(response)['specialities']['specialities_response_api'];['specialities_response_api'];
          jQuery('#healthloft-specialities-response-url').val(jQuery.parseJSON(response)['specialities_url'])
          jQuery('#healthloft-specialities-response-cache').val(JSON.stringify(specialities_data))
          jQuery('#healthloft-specialities-response-cache-date').val(jQuery.parseJSON(response)['specialities']['specialities_cache_date'])
          jQuery('#healthloft-specialities-response-cache-ttl').val(jQuery.parseJSON(response)['specialities']['specialities_ttl'])

          
          let age_ranges_data = jQuery.parseJSON(response)['age_ranges']['age_ranges_response_api'];
          jQuery('#healthloft-age_ranges-response-url').val(jQuery.parseJSON(response)['age_ranges_url'])
          jQuery('#healthloft-age_ranges-response-cache').val(JSON.stringify(age_ranges_data))
          jQuery('#healthloft-age_ranges-response-cache-date').val(jQuery.parseJSON(response)['age_ranges']['age_ranges_cache_date'])
          jQuery('#healthloft-age_ranges-response-cache-ttl').val(jQuery.parseJSON(response)['age_ranges']['age_ranges_ttl'])

        }
        let msg = jQuery.parseJSON(response)['profile']['msg'];
        jQuery(".alert").text(msg).removeClass("alert-warning").addClass("alert-success").css("display", "block");      

        setTimeout(function() {
            jQuery(".alert").text('The form has been successfully submitted').css("display", "none");
        }, 4000);
        

        
        jQuery("#healthloft-profile-response-cache").attr("readonly","readonly")
        jQuery("#healthloft-profile-response-cache-date").attr("readonly","readonly")
        jQuery("#healthloft-states-response-cache").attr("readonly","readonly")
        jQuery("#healthloft-states-response-cache-date").attr("readonly","readonly")
        jQuery("#healthloft-specialities-response-cache").attr("readonly","readonly")
        jQuery("#healthloft-specialities-response-cache-date").attr("readonly","readonly")
        jQuery("#healthloft-specialities-response-cache-date").attr("readonly","readonly")
        jQuery("#healthloft-age_ranges-response-cache").attr("readonly","readonly")
        jQuery("#healthloft-age_ranges-response-cache-date").attr("readonly","readonly")
      },
      error: function(error) {
          console.log('Error en la solicitud AJAX:', error);
      }
  });
  });
});

jQuery(document).ready(function($) {
  $("#adminmenu .wp-has-submenu").hover(
      function() {
          $(this).find(".wp-submenu").stop(true, true).slideDown();
      },
      function() {
          $(this).find(".wp-submenu").stop(true, true).slideUp();
      }
  );
});