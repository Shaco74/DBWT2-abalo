// Function to check if the cookie agreement is present
function checkCookieAgreement() {
    const cookieAgreement = getCookie('cookieAgreement');
    if (cookieAgreement === "true") {
        // Cookie agreement is present
        console.log('Cookie agreement is present');
    } else {
        // Cookie agreement is not present, prompt user for agreement
        const userAgrees = confirm('Do you agree to the use of cookies?');
        if (userAgrees) {
            // Set the cookie with a boolean value
            setCookie('cookieAgreement', 'true', 365);
            console.log('Cookie agreement set to true');
        } else {
            console.log('User disagreed to the use of cookies');
        }
    }
}

// Function to get the value of a specific cookie
function getCookie(name) {
    const cookieName = name + "=";
    const cookieArray = document.cookie.split(';');
    for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i].trim();
        if (cookie.indexOf(cookieName) === 0) {
            return cookie.substring(cookieName.length, cookie.length);
        }
    }
    return "";
}

// Function to set a cookie with a specific value and expiration date
function setCookie(name, value, days) {
    let expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + days);
    let cookieValue = name + "=" + value + "; path=/; expires=" + expirationDate.toUTCString();
    document.cookie = cookieValue;
}

// Display an alert when the script is executed
alert('Cookie checker script has been loaded');
