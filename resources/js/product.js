if (document.querySelector("#productImg")) {
    let productImg = document.querySelector("#productImg");
    let productSmallImgs = document.querySelectorAll("#productSmallImg");
    productSmallImgs.forEach(element => {
        element.addEventListener("click", changeImg);
    });

    function changeImg() {
        let temporary = productImg.src;
        productImg.src = this.src;
        this.src = temporary;
    }
}

