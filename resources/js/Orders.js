class Order {
    constructor(containerId) {
        this.orderContainer = null;
        this.orderItems = null;
        this.selectContainer(containerId);
    }
    selectContainer(id) {
        if (document.querySelector(id)) {
            this.orderContainer = document.querySelector(id);
            this.getItems();
        }
        this.getCurrencyName();
    }
    getItems() {
        window.axios
            .get("/api/cart")
            .then(response => {
                this.orderItems = response.data;
                this.getProducts();
            })
            .catch(e => {
                console.log(e);
            });
    }
    getProducts() {
        let empty = true;
        if (this.orderItems.length > 0) {
            empty = false;
        }
        this.orderItems.forEach(element => {
            window.axios
                .get(`/api/products/${element.product_id}`)
                .then(response => {
                    // Maps keys and values of product object into cartItem object
                    element["product"] = response.data;
                    for (const [key, value] of Object.entries(response.data)) {
                        // We check if key is 'id' because it will override cartItem.id over of product.id
                        if (key == "id") {
                            continue;
                        }
                        element[key] = value;
                    }
                    try {
                        this.renderItems(empty);
                    } catch (e) {}
                })
                .catch(e => {});
        });
        this.renderItems(empty);
    }
    getCurrencyName() {
        window.axios
            .get("/api/currency")
            .then(response => {
                this.currency = response.data;
            })
            .catch(err => console.log("Can't get currency " + err));
    }
    renderItems(empty = true) {
        output = "";

        this.orderItems.forEach(item => {
            try {
                output += `
                <div class="cart-item">
                    <div class="cart-item__img-container">
                        <img src="/storage/${item.category_name}/${
                    item.images[0].image_name
                }" alt="Product" class="cart-item__img">
                    </div>
                    <div class="cart-item__content">
                        <h1 class="cart-item__heading">${item.name}</h1>
                        <h1 class="heading-small">${
                            this.currency == "RSD"
                                ? item.price_rsd * item.quantity
                                : item.price * item.quantity
                        } ${this.currency}</h1>
                        <p>Količina: ${item.quantity}</p>
                        <p>Veličina: ${item.size}</p>
                        <div class="cart-item__btn-container">
                            <button class="cart-item__delete-btn" id="deleteCartItemBtn2" data-item-id="${
                                item.id
                            }"></button>
                        </div>
                    </div>
                </div>

                `;
            } catch (e) {
                //console.log(e);
            }
        });
        if (empty) {
            output += `<div class="u-center-flex-w100-h100"><h1 class="heading-small">Korpa je prazna</h1></div>`;
        }

        this.orderContainer.innerHTML = output;
        this.addDeleteListener();
    }

    addDeleteListener() {
        // Adds listeners for delete buttons after it's rendered
        if (document.querySelectorAll("#deleteCartItemBtn2")) {
            let btns = document.querySelectorAll("#deleteCartItemBtn2");
            btns.forEach(element => {
                element.addEventListener("click", () => {
                    this.deleteItem(element);
                });
            });
        }
    }

    deleteItem(element) {
        let cartItemID = element.getAttribute("data-item-id");
        window.axios
            .post(`/api/cart/${cartItemID}`, { _method: "DELETE" })
            .then(response => {
                this.getItems();
                location.reload();
            })
            .catch(e => {
                console.log(e);
            });
    }
}

module.exports = Order;
