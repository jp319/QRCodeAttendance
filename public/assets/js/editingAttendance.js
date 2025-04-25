function setAction(action, event) {
    event.preventDefault();

    let message;
    message = `Are you sure you want to ${action} the attendance?`;


    if (confirm(message)) {
        document.getElementById('action').value = action;
        console.log("Selected action:", action); // Debugging check
        document.getElementById('attendanceForm').submit();
    } else {
        console.log("Action cancelled");
    }
}



// Function to handle the "Start Attendances" button
function startAttendance() {
    // Retrieve the event ID from the form field
    const eventId = document.getElementById('atten_id').value;

    if (!eventId) {
        alert('Please provide an Attendances ID.');
        return;
    }

    // Send an AJAX request to the PHP script
    fetch('<?php echo ROOT ?>/update_attendance', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ eventId: eventId, action: 'start' }), // Send the event ID and action
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message); // Show success message
            } else {
                alert(data.message); // Show error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while starting attendance.');
        });
}





