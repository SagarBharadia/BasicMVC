<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Logs - <?= (isset($title)) ? $title : '' ?></title>
</head>
<body>
    <form action="/logs/php/" method="get">
        <select name="log">
            <?php foreach($pathToLogFiles as $pathToFile): ?>
                <?php 
                    $filePathExploded = explode("/", $pathToFile);
                    $file = array_pop($filePathExploded); 
                ?>
                <option value="<?= $file ?>" <?= ($logFileLoadedName == $file) ? ' selected' : '' ?>><?= $file ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">View Log</button>
    </form>
    <div id="logFileContents">
        <?= $logFileContents ?>
    </div>
    <script>
        setInterval(() => {
            fetch('/logs/php/', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type':'application/x-www-form-urlencoded'
                },
                method: 'post',
                body: 'log=<?= $logFileLoadedName ?>'
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                document.getElementById('logFileContents').innerHTML = data.body;
            })
        }, 2000);
    </script>
</body>
</html>