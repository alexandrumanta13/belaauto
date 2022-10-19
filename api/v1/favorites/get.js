const getFavoritesItemsApiUrl = "/api/v1/favorites/get.php";
const mainFavoritesWrapper = document.querySelector('.get-favorites-items');

const getFavoritesItems = () => {
    fetch(getFavoritesItemsApiUrl, {
            mode: "same-origin",
            credentials: "same-origin"
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data) {
                summaryFavorites(data);
                const favorites = document.querySelector('.favorites-table-container');
                if (favorites) {
                    primaryFavorites(data);
                }
            }

        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}


const summaryFavorites = (arr) => {
    const favoritesWrapper = document.createElement('div');
    const favoritesCount = document.querySelector('.favorites-count');
    favoritesCount.textContent = arr.count;
    favoritesWrapper.className = 'dropdownmenu-wrapper';
    if (arr.count > 0) {
        arr.body.map((product) => {
            const productContainer = document.createElement("div");
            productContainer.className = 'product';
            favoritesWrapper.append(productContainer);

            const productDetails = document.createElement("div");
            productDetails.className = 'product-details';
            productContainer.append(productDetails);

            const productTitle = document.createElement('h4');
            productTitle.className = 'product-title';
            productDetails.append(productTitle);

            const productLink = document.createElement('a');
            productLink.setAttribute('href', '/produse?produs=' + product.id);
            productLink.textContent = product.model;
            productTitle.append(productLink);

            

            const remove = document.createElement('a');
            remove.setAttribute('onclick', 'removeFromFavorites(' + product.id + ')')
            remove.className = 'btn-remove';
            productContainer.append(remove);

            const iconRemove = document.createElement('i');
            iconRemove.className = 'icon-cancel';
            remove.append(iconRemove);
        });


        const action = document.createElement('div');
        action.className = 'dropdown-favorites-action';
        favoritesWrapper.append(action);

        const clearUrl = document.createElement('a');
        clearUrl.setAttribute('onclick', 'deleteFavorites()')
        clearUrl.classList.add('action-link');
        clearUrl.textContent = 'Goleste';
        action.append(clearUrl);


        const viewUrl = document.createElement('a');
        viewUrl.setAttribute('href', '/favorite');
        viewUrl.classList.add('btn');
        viewUrl.classList.add('btn-primary');
        viewUrl.textContent = 'Vezi favorite';
        action.append(viewUrl);


    } else {
        const empty = document.createElement('p');
        empty.textContent = 'Nu exista produse in lista';
        favoritesWrapper.append(empty);
    }

    mainFavoritesWrapper.innerHTML = "";
    mainFavoritesWrapper.append(favoritesWrapper);
}

const primaryFavorites = (arr) => {
    const cartTableContainer = document.querySelector('.cart-table-container');
    const cartTable = document.querySelector('.table-cart');
    const cartTableBody = document.querySelector('.table.table-cart tbody');
    const summary = document.querySelector('.cart-summary-container');
    const summarySubtotal = document.querySelector('.summary-subtotal');
    const summaryTotal = document.querySelector('.summary-total');
    const summaryTransport = document.querySelector('.summary-transport');
    const cartTableTfoot = document.querySelector('tfoot');
    if (arr.count > 0) {
        cartTableBody.innerHTML = "";
        arr.body.map((product) => {
            const tr = document.createElement('tr');
            tr.className = 'product-row';
            cartTableBody.append(tr);

            const td = document.createElement('td');
            td.className = 'product-col';
            tr.append(td);

            const figure = document.createElement('figure');
            figure.className = 'product-image-container';
            td.append(figure);

            const a = document.createElement('a');
            a.setAttribute('href', '/produse?produs=' + product.id);
            a.className = 'product-image';
            figure.append(a);

            const img = document.createElement('img');
            img.setAttribute('src', product.image);
            a.append(img);

            const title = document.createElement('h2');
            title.className = 'product-title';
            td.append(title);

            const titleLink = document.createElement('a');
            titleLink.setAttribute('href', '/produse?produs=' + product.id);
            titleLink.textContent = product.model;
            title.append(titleLink);

            const tdPrice = document.createElement('td');
            tdPrice.textContent = product.price + ' Lei';
            tr.append(tdPrice);

            const tdInputQnt = document.createElement('td');
            tr.append(tdInputQnt);

            const qnt = document.createElement('input');
            qnt.classList.add('vertical-quantity');
            qnt.setAttribute('onchange', 'updateCartItems(' + product.id + ', this)');
            qnt.classList.add('form-control');
            qnt.setAttribute('value', product.qnt);
            tdInputQnt.append(qnt);

            const tdSubtotal = document.createElement('td');
            tdSubtotal.textContent = product.qnt * product.price + ' Lei';
            tr.append(tdSubtotal);

            const trAction = document.createElement('tr');
            trAction.className = 'product-action-row';
            cartTableBody.append(trAction);

            const tdAction = document.createElement('td');
            tdAction.setAttribute('colspan', '4');
            tdAction.className = 'clearfix';
            trAction.append(tdAction);

            const actionLeft = document.createElement('div');
            actionLeft.className = 'float-left';
            tdAction.append(actionLeft);

            const addToFavorites = document.createElement('a');
            addToFavorites.setAttribute('onclick', 'addToFavorites(' + product.id + ')')
            addToFavorites.className = 'btn-move';
            addToFavorites.textContent = 'Adauga la favorite';
            actionLeft.append(addToFavorites);

            const actionRight = document.createElement('div');
            actionRight.className = 'float-right';
            tdAction.append(actionRight);

            const removeFromCart = document.createElement('a');
            removeFromCart.setAttribute('onclick', 'removeFromCart(' + product.id + ')')
            removeFromCart.className = 'btn-remove';
            actionRight.append(removeFromCart);

            const removeIcon = document.createElement('span');
            removeIcon.textContent = 'Sterge produs';
            removeIcon.className = 'sr-only';
            removeFromCart.append(removeIcon);

            summarySubtotal.textContent = arr.total + ' Lei';
            summaryTotal.textContent = parseInt(arr.total) + parseInt(summaryTransport.dataset.price) + ' Lei'
         

            $('.vertical-quantity').TouchSpin({
                verticalbuttons: true,
                verticalup: '',
                verticaldown: '',
                verticalupclass: 'icon-up-dir',
                verticaldownclass: 'icon-down-dir',
                buttondown_class: 'btn btn-outline',
                buttonup_class: 'btn btn-outline',
                initval: 1,
                min: 1
            });
        });

    } else {
        // cartTableContainer.removeChild(cartTable);
        // cartTableContainer.removeChild(cartTableTfoot);
        console.log(summary);
        //cartTableContainer.parentNode.parentNode.removeChild(summary);
        cartTable.innerHTML = "";
        cartTableTfoot.innerHTML = "";
        summary.innerHTML = "";
       
        const empty = document.createElement('p');
        empty.textContent = 'Nu exista produse in lista';
        cartTableContainer.append(empty);
    }
}


getFavoritesItems();
