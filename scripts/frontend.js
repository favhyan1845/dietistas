// Get URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    let regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    let results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Function to get the correct age text from the agesCode function
function getAgeTextFromCode(ageCode) {
    const ageMapping = {
        1: 'Infant (0-24 months)',
        3: 'Pediatric (2-11)',
        13: 'Adolescent (12-18)',
        20: 'Adult (19-69)',
        70: 'Older Adult (70+)',
    };
    return ageMapping[ageCode] || null;
}

function getCodeFromAgeText(ageText) {
    const ageMapping = {
        1: 'Infant (0-24 months)',
        3: 'Pediatric (2-11)',
        13: 'Adolescent (12-18)',
        20: 'Adult (19-69)',
        70: 'Older Adult (70+)',
    };
    return ageMapping[ageText] || null;
}

// Define selectedTags as a global variable
var selectedTags = [];

// Get current URL once for reuse
var currentUrl = new URL(window.location.href);

// Parse URL parameters on page load
var urlParams = new URLSearchParams(window.location.search);

// Check if 'state' parameter exists in the URL
if (urlParams.has('state')) {
    let state = urlParams.get('state');
        $('#states').val(state); // Set the state value without triggering the change event
}

// Check if 'ageRange' parameter exists in the URL
if (urlParams.has('ageRange')) {
    let ageCode = urlParams.get('ageRange');
        $('#ages').val(ageCode); // Set the age range value without triggering the change event
}

// Check if 'tags' parameter exists in the URL and set the selected tags
if (urlParams.has('tags')) {
    let tags = urlParams.get('tags');
    selectedTags = tags.split(',').filter(tag => tag !== 'all'); // Exclude 'all' from tags
    updateSelectedTagsDisplay();
}

// Define selectedTags as a global variable
var selectedTags = [];
var currentUrl = new URL(window.location.href);
var hasRedirected = false;

// Attach change event handlers for filters (only triggered by user interaction)
$('.selects-content #states, .selects-content #ages').on('change', function () {
    hasRedirected = false; 
    runAllFilters(1); // Reset to page 1 on filter change
});

// Event to handle tag selection from dropdown
$('#dropdownContent').on('click', 'a', function () {
    var value = $(this).data('value');
    if (typeof value === 'string' && value.toLowerCase() !== 'all') {
        var selectedTag = value.replace(/ /g, '-');
        if (!selectedTags.includes(selectedTag)) {
            selectedTags.push(selectedTag);
            hasRedirected = false; 
            runAllFilters(1);
            $('#dropdownContent a[data-value="' + selectedTag + '"]').remove();
        }
    }
});

// Event to remove selected tag and update the URL
$('.selects-content #selectedItems').on('click', 'button', function () {
    var value = $(this).data('value');
    const index = selectedTags.indexOf(value);
    if (index > -1) {
        selectedTags.splice(index, 1);
        hasRedirected = false; 
        runAllFilters(selectedTags.length === 0 ? 1 : currentPage); // Reset to page 1 if all tags removed
    }
});

$(document).ready(function () {        
    // Get the current page number from the URL
    const currentPageMatch = currentUrl.pathname.match(/\page\/(\d+)/);
    const currentPage = currentPageMatch ? currentPageMatch[1] : 1;
    hasRedirected = true; 
    runAllFilters(currentPage);
});
function runAllFilters(page = 1) {

    let state = $('#states').val();
    let ages = $('#ages').val();
    
    if  (typeof state !== 'undefined' && state !== '' && 
        typeof ages !== 'undefined' && ages !== '') {     

    let baseUrl = currentUrl.origin + currentUrl.pathname.replace(/\page\/\d+\/?/, '');
    let queryParams = [];
    let request = baseUrl + 'page/' + page + '/'; 

    queryParams.push('state=' + encodeURIComponent(state).toLowerCase());
    queryParams.push('ageRange=' + encodeURIComponent(ages));    
    // Add tags filter if there are selected tags

    if (selectedTags.length > 0) {
        $('.selected-items span').each(function() {
            const spanValue = $(this).text(); 
            selectedTags.push(encodeURIComponent(spanValue.toLowerCase().replace(/\s+/g, '-')));
        });  
        
            let tagsString = Array.from(new Set(selectedTags)).join(',');
            
            if (tagsString) {
                queryParams.push('tags=' + encodeURIComponent(tagsString));
            }
    }else{   
        // Loop through each span element in selected-items to collect tags
            $('.selected-items span').each(function() {
                const spanValue = $(this).text().toLowerCase().replace(/\s+/g, '-');
                const encodedTag = encodeURIComponent(spanValue);

                // Only add the tag if it doesn't already exist in selectedTags
                if(encodedTag != 'all'){
                    if (!selectedTags.includes(encodedTag)) {
                            selectedTags.push(encodedTag);
                    }
                }
            });

            if (selectedTags.length === 0) {
                    queryParams.push('tags=all');
            }else{
                // Use a Set to ensure unique tags and create a comma-separated string
                let uniqueTagsString = Array.from(new Set(selectedTags)).join(',');

                // Remove any existing tags= parameters from queryParams
                queryParams = queryParams.filter(param => !param.startsWith('tags='));

                // Add the new tags parameter if uniqueTagsString is not empty
                if (uniqueTagsString) {   
                    queryParams.push('tags=' + uniqueTagsString);
                } 

            }
        } 
        

        if (queryParams.length > 0) {
            request += '?' + queryParams.join('&');
        } 

        let Url = new URL(window.location.href);
        
        if(Url.searchParams.size == 0){
            hasRedirected = false;     
            window.location.href = request;   
        }
        
        if(Url.searchParams.size == 0){
            hasRedirected = true;            
        }
        if (hasRedirected) return;
        // Redirect only if it's a new URL
        
        hasRedirected = true;
        window.location.href = request;     
    }
}

// Pagination event
$('.pagination').on('click', 'a', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    hasRedirected = false; 
    runAllFilters(page);
});

// Function to capitalize the first letter of each word in a string
function toTitleCase(str) {
    return str
        .toLowerCase()
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
}

// Function to update the UI with selected tags
function updateSelectedTagsDisplay() {    
    $('#selectedItems').empty();
    selectedTags.forEach(function(tag) {
        const formattedTag = toTitleCase(tag.replace(/\-/g, ' ')); // Replace dashes with spaces and capitalize
        formaterButton(formattedTag);
        formaterButtonClearAll();
    });
}

// Show the options when hovering over the dropdown.
$('#Dropdown').on('click', function(e) {
    e.preventDefault();
    $('#dropdownContent').toggle();
    }
);

// Handle the selection of options.
$('#dropdownContent').on('click', 'a', function(e) {
    e.preventDefault(); // Prevent default link behavior
    const value = $(this).data('value'); // Get the value of the clicked option
    
    
    // Check if the value is already in selectedItems
    if ($('#selectedItems').find(`div[data-value="${value}"]`).length) {
        // Option already selected, do not add again
        return; // Exit the function if the item is already selected
    }
    
    let selectedItem = formaterButton(value); // Create a button for the selected tag
    
    // Update the HTML to show the clear all button.
    formaterButtonClearAll();
    // Add the selected item to the selectedItems container.
    $('#selectedItems').append(selectedItem);

    // Remove the selected option from the dropdown content.
    $(this).remove(); // This removes the selected option from the dropdown.

    // Hide the dropdown after selection.
    $('#dropdownContent').hide(); // Close the dropdown
});

// Function to remove a selected item and return it to the dropdown.
$('#selectedItems').on('click', 'button', function() {        
    const valueToRemove = $(this).data('value'); // Get the value of the item being removed.
    const textToReturn = $(this).siblings('span').text(); // Get the text of the item to return.
    
    // Call the function to get the currently selected values
    let selectedOptions = getSelectedItems(); // Get all selected items
    
    // Add the option back to the dropdown content at the beginning if it has text
    if (textToReturn !== "") {
        if (selectedOptions.length == 0) {
            // Update the dropdown prompt if no items are selected
            $('.select-choose').html('All'); 
        }
        
        const optionToAddBack = `<a href="#" data-value="${valueToRemove}">${textToReturn}</a>`; // Create the option HTML
        $('#dropdownContent').prepend(optionToAddBack); // Add the option back to the beginning of the dropdown
    } else {
        // If there are no specific items to return, loop through all selected options
        $.each(selectedOptions, function(index, textReturnAll) {
            const optionToAddBack = `<a href="#" data-value="${textReturnAll}">${textReturnAll}</a>`; // Create option HTML
            $('#dropdownContent').prepend(optionToAddBack); // Add option back to the dropdown
        });
        
        // Remove all selected items from the UI and reset the prompt
        $('.selected-item').remove();
        $('.select-choose').html('All');
    }

    // Remove the selected item from the selectedItems container.
    $(this).parent('.selected-item').remove(); // Remove the selected item from the displayed list
});

// Function to retrieve the selected items' values
function getSelectedItems() {
    const selectedItemsContainer = document.querySelector('.selected-items'); // Get the selected items container
    const selectedItems = selectedItemsContainer.querySelectorAll('.selected-item span'); // Get all selected item spans

    let selectedValues = []; // Initialize an array to hold the selected values

    // Loop through each selected item and add its text content to the selectedValues array
    selectedItems.forEach(item => {
        selectedValues.push(item.textContent);
    });

    return selectedValues.reverse(); // Return the values in reverse order
}
// Function to update the dropdown based on selected items
function updateDropdown() {
    // Get the selected values
    let selectedValues = [];
    $('#selectedItems .selected-item span').each(function() {
        selectedValues.push($(this).text());
    });

    // Update the dropdown
    $('#dropdownContent a').each(function() {
        let optionText = $(this).text();
        if (selectedValues.includes(optionText)) {
            $(this).hide(); // Hide if it's selected
        } else {
            $(this).show(); // Show if it's not selected
        }
    });
}

// Call the function when the page loads
updateDropdown();

// Event to handle the removal of a selected item
$(document).on('click', '.select__multi-value__remove', function() {
    // Remove the selected item from the DOM
    $(this).closest('.selected-item').remove();
    updateDropdown(); // Update the dropdown

    // Get the value of the element that was removed
    let valueToRemove = $(this).data('value');
    let currentUrl = new URL(window.location.href);
    
    // Get the current values of state, ageRanges, and tags from the URL
    let state = currentUrl.searchParams.get("state");
    let ageRange = currentUrl.searchParams.get("ageRange");
    let tags = currentUrl.searchParams.get("tags");

    if (tags) {
        let tagsArray = tags.split(',');
        let valueToRemoveFormatted = valueToRemove.toLowerCase().replace(/\s+/g, '-');
        tagsArray = tagsArray.filter(tag => tag.toLowerCase() !== valueToRemoveFormatted);
        let newTags = tagsArray.join(',');

        // Update the URL based on whether tags array has values
        if (tagsArray.length > 0) {
            currentUrl.searchParams.set("tags", newTags);
        } else {
            currentUrl.searchParams.set("tags", 'all'); // Set to 'all' if no tags
        }

        currentUrl.pathname = currentUrl.pathname.replace(/\page\/\d+/, 'page/1');

        // Clear query parameters if state, ageRange, and tags are all 'all'
        if (state === 'all' && ageRange === 'all' && currentUrl.searchParams.get("tags") === 'all') {
            currentUrl.search = ''; // Clear all query parameters
        }
        // Replace the URL in the address bar without reloading the page
        window.location.href = currentUrl.href;
    }
});



// Helper function to format and append a tag button to the UI
function formaterButton(formattedTag) {
    // Append a new selected item to the selectedItems container
    $('#selectedItems').append(
        '<div class="selected-item">' +
            '<span>' + formattedTag + '</span>' +
            '<button role="button" class="select__multi-value__remove css-1wegy39" ' +
            'aria-label="Remove ' + formattedTag + '" data-value="' + formattedTag + '">' +
                '<svg height="14" width="14" viewBox="0 0 20 20" aria-hidden="true" focusable="false" class="css-8mmkcg">' +
                    '<path fill="white" d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.029c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"></path>' +
                '</svg>' +
            '</button>' +
        '</div>'
    );
}
//button to clean all tags
function formaterButtonClearAll(){    
    $('.select-choose').html(
        '<button role="button" id="clearAll" class="select__indicator select__clear-indicator css-1xc3v61-indicatorContainer" aria-hidden="true"><svg height="20" width="20" viewBox="0 0 20 20" aria-hidden="true" focusable="false" class="css-8mmkcg"><path d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.029c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"></path></svg></button>'
    );
}