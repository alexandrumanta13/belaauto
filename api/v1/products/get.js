const productsApiUrl = "/api/v1/products/get.php";

const getProducts = (arr) => {
    const body = document.querySelector('body');
    body.className = "loading-overlay";
    fetch(productsApiUrl, {
            method: "POST",
            mode: "same-origin",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(
                arr
            )
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data) {
                getEachProduct(data);
                setTimeout(function () {
                    body.className = "loaded";
                }, 1000);
            }
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}

const getEachProduct = (arr) => {

    const productList = document.querySelector('#product-list');
    productList.innerHTML = "";

    if (arr.count > 0) {
        arr.body.map((product) => {
            const productContainer = document.createElement('div');
            productContainer.classList.add('product-container');
            productContainer.classList.add('col-6');
            productContainer.classList.add('col-md-4');
            productList.append(productContainer);

            const productMain = document.createElement('div');
            productMain.classList.add('product');
            productContainer.append(productMain);

            const productImageContainer = document.createElement('figure');
            productImageContainer.className = 'product-image-container';
            productMain.append(productImageContainer);

            const productImage = document.createElement('a');
            productImage.className = 'product-image';
            productImage.setAttribute('href', 'produse?produs=' + product.id);
            productImageContainer.append(productImage);

            const image = document.createElement('img');
            image.setAttribute('src', product.image);
            productImage.append(image);

            const productDetails = document.createElement('div');
            productDetails.classList.add('product-details');
            productMain.append(productDetails);

            const productTitle = document.createElement('h2');
            productTitle.classList.add('product-title');
            productDetails.append(productTitle);

            const productTitleLink = document.createElement('a');
            productTitleLink.textContent = product.product_name;
            productTitleLink.setAttribute('href', 'produse?produs=' + product.id);
            productTitle.append(productTitleLink);

            const productPriceBox = document.createElement('div');
            productPriceBox.classList.add('price-box');
            productDetails.append(productPriceBox);

            const productPrice = document.createElement('span');
            productPrice.classList.add('product-price');
            productPrice.textContent = product.price + ' Lei';
            productPriceBox.append(productPrice);

            const productAction = document.createElement('div');
            productAction.classList.add('product-action');
            productDetails.append(productAction);

            const productAddToFavorites = document.createElement('a');
            productAddToFavorites.classList.add('paction');
            productAddToFavorites.classList.add('add-wishlist');
            productAddToFavorites.setAttribute('onclick', 'addToFavorites(' + product.id + ')');
            productAction.append(productAddToFavorites);

            const productAddToFavoritesText = document.createElement('span');
            productAddToFavoritesText.textContent = 'Adauga la favorite';
            productAddToFavorites.append(productAddToFavoritesText);

            const productAddToCart = document.createElement('a');
            productAddToCart.classList.add('paction');
            productAddToCart.classList.add('add-cart');
            productAddToCart.setAttribute('onclick', 'addToCart(' + product.id + ')');
            productAction.append(productAddToCart);

            const productAddToCartText = document.createElement('span');
            productAddToCartText.textContent = 'Adauga in cos';
            productAddToCart.append(productAddToCartText);

            const productAddToCompare = document.createElement('a');
            productAddToCompare.classList.add('paction');
            productAddToCompare.classList.add('add-compare');
            productAddToCompare.setAttribute('onclick', 'addToCompare(' + product.id + ')');
            productAction.append(productAddToCompare);

            const productAddToCompareText = document.createElement('span');
            productAddToCompareText.textContent = 'Adauga la comparatie';
            productAddToCompare.append(productAddToCompareText);


        });




    } else {
        const empty = document.createElement('p');
        empty.classList.add('col-lg-9');
        empty.textContent = 'Nu exista produse';
        productList.append(empty);


    }
}