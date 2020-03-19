function goToProfile(formId) {
    document.getElementById(formId).submit();
}

function search() { // Search function for feed posts
    var query = $("#search").val().toUpperCase(); // What user has typed
    var posts = $(".post"); // All posts on page
    posts.each(function(index) {
        if ($(this).find(".title").text().toUpperCase().indexOf(query) == -1) // If query was not found in title of post
            $(this).hide(); // Hide non-matching elements
        else
            $(this).show(); // Show all matching elements
    });
}