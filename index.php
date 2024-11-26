<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск записей по тексту комментария</title>
    <link rel="stylesheet" href="styles.css">
    <div class="logo">
    <img src="../logo.png" alt="">
</div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const alert = document.querySelector(".alert");
            if (alert) {
                // Лог сообщения в консоль
                console.log(alert.textContent.trim());

                // Плавное появление
                setTimeout(() => {
                    alert.classList.add("show");
                }, 100);

                // Установка таймера на скрытие через 5 секунд
                setTimeout(() => {
                    alert.classList.remove("show");
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500); // Удаление элемента
                }, 5000);
            }
        });
    </script>
</head>
<body>
<div class="description2">
    <div class="description">
        <h1>Поиск записей по тексту комментария</h1>
        <!-- Вывод сообщения, если оно существует -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']); // Удаление сообщения после отображения
                ?>
            </div>
        <?php endif; ?>
        <form method="GET" action="scripts/search.php">
            <label for="query">Введите текст для поиска в комментариях:</label>
            <input type="text" id="query" name="query" minlength="3" required>
            <button type="submit">Найти</button>
        </form>
        <a href="scripts/load.php">
            <button>Загрузить данные в базу данных</button>
        </a>
    </div>
</div>
</body>
</html>
