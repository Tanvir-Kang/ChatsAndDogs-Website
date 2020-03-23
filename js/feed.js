$(document).ready(function() {
    var origSource;
    $(".starsImg")
        .on("mousemove", function(event) {
            // This function responsively shows # of stars where user 
            // is mousing over for rating
            var pos = event.pageX - this.offsetLeft;
            var chunkSize = this.width / 5;
            if (chunkSize * 0 < pos && pos < chunkSize * 1)
                $(this).attr("src", "images/star1.png");
            else if (chunkSize * 1 < pos && pos < chunkSize * 2)
                $(this).attr("src", "images/star2.png");
            else if (chunkSize * 2 < pos && pos < chunkSize * 3)
                $(this).attr("src", "images/star3.png");
            else if (chunkSize * 3 < pos && pos < chunkSize * 4)
                $(this).attr("src", "images/star4.png");
            else if (chunkSize * 4 < pos && pos < chunkSize * 5)
                $(this).attr("src", "images/star5.png");

        })
        .on("mouseenter", function() {
            origSource = $(this).attr("src");
        })
        .on("mouseleave", function() {
            $(this).attr("src", origSource);
        })
});

function goToProfile(formId) {
    document.getElementById(formId).submit();
}

function search() { // Search function for feed posts
    var query = $("#search").val().toUpperCase(); // What user has typed
    var posts = $(".post"); // All posts on page
    posts.each(function() {
        if ($(this).find(".title").text().toUpperCase().indexOf(query) == -1) // If query was not found in title of post
            $(this).hide(); // Hide non-matching elements
        else
            $(this).show(); // Show all matching elements
    });
}

function sort() {
    var selection = $("#sort").children("option:selected").val().toLowerCase();
    $("#" + selection).submit();
}