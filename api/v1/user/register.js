const registerApiUrl = "/api/v1/user/register.php";

const register = () => {
    const name = document.querySelector('#register-name');
    const lastName = document.querySelector('#register-lastName');
    const phone = document.querySelector("#register-phone");
    const buttonRegister = document.querySelector(".register-button");
    const email = document.querySelector("#register-email");
    const password = document.querySelector("#register-password");
    const repeatPassword = document.querySelector("#register-repeatPassword");
    const acceptTerms = document.querySelector("#termsAndConditions");
    const errorDuplicate = document.querySelector(".error-duplicate");
   
    if (!email.checkValidity() || !password.checkValidity() || !name.checkValidity() || !lastName.checkValidity() || !repeatPassword.checkValidity() || !acceptTerms.checkValidity()) {

        email.classList.add('error');
        password.classList.add('error');
        name.classList.add('error');
        lastName.classList.add('error');
        repeatPassword.classList.add('error');

        const nameMessage = document.createElement("p");
        nameMessage.innerHTML = name.validationMessage;
        nameMessage.className = "error-message";
        name.parentNode.insertBefore(nameMessage, name.nextSibling);

        const lastNameMessage = document.createElement("p");
        lastNameMessage.innerHTML = lastName.validationMessage;
        lastNameMessage.className = "error-message";
        lastName.parentNode.insertBefore(lastNameMessage, lastName.nextSibling);

        const repeatPasswordMessage = document.createElement("p");
        repeatPasswordMessage.innerHTML = repeatPassword.validationMessage;
        repeatPasswordMessage.className = "error-message";
        repeatPassword.parentNode.insertBefore(repeatPasswordMessage, repeatPassword.nextSibling);

        const emailMessage = document.createElement("p");
        emailMessage.innerHTML = email.validationMessage;
        emailMessage.className = "error-message";
        email.parentNode.insertBefore(emailMessage, email.nextSibling);

        const passwordMessage = document.createElement("p");
        passwordMessage.innerHTML = password.validationMessage;
        passwordMessage.className = "error-message";
        password.parentNode.insertBefore(passwordMessage, password.nextSibling);
        if (acceptTerms.checked == false){
            acceptTerms.classList.add('error');
            const acceptTermsMessage = document.createElement("p");
            acceptTermsMessage.innerHTML = "Trebuie sa fii de acord cu termeni si conditii!";
            acceptTermsMessage.className = "error-message";
            acceptTerms.parentNode.appendChild(acceptTermsMessage, acceptTerms.nextSibling);
            buttonRegister.disabled;
    
        }
       
        
    } else if (password.value != repeatPassword.value) {
        password.classList.add('error');
        repeatPassword.classList.add('error');

        const repeatPasswordMessage = document.createElement("p");
        repeatPasswordMessage.innerHTML = "Parolele nu se potrivesc";
        repeatPasswordMessage.className = "error-message";
        repeatPassword.parentNode.insertBefore(repeatPasswordMessage, repeatPassword.nextSibling);
    } else  if (acceptTerms.checked == false){
        acceptTerms.classList.add('error');
        const acceptTermsMessage = document.createElement("p");
        acceptTermsMessage.innerHTML = "Trebuie sa fii de acord cu termeni si conditii!";
        acceptTermsMessage.className = "error-message";
        acceptTerms.parentNode.appendChild(acceptTermsMessage, acceptTerms.nextSibling);
       

    } else {
        fetch(registerApiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "name": name.value,
                    "lastName": lastName.value,
                    "phone": (!phone ? '' : phone.value),
                    "email": email.value,
                    "password": password.value,
                    "repeatPassword": repeatPassword.value
                })
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.replace("/contul-meu");
                } else if (data.duplicate) {
                   
                    const errorDuplicateMessage = document.createElement("p");
                    errorDuplicateMessage.innerHTML = data.message;
                    errorDuplicateMessage.className = "error-message";
                    acceptTerms.parentNode.appendChild(errorDuplicateMessage, acceptTerms.nextSibling);
                }
            })
            .catch(err => {
                console.log("Error Reading data " + err);
            });
    }
}
