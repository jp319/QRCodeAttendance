
    window.addEventListener('unload', function() {
    // Check if the page is actually being closed (not reloaded)
    if (sessionStorage.getItem('isPageOpen') === 'false') {
    // Use sendBeacon to update the status
    let url = '<?php echo ROOT; ?>logout';
    let data = new URLSearchParams();
    data.append('isClosing', 'true');

    // Use sendBeacon with URLSearchParams as payload
    if (!navigator.sendBeacon(url, data.toString())) {
    // Fallback to AJAX if sendBeacon fails
    fetch(url, {
    method: 'POST',
    headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
},
    body: data.toString()
}).catch((error) => console.error('Error:', error));
}
}
});

