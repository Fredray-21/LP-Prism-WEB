class Element {

    constructor(x, y, id) {
        this.X = x;
        this.Y = y;
        this.sprite = document.getElementById(id);
    }

    initialiser(x, y, str) {
        this.X = x;
        this.Y = y;
        this.setSrc(str);
        this.placer();
    }

    setSrc(str) {
        this.sprite.setAttribute("src", str);
    }

    placer() {
        let t = 51 + 20 * (this.Y - 1);
        let l = 51 + 20 * (this.X - 1);
        this.sprite.style.top = t + "px";
        this.sprite.style.left = l + "px";
    }

}