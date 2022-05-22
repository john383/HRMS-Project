<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>Page Not Found</title>
        <style>
            @import url("Css/css2.css");

            * {
                margin: 0;
                padding: 0;
                outline: none;
                box-sizing: border-box;
                font-family: "Poppins", sans-serif;
            }
            body {
                background: #19B5FE;

                background-image: url(images/pattern.png);
                background-position: center;
                background-repeat: none;
                /* background: -webkit-repeating-linear-gradient(-45deg, #71b7e6, #69a6ce, #b98acc, #69a6ce, #9b59b6); */
                height: 100vh;
                /* background-size: 400%; */
            }
            .error-page {
                position: absolute;
                top: 10%;
                left: 17%;
                right: 17%;
                bottom: 10%;
                display: flex;
                align-items: center;
                justify-content: center;
                /* background-image: url(images/); */
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0, 1);
            }
            .error-page .content {
                max-width: 600px;
                text-align: center;
            }
            .content h1 {
                font-size: 18vw;
                line-height: 1em;
                position: relative;
            }
            .content h1:after {
                position: absolute;
                content: attr(data-text);
                top: 0;
                left: 0;
                right: 0;
                background: -webkit-repeating-linear-gradient(-45deg, #71b7e6, #69a6ce, #b98acc, #69a6ce, #9b59b6);
                background-size: 400%;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.25);
                animation: animate 10s ease-in-out infinite;
            }
            .content h4 {
                margin-bottom: 20px;
                text-transform: uppercase;
                color: #000;
                max-width: 600px;
                font-size: 2em;
            }
            .content p {
                font-size: 1.2em;
                color: #0d0d0d;
            }
            .content .btns {
                margin: 25px 0;
                display: inline-flex;
            }
            .content .btns a {
                display: inline-block;
                margin: 0 10px;
                text-decoration: none;
                border: 2px solid #0a2558;
                color: #0a2558;
                font-weight: 500;
                padding: 10px 25px;
                border-radius: 25px;
                text-transform: uppercase;
                transition: all 0.3s ease;
            }
            .content .btns a:hover {
                color: #fff;
                background: #0a2558;
            }
        </style>
    </head>
    <body>
        <div class="error-page">
            <div class="content">
                <img src="images/error.png" alt="">
                <!-- <h1 data-text="404">404</h1> -->
                <h4 data-text="Opps! Page not found">Opps! Page Not Found</h4>
                <p>Sorry, the page you're looking for doesn't exist.</p>
                <div class="btns">
                    <a href="javascript:history.go(-1)">Back</a>
                </div>
            </div>
        </div>
    </body>
</html>
