<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" onclick="toggleNavbar()">☰</button>
        <div class="navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="user.php">Quiz</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
            </ul>
            
        </div>
    </nav>
    <div class="container">
        <h1>Welcome to the Quiz</h1>
        <div id="timer">Time Left: 03:00</div> 
        <a href="user.php">
            <button>Start Quiz</button>
        </a>
        <h2>List of Participants</h2>
        <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>NIM</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['nim']) ?></td>
                            <td><?= htmlspecialchars($row['score']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No participants yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>
