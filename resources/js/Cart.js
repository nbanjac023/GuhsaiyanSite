class Cart {
    constructor(cartBtnID) {
        this.cartBtn = document.querySelector(cartBtnID)
            ? document.querySelectorAll(cartBtnID)
            : null;
        this.cart = null;
        this.addListener();
        this.currency = null;
        this.addToCart();
        this.cartItems = null;
        this.cartItemCount = document.querySelector("#cartItemCount")
            ? document.querySelector("#cartItemCount")
            : null;
        this.getItems();
    }

    getCurrencyName() {
        window.axios
            .get("/api/currency")
            .then(response => {
                this.currency = response.data;
            })
            .catch(err => {});
    }

    addListener() {
        if (this.cartBtn != null) {
            this.cart = document.querySelector(".cart");
            this.sectionIntro = document.querySelector("#cartToggleArea");

            this.cartBtn.forEach(element => {
                element.addEventListener("click", e => {
                    this.cart.classList.toggle("cart--active");
                });
            });

            this.sectionIntro.addEventListener("click", () => {
                if (
                    this.cart.classList.contains("cart--active") &&
                    !this.cart.classList.contains("cart--block")
                ) {
                    this.cart.classList.remove("cart--active");
                }
            });
        }
        this.getCurrencyName();
    }

    getItems() {
        window.axios
            .get("/api/cart")
            .then(response => {
                this.cartItems = response.data;
                this.getProducts();
                this.setItemCount(this.cartItems.length);
            })
            .catch(e => {});
    }
    getProducts() {
        let empty = true;
        if (this.cartItems.length > 0) {
            empty = false;
        }
        this.cartItems.forEach(element => {
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
    renderItems(empty = true) {
        output = "";
        this.cartItems.forEach(item => {
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
                            <button class="cart-item__delete-btn" id="deleteCartItemBtn" data-item-id="${
                                item.id
                            }"></button>
                        </div>
                    </div>
                </div>

                `;
            } catch (e) {}
        });
        if (!empty) {
            this.cart.style.maxHeight = "53vh";
            output += `<div class="cart__btn-container u-margin-top-sm u-margin-bottom-sm">
		                <a href="/orders" class="btn btn--primary">Poruci</a>
	                </div>`;
        } else {
            this.cart.style.height = "auto";
            output += `<div class="u-margin-top-sm u-margin-bottom-sm"><h1 class="heading-small u-color-grey">Korpa je prazna</h1></div>`;
        }
        this.cart.innerHTML = output;

        this.addDeleteListener();
    }

    setItemCount(itemCount) {
        try {
            if (itemCount == 0) {
                this.cartItemCount.innerHTML = "";
            } else {
                this.cartItemCount.innerHTML = itemCount;
            }
        } catch (e) {}
    }

    addToCart() {
        if (document.querySelector("#addToCartBtn")) {
            let data = {
                product_id: "",
                size: "",
                quantity: null
            };

            let addToCartBtn = document
                .querySelector("#addToCartBtn")
                .addEventListener("click", event => {
                    data.product_id = event.target.getAttribute("data-id");
                    data.size = document.querySelector("#size").value;
                    data.quantity = document.querySelector("#quantity").value;
                    if (data.size == "none") {
                        this.showAlert("Niste izabarali veličinu", "error");
                        return;
                    }
                    if (data.quantity > 5) {
                        this.showAlert("Maksimalna količina je 5", "error");
                        return;
                    }
                    window.axios
                        .post("/api/cart", data)
                        .then(response => {
                            this.getItems();
                            this.cart.style.maxHeight = "53vh";
                            this.cart.style.height = "";
                            this.showAlert(
                                "Proizvod je dodat u korpu",
                                "success"
                            );
                        })
                        .catch(e => {});
                });
        }
    }
    addDeleteListener() {
        // Adds listeners for delete buttons after it's rendered
        if (document.querySelectorAll("#deleteCartItemBtn")) {
            let btns = document.querySelectorAll("#deleteCartItemBtn");

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

                if (window.location.pathname == "/orders") {
                    location.reload();
                }
            })
            .catch(e => {});
    }

    showAlert(message, type) {
        let alert = document.querySelector(".alert");
        if (type == "success") {
            alert.classList.add("alert--success");
        } else if (type == "error") {
            alert.classList.add("alert--error");
        }

        let content = document.querySelector("#alert-text");

        content.innerHTML = message;

        alert.classList.remove("alert--hidden");

        setTimeout(() => {
            alert.classList.add("alert--hidden");
            alert.classList.remove("alert--error");
            alert.classList.remove("alert--success");
        }, 2000);
    }
}
module.exports = Cart;
