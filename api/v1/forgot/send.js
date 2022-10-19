const sendForgotApiUrl = "/api/v1/forgot/send.php";


const sendForgot = (email) => {
    fetch(sendForgotApiUrl, {
            mode: "same-origin",
            credentials: "same-origin",
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "email": email
            })
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.success) {
                successSendForgot(data.message);
            }

        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}