$(document).ready(function() {
    var origSource;
    $(".starsImg")
        .on("mousemove", function(event) {
            // This function responsively shows # of stars where user 
            // is mousing over for rating
            var pos = event.pageX - event.target.offsetLeft;
            var chunkSize = event.target.width / 5;
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
        .on("click", function(event) { // This function posts what the user has rated back to the feed
            var pos = event.pageX - event.target.offsetLeft;
            var chunkSize = event.target.width / 5;
            var post = event.target.id;
            var rating = 0;
            if (chunkSize * 0 < pos && pos < chunkSize * 1)
                rating = 1;
            else if (chunkSize * 1 < pos && pos < chunkSize * 2)
                rating = 2;
            else if (chunkSize * 2 < pos && pos < chunkSize * 3)
                rating = 3;
            else if (chunkSize * 3 < pos && pos < chunkSize * 4)
                rating = 4;
            else if (chunkSize * 4 < pos && pos < chunkSize * 5)
                rating = 5;
            $.post("feed.php", {
                    rating: rating,
                    postId: post,
                },
                function(content, status) {});
        })
});

function goToDestination(formId) {
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

function ratingFailed() {
    Swal.fire(
        'Sorry!',
        'You have already rated this post.',
        'error'
    );
}

function ratingSucceed() {
    Swal.fire(
        'Rating Received!',
        'You have rated this post.',
        'success'
    );
}

function topicSelect(topic) { // Function to determine which topics to display based on user feedback, using GET
    var posts = $(".post"); // All posts on page
    posts.each(function() {
        if (topic == "all")
            $(this).show(); // Show all elements
        else if ($(this).attr("id") == topic) // post topic equals user-defined topic
            $(this).show(); // show matching elements
        else
            $(this).hide(); // Hide non-matching elements
    });
}