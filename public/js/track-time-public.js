document.addEventListener('DOMContentLoaded', function () {
    
    'use strict';

    const { ajaxUrl, nonce, currentPageId, trackedPages } = trackTime;
    let storageKey = 'trackedPagesEmail';

    // Function to start tracking time
    function startTracking(startTime) {
		
        window.addEventListener('beforeunload', function () {
            let endTime = Date.now();
            let timeSpent = Math.round((endTime - startTime) / 1000); // Calculate time spent in seconds

            let userActivity = {
                time_spent: timeSpent,
                date_visited: new Date().toISOString() // ISO format for date
            };

            // Prepare data to send
            const data = new URLSearchParams({
                action: 'track_user_activity',
                user_email: localStorage.getItem(storageKey),
				security: nonce, // Include nonce here
                page_id: currentPageId,
                user_activity: JSON.stringify(userActivity)
            });

            // Use Beacon API to send data when the user leaves the page
            navigator.sendBeacon(ajaxUrl, data);
        });
    }

    if (trackedPages.includes(currentPageId)) {
        let startTime = Date.now();
        let storedEmail = localStorage.getItem(storageKey);
        console.log({storedEmail});
        
        if (storedEmail) {
            startTracking(startTime); // Start tracking if email is already stored
        } else {
            let userEmail = prompt("This page is being tracked. Please enter your email:");

            if (userEmail) {
                if (validateEmail(userEmail)) {
                    localStorage.setItem(storageKey, userEmail);
                    alert("Thank you! Your email has been recorded.");
                    startTracking(startTime); // Start tracking immediately after storing email
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
