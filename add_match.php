<?php
include 'db_connection.php'; // Include your database connection

// Fetch data for dropdowns
$teamsResult = $conn->query("SELECT Team_ID, Name FROM Team");
$stagesResult = $conn->query("SELECT Stage_ID, Name FROM Stage");

$teams = $teamsResult->fetch_all(MYSQLI_ASSOC);
$stages = $stagesResult->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $season = $_POST['season'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $sport = $_POST['sport'];
    $home_team_id = $_POST['home_team'];
    $away_team_id = $_POST['away_team'];
    $stage_id = $_POST['stage'];

    // Determine the status: "played" or "scheduled"
    $currentDateTime = new DateTime();
    $eventDateTime = new DateTime("$date $time");
    $status = $eventDateTime < $currentDateTime ? 'played' : 'scheduled';

    // Check if the match already exists
    $checkMatchSQL = "SELECT Match_ID FROM `Match` WHERE Date_Venue = ? AND Time_Venue_UTC = ? AND 
                      Home_Team_ID_foreignkey = ? AND Away_Team_ID_foreignkey = ? AND 
                      Stage_ID_foreignkey = ?";
    
    $stmt = $conn->prepare($checkMatchSQL);
    $stmt->bind_param("sssss", $date, $time, $home_team_id, $away_team_id, $stage_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p>Error: Duplicate match. A match with the same date, time, teams, and stage already exists.</p>";
        $stmt->close();
    } else {
        // Insert the match into the database
        $sql = "INSERT INTO `Match` (Season, Status, Date_Venue, Time_Venue_UTC, Sport, 
                Home_Team_ID_foreignkey, Away_Team_ID_foreignkey, Stage_ID_foreignkey) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssss", $season, $status, $date, $time, $sport, $home_team_id, 
                              $away_team_id, $stage_id);

            if ($stmt->execute()) {
                echo "<p>Match added successfully!</p>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Error preparing statement: " . $conn->error . "</p>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Match</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Add New Match</h1>
    </header>

    <?php include 'nav.php'; ?>

    <main>
        <form action="add_match.php" method="POST">
            <label for="season">Season:</label>
            <select id="season" name="season" required>
                <?php for ($year = 2025; $year <= date("Y") + 5; $year++): ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endfor; ?>
            </select>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="sport">Sport:</label>
            <input type="text" id="sport" name="sport" required>

            <label for="home_team">Home Team:</label>
            <select id="home_team" name="home_team" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team['Team_ID']; ?>"><?php echo htmlspecialchars($team['Name']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="away_team">Away Team:</label>
            <select id="away_team" name="away_team" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team['Team_ID']; ?>"><?php echo htmlspecialchars($team['Name']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="stage">Stage:</label>
            <select id="stage" name="stage" required>
                <?php foreach ($stages as $stage): ?>
                    <option value="<?php echo $stage['Stage_ID']; ?>"><?php echo htmlspecialchars($stage['Name']); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Add Match</button>
        </form>
    </main>
</body>
</html>
