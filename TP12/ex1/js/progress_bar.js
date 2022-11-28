function scrollProgressBar() {
    function getMax() {
        return document.body.clientHeight - window.innerHeight;
    }

    function getValue() {
        return window.scrollY;
    }

    const progressBar = document.querySelector(".progress-bar");
    let max = getMax();

    function getWidth() {
        const value = getValue();
        let width = (value / max) * 100;
        width = width + "%";
        return width;
    }

    function setWidth() {
        progressBar.style.width = getWidth();
    };
    document.addEventListener("scroll", () => {
        setWidth();
    });
    window.addEventListener("resize", () => {
        max = getMax();
        setWidth();
    });
}

scrollProgressBar();