<?php include 'import_json.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportradar</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Output PHP messages to the console
        const messages = <?php echo json_encode($consoleMessages); ?>;
        messages.forEach(message => console.log(message));
    </script>
</head>
<body>
    <header>
        <h1>Sportradar</h1>
    </header>

    <?php include 'nav.php'; ?>

    <!-- Content for the welcome page -->
    <main class="main-content">
        <div class="welcome-section">
            <h2>Welcome to Sportradar</h2>
            <p>Explore and add new sports events easily. Track upcoming games, check their details, and stay up-to-date with your favorite sports!</p>
        </div>

        <div class="what-you-can-do">
            <p><strong>What you can do:</strong></p>
            <ul>
                <li>View upcoming sports events</li>
                <li>Get detailed information on each match</li>
                <li>Manage events and add new ones</li>
            </ul>
        </div>

        <a href="events.php" class="button">View Upcoming Events</a>
    </main>
</body>
</html>
