<?php
include 'db_connection.php'; // Include your database connection

// Check if the match ID is provided in the URL
if (isset($_GET['match_id'])) {
    $matchId = $_GET['match_id'];

    // Query to fetch the event details by Match ID
    $sql = "SELECT 
                m.Date_Venue, 
                m.Time_Venue_UTC, 
                m.Sport, 
                t1.Name AS Home_Team, 
                t2.Name AS Away_Team, 
                s.Name AS Stage, 
                m.Origin_Competition_Name
            FROM `Match` m
            JOIN Team t1 ON m.Home_Team_ID_foreignkey = t1.Team_ID
            JOIN Team t2 ON m.Away_Team_ID_foreignkey = t2.Team_ID
            JOIN Stage s ON m.Stage_ID_foreignkey = s.Stage_ID
            WHERE m.Match_ID = ?";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the match ID to the query
        $stmt->bind_param("i", $matchId);

        // Execute the query
        if ($stmt->execute()) {
            // Bind the results to variables
            $stmt->bind_result($date, $time, $sport, $homeTeam, $awayTeam, $stage, $competitionName);

            // Fetch the data if it exists
            if ($stmt->fetch()) {
                $stmt->close(); // Close the statement
            } else {
                die("No match found for the provided ID.");
            }
        } else {
            die("Error executing query: " . $stmt->error);
        }
    } else {
        die("Error preparing query: " . $conn->error);
    }
} else {
    die("Match ID not provided.");
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <h1>Event Details</h1>
    </header>

    <?php include 'nav.php'; ?>

    <main>
        <div class="event-details">
            <h2>Match Details</h2>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($time); ?></p>
            <p><strong>Sport:</strong> <?php echo htmlspecialchars($sport); ?></p>
            <p><strong>Home Team:</strong> <?php echo htmlspecialchars($homeTeam); ?></p>
            <p><strong>Away Team:</strong> <?php echo htmlspecialchars($awayTeam); ?></p>
            <p><strong>Stage:</strong> <?php echo htmlspecialchars($stage); ?></p>
            <p><strong>Origin Competition:</strong> <?php echo htmlspecialchars($competitionName); ?></p>
        </div>
    </main>
</body>
</html>
