const removeFromCompareApiUrl = "/api/v1/compare/delete.php";

const removeFromCompare = (product) => {
    fetch(removeFromCompareApiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "product": product
            })
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.success) {
                getCompareItems();
            }
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}

const deleteCompare = () => {
    fetch(removeFromCompareApiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "compare": true
            })
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.success) {
                getCompareItems();
            }
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}