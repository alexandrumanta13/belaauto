const loginApiUrl = "/api/v1/user/login.php";

const checkCredentials = () => {

    const email = document.querySelector("#login-email");
    const password = document.querySelector("#login-password");
    const checkboxPersistent = document.querySelector("#login-persistent");
   

    if (!email.checkValidity() || !password.checkValidity()) {

        email.classList.add('error');
        password.classList.add('error');

        const emailMessage = document.createElement("p");
        emailMessage.textContent = email.validationMessage;
        emailMessage.className = "error-message";
        email.parentNode.insertBefore(emailMessage, email.nextSibling);

        const passwordMessage = document.createElement("p");
        passwordMessage.innerHTML = password.validationMessage;
        passwordMessage.className = "error-message";
        password.parentNode.insertBefore(passwordMessage, password.nextSibling);
    } else {
        fetch(loginApiUrl, {
                mode: "same-origin",
                credentials: "same-origin",
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "email": email.value,
                    "password": password.value,
                    "persistent": checkboxPersistent.checked,
                })
            })
            .then(response => {
                return response.json();

            })
            .then(data => {
                
                if (data.success) {
                     window.location.replace("/");
                } else {
                    const formFooter = document.querySelector('.form-footer');
                    const message = document.createElement("p");
                    message.innerHTML = data.message;
                    message.className = "error-message";
                    formFooter.parentNode.insertBefore(message, formFooter.nextSibling);
                }
            })
            .catch(err => {
                console.log("Error Reading data " + err);
            });
    }
}