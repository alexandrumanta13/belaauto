const removeFromFavoritesApiUrl = "/api/v1/favorites/delete.php";

const removeFromFavorites = (product) => {
    fetch(removeFromFavoritesApiUrl, {
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
                getFavoritesItems();
            }
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}

const deleteFavorites = () => {
    fetch(removeFromFavoritesApiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "favorite": true
            })
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.success) {
                getFavoritesItems();
            }
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}