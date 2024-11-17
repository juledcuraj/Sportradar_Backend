<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php'; // Include your database connection

// Get filter parameters from the URL
$sportFilter = isset($_GET['sport']) && $_GET['sport'] !== 'All Sports' ? $_GET['sport'] : '';
$dateFilter = isset($_GET['date']) ? $_GET['date'] : '';

// Base query to fetch event details
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
        WHERE 1=1";

// Add filters to the query if they are provided
if (!empty($sportFilter)) {
    $sql .= " AND m.Sport = ?";
}
if (!empty($dateFilter)) {
    $sql .= " AND m.Date_Venue = ?";
}

$sql .= " ORDER BY m.Date_Venue, m.Time_Venue_UTC";

$stmt = $conn->prepare($sql);

// Bind parameters dynamically based on which filters are set
$bindParams = [];
if (!empty($sportFilter)) {
    $bindParams[] = $sportFilter;
}
if (!empty($dateFilter)) {
    $bindParams[] = $dateFilter;
}

if (count($bindParams) > 0) {
    $stmt->bind_param(str_repeat('s', count($bindParams)), ...$bindParams);
}

$stmt->execute();
$result = $stmt->get_result();

$events = [
    'upcoming' => [],
    'finished' => []
];

$currentDateTime = new DateTime();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventDateTime = new DateTime($row['Date_Venue'] . ' ' . $row['Time_Venue_UTC']);
        if ($eventDateTime > $currentDateTime) {
            $events['upcoming'][] = $row;
        } else {
            $events['finished'][] = $row;
        }
    }
}

// Return events as JSON
header('Content-Type: application/json');
echo json_encode($events);

$conn->close();
?>
