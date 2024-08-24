document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const { ajaxUrl, nonce, currentPageId, trackedPages } = trackTime;
    let storageKey = 'trackedPagesEmail';

    let elapsedTime = 0;  // Accumulated time spent on the page in milliseconds
    let focusStartTime = Date.now();  // Start tracking as soon as the page loads

    // Function to send data via Beacon API
    function sendBeaconData() {
        if (focusStartTime === null) return; // If focusStartTime is not set, exit

        const endDate = Date.now();
        const timeSpentDuringFocus = endDate - focusStartTime; // Time spent during the last focus period
        elapsedTime += timeSpentDuringFocus;

        let timeSpentInSeconds = Math.round(elapsedTime / 1000); // Convert to seconds

        let userActivity = {
            time_spent: timeSpentInSeconds,
            date_visited: new Date().toISOString()
        };

        // Prepare data to send
        const data = new URLSearchParams({
            action: 'track_user_activity',
            user_email: localStorage.getItem(storageKey),
            security: nonce, // Include nonce here
            page_id: currentPageId,
            user_activity: JSON.stringify(userActivity)
        });

        // Use Beacon API to send data
        navigator.sendBeacon(ajaxUrl, data);

        // Reset focusStartTime and elapsedTime after sending data
        focusStartTime = null;
        elapsedTime = 0;
    }

    // Function to start tracking time
    function startTracking() {

        window.addEventListener('focus', function() {
            focusStartTime = Date.now();  // Start the timer when the page gains focus
        });
        
        window.addEventListener('blur', function() {
            sendBeaconData();  // Send data when the page loses focus
        });

        window.addEventListener('beforeunload', function() {
            sendBeaconData();  // Send data when the page is about to unload
        });
    }

    if (trackedPages.includes(currentPageId)) {
        let storedEmail = localStorage.getItem(storageKey);
        
        if (storedEmail) {
            startTracking(); // Start tracking if email is already stored
        } else {
            let userEmail = prompt("This page is being tracked. Please enter your email:");

            if (userEmail) {
                if (validateEmail(userEmail)) {
                    localStorage.setItem(storageKey, userEmail);
                    alert("Thank you! Your email has been recorded.");
                    this.location.reload();
                } else {
                    alert("Please enter a valid email address.");
                }
            }
        }
    }

    // Email validation function
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email); // Validate email format
    }
});
