class LatestProducts {
    constructor(btnId) {
        this.btnId = document.querySelectorAll(btnId)
            ? document.querySelectorAll(btnId)
            : null;
        this.addListeners();
        this.currency = null;
    }

    getCurrencyName() {
        window.axios
            .get("/api/currency")
            .then(response => {
                this.currency = response.data;
            })
            .catch(err => console.log("Can't get currency " + err));
    }

    addListeners() {
        if (this.btnId != null) {
            this.btnId.forEach(element => {
                element.addEventListener("click", this.toggle);
            });
            this.getCurrencyName();
            this.populateData();
        }
    }
    toggle() {
        // console.log(this.getAttribute("data-id"));
        window.axios
            .get(`/api/products/${this.getAttribute("data-id")}/latest`)
            .then(response => {
                const data = response.data.data;

                output = "";

                if (document.querySelector("#cardRenderArea")) {
                    let area = document.querySelector("#cardRenderArea");

                    let heading = document.querySelector("#latest-heading");
                    heading.innerHTML = data[0].category_name;
                    for (let i = 0; i < data.length; i++) {
                        data[i].name = data[i].name.split(" ");

                        output += `
                        <a href="/product/${
                            data[i].id
                        }" class="card-anchor-wrapper col-md-6 col-lg-5 mx-auto">
                            <div class="card m-3 col-md-12">
                                <div class="card__left-content">
                                    <div class="card__titles">
                                        <h1 class="card__title" id="latest-card-heading">
                                        ${data[i].name[0]}</h1>
                                        <h1 class="card__title-2" id="latest-card-subheading">
                                        ${data[i].name[1]}</h1>
                                    </div>
                                    <h1 class="card__desc" id="latest-card-price">${
                                        data[i].price
                                    } ${data[i].currency}</h1>
                                </div>
                                <div class="card__right-content">
                                    <img src="/storage/${
                                        data[i].category_name
                                    }/${
                            data[i].images[0].image_name
                        }" id="latest-card-img" alt="Man" class="card__img">
                                </div>
                            </div>
                        </a>
                        `;
                    }

                    area.innerHTML = output;
                }
            })
            .catch(e => {
                console.log(e);
            });
    }

    populateData() {
        window
            .axios(`/api/products/1/latest`)
            .then(response => {
                output = "";
                if (document.querySelector("#cardRenderArea")) {
                    let area = document.querySelector("#cardRenderArea");
                    const data = response.data.data;
                    let heading = document.querySelector("#latest-heading");
                    heading.innerHTML = data[0].category_name;
                    for (let i = 0; i < data.length; i++) {
                        data[i].name = data[i].name.split(" ");

                        output += `
                        <a href="/product/${
                            data[i].id
                        }" class="card-anchor-wrapper col-md-6 col-lg-5 mx-auto">
                            <div class="card m-3 col-md-12">
                                <div class="card__left-content">
                                    <div class="card__titles">
                                        <h1 class="card__title" id="latest-card-heading">
                                        ${data[i].name[0]}</h1>
                                        <h1 class="card__title-2" id="latest-card-subheading">
                                        ${data[i].name[1]}</h1>
                                    </div>
                                    <h1 class="card__desc" id="latest-card-price">${
                                        data[i].price
                                    } ${data[i].currency}</h1>
                                </div>
                                <div class="card__right-content">
                                    <img src="/storage/${
                                        data[i].category_name
                                    }/${
                            data[i].images[0].image_name
                        }" id="latest-card-img" alt="Man" class="card__img">
                                </div>
                            </div>
                        </a>
                    `;
                    }

                    area.innerHTML = output;
                }
            })
            .catch(e => {
                console.log(e);
            });
    }
}

module.exports = LatestProducts;
