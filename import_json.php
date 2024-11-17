<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php'; // Include your database connection

// Function to add or update a team
function addOrUpdateTeam($conn, $teamName, $officialName, $slug, $abbreviation, $teamCountryCode, $stagePosition) {
    // Insert or update team information
    $sql = "INSERT INTO Team (Name, Official_Name, Slug, Abbreviation, Team_Country_Code, Stage_Position) 
            VALUES (?, ?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE Name=Name, Official_Name=VALUES(Official_Name), 
                                   Slug=VALUES(Slug), Abbreviation=VALUES(Abbreviation), 
                                   Team_Country_Code=VALUES(Team_Country_Code), 
                                   Stage_Position=VALUES(Stage_Position)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $teamName, $officialName, $slug, $abbreviation, $teamCountryCode, $stagePosition);
        $stmt->execute();
        $stmt->close();
    }
}

// Function to add or update stage
function addOrUpdateStage($conn, $stageName) {
    $sql = "INSERT INTO Stage (Stage_ID, Name) VALUES (UUID(), ?) ON DUPLICATE KEY UPDATE Name=Name";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $stageName);
        $stmt->execute();
        $stmt->close();
    }
}

// Function to check if the match exists
function matchExists($conn, $dateVenue, $timeVenueUTC, $homeTeamName, $awayTeamName, $stageName) {
    $sql = "SELECT Match_ID FROM `Match` WHERE Date_Venue = ? AND Time_Venue_UTC = ? AND 
            Home_Team_ID_foreignkey = (SELECT Team_ID FROM Team WHERE Name = ? LIMIT 1) AND 
            Away_Team_ID_foreignkey = (SELECT Team_ID FROM Team WHERE Name = ? LIMIT 1) AND 
            Stage_ID_foreignkey = (SELECT Stage_ID FROM Stage WHERE Name = ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $dateVenue, $timeVenueUTC, $homeTeamName, $awayTeamName, $stageName);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }
    return false;
}

// Load and parse the JSON file
$jsonFile = __DIR__ . '/sportData.json'; // Make sure the JSON file is in the correct directory
$jsonData = file_get_contents($jsonFile);
if ($jsonData === false) {
    die("Error: Failed to open the JSON file. Please check the file path.");
}

$data = json_decode($jsonData, true);
if ($data === null) {
    die("Error decoding JSON: " . json_last_error_msg());
}

$consoleMessages = []; // Array to store messages for the console

// Iterate through the data and insert it into the database
foreach ($data['data'] as $index => $event) {
    $season = $event['season'] ?? null;
    $status = $event['status'] ?? null;
    $timeVenueUTC = $event['timeVenueUTC'] ?? null;
    $dateVenue = $event['dateVenue'] ?? null;
    $stadium = $event['stadium'] ?? null;
    $homeTeamName = $event['homeTeam']['name'] ?? null;
    $homeOfficialName = $event['homeTeam']['officialName'] ?? 'N/A';
    $homeSlug = $event['homeTeam']['slug'] ?? 'N/A';
    $homeAbbreviation = $event['homeTeam']['abbreviation'] ?? 'N/A';
    $homeCountryCode = $event['homeTeam']['teamCountryCode'] ?? 'N/A';
    $homeStagePosition = $event['homeTeam']['stagePosition'] ?? 'N/A';
    
    $awayTeamName = $event['awayTeam']['name'] ?? null;
    $awayOfficialName = $event['awayTeam']['officialName'] ?? 'N/A';
    $awaySlug = $event['awayTeam']['slug'] ?? 'N/A';
    $awayAbbreviation = $event['awayTeam']['abbreviation'] ?? 'N/A';
    $awayCountryCode = $event['awayTeam']['teamCountryCode'] ?? 'N/A';
    $awayStagePosition = $event['awayTeam']['stagePosition'] ?? 'N/A';
    
    $stageName = $event['stage']['name'] ?? null;
    $originCompetitionId = $event['originCompetitionId'] ?? null;
    $originCompetitionName = $event['originCompetitionName'] ?? null;
    $sport = $event['sport'] ?? null;

    if (!$homeTeamName || !$awayTeamName || !$stageName || !$sport) {
        $consoleMessages[] = "Skipping event at index $index due to missing data.";
        continue;
    }

    // Add or update teams and stage
    addOrUpdateTeam($conn, $homeTeamName, $homeOfficialName, $homeSlug, $homeAbbreviation, $homeCountryCode, $homeStagePosition);
    addOrUpdateTeam($conn, $awayTeamName, $awayOfficialName, $awaySlug, $awayAbbreviation, $awayCountryCode, $awayStagePosition);
    addOrUpdateStage($conn, $stageName);

    // Check if the match already exists
    if (matchExists($conn, $dateVenue, $timeVenueUTC, $homeTeamName, $awayTeamName, $stageName)) {
        $consoleMessages[] = "Skipping duplicate event at index $index.";
        continue;
    }

    // Insert the match
    $sql = "INSERT INTO `Match` (Season, Status, Date_Venue, Time_Venue_UTC, Sport, Stadium, 
            Home_Team_ID_foreignkey, Away_Team_ID_foreignkey, Stage_ID_foreignkey, 
            Origin_Competition_ID, Origin_Competition_Name)
            VALUES (?, ?, ?, ?, ?, ?, 
                    (SELECT Team_ID FROM Team WHERE Name = ? LIMIT 1), 
                    (SELECT Team_ID FROM Team WHERE Name = ? LIMIT 1), 
                    (SELECT Stage_ID FROM Stage WHERE Name = ? LIMIT 1), ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssssss", $season, $status, $dateVenue, $timeVenueUTC, $sport, $stadium,
                          $homeTeamName, $awayTeamName, $stageName, $originCompetitionId, $originCompetitionName);
        if (!$stmt->execute()) {
            $consoleMessages[] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$consoleMessages[] = "Data imported successfully!";
$conn->close();
?>
