const toolbox = document.querySelector('.toolbox-pagination');
const getTotalPages = (arr) => {
    const paginationApiUrl = "/api/v1/products/pagination.php";
    fetch(paginationApiUrl, {
            method: "POST",
            mode: "same-origin",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(arr)
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data) {
                console.log(data)
                Pagination.Init(document.getElementById('pagination'), data);
                if(data.count == 0) {
                    toolbox.classList.add('hide');
                } else {
                    toolbox.classList.remove('hide');
                   
                }
               
            } 
        })
        .catch(err => {
            console.log("Error Reading data " + err);
        });
}
/* * * * * * * * * * * * * * * * *
 * Pagination
 * javascript page navigation
 * * * * * * * * * * * * * * * * */

function getAllUrlParams(url) {

    var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

    var obj = {};

    if (queryString) {
        
        queryString = queryString.split('#')[0];

        var arr = queryString.split('&');

        for (var i = 0; i < arr.length; i++) {
            var a = arr[i].split('=');

            var paramName = a[0];
            var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];

            paramName = paramName.toLowerCase();
            if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase();

            if (paramName.match(/\[(\d+)?\]$/)) {

                var key = paramName.replace(/\[(\d+)?\]/, '');
                if (!obj[key]) obj[key] = [];

                if (paramName.match(/\[\d+\]$/)) {
                    var index = /\[(\d+)\]/.exec(paramName)[1];
                    obj[key][index] = paramValue;
                } else {
                    obj[key].push(paramValue);
                }
            } else {
                if (!obj[paramName]) {
                    obj[paramName] = paramValue;
                } else if (obj[paramName] && typeof obj[paramName] === 'string') {
                    obj[paramName] = [obj[paramName]];
                    obj[paramName].push(paramValue);
                } else {
                    obj[paramName].push(paramValue);
                }

                const catList = document.querySelectorAll('.cat-list li');
               
                catListArr = [...catList];
                
                catListArr.map((cat) => {
                    if(cat.dataset.id == paramValue) {
                        cat.classList.add('active')
                    }
                })
            }
        }
    } else {
        obj.all = true;
        obj.pagina = Pagination.page;
    }
    return obj;
}



var Pagination = {

    code: '',

    // --------------------
    // Utility
    // --------------------

    // converting initialize data
    Extend: function (data) {
        data = data || {};
        Pagination.size = data.size || 300;
        Pagination.page = data.page || 1;
        Pagination.step = data.step || 3;
    },

    // add pages by number (from [s] to [f])
    Add: function (s, f) {
        for (var i = s; i < f; i++) {
            Pagination.code += '<li class="page-item"><a class="page-link">' + i + '</a></li>';
        }
    },

    // add last page with separator
    Last: function () {
        Pagination.code += '<li class="page-item"><span>...</span></li><li class="page-item"><a class="page-link">' + Pagination.size + '</a></li>';
    },

    // add first page with separator
    First: function () {
        Pagination.code += '<li class="page-item"><a class="page-link">1</a></li><li class="page-item"><span>...</span></li>';
    },



    // --------------------
    // Handlers
    // --------------------

    // change page
    Click: function () {
        Pagination.page = +this.innerHTML;
        Pagination.Start();
        let urlParams = getAllUrlParams();
        urlParams.pagina = Pagination.page;
        getProducts(urlParams);
    },

    // previous page
    Prev: function () {
        Pagination.page--;
        if (Pagination.page < 1) {
            Pagination.page = 1;
        }
        Pagination.Start();
    },

    // next page
    Next: function () {
        Pagination.page++;
        if (Pagination.page > Pagination.size) {
            Pagination.page = Pagination.size;
        }
        Pagination.Start();
    },



    // --------------------
    // Script
    // --------------------

    // binding pages
    Bind: function () {
        var a = Pagination.e.getElementsByTagName('a');
        for (var i = 0; i < a.length; i++) {
            if (+a[i].innerHTML === Pagination.page) a[i].parentNode.classList.add('active');
            a[i].addEventListener('click', Pagination.Click, false);
        }
    },

    // write pagination
    Finish: function () {
        Pagination.e.innerHTML = Pagination.code;
        Pagination.code = '';
        Pagination.Bind();
    },

    // find pagination type
    Start: function () {
        if (Pagination.size < Pagination.step * 2 + 6) {
            Pagination.Add(1, Pagination.size + 1);
        } else if (Pagination.page < Pagination.step * 2 + 1) {
            Pagination.Add(1, Pagination.step * 2 + 4);
            Pagination.Last();
        } else if (Pagination.page > Pagination.size - Pagination.step * 2) {
            Pagination.First();
            Pagination.Add(Pagination.size - Pagination.step * 2 - 2, Pagination.size + 1);
        } else {
            Pagination.First();
            Pagination.Add(Pagination.page - Pagination.step, Pagination.page + Pagination.step + 1);
            Pagination.Last();
        }
        Pagination.Finish();
    },



    // --------------------
    // Initialization
    // --------------------

    // binding buttons
    Buttons: function (e) {
        var nav = e.getElementsByTagName('a');
        nav[0].addEventListener('click', Pagination.Prev, false);
        nav[1].addEventListener('click', Pagination.Next, false);
    },

    // create skeleton
    Create: function (e) {

        var html = [
            '<a class="page-link page-link-btn"><i class="icon-angle-left"></i></a>', // prev button
            '<ul class="pagination"></ul>', // pagination container
            '<a class="page-link page-link-btn"><i class="icon-angle-right"></i></a>', // next button
        ];

        e.innerHTML = html.join('');
        Pagination.e = e.getElementsByTagName('ul')[0];
        Pagination.Buttons(e);
    },



    // init
    Init: function (e, data) {
        Pagination.Extend(data);
        Pagination.Create(e);
        Pagination.Start();
    }
};





/* * * * * * * * * * * * * * * * *
 * Initialization
 * * * * * * * * * * * * * * * * */

var init = function () {

    // const location = window.location.href;
    // console.log(getAllUrlParams())
    
    if (getAllUrlParams().all != true) {
        // all = false;
        // const parts = window.location.search.substr(1).split("&");
        // const $_GET = {};
        // parts.map((part, i) => {
        //     let value = part.split("=");
        //     $_GET[value[0]] = parseInt(value[1]);
        // })
        getProducts(getAllUrlParams(), Pagination.page || 1);
        getTotalPages(getAllUrlParams());
    }else {
        getProducts({all: true}, Pagination.page || 1);
        getTotalPages({all: true, pagina: Pagination.page || 1});
        
    }
};

document.addEventListener('DOMContentLoaded', init, false);