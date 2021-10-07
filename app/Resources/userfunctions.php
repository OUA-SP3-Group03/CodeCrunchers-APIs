<script>
    //now perform a button check for the logout button
    function logout(){
        //initialize the token
        let token = null;
        //get all cookies from the document and split them by ";"
        const cookies = document.cookie.split(';');
        //get all cookies from the cookie array and split them up by
        const cookieArray = cookies.map(cookies => cookies.split('='));

        //loop over all the cookies and see if we have our cookie, if so set the token value
        let i = 0;
        while (i < cookieArray.length) {
            if (cookieArray[i][0].trim() === "codecrunchers") {
                token = cookieArray[i][1];
            }
            i++;
        }
        //DEBUG
        console.log(token);
        const jqxhr = $.post("/api/auth/logout", {type: "web", token: token})
            .done(function (data) {
                //redirect to successful logout location
                window.location.href=data.redirect;
            });
    }
</script>