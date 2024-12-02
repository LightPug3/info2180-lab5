document.addEventListener("DOMContentLoaded", function() {
    // function to fetch and display results:
    function lookupCountries() {
        const country = document.getElementById('country').value.trim();

        // URL for the fetch request:
        let url = 'world.php';
        if (country) {
            url += `?country=${encodeURIComponent(country)}`;
        }

        // create a new AJAX request using Fetch API:
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // clear any previous results::
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = '';

                // check if results are returned:
                if (data.length === 0) {
                    resultDiv.innerHTML = 'No countries found.';
                    return;
                }

                // print the data into the result div:
                data.forEach(row => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `${row.name} is ruled by ${row.head_of_state}`;
                    resultDiv.appendChild(listItem);
                });
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                document.getElementById('result').innerHTML = 'An error occurred while fetching the data.';
            });
    }

    // listen for the 'click' event on the Lookup button
    document.getElementById('lookup').addEventListener('click', lookupCountries);

    // listen for the 'Enter' key press in the input field:
    document.getElementById('country').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            lookupCountries();
        }
    });
});
