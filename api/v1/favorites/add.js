const addToFavoritesApiUrl = "/api/v1/favorites/add.php";

const addToFavorites = (product) => {

    fetch(addToFavoritesApiUrl, {
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
                successAddedFavorites(product);
                getFavoritesItems();
            }
            
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}