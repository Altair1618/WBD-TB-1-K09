//  Variables
const messageCloseButton = document.getElementsByClassName("message-close-button");
const searchInput = document.getElementById("search-input");
const searchButton = document.getElementById("search-button");
const fakultasSelector = document.getElementById("fakultas-selector");
const prodiSelector = document.getElementById("prodi-selector");
const sortSelector = document.getElementById("sort-selector");
const orderSelector = document.getElementById("order-selector");
var footer = document.getElementById("body-footer");

// Functions

// URI Builder
function buildCourseFetchURI(caller, value) {
    let uri = "/api/courses/student?";

    var search, fakultas, prodi, sort, order, page;

    search = caller === "search" ? value : document.getElementById("search-input").value;
    fakultas = caller === "fakultas" ? value : document.getElementById("fakultas-selector").value;
    prodi = caller === "prodi" ? value : document.getElementById("prodi-selector").value;
    sort = caller === "sort" ? value : document.getElementById("sort-selector").value;
    order = caller === "order" ? value : document.getElementById("order-selector").value;
    page = caller === "page" ? value : 1;

    if (search && search.trim() !== "") uri += `q-search=${encodeURI(search)}&`;
    if (fakultas && fakultas !== "all") uri += `q-fakultas=${encodeURI(fakultas)}&`;
    if (prodi && prodi !== "all") uri += `q-kode_prodi=${encodeURI(prodi)}&`;
    if (sort) uri += `q-sort_param=${encodeURI(sort)}&`;
    if (order) uri += `q-sort_order=${encodeURI(order)}&`;
    if (page) uri += `page=${encodeURI(page)}&`;

    // Remove trailing '?' or '&' if exists
    if (uri.endsWith("?") || uri.endsWith("&")) uri = uri.slice(0, -1);

    return uri;
}

// Update InnerHTML of body-main-container
function updateBodyHTML(responseText) {
    document.getElementById("body-main-container").innerHTML = responseText;
    footer = document.getElementById("body-footer");
    if (footer) footer.addEventListener("click", footerEventHandler);
}

// Message Container Handler
function messageContainerHandler(event) {
    let messageContainer = event.target.parentElement;

    while (messageContainer.className !== "message-container") {
        messageContainer = messageContainer.parentElement;
        console.log(messageContainer)
    }

    messageContainer.style.display = "none";
}

for (let i = 0; i < messageCloseButton.length; i++) {
    messageCloseButton[i].addEventListener("click", messageContainerHandler);
}

// Search Handler
let searchDebounceTimeout;

function searchDebounce(func, wait) {
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(searchDebounceTimeout);
        searchDebounceTimeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}

function searchFunction() {
    const uri = buildCourseFetchURI("search", this.value);

    var xhr = new XMLHttpRequest();
    xhr.open("GET", uri, true);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) updateBodyHTML(this.responseText);
    }

    xhr.send();
}

searchInput.addEventListener("input", searchDebounce(searchFunction, 500));
searchButton.addEventListener("click", function() {
    clearTimeout(searchDebounceTimeout);
    searchFunction();
});

// Fakultas Filter Handler
fakultasSelector.addEventListener("change", function() {
    // Reset prodi selector
    const prodiSelector = document.getElementById("prodi-selector");
    prodiSelector.value = "all";

    const uri = buildCourseFetchURI("fakultas", this.value);

    var xhr = new XMLHttpRequest();
    xhr.open("GET", uri, true);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            updateBodyHTML(this.responseText);

            // Update prodi selector
            var xhr2 = new XMLHttpRequest();

            if (fakultasSelector.value === "all") xhr2.open("GET", "/api/prodi", true);
            else xhr2.open("GET", "/api/prodi?kode_fakultas=" + encodeURI(fakultasSelector.value), true);

            xhr2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    prodiSelector.innerHTML = "<option value='all'></option>";

                    const prodiList = JSON.parse(this.responseText);
                    prodiList.forEach(prodi => {
                        prodiSelector.innerHTML += `<option value="${prodi.kode}">${prodi.kode} - ${prodi.nama}</option>`;
                    });

                    prodiSelector.value = "all";
                }
            }

            xhr2.send();
        }
    }

    xhr.send();
});

// Prodi Filter Handler
prodiSelector.addEventListener("change", function() {
    const uri = buildCourseFetchURI("prodi", this.value);

    var xhr = new XMLHttpRequest();
    xhr.open("GET", uri, true);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) updateBodyHTML(this.responseText);
    }

    xhr.send();
});

// Sort Selector Handler
sortSelector.addEventListener("change", function() {
    const uri = buildCourseFetchURI("sort", this.value);

    var xhr = new XMLHttpRequest();
    xhr.open("GET", uri, true);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            updateBodyHTML(this.responseText);
        }
    }

    xhr.send();
});

// Order Selector Handler
orderSelector.addEventListener("change", function() {
    const uri = buildCourseFetchURI("order", this.value);

    var xhr = new XMLHttpRequest();
    xhr.open("GET", uri, true);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) updateBodyHTML(this.responseText);
    }

    xhr.send();
});

// Footer Event Handler
function footerEventHandler(event) {
    if (event.target.className === "page-button") {
        let pageTarget = event.target.textContent.trim();

        if (pageTarget === "PREV") pageTarget = parseInt(document.getElementById("current-page-button").textContent.trim()) - 1;
        else if (pageTarget === "NEXT") pageTarget = parseInt(document.getElementById("current-page-button").textContent.trim()) + 1;

        const uri = buildCourseFetchURI("page", pageTarget);

        var xhr = new XMLHttpRequest();
        xhr.open("GET", uri, true);

        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) updateBodyHTML(this.responseText);
        }

        xhr.send();
    }
}

footer.addEventListener("click", footerEventHandler);
