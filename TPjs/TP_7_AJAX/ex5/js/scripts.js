let xhr = new XMLHttpRequest();
let div_verbes = document.getElementById("liste_verbes");
let div_input = document.getElementById("input");

document.body.onload = creer_interface;

function creer_interface() {
    const input = document.createElement("input");
    input.id = "input_recherche";
    input.placeholder = "Entrez un séquance..."
    div_input.append(input);

    // creation de l'alphabet sans les lettres W, X et Y et avec la lettre Œ pour le clavier
    const alpha = Array.from(Array(26)).map((e, i) => i + 65);
    const alphabet = alpha.map((x) => String.fromCharCode(x)).filter(e => e != "W" && e != "X" && e != "Y");
    alphabet.push("Œ");

    let row = document.createElement("div");
    row.classList.add("row");
    alphabet.forEach((letter, idx) => {
        const div = document.createElement("div");
        div.innerHTML = letter;
        div.classList.add("key");
        row.append(div);
        if (idx % 6 == 5) {
            div_input.append(row);
            row = document.createElement("div");
            row.classList.add("row");
        }
    });

    const btnClear = document.createElement("input");
    btnClear.type = "button";
    btnClear.id = "clear";
    btnClear.value = "Effacer la liste";
    div_input.append(btnClear);

    btnClear.addEventListener("click", () => {
        const liste_verbes = document.querySelector('#liste_verbes');
        const input_recherche = document.querySelector('#input_recherche');
        liste_verbes.innerHTML = null;
        input_recherche.value = "";
    });
    main();
}

function callback_basique(xhr) {
    const data = JSON.parse(xhr.responseText);
    console.table(data);
}

function callback(xhr) {
    const data = JSON.parse(xhr.responseText);
    const liste_verbes = document.querySelector('#liste_verbes');
    liste_verbes.innerHTML = null;
    data.forEach(verb => {
        const p = document.createElement("p")
        p.innerHTML = verb["libelle"];
        p.style.margin = "0";
        liste_verbes.append(p);
    });
}

function charger_verbes(lettre, type) {
    const xhr = new XMLHttpRequest();
    const url = "./php/recherche.php?lettre=" + lettre + "&type=" + type;
    xhr.open("GET", url, true);
    xhr.onload = () => {
        callback(xhr)
        callback_basique(xhr);
    }
    xhr.send();
}

function main() {
    const keys = document.querySelectorAll('.key');
    keys.forEach(key => {
        key.addEventListener("click", () => {
            console.log(key.innerHTML);
            charger_verbes(key.innerHTML, 'init');
        })
    })

    const input_recherche = document.querySelector('#input_recherche');
    input_recherche.addEventListener('input', () => {
        charger_verbes(input_recherche.value, 'seq');
    });
}
