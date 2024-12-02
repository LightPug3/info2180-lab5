document.addEventListener('DOMContentLoaded', function() {
    const lookupCountriesButton = document.getElementById('lookup_countries');
    const lookupCitiesButton = document.getElementById('lookup_cities');
    const resultDiv = document.getElementById('result');
    const countryInput = document.getElementById('country');

    function fetchData(queryParam) {
        const country = countryInput.value.trim();
        let url = `world.php?country=${country}`;

        // add query parameter for cities if requested:
        if (queryParam === 'cities') {
            url += '&lookup=cities';
            // console.log(url);
        }
        // proceed with default URL if city is not requested:
        // console.log(url)
        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                resultDiv.innerHTML = 'Error fetching data';
                console.error(error);
            });
    }

    // lookup countries button click:
    lookupCountriesButton.addEventListener('click', function() {
        fetchData('country');
    });

    
    // lookup cities button click:
    lookupCitiesButton.addEventListener('click', function() {
        fetchData('cities');
    });

    // optional: listen for 'Enter' key press to trigger search:
    countryInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            fetchData('country');
        }
    });

});