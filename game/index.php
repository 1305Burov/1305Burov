<?php


if( isset( $_POST['start'] ) ) {
    $id = rand(1, 4);
    $conn = new PDO('mysql:host=127.0.0.1;port=3306;dbname=game', 'root', '');
    foreach($conn->query('SELECT * FROM gametasks WHERE id') as $row) {
        if ($id === $row['id'] = (int)$row['id']) {
            echo '<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <form method="post" action="index.php" class="form" >
        <input class="btn" type="submit" name="start" value="Тянуть фант">
    </form>
    <div class="text">';
        echo $m = $row["id"] . " " . $row["task"]."<br>";
   echo '</div>
</div>
</body>
</html>\'';

        }
    };
}

