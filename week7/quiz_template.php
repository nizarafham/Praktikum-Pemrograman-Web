<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Quiz</title>
</head>
<body>
    <div class="container">
        <h1>Quiz</h1>
        <p>Nama: <?= htmlspecialchars($_SESSION['name']) ?> | NIM: <?= htmlspecialchars($_SESSION['nim']) ?></p>
        <form method="post">
            <h2><?= htmlspecialchars($question['question']) ?></h2>
            <?php if ($question['type'] === "multiple-choice"): ?>
                <?php foreach ($question['options'] as $option): ?>
                    <label>
                        <input type="radio" name="answer" value="<?= htmlspecialchars($option) ?>" required>
                        <?= htmlspecialchars($option) ?>
                    </label><br>
                <?php endforeach; ?>
            <?php elseif ($question['type'] === "text"): ?>
                <input type="text" name="answer" required>
            <?php endif; ?>
            <button type="submit"><?= $currentQuestionIndex < count($questions) - 1 ? 'Next' : 'Finish' ?></button>
        </form>
    </div>
</body>
</html>
