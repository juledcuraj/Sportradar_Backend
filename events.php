<?php include 'nav.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportradar</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>
<body>
    <header>
        <h1>Sportradar</h1>
    </header>

    <main>
        <div class="header-with-button">
            <h2>All Events</h2>
            <a href="add_match.php" class="button">Add Event</a> <!-- Add Event Button -->
        </div>

        <!-- Upcoming Events Section -->
        <br><h3>Upcoming Events</h3>
        <table id="upcoming-events-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Sport</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Stage</th>
                    <th>Details</th> <!-- Add a new column for the "Details" button -->
                </tr>
            </thead>
            <tbody>
                <!-- Upcoming events will be inserted here -->
            </tbody>
        </table>

        <!-- Finished Events Section -->
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
                    <th>Details</th> <!-- Add a new column for the "Details" button -->
                </tr>
            </thead>
            <tbody>
                <!-- Finished events will be inserted here -->
            </tbody>
        </table>
    </main>

    <script>
        // Fetch events from the get_events.php endpoint
        fetch('get_events.php')
            .then(response => response.json())
            .then(events => {
                const upcomingTableBody = document.querySelector('#upcoming-events-table tbody');
                const finishedTableBody = document.querySelector('#finished-events-table tbody');

                if (events.upcoming.length > 0) {
                    events.upcoming.forEach(event => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${event.Date_Venue}</td>
                            <td>${event.Time_Venue_UTC}</td>
                            <td>${event.Sport}</td>
                            <td>${event.Home_Team}</td>
                            <td>${event.Away_Team}</td>
                            <td>${event.Stage}</td>
                            <td><a href="eventdetails.php?match_id=${event.Match_ID}" class="button">Open</a></td>
                        `;
                        upcomingTableBody.appendChild(row);
                    });
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="7">No upcoming events found.</td>`;
                    upcomingTableBody.appendChild(row);
                }

                if (events.finished.length > 0) {
                    events.finished.forEach(event => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${event.Date_Venue}</td>
                            <td>${event.Time_Venue_UTC}</td>
                            <td>${event.Sport}</td>
                            <td>${event.Home_Team}</td>
                            <td>${event.Away_Team}</td>
                            <td>${event.Stage}</td>
                            <td><a href="eventdetails.php?match_id=${event.Match_ID}" class="button">Open</a></td>
                        `;
                        finishedTableBody.appendChild(row);
                    });
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="7">No finished events found.</td>`;
                    finishedTableBody.appendChild(row);
                }
            })
            .catch(error => console.error('Error fetching events:', error));
    </script>
</body>
</html>
