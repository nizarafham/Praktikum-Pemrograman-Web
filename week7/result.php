<?php
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['nim']) || !isset($_SESSION['totalPoints'])) {
    header('Location: index.php');
    exit();
}

$totalPoints = $_SESSION['totalPoints'];
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 80%;
    max-width: 600px;
    margin: auto;
}

h1 {
    color: #333;
}

p {
    color: #555;
}

button {
    background-color: #007BFF;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
}

.result-item {
    background-color: #fafafa;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin: 10px 0;
    text-align: left;
}

.result-item p {
    margin: 5px 0;
}

hr {
    margin: 20px 0;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Quiz Result</h1>
        <p>Nama: <?= htmlspecialchars($_SESSION['name']) ?> | NIM: <?= htmlspecialchars($_SESSION['nim']) ?></p>
        <p>Total Points: <?= $totalPoints ?></p>
        <a href="index.php"><button>Main Ulang</button></a>
    </div>
</body>
</html>
