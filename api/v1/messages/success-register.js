const successRegisterApiUrl = "/api/v1/messages/success-register.php";

const successRegister = (message) => {
    fetch(successRegisterApiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "message": message
            })
        })
        .then(response => {
            return response.text();
        })
        .then(data => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, "text/html");
            const message = document.querySelector('.success-message-container');
            const section = doc.documentElement.querySelector(".msg-box-container");
            const successMesssage = document.querySelector('.after-loading-success-message');
      
            message.append(section);

            successMesssage.style.display = "block";

            setTimeout(() => {
                closeMessage();
            }, 3000);
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}