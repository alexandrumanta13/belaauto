const addToCompareApiUrl = "/api/v1/compare/add.php";

const addToCompare = (product) => {

    fetch(addToCompareApiUrl, {
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
                successAddedCompare(product);
                getCompareItems();
            } else if (data.limit) {
                limitAddedCompare();
                getCompareItems();
            }
            
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}