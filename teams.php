<?php
include 'db_connection.php'; // Include your database connection

// Query to fetch team details
$sql = "SELECT Name, Official_Name, Slug, Abbreviation, Team_Country_Code, Stage_Position FROM Team";
$result = $conn->query($sql);

$teams = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Replace NULL with 'N/A' for display purposes
        $row['Official_Name'] = $row['Official_Name'] ?: 'N/A';
        $row['Slug'] = $row['Slug'] ?: 'N/A';
        $row['Abbreviation'] = $row['Abbreviation'] ?: 'N/A';
        $row['Team_Country_Code'] = $row['Team_Country_Code'] ?: 'N/A';
        $row['Stage_Position'] = $row['Stage_Position'] ?: 'N/A';
        
        $teams[] = $row;
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
    <title>Teams</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <h1>Teams</h1>
    </header>

    <?php include 'nav.php'; ?>

    <main>
        <div class="teams-container">
            <?php if (count($teams) > 0): ?>
                <?php foreach ($teams as $team): ?>
                    <div class="team-card">
                        <h3><?php echo htmlspecialchars($team['Name']); ?></h3>
                        <p><strong>Official Name:</strong> <?php echo htmlspecialchars($team['Official_Name']); ?></p>
                        <p><strong>Slug:</strong> <?php echo htmlspecialchars($team['Slug']); ?></p>
                        <p><strong>Abbreviation:</strong> <?php echo htmlspecialchars($team['Abbreviation']); ?></p>
                        <p><strong>Country Code:</strong> <?php echo htmlspecialchars($team['Team_Country_Code']); ?></p>
                        <p><strong>Stage Position:</strong> <?php echo htmlspecialchars($team['Stage_Position']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No teams found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
