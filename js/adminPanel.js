function search(method) { // Search function for adminpanel
    if (method == "users") { // If search box is users
        var query = $("#userSearch").val().toUpperCase(); // What user has typed
        var items = $(".userEntry"); // Put users in Items
    } else if (method == "posts") { // If search box is posts
        var query = $("#postSearch").val().toUpperCase(); // What user has typed
        var items = $(".postEntry"); // Put posts in Items
    }
    items.each(function() {
        var match = false; // Will search terms for query match
        $(this).find(".searchTerm").each(function() { // Check all search terms for query
            if ($(this).text().toUpperCase().indexOf(query) >= 0) // If query was found
                match = true;
        })
        if (match == true)
            $(this).show(); // Show all matching elements
        else
            $(this).hide(); // Hide non-matching elements
    })
}