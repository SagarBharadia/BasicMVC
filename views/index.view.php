<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BasicMVC | Lightweight PHP MVC framework</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400&display=swap" rel="stylesheet">
    <style>
        * {
            -webkit-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Lato', sans-serif;
        }
        main {
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
            height: 100vh;
            min-width: 100vw;
            font-size: 1.4em;
            text-align: center;
        }
        #logo h1 {
            font-weight: 400;
            margin-bottom: 0px;
            text-decoration: underline;
        }
        #logo p {
            margin-top: 0.5em;
            font-weight: 300;
        }
        #links ul {
            list-style: none;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }
        #links ul li {
            margin: 10px 20px;
        }
        #links ul li a {
            color: #000;
            text-decoration: none;
        }
        #links ul li a:hover {
            color: #5E35B1;
        }
    </style>
</head>
<body>
    <main>
        <div id="logo">
            <h1>BasicMVC</h1>
            <p>A lightweight PHP MVC framework.</p>
        </div>
        <div id="links">
            <ul>
                <li><a href="https://github.com/SagarBharadia/BasicMVC" target="_blank">GitHub</a></li>
                <li><a href="https://basicmvc.sagarbharadia.com/docs" target="_blank">Documentation</a></li>
                <li><a href="https://sagarbharadia.com" target="_blank">Sagar Bharadia</a></li>
            </ul>
        </div>
    </main>
</body>
</html>