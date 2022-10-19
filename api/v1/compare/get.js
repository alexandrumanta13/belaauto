const getCompareItemsApiUrl = "/api/v1/compare/get.php";
const mainCompareWrapper = document.querySelector('.get-compare-items');

const getCompareItems = () => {
    fetch(getCompareItemsApiUrl, {
            mode: "same-origin",
            credentials: "same-origin"
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data) {
                summaryCompare(data);
                const compare = document.querySelector('.compare-table-container');
                if (compare) {
                    primaryCompare(data);
                }
            }

        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}


const summaryCompare = (arr) => {
    const compareWrapper = document.createElement('div');
    const compareCount = document.querySelector('.compare-count');
    compareCount.textContent = arr.count;
    compareWrapper.className = 'dropdownmenu-wrapper';
    if (arr.count > 0) {
        arr.body.map((product) => {
            const productContainer = document.createElement("div");
            productContainer.className = 'product';
            compareWrapper.append(productContainer);

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
            remove.setAttribute('onclick', 'removeFromCompare(' + product.id + ')')
            remove.className = 'btn-remove';
            productContainer.append(remove);

            const iconRemove = document.createElement('i');
            iconRemove.className = 'icon-cancel';
            remove.append(iconRemove);
        });


        const action = document.createElement('div');
        action.className = 'dropdown-compare-action';
        compareWrapper.append(action);

        const clearUrl = document.createElement('a');
        clearUrl.setAttribute('onclick', 'deleteCompare()')
        clearUrl.classList.add('action-link');
        clearUrl.textContent = 'Goleste';
        action.append(clearUrl);


        const viewUrl = document.createElement('a');
        viewUrl.setAttribute('href', '/compara');
        viewUrl.classList.add('btn');
        viewUrl.classList.add('btn-primary');
        viewUrl.textContent = 'Vezi produse';
        action.append(viewUrl);


    } else {
        const empty = document.createElement('p');
        empty.textContent = 'Nu exista produse in lista';
        compareWrapper.append(empty);
    }

    mainCompareWrapper.innerHTML = "";
    mainCompareWrapper.append(compareWrapper);
}

const primaryCompare = (arr) => {
    const compareTableContainer = document.querySelector('.compare-table-container');
    const compareTable = document.querySelector('.table-compare');
    const compareTableBody = document.querySelector('.table.table-compare tbody');
    const compareTableTfoot = document.querySelector('tfoot');
   
   
    if (arr.count > 0) {
        compareTableBody.innerHTML = "";
        const tr = document.createElement('tr');
        tr.className = 'product-row';
        compareTableBody.append(tr);

        const tdEmpty = document.createElement('td');
        tdEmpty.className = 'compare-item';
        tr.prepend(tdEmpty);

        const caracteristics = document.createElement('tr');
        compareTableBody.append(caracteristics);

        const caracteristicsTitle = document.createElement('h2');
        caracteristicsTitle.textContent = 'Caracteristici';
        caracteristics.append(caracteristicsTitle);

        const model = document.createElement('tr');
        model.className = 'product-model-row';
        compareTableBody.append(model);

        const modelLabel = document.createElement('td');
        modelLabel.textContent = 'Model';
        model.append(modelLabel);

        const supplier = document.createElement('tr');
        supplier.className = 'product-supplier-row';
        compareTableBody.append(supplier);

        const supplierLabel = document.createElement('td');
        supplierLabel.textContent = 'Producator';
        supplier.append(supplierLabel);

        const diameter = document.createElement('tr');
        diameter.className = 'product-diameter-row';
        compareTableBody.append(diameter);

        const diameterLabel = document.createElement('td');
        diameterLabel.textContent = 'Diametru';
        diameter.append(diameterLabel);

        const width = document.createElement('tr');
        width.className = 'product-width-row';
        compareTableBody.append(width);

        const widthLabel = document.createElement('td');
        widthLabel.textContent = 'Latime';
        width.append(widthLabel);

        const height = document.createElement('tr');
        height.className = 'product-height-row';
        compareTableBody.append(height);

        const heightLabel = document.createElement('td');
        heightLabel.textContent = 'Inaltime';
        height.append(heightLabel);

        const season = document.createElement('tr');
        season.className = 'product-season-row';
        compareTableBody.append(season);

        const seasonLabel = document.createElement('td');
        seasonLabel.textContent = 'Sezon';
        season.append(seasonLabel);

        const category = document.createElement('tr');
        category.className = 'product-category-row';
        compareTableBody.append(category);

        const categoryLabel = document.createElement('td');
        categoryLabel.textContent = 'Tip vehicul';
        category.append(categoryLabel);

        const speed = document.createElement('tr');
        speed.className = 'product-speed-row';
        compareTableBody.append(speed);

        const speedLabel = document.createElement('td');
        speedLabel.textContent = 'Indice viteza';
        speed.append(speedLabel);

        const weight = document.createElement('tr');
        weight.className = 'product-weight-row';
        compareTableBody.append(weight);

        const weightLabel = document.createElement('td');
        weightLabel.textContent = 'Indice masa';
        weight.append(weightLabel);

        const consumption = document.createElement('tr');
        consumption.className = 'product-consumption-row';
        compareTableBody.append(consumption);

        const consumptionLabel = document.createElement('td');
        consumptionLabel.textContent = 'Clasa consum';
        consumption.append(consumptionLabel);

        const adhesion = document.createElement('tr');
        adhesion.className = 'product-adhesion-row';
        compareTableBody.append(adhesion);

        const adhesionLabel = document.createElement('td');
        adhesionLabel.textContent = 'Aderenta';
        adhesion.append(adhesionLabel);

        const noise = document.createElement('tr');
        noise.className = 'product-noise-row';
        compareTableBody.append(noise);

        const noiseLabel = document.createElement('td');
        noiseLabel.textContent = 'Zgomot';
        noise.append(noiseLabel);

        const trFoot = document.createElement('tr');
        trFoot.className = 'product-disponibility';
        compareTableBody.append(trFoot);

        // const tdEmptyFoot = document.createElement('td');
        // tdEmptyFoot.className = 'compare-item';
        // trFoot.prepend(tdEmptyFoot);

        // const stoc = document.createElement('tr');
        // trFoot.append(stoc);

        const stocTitle = document.createElement('h2');
        stocTitle.textContent = 'Disponibilitate';
        trFoot.append(stocTitle);

        const actions = document.createElement('tr');
        actions.className = 'product-actions';
        compareTableBody.append(actions);

        const tdEmptyFoot = document.createElement('td');
        tdEmptyFoot.className = 'compare-item';
        actions.prepend(tdEmptyFoot);
        
        arr.body.map((product) => {
            

            const td = document.createElement('td');
            td.className = 'compare-item';
            tr.append(td);

            const productContainer = document.createElement('div');
            productContainer.classList.add('product');
            td.append(productContainer);

            const figure = document.createElement('figure');
            figure.className = 'product-image-container';
            productContainer.append(figure);

            const a = document.createElement('a');
            a.setAttribute('href', '/produse?produs=' + product.id);
            a.className = 'product-image';
            figure.append(a);

            const img = document.createElement('img');
            img.setAttribute('src', product.image);
            a.append(img);

            const productDetails = document.createElement('div');
            productDetails.classList.add('product-details');
            td.append(productDetails);

            const title = document.createElement('h2');
            title.className = 'product-title';
            productDetails.append(title);

            const titleLink = document.createElement('a');
            titleLink.setAttribute('href', '/produse?produs=' + product.id);
            titleLink.textContent = product.model;
            title.append(titleLink);

            const priceBox = document.createElement('div');
            priceBox.classList.add('price-box');
            productDetails.append(priceBox);

            const price = document.createElement('span');
            price.classList.add('product-price');
            price.textContent = product.price + ' Lei';
            priceBox.append(price);

           
            const models = document.createElement('td')
            models.textContent = product.model
            model.append(models);

            const suppliers = document.createElement('td')
            suppliers.textContent = product.supplier
            supplier.append(suppliers);

            const diameters = document.createElement('td')
            diameters.textContent = product.diameter
            diameter.append(diameters);

            const widths = document.createElement('td')
            widths.textContent = product.width
            width.append(widths);

            const heights = document.createElement('td')
            heights.textContent = product.height
            height.append(heights);

            const seasons = document.createElement('td')
            seasons.textContent = product.season
            season.append(seasons);

            const categories = document.createElement('td')
            categories.textContent = product.category
            category.append(categories);

            const speeds = document.createElement('td')
            speeds.textContent = (product.speed_index ? product.speed_index : '-');
            speed.append(speeds);

            const weights = document.createElement('td')
            weights.textContent = (product.weight_index ? product.weight_index : '-');
            weight.append(weights);

            const consumptions = document.createElement('td')
            consumptions.textContent = (product.consumption_class ? product.consumption_class : '-');
            consumption.append(consumptions);

            const adhesions = document.createElement('td')
            adhesions.textContent = (product.adhesion ? product.adhesion : '-');
            adhesion.append(adhesions);

            const noises = document.createElement('td')
            noises.textContent = (product.noise ? product.noise : '-');
            noise.append(noises);

            // const trAction = document.createElement('tr');
            // trAction.className = 'product-action-row';
            // compareTableBody.append(trAction);

            const tdAction = document.createElement('td');
            //tdAction.setAttribute('colspan', '4');
            tdAction.className = 'product';
            actions.append(tdAction);

            const stoc = document.createElement('p');
            //tdAction.setAttribute('colspan', '4');
            stoc.classList.add('stoc');
            (product.stoc > 0 ? stoc.classList.add('in-stoc') : stoc.classList.add('not-in-stoc'));
            stoc.textContent = (product.stoc > 0 ? 'In stoc' : 'La comanda');
            tdAction.append(stoc);

            const productAction = document.createElement('div');
            productAction.className = 'product-action';
            tdAction.append(productAction);

            const addToFavorites = document.createElement('a');
            addToFavorites.setAttribute('onclick', 'addToFavorites(' + product.id + ')')
            addToFavorites.classList.add('paction'); 
            addToFavorites.classList.add('add-wishlist');
            productAction.append(addToFavorites);

            const addToCart = document.createElement('a');
            addToCart.setAttribute('onclick', 'addToCart(' + product.id + ')')
            addToCart.classList.add('paction'); 
            addToCart.classList.add('add-cart');
            productAction.append(addToCart);

            const cartIcon = document.createElement('span');
            cartIcon.textContent = 'Adauga in cos';
            addToCart.append(cartIcon)

            const removeFromCompare = document.createElement('a');
            removeFromCompare.setAttribute('onclick', 'removeFromCompare(' + product.id + ')')
            removeFromCompare.classList.add('paction'); 
            productAction.append(removeFromCompare);

            const removeIcon = document.createElement('i');
            
            removeIcon.className = 'icon-cancel';
            removeFromCompare.append(removeIcon);

        });

    } else {
 
        compareTable.innerHTML = "";
        compareTableTfoot.innerHTML = "";
       
       
        const empty = document.createElement('p');
        empty.textContent = 'Nu exista produse in lista';
        compareTableContainer.append(empty);
    }
}


getCompareItems();
