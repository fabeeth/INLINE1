<?php
session_start(); // Запуск сессии
require_once 'connect.php';

try {
    $postsJson = file_get_contents('https://jsonplaceholder.typicode.com/posts');
    $posts = json_decode($postsJson, true);

    $postStmt = $mysqli->prepare("INSERT INTO posts (id, user_id, title, body) VALUES (?, ?, ?, ?)");
    foreach ($posts as $post) {
        $postStmt->bind_param('iiss', $post['id'], $post['userId'], $post['title'], $post['body']);
        $postStmt->execute();
    }

    $commentsJson = file_get_contents('https://jsonplaceholder.typicode.com/comments');
    $comments = json_decode($commentsJson, true);

    $commentStmt = $mysqli->prepare("INSERT INTO comments (id, post_id, name, email, body) VALUES (?, ?, ?, ?, ?)");
    foreach ($comments as $comment) {
        $commentStmt->bind_param('iisss', $comment['id'], $comment['postId'], $comment['name'], $comment['email'], $comment['body']);
        $commentStmt->execute();
    }

    // Сохранение сообщения в сессии
    $_SESSION['message'] = "Загружено " . count($posts) . " записей и " . count($comments) . " комментариев.";
    header('Location: ../index.php'); // Перенаправление на главную страницу
    exit();
} catch (mysqli_sql_exception $e) {
    $_SESSION['message'] = "Ошибка базы данных: " . $e->getMessage();
    header('Location: ../index.php');
    exit();
} catch (Exception $e) {
    $_SESSION['message'] = "Ошибка: " . $e->getMessage();
    header('Location: ../index.php');
    exit();
}
