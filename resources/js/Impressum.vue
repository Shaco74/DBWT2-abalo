<template>
    <div class="container mx-auto mt-10  text-white">
        <div class="bg-zinc-950 p-8 rounded-lg shadow-md">
            <h1 class="text-4xl font-bold mb-6 text-center text-white">Impressum</h1>
            <p class="text-lg mb-4">Angaben gemäß § 5 TMG:</p>
            <p class="text-lg mb-4">
                Musterfirma GmbH<br>
                Musterstraße 1<br>
                12345 Musterstadt
            </p>
            <p class="text-lg mb-4">
                Vertreten durch:<br>
                Max Mustermann
            </p>
            <p class="text-lg mb-4">
                Kontakt:<br>
                Telefon: 01234/567890<br>
                E-Mail: info@musterfirma.de
            </p>
            <p class="text-lg mb-4">
                Registereintrag:<br>
                Eintragung im Handelsregister.<br>
                Registergericht: Amtsgericht Musterstadt<br>
                Registernummer: HRB 123456
            </p>
            <p class="text-lg mb-4">
                Umsatzsteuer-ID:<br>
                Umsatzsteuer-Identifikationsnummer gemäß §27 a Umsatzsteuergesetz: DE123456789
            </p>
            <p class="text-lg mb-4">
                Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:<br>
                Max Mustermann<br>
                Musterstraße 1<br>
                12345 Musterstadt
            </p>
        </div>
        <div class="flex justify-center p-4"><a href="/newsite">Back to Home</a></div>
            <div id="app">
                <google-map class="mb-20"
                    :center="{ lat: 51.1657, lng: 10.4515 }"
                    :zoom="5"
                    style="width: 100%; height: 400px"
                    disabledSearch="true"
                >
                </google-map>
            </div>
    </div>
</template>

<script>
export default {
    name: 'Impressum',
}
</script>

<style scoped>
.container {
    padding: 20px;
}
</style>
