<template>
    <div>
        <div v-if="!cookieAgreement" class="overlay">
            <div class="dialog">
                <!--  TODO: Füge sinnvollen Inhalt hier zu oder einen Link zu den Agreements -->
                <!--  TODO: Diese Component muss auf jeder Seite laufen. Aktuell muss sie händisch hinzugefügt werden -->
                <p>Our website uses cookies. Do you agree to the use of cookies?</p>
                <button @click="agreeToCookies" type="button">Agree</button>
                <button @click="disagreeToCookies" type="button">Disagree</button>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            cookieAgreement: this.checkCookieAgreement()
        };
    },
    methods: {
        checkCookieAgreement() {
            const cookieAgreement = this.getCookie('cookieAgreement');
            if (cookieAgreement === 'true') {
                return true;
            }
            if (cookieAgreement === 'false') {
                return false;
            }
        },
        agreeToCookies() {
            this.setCookie('cookieAgreement', 'true', 365);
            this.cookieAgreement = true;
        },
        disagreeToCookies() {
            this.setCookie('cookieAgreement', 'false', 365);
            this.cookieAgreement = false;
        },
        getCookie(name) {
            const cookieName = name + "=";
            const cookieArray = document.cookie.split(';');
            for (let i = 0; i < cookieArray.length; i++) {
                let cookie = cookieArray[i].trim();
                if (cookie.indexOf(cookieName) === 0) {
                    return cookie.substring(cookieName.length, cookie.length);
                }
            }
            return "";
        },
        setCookie(name, value, days) {
            let expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + days);
            document.cookie = name + "=" + value + "; path=/; expires=" + expirationDate.toUTCString() + ";" + "SameSite=lax;";
        }
    }
};
</script>

<style scoped>
* {
    color: black;
}

button {
    padding: 10px 20px;
    margin: 10px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(60, 60, 60, 0.7);
    backdrop-filter: blur(3px);
    display: flex;
    justify-content: center;
    align-items: center;
}

.dialog {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}
</style>

