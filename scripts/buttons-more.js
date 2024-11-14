function showMore(id) {

    let selector = '#tags-text-'+id;
    let base64String = $(selector).val(); 
    let decodedString = atob(base64String);
    let allTags = JSON.parse(decodedString);

    // Select the correct container using the passed ID
    const container = $('#tags-container-' + id);

    // Get the number of tags already present
    const currentCount = container.find('.tag-item').length;

    // Limit based on the total number of tags
    const limit = allTags.length;

    // Add the remaining tags to the container
    for (let i = currentCount; i < currentCount + limit && i < allTags.length; i++) {
        const tagDiv = $('<div></div>')
            .addClass('mb-2 mr-2 rounded-full bg-cobalt px-3 py-1 text-xs font-semibold text-white tag-item')
            .text(allTags[i]['name']);
        container.append(tagDiv);
    }

    // Add the 'Show less' button
    container.append('<a class=\"flex cursor-pointer items-center text-sm text-gray-500 underline hover:opacity-80\" id=\"show-less-btn-' + id + '\" href=\"javascript:showLess(' + id + ')\" style=\"color: #666;\">Show less</a>');
    
    // Remove the 'Show more' button
    $('#show-more-btn-' + id).remove();
    $('#show-less-btn-' + id).css('display', 'block');
}

function showLess(id) {

    let selector = '#tags-text-'+id;
    let base64String = $(selector).val(); 
    let decodedString = atob(base64String);
    let allTags = JSON.parse(decodedString); 

    // Select the correct container using the passed ID
    const container = $('#tags-container-' + id);

    // Get the number of tags already present
    const currentCount = container.find('.tag-item').length;

    // Define the limit, removing 8 tags
    const limit = allTags.length - 8;

    // Remove the extra tags
    if (currentCount > 0) {
        for (let i = 0; i < limit && currentCount - i - 1 >= 0; i++) {
            container.find('.tag-item').last().remove();
        }
    }

    // If no tags are visible, hide the 'Show less' button
    if (container.find('.tag-item').length === 0) {
        $('#show-less-btn-' + id).hide();
    }

    // Remove the 'Show less' button and show the 'Show more' button
    $('#show-less-btn-' + id).remove();
    $('#show-more-btn-' + id).css('display', 'block');

    // Add the 'Show more' button again
    container.append('<a class=\"flex cursor-pointer items-center text-sm text-gray-500 underline hover:opacity-80\" id=\"show-more-btn-' + id + '\" href=\"javascript:showMore(' + id + ')\" style=\"color: #666;\">Show more</a>');
}


