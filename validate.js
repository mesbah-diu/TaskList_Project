let usernameValid = true;
let usernameWidget = document.querySelector("#username");
usernameWidget.addEventListener("input", checkusername);

function checkusername() {
    let username = usernameWidget.value;
    username = username.trim();

    let pattern = new RegExp(/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/); //unacceptable chars
    if (pattern.test(username)) {
        alert("Please only use standard alphanumerics");
        return false;
    }else if(username.length >= 35){
        alert("Enter a username between 3 and 35 characters long");
        return false;
    }else{
        return true;
    }
}

let formWidget = document.querySelector("#signUp");
formWidget.addEventListener("submit", checkForm);

function checkForm(event) {
    let username = usernameWidget.value;
    username = username.trim();

    if(username.length <= 3){
        alert("Enter a username between 3 and 35 characters long");
        event.preventDefault();
    }
    if (!usernameValid) {
        event.preventDefault();
    }
}