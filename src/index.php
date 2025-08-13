<?php

if ($_SERVER['REQUEST_URI'] === '/api/data') {
    header('Content-Type: applocation/json');
    echo json_encode(['message' => 'Hello from PHP!', 'time' => date('H:i:s')]);
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP SPA Demo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <h1>PHP SPA Demo</h1>
        <div>
            <a href="#home" onclick="showPage('home')">Home</a>
            <a href="#about" onclick="showPage('about')">About</a>
        </div>
    </nav>

    <main id="content">
        <h2>Welcome!</h2>
        <p>This is a simple PHP SPA demo.</p>
        <button onclick="loadData()">Load API Data</button>
        <div id="result"></div>
    </main>

    <script src="app.js"></script>
</body>
</html>