document.getElementById("email").addEventListener("focusout", () => {
    var email = document.getElementById("email").value;
    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    document.getElementById("emailError").innerHTML = "";
    if (email == "") {
        document.getElementById("emailError").innerHTML =
            "Należy podać adres email.";
    } else if (email.length < 6) {
        document.getElementById("emailError").innerHTML =
            "Niepoprawna forma adresu email.";
    } else if (!document.getElementById("email").value.match(mailformat)) {
        document.getElementById("emailError").innerHTML =
            "Niepoprawna forma adresu email.";
    }
});

document.getElementById("password").addEventListener("focusout", () => {
    var password = document.getElementById("password").value;
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,25}$/;
    document.getElementById("passwordError").innerHTML = "";
    if (password == "") {
        document.getElementById("passwordError").innerHTML =
            "Należy podać hasło.";
    } else if (!password.match(passw)) {
        if (password.length < 8) {
            document.getElementById("passwordError").innerHTML +=
                "Hasło powinno składać się z co najmniej 8 znaków. <br>";
        }
        if (password.length > 25) {
            document.getElementById("passwordError").innerHTML +=
                "Hasło nie może zawierać więcej niż 25 znaków. <br>";
        }
        document.getElementById("passwordError").innerHTML +=
            "Hasło powinno składać się z: małej litery, dużej litery oraz liczby. <br>";
    }
});
