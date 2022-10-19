const getCartItemsApiUrl = "/api/v1/cart/get.php";
const wrapper = document.querySelector('.get-cart-items');

const getCartItems = () => {
    fetch(getCartItemsApiUrl, {
            mode: "same-origin",
            credentials: "same-origin"
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data) {
                summaryCart(data);
                const cart = document.querySelector('.cart-table-container');
                if (cart) {
                    primaryCart(data);
                }
            }

        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}


const summaryCart = (arr) => {
    const cartWrapper = document.createElement('div');
    const cartCount = document.querySelector('.cart-count');
    cartCount.textContent = arr.count;
    cartWrapper.className = 'dropdownmenu-wrapper';
    if (arr.count > 0) {
        arr.body.map((product) => {
            const productContainer = document.createElement("div");
            productContainer.className = 'product';
            cartWrapper.append(productContainer);

            const productDetails = document.createElement("div");
            productDetails.className = 'product-details';
            productContainer.append(productDetails);

            const productTitle = document.createElement('h4');
            productTitle.className = 'product-title';
            productDetails.append(productTitle);

            const productLink = document.createElement('a');
            productLink.setAttribute('href', '/produse?produs=' + product.id);
            productLink.innerHTML = product.model + ` <span>x${product.qnt}</span>`;
            productTitle.append(productLink);


            const productInfo = document.createElement('span');
            productInfo.className = 'cart-product-info';
            let priceSubtotal = product.qnt * product.price;
            productInfo.innerHTML = `<span>${priceSubtotal.toFixed(2)}` + ` Lei</span>`;
            productDetails.append(productInfo);

            const productQuantity = document.createElement("div");
            productQuantity.className = "product-quantity";
            productContainer.append(productQuantity);

            
            const productQuantitySubtractBtn = document.createElement("button");
            productQuantitySubtractBtn.className = "product-quantity--subtract";
            productQuantitySubtractBtn.textContent = "-";
            productQuantitySubtractBtn.onclick = `productQuantitySubtractBtnFn(${product.id}, this)`;
            productQuantity.append(productQuantitySubtractBtn);

            productQuantitySubtractBtn.onclick = function(e) {
                let currentQty = parseInt(this.nextSibling.getAttribute("value")) - 1;
                if(currentQty == 0)
                {
                    updateCartItems(product.id, 1);
                } else {
                    updateCartItems(product.id, currentQty);
                }
            }


            const productQuantityInput = document.createElement("input");
            productQuantityInput.className = "product-quantity--input";
            productQuantityInput.setAttribute("type", "number");
            productQuantityInput.setAttribute("min", 1);
            productQuantityInput.setAttribute("value", product.qnt);
            productQuantityInput.setAttribute("data-product-id", product.id);
            productQuantity.append(productQuantityInput);


            productQuantityInput.onchange = function(e)
            {
                updateCartItems(product.id, e.target.value);
            }

            const productQuantityAddBtn = document.createElement("button");
            productQuantityAddBtn.className = "product-quantity--add";
            productQuantityAddBtn.textContent = "+";
            productQuantityAddBtn.onclick = function(e)
            {
                let currentQty = parseInt(this.previousSibling.getAttribute("value")) + 1;
                updateCartItems(product.id, currentQty);
            }
            productQuantity.append(productQuantityAddBtn);

            const figure = document.createElement('figure');
            figure.className = "product-image-container";
            productContainer.append(figure);

            const figureProductLink = document.createElement('a');
            //figureProductLink.setAttribute('href', '/produse?produs=' + product.id);
            figureProductLink.className = 'product-image';
            figure.append(figureProductLink);

            const img = document.createElement('img');
            img.setAttribute('src', product.image);
            figureProductLink.append(img);

            const remove = document.createElement('a');
            remove.setAttribute('onclick', 'removeFromCart(' + product.id + ')')
            remove.className = 'btn-remove';
            figureProductLink.append(remove);

            const iconRemove = document.createElement('i');
            iconRemove.className = 'icon-cancel';
            remove.append(iconRemove);
        });




        const cartHeader = document.createElement('div');
        cartHeader.className = 'dropdown-cart-header';
        cartWrapper.prepend(cartHeader);

        const cartHeaderItems = document.createElement('span');
        cartHeaderItems.textContent = arr.count + ' produse';
        cartHeader.append(cartHeaderItems);

        const cartHeaderLink = document.createElement('a');
        cartHeaderLink.textContent = 'Vezi cos';
        cartHeaderLink.setAttribute('href', '/cos-cumparaturi');
        cartHeader.append(cartHeaderLink);

        const total = document.createElement('div');
        total.className = 'dropdown-cart-total';
        cartWrapper.append(total);

        const totalText = document.createElement('span');
        totalText.textContent = 'Total';
        total.append(totalText);

        const totalValue = document.createElement('span');
        totalValue.className = 'cart-total-price';
        totalValue.textContent = arr.total + ' Lei';
        total.append(totalValue);

        const checkout = document.createElement('div');
        checkout.className = 'dropdown-cart-action';
        cartWrapper.append(checkout);

        const checkoutUrl = document.createElement('a');
        checkoutUrl.setAttribute('href', '/finalizare-comanda');
        checkoutUrl.classList.add('btn-block');
        checkoutUrl.classList.add('btn');
        checkoutUrl.textContent = 'Finalizeaza comanda';
        checkout.append(checkoutUrl);


    } else {
        const empty = document.createElement('p');
        empty.textContent = 'Nu exista produse in cos';
        cartWrapper.append(empty);
    }

    wrapper.innerHTML = "";
    wrapper.append(cartWrapper);
}

const primaryCart = (arr) => {
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
        empty.textContent = 'Nu exista produse in cos';
        cartTableContainer.append(empty);
    }
}

getCartItems();
