<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/mobile/1.3.0-beta.1/jquery.mobile-1.3.0-beta.1.js"></script>
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.3.0-beta.1/jquery.mobile-1.3.0-beta.1.css">
        <link rel="stylesheet" type="text/css" href="/css/result-light.css">
        <title> by Palestinian</title>     

        <script type='text/javascript'>
            $(window).load(function(){
                $(window).on("navigate", function (event, data) {
                    var direction = data.state.direction;
                    if ( !! direction) {
                        alert(direction);
                    }
                });
            });
        </script>  
    </head>
    <body>
        <div data-role="page" id="p1">
          <a href="#p2">goto page 2</a> and then use browser's navigation.
        </div>
        <div data-role="page" id="p2">Page 2</div>
    </body>
</html>


