<?php
include 'nav.php';
include 'db_connection.php'; // Include your database connection

// Fetch distinct sports from the database
$sportsQuery = "SELECT DISTINCT Sport FROM `Match`";
$sportsResult = $conn->query($sportsQuery);

$sports = [];
if ($sportsResult && $sportsResult->num_rows > 0) {
    while ($row = $sportsResult->fetch_assoc()) {
        $sports[] = $row['Sport'];
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
    <title>Sports Events Calendar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Sports Events Calendar</h1>
    </header>

    <main>
        <div class="header-with-button">
            <h2>All Events</h2>
            <div class="button-and-filters">
                <a href="add_match.php" class="open-event-button">Add Event</a>
                <div class="filter-options">
                    <label for="sport-filter" class="filter-label">Sport:</label>
                    <select id="sport-filter" class="filter-select">
                        <option value="All Sports">All Sports</option>
                        <?php foreach ($sports as $sport): ?>
                            <option value="<?php echo htmlspecialchars($sport); ?>"><?php echo htmlspecialchars($sport); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="date-filter" class="filter-label">Date:</label>
                    <input type="date" id="date-filter" class="filter-input">

                    <button id="apply-filters" class="filter-button">Apply Filters</button>
                </div>
            </div>
        </div>

        <h3>Upcoming Events</h3>
        <table id="upcoming-events-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Sport</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Stage</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <!-- Upcoming events will be inserted here -->
            </tbody>
        </table>

        <h3>Finished Events</h3>
        <table id="finished-events-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Sport</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Stage</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <!-- Finished events will be inserted here -->
            </tbody>
        </table>
    </main>

    <script src="scripts.js"></script>
</body>
</html>

