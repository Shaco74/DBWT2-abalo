<head>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/default.min.css">
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js"></script>
</head>

<div>
    <script>
        hljs.highlightAll();

        const DATA = {
            'produkte': [
                {name: 'Ritterburg', preis: 59.99, kategorie: 1, anzahl: 3},
                {name: 'Gartenschlau 10m', preis: 6.50, kategorie: 2, anzahl: 5},
                {name: 'Robomaster', preis: 199.99, kategorie: 1, anzahl: 2},
                {name: 'Pool 250x400', preis: 250, kategorie: 2, anzahl: 8},
                {name: 'Rasenmähroboter', preis: 380.95, kategorie: 2, anzahl: 4},
                {name: 'Prinzessinnenschloss', preis: 59.99, kategorie: 1, anzahl: 5}
            ],
            'kategorien': [
                {id: 1, name: 'Spielzeug'},
                {id: 2, name: 'Garten'}
            ]
        };

        /**
         * Sets the result element in the DOM with the provided input.
         * The input is stringified and formatted with 2 spaces indentation.
         * The JSON string is then highlighted using the hljs library and displayed in the result element.
         *
         * @param {Object|Array|number|string} input - The data to be displayed in the result element. Can be of any type that can be stringified to JSON.
         * @returns {void} The function does not return a value.
         */
        function setResult(input) {
            let resultElement = document.getElementById('result');

            // parse the string and format it with 2 spaces
            const jsonString = JSON.stringify(input, null, 2);

            // Highlight JSON
            var formattedJson = hljs.highlight(jsonString, {language: 'json'}).value;

            // Display formatted JSON
            resultElement.innerHTML = '<pre><code class="language-json hljs">' + formattedJson + '</code></pre>';
        }

        /**
         * Returns the highest price among all products in the data object.
         *
         * @param {Object} data - The data object containing an array of 'produkte'.
         * Each 'produkt' is an object with a 'preis' (price) property.
         * @returns {void} The function does not return a value. It calls the setResult function with the highest price.
         */
        function getMaxPrice(data) {
            let highestPrice = data.produkte[0].preis;
            for (let product of data.produkte) {
                if (product.preis > highestPrice) {
                    highestPrice = product.preis;
                }
            }

            setResult(highestPrice + '€');
        }

        /**
         * Returns the product with the lowest price in the data object.
         * If multiple products have the same lowest price, the first one encountered is returned.
         *
         * @param {Object} data - The data object containing an array of 'produkte'.
         * Each 'produkt' is an object with a 'preis' (price) property.
         * @returns {void} The function does not return a value. It calls the setResult function with the product with the lowest price.
         */
        function getMinPriceProduct(data) {
            let lowestPrice = data.produkte[0].preis;
            let lowestPriceProduct = data.produkte[0];
            for (let product of data.produkte) {
                if (product.preis < lowestPrice) {
                    lowestPrice = product.preis;
                    lowestPriceProduct = product;
                }
            }

            setResult(lowestPriceProduct);
        }


        /**
         * Calculates and returns the total sum of all product prices in the data object.
         * The total sum is calculated as the sum of the prices of each product.
         *
         * @param {Object} data - The data object containing an array of 'produkte'.
         * Each 'produkt' is an object with a 'preis' (price) property.
         * @returns {void} The function does not return a value. It calls the setResult function with the total sum.
         */
        function getPriceSum(data) {
            let sum = 0;
            for (let product of data.produkte) {
                sum += product.preis;
            }

            //adjust precision
            setResult(sum.toFixed(2) + '€');
        }

        /**
         * Calculates and returns the total sum of all products in the data object.
         * The total sum is calculated as the sum of the product of the price and quantity of each product.
         *
         * @param {Object} data - The data object containing an array of 'produkte'.
         * Each 'produkt' is an object with properties 'preis' (price) and 'anzahl' (quantity).
         * @returns {void} The function does not return a value. It calls the setResult function with the total sum.
         */
        function getTotalSum(data) {
            let sum = 0;
            for (let product of data.produkte) {
                sum += product.preis * product.anzahl;
            }

            // Adjust precision and append the currency symbol
            setResult(sum.toFixed(2) + '€');
        }

        /**
         * Calculates and returns the total quantity of products for a given category.
         *
         * @param {Object} data - The data object containing 'produkte' and 'kategorien' arrays.
         * @param {string} categoryName - The name of the category for which the total quantity of products is to be calculated.
         * @returns {number} The total quantity of products for the given category.
         */
        function getAmountOfProductsByCategory(data, categoryName) {
            let sum = 0;
            let categoryId = data.kategorien.find(kategorie => kategorie.name === categoryName).id;

            for (let product of data.produkte) {
                if (product.kategorie === categoryId) {
                    sum += product.anzahl;
                }
            }

            setResult(sum);
        }

    </script>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
    <h1>Playground</h1>
    <pre>
        <code class="language-json">
        const DATA = {
            'produkte': [
                { name: 'Ritterburg', preis: 59.99, kategorie: 1, anzahl: 3 },
                { name: 'Gartenschlau 10m', preis: 6.50, kategorie: 2, anzahl: 5 },
                { name: 'Robomaster' ,preis: 199.99, kategorie: 1, anzahl: 2 },
                { name: 'Pool 250x400', preis: 250, kategorie: 2, anzahl: 8 },
                { name: 'Rasenmähroboter', preis: 380.95, kategorie: 2, anzahl: 4 },
                { name: 'Prinzessinnenschloss', preis: 59.99, kategorie: 1, anzahl: 5 }
            ],
            'kategorien': [
                { id: 1, name: 'Spielzeug' },
                { id: 2, name: 'Garten' }
            ]
        };
        </code>
    </pre>

    <p>Click the button to display getMaxPrice(DATA) result</p>
    <button onclick="getMaxPrice(DATA)">Try it</button>

    <p>Click the button to display getMinPriceProduct(DATA) result</p>
    <button onclick="getMinPriceProduct(DATA)">Try it</button>

    <p>Click the button to display getPriceSum(DATA) result</p>
    <button onclick="getPriceSum(DATA)">Try it</button>

    <p>Click the button to display getTotalSum(DATA) result</p>
    <button onclick="getTotalSum(DATA)">Try it</button>

    <p>Click the button to display getAmountOfProductsByCategory(DATA, categoryName) result</p>
    <button onclick="getAmountOfProductsByCategory(DATA, 'Spielzeug')">Anzahl Spielzeuge</button>
    <button onclick="getAmountOfProductsByCategory(DATA, 'Garten')">Anzahl Garten</button>


    <h3>Result</h3>
    <pre id="result"></pre>
</div>
