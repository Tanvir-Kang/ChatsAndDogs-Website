

    function reply_click(comment_id){
        $("#"+ comment_id).append("<form id='commentForm' action='#' method='POST' >\
        <label id='commentLabel'>Reply: </label>\
        <textarea name='reply' id='commentBox'></textarea>\
        <input type='hidden' name='parentId' value='"+ comment_id+ " '>\
        <input type='submit' id='ubmitReply' name='submitReply'/>\
        </form>");
     
    }
    function jsfunction(commentParent,commentContent,commentDate,commentAuthor){
        
       $("#"+ commentParent).append( "<article class='reply'>\
       <p class='subComment'>"+ commentContent+"</p>\
       <div class='commentInfo'>\
           <a href='#'><p class='userName'>By: "+commentAuthor+"</p></a>\
           <p>on: "+commentDate+"</p>\
           \
       </div>\
       </article>");
    }
    

    