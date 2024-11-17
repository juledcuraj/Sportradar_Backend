// Function to fetch events and display them in the tables
function fetchEvents(filters = '') {
    fetch('get_events.php?' + filters)
        .then(response => response.json())
        .then(events => {
            const upcomingTableBody = document.querySelector('#upcoming-events-table tbody');
            const finishedTableBody = document.querySelector('#finished-events-table tbody');

            upcomingTableBody.innerHTML = '';  // Clear previous rows
            finishedTableBody.innerHTML = '';  // Clear previous rows

            // Display upcoming events
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
                        <td><a href="eventdetails.php?match_id=${event.Match_ID}" class="open-event-button">Open</a></td>
                    `;
                    upcomingTableBody.appendChild(row);
                });
            } else {
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="7">No upcoming events found.</td>`;
                upcomingTableBody.appendChild(row);
            }

            // Display finished events
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
                        <td><a href="eventdetails.php?match_id=${event.Match_ID}" class="open-event-button">Open</a></td>
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
}

// Fetch all events initially (no filters applied)
fetchEvents();

// Apply filters when the button is clicked
document.getElementById('apply-filters').addEventListener('click', function() {
    const sport = document.getElementById('sport-filter').value;
    const date = document.getElementById('date-filter').value;

    // Build the filter query parameters
    const filters = new URLSearchParams({
        sport: sport,
        date: date
    }).toString();

    // Fetch filtered events
    fetchEvents(filters);
});
