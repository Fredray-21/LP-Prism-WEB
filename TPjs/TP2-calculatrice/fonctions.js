let isCalculed = false;

function effacer() {
    document.getElementById("ecran").value = null;
}

function MAJecran(c) {
    if (isCalculed) {
        if (c !== "*" && c !== "/" && c !== "+" && c !== "-") {
            effacer();
        }
        isCalculed = false;
    }
    document.getElementById("ecran").value += c;
}

function calculer() {
    isCalculed = true;
    const val = document.getElementById("ecran").value;

    function eval(fn) {
        return new Function('return ' + fn)();
    }

    document.getElementById("ecran").value = eval(val); // result
}

function correction() {
    const val = document.getElementById("ecran").value;
    document.getElementById("ecran").value = val.slice(0, val.length - 1);
}
