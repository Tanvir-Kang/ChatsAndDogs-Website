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

function conf(caller, id) {
    var element = $(caller);
    var del = false;
    if (element.text() === "Remove") { // If post was selected for removal
        var title = element.parent().parent().next().find(".searchTerm").text();
        swalConfirm("Are you sure you would you like to delete \"" + title + "\"?", function(del) {
            if (del == true) {
                $.post("adminPanel.php", {
                        postId: id,
                    },
                    function(content, status) {
                        if (status == "success") {
                            Swal.fire(
                                'Success!',
                                'The post has been deleted.',
                                'success'
                            )
                            element.parent().parent().parent().parent().hide();
                        } else
                            Swal.fire(
                                'Error',
                                'Something went wrong!',
                                'error'
                            )
                    });
            }
        });
    } else if (element.text() === "Disable" || element.text() === "Enable") { // If user was selected for disabling
        var prevText = element.text();
        var newText = "";
        if (prevText === "Disable")
            newText = "Enable";
        else
            newText = "Disable";
        swalConfirm("Are you sure you would you like to " + prevText.toLowerCase() + " \"" + id +
            "\"?",
            function(del) {
                if (del == true) {
                    $.post("adminPanel.php", {
                            username: id,
                        },
                        function(content, status) {
                            if (status == "success") {
                                element.text(newText);
                                Swal.fire(
                                    'Success!',
                                    'User has been ' + prevText.toLowerCase() + 'd.',
                                    'success'
                                )
                            } else
                                Swal.fire(
                                    'Error',
                                    'Something went wrong!',
                                    'error'
                                )
                        });
                }
            });

    }
}

function swalConfirm(text, callback) {
    Swal.fire({
        title: 'Are you sure?',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        callback(result.value);
    })
}