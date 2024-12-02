document.addEventListener("DOMContentLoaded", function() {
    // Function to fetch and display the results
    function lookupCountries() {
        // Get the country name from the input field
        const country = document.getElementById('country').value.trim();

        // Build the URL for the fetch request
        let url = 'world.php';
        if (country) {
            // If the country field is not empty, append it to the URL
            url += `?country=${encodeURIComponent(country)}`;
        }

        // Create a new AJAX request using the Fetch API
        fetch(url)
            .then(response => {
                // Check if the response is ok (status 200-299)
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Since PHP returns HTML now, we use .text()
            })
            .then(html => {
                // Insert the returned HTML table into the result div
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = html; // Insert the full table HTML directly
            })
            .catch(error => {
                // Display an error message if something went wrong
                console.error('There was a problem with the fetch operation:', error);
                document.getElementById('result').innerHTML = 'An error occurred while fetching the data.';
            });
    }

    // Listen for the 'click' event on the Lookup button
    document.getElementById('lookup').addEventListener('click', lookupCountries);

    // Listen for the 'Enter' key press in the input field
    document.getElementById('country').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission if it's in a form
            lookupCountries(); // Trigger the same action as the button click
        }
    });
});
