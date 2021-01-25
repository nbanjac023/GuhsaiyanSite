require("./bootstrap");
require("./product");
require("./Alert");
require("./Chart");
require("./ImageSlider");

const Cart = require("./Cart");
// const LatestProducts = require("./LatestProducts");
const Orders = require("./Orders");

// Navbar toggle

const burgerBtn = document
    .querySelector("#burgerBtn")
    .addEventListener("click", () => {
        document
            .querySelector(".navbar-mobile")
            .classList.toggle("navbar-mobile--hidden");
    });

const cart = new Cart("#cartBtn");
// const latestProducts = new LatestProducts("#section-latest-btn");
const order = new Orders("#orderShowItems");

/*
@desc:
    Image slider
*/

if (document.querySelector(".product-index__link")) {
    let imageInstances = [];
    // Instantiate imgs
    let allProducts = document.querySelectorAll(".product-index__link");
    for (let product of allProducts) {
        let leftToggler = product.nextElementSibling.children[0];
        let rightToggler = product.nextElementSibling.children[1];
        let productChilds = product.childNodes;
        for (let child of productChilds) {
            if (child.nodeType == 1) {
                imageInstances.push(
                    new ImageSlider(productChilds, leftToggler, rightToggler)
                );
                break;
            }
        }
    }
}
