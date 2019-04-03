<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Debug - <?= (isset($title)) ? $title : '' ?></title>
</head>
<body>
    <form action="/logs/debug/" method="get">
        <select name="debug">
            <?php foreach($pathToDebugFiles as $pathToFile): ?>
                <?php 
                    $filePathExploded = explode("/", $pathToFile);
                    $file = array_pop($filePathExploded); 
                ?>
                <option value="<?= $file ?>" <?= ($debugFileLoadedName == $file) ? ' selected' : '' ?>><?= $file ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">View Debug File</button>
    </form>
    <div id="debugFileContents">
        <?= $debugFileContents ?>
    </div>
    <script>
        setInterval(() => {
            fetch('/logs/debug/', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type':'application/x-www-form-urlencoded'
                },
                method: 'post',
                body: 'debug=<?= $debugFileLoadedName ?>'
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                document.getElementById('debugFileContents').innerHTML = data.body;
            })
        }, 2000);
    </script>
</body>
</html>