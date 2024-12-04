<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['nim'])) {
    header('Location: index.php');
    exit();
}

$questions = [
    [
        "question" => "What is 2 + 2?",
        "type" => "multiple-choice",
        "options" => ["3", "4", "5", "6"],
        "answer" => "4",
        "points" => 5
    ],
    [
        "question" => "What is the capital of France?",
        "type" => "text",
        "answer" => "Paris",
        "points" => 5
    ]
];

$currentQuestionIndex = isset($_SESSION['currentQuestionIndex']) ? $_SESSION['currentQuestionIndex'] : 0;
$totalPoints = isset($_SESSION['totalPoints']) ? $_SESSION['totalPoints'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answer = $_POST['answer'];
    $question = $questions[$currentQuestionIndex];
    
    if ($answer === $question['answer']) {
        $totalPoints += $question['points'];
    }

    $_SESSION['totalPoints'] = $totalPoints;

    if ($currentQuestionIndex < count($questions) - 1) {
        $_SESSION['currentQuestionIndex'] = ++$currentQuestionIndex;
    } else {
        header('Location: result.php');
        exit();
    }
}

$question = $questions[$currentQuestionIndex];

require 'quiz_template.php';
