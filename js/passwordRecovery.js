window.onload=function(){
   
    $("#forgotPassword").click(function(){
        $(".holder").empty();
        $(".holder").html("<h1> Password Recovery</h1>");
        $(".holder").append("<form method='POST' action='' enctype='multipart/form-data'>\
        <label id=desc>If the entered username exists a email will be sent to the associated email</label>\
        <input required type='text' name='uname' placeholder='Username' >\
        <input type='submit' name='recoverButton' value='Recover'></input>");
        $("#desc").css('color','white');       
    });
    
    
    }
    