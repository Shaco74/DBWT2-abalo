<template>
    <p>
    <a id="btArticle" href="/articles">Back to Articles</a>
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
form.setAttribute("action", "/articles");
form.setAttribute("type", "submit");

var input = document.createElement("input");
input.setAttribute("type", "hidden");
input.setAttribute("name", "_token");
input.setAttribute("value", "ghjpL4WOYItNc1kCLDnSZG2gICpZStxinmbuVOEw");
input.setAttribute("autoComplete", "off");
form.appendChild(input);



var div = document.createElement("div");
div.setAttribute("class", "form-group");
// Create an input element for Full Name

var ANl = document.createElement("label");
ANl.setAttribute("for", "ab_name");
ANl.innerHTML = "Article name";

var ANt = document.createElement("input");
ANt.setAttribute("type", "text");
ANt.setAttribute("name", "ab_name");
ANt.setAttribute("id", "ab_name");
ANt.setAttribute("placeholder", "Please enter the name of the article");
ANt.required = true;


// Create an input element for date of birth
var DESCl = document.createElement("label");
DESCl.setAttribute("for", "ab_description");
DESCl.innerHTML = "Article Description";

var DESCt = document.createElement("textarea");
DESCt.setAttribute("name", "ab_description");
DESCt.setAttribute("id", "ab_description");
DESCt.setAttribute("placeholder", "Please enter the description of the article");
DESCt.setAttribute("rows", "4");
DESCt.required = true;

// Create an input element for emailID
var PRl = document.createElement("label");
PRl.setAttribute("for", "ab_price");
PRl.innerHTML = "Price";

var PRt = document.createElement("input");
PRt.setAttribute("type", "number");
PRt.setAttribute("name", "ab_price");
PRt.setAttribute("placeholder", "Please enter the price of the article");
PRt.required = true;

// Create an input element for password
var CIDl = document.createElement("label");
CIDl.setAttribute("for", "ab_creator_id");
CIDl.innerHTML = "Creater-ID";


var CIDt = document.createElement("input");
CIDt.setAttribute("type", "number");
CIDt.setAttribute("name", "ab_creator_id");
CIDt.setAttribute("id", "ab_creator_id");
CIDt.setAttribute("placeholder", "Please enter the creator id of the article");

// create a submit button
var s = document.createElement("input");
s.setAttribute("type", "submit");
s.setAttribute("value", "Submit");
s.innerHTML = "Create Article";

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

input, textarea{
        text-indent: 10px;
        font-size: small;
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
