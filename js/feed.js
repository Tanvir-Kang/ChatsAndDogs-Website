var rating;
$(document).ready(function() {
    var origSource;
    var newSource;
    $(".starsImg")
        .on("mousemove", function(event) {
            // This function responsively shows # of stars where user 
            // is mousing over for rating
            var pos = event.pageX - event.target.offsetLeft;
            var chunkSize = event.target.width / 5;
            if (chunkSize * 0 < pos && pos < chunkSize * 1) {
                newSource = "images/star1.png";
                rating = 1;
            } else if (chunkSize * 1 < pos && pos < chunkSize * 2) {
                newSource = "images/star2.png";
                rating = 2;
            } else if (chunkSize * 2 < pos && pos < chunkSize * 3) {
                newSource = "images/star3.png";
                rating = 3;
            } else if (chunkSize * 3 < pos && pos < chunkSize * 4) {
                newSource = "images/star4.png";
                rating = 4;
            } else if (chunkSize * 4 < pos && pos < chunkSize * 5) {
                newSource = "images/star5.png";
                rating = 5;
            }
            $(this).attr("src", newSource);

        })
        .on("mouseenter", function() {
            origSource = $(this).attr("src");
        })
        .on("mouseleave", function() {
            $(this).attr("src", origSource);
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

function setRating(id) { // This function posts what the user has rated back to the feed
    $.post("feed.php", {
            rating: rating,
            postId: id,
            test: 5,
        },
        function() {
            Swal.fire(
                'Rating Received!',
                'You have rated this post.',
                'success'
            );
        });
}