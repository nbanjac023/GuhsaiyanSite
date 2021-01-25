class ImageSlider {
    constructor(imgs, togglerLeft, toggleRight) {
        this.togglerLeft = togglerLeft;
        this.togglerRight = toggleRight;
        this.imgs = imgs;
        this.currentImage = null;
        this.clear();
        this.currentIndex = 0;
        this.previousIndex = null;
        this.showImage(this.currentIndex);
        this.addListeners();
    }
    addListeners() {
        if (this.togglerLeft) {
            this.togglerLeft.addEventListener("click", () => {
                this.toggleLeft();
            });
        }
        if (this.togglerRight) {
            this.togglerRight.addEventListener("click", () => {
                this.toggleRight();
            });
        }
    }

    clear() {
        for (let img of this.imgs) {
            // Check if type of node is text, it it is, remove it because we don't need it, we need just the div
            if (img.nodeType == 3) {
                img.remove();
            }
        }
    }

    showImage(index) {
        this.imgs[index].classList.add("slide--active");
        this.currentImage = this.imgs[index];
        this.currentIndex = index;
    }
    hideImage(previous) {
        this.imgs[previous].classList.remove("slide--active");
    }

    toggleRight() {
        if (this.currentIndex + 1 < this.imgs.length) {
            this.previousIndex = this.currentIndex;
            this.currentIndex += 1;
            this.showImage(this.currentIndex);
        }
        this.hideImage(this.previousIndex);
    }
    toggleLeft() {
        if (this.currentIndex - 1 >= 0) {
            this.previousIndex = this.currentIndex;
            this.currentIndex -= 1;
            this.showImage(this.currentIndex);
            this.hideImage(this.previousIndex);
        }
    }
}
