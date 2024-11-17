<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php'; // Include your database connection

// Get the current date and time
$currentDateTime = new DateTime();

// Query to fetch event details
$sql = "SELECT 
            m.Match_ID, 
            m.Date_Venue, 
            m.Time_Venue_UTC, 
            m.Sport, 
            t1.Name AS Home_Team, 
            t2.Name AS Away_Team, 
            s.Name AS Stage 
        FROM `Match` m
        JOIN Team t1 ON m.Home_Team_ID_foreignkey = t1.Team_ID
        JOIN Team t2 ON m.Away_Team_ID_foreignkey = t2.Team_ID
        JOIN Stage s ON m.Stage_ID_foreignkey = s.Stage_ID
        ORDER BY m.Date_Venue, m.Time_Venue_UTC";

$result = $conn->query($sql);

$events = [
    'upcoming' => [],
    'finished' => []
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Combine date and time into a single datetime object
        $eventDateTime = new DateTime($row['Date_Venue'] . ' ' . $row['Time_Venue_UTC']);

        // Categorize the event as upcoming or finished
        if ($eventDateTime > $currentDateTime) {
            $events['upcoming'][] = $row; // Upcoming event
        } else {
            $events['finished'][] = $row; // Finished event
        }
    }
}

// Return events as JSON
header('Content-Type: application/json');
echo json_encode($events);

// Close the database connection
$conn->close();
?>
