<template>
    <p>
        <a id="btArticle" href="/articles">Zurück zur Artikelübersicht</a>
    </p>
    <p id="GFG_DOWN"></p>
</template>


<script setup>

// Create a break line element
var br = document.createElement("br");

var cont = document.createElement("div");
cont.setAttribute("class", "bg-stone-200 h-auto w-1/2 p-4 mx-auto my-4 rounded-md");

// Create a form dynamically
var form = document.createElement("form");
form.setAttribute("method", "post");
form.setAttribute("action", "/articles/store");
form.setAttribute("type", "submit");

// add csrf token
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
var inputToken = document.createElement("input");
inputToken.setAttribute("type", "hidden");
inputToken.setAttribute("name", "_token");
inputToken.setAttribute("value", csrfToken);
form.appendChild(inputToken);

var div = document.createElement("div");
div.setAttribute("class", "form-group");
// Create an input element for Full Name

var ANl = document.createElement("label");
ANl.setAttribute("for", "ab_name");
ANl.innerHTML = "Artikel Name";

var ANt = document.createElement("input");
ANt.setAttribute("type", "text");
ANt.setAttribute("name", "ab_name");
ANt.setAttribute("id", "ab_name");
ANt.setAttribute("placeholder", "Namen des Artikels");
ANt.required = true;


// Create an input element for date of birth
var DESCl = document.createElement("label");
DESCl.setAttribute("for", "ab_description");
DESCl.innerHTML = "Artikel Beschreibung";

var DESCt = document.createElement("textarea");
DESCt.setAttribute("name", "ab_description");
DESCt.setAttribute("id", "ab_description");
DESCt.setAttribute("placeholder", "Beschreibung des Artikels");
DESCt.setAttribute("rows", "4");
DESCt.required = true;

// Create an input element for emailID
var PRl = document.createElement("label");
PRl.setAttribute("for", "ab_price");
PRl.innerHTML = "Preis";

var PRt = document.createElement("input");
PRt.setAttribute("type", "number");
PRt.setAttribute("step", "0.01");
PRt.setAttribute("name", "ab_price");
PRt.setAttribute("placeholder", "Preis des Artikels");
PRt.required = true;

// Create an input element for password
var CIDl = document.createElement("label");
CIDl.setAttribute("for", "ab_creator_id");
CIDl.innerHTML = "Ersteller-ID";


var CIDt = document.createElement("input");
CIDt.setAttribute("type", "number");
CIDt.setAttribute("name", "ab_creator_id");
CIDt.setAttribute("id", "ab_creator_id");
CIDt.setAttribute("placeholder", "ID des Erstellers");

// create a submit button
var s = document.createElement("input");
s.setAttribute("type", "submit");
s.setAttribute("value", "Erstellen");
s.innerHTML = "Erstellen";

cont.appendChild(form);
form.appendChild(div);

var li1 = div.cloneNode();
li1.setAttribute("id", "name");
li1.appendChild(ANl);
li1.appendChild(ANt);
li1.appendChild(br.cloneNode());

div.appendChild(li1);


var li2 = div.cloneNode();
li2.setAttribute("id", "description");
li2.appendChild(DESCl);
li2.appendChild(DESCt);
li2.appendChild(br.cloneNode());

div.appendChild(li2);

var li3 = div.cloneNode();
li3.setAttribute("id", "price");
li3.appendChild(PRl);
li3.appendChild(br.cloneNode());
li3.appendChild(PRt);
li3.appendChild(br.cloneNode());

div.appendChild(li3);

var li4 = div.cloneNode();
li4.setAttribute("id", "creator_id");
li4.appendChild(CIDl);
li4.appendChild(br.cloneNode());
li4.appendChild(CIDt);
li4.appendChild(br.cloneNode());

div.appendChild(li4);
div.appendChild(s);


document.getElementsByTagName("body")[0]
    .appendChild(cont);
</script>

<style>
form {
    margin: 40px auto;
    width: 250px;

}

input[type="text"],
input[type="password"],
input[type="email"] {
    width: 100%;
    height: 30px;
    margin-top: 5px;
}

input, textarea {
    text-indent: 10px;
    font-size: small;
    width: 100%;
}

@keyframes fadeIn {
    from {
    }
    to {
        border: 1px solid green;
    }
}

input:focus, textarea:focus {
    animation: fadeIn 1s;
}

input[type="submit"] {
    width: 100%;
    height: 35px;
    background-color: green;
    color: white;
    border: none;
}

input[type="submit"]:hover {
    background-color: darkgreen;
}

textarea {
    width: 100%;
    margin-top: 5px;
}

label {
    font-weight: bold;
}

.form-group {
    margin-bottom: 10px;
}

p {
    text-align: center;
    margin-top: 20px;
}

</style>
