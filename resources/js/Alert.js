let alert = document.querySelector(".alert");

// alert.classList.remove("alert--hidden");

setTimeout(() => {
    try {
        alert.classList.add("alert--hidden");
    } catch (e) {}
}, 3000);
