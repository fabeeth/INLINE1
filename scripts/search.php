<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск</title>
    <link rel="stylesheet" href="../styles.css">
    <div class="logo">
        <img src="../logo.png" alt="">
    </div><br>
    <a href="../"><button>Назад</button></a>
</head>
<body>

</body>
</html>
<?php
require_once 'connect.php';

if (isset($_GET['query']) && strlen($_GET['query']) >= 3) {
    $query = $_GET['query'];

    try {
        $stmt = $mysqli->prepare(
            "SELECT posts.title, comments.body 
             FROM comments 
             JOIN posts ON comments.post_id = posts.id 
             WHERE comments.body LIKE ?"
        );
        $likeQuery = '%' . $query . '%';
        $stmt->bind_param('s', $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        $numResults = $result->num_rows; // Подсчёт результатов

        if ($numResults > 0) {
            echo "<h1>Результаты:</h1>";
            echo "<p>Найдено результатов: <strong>$numResults</strong></p>"; // Вывод количества результатов
            while ($row = $result->fetch_assoc()) {
                echo "<div class='description2'>";
                echo "<div class='description'>";
                echo "<h2>Заголовок сообщения: " . htmlspecialchars($row['title']) . "</h2>";
                echo "<p>Комментарий: " . htmlspecialchars($row['body']) . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Нет результатов для '<strong>" . htmlspecialchars($query) . "</strong>'</p>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<p>Введите не менее 3 символов</p>";
}
?>
