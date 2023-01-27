function estBissextile(annee) {
    return (annee % 400 == 0) || ((annee % 4 == 0) && (annee % 100 != 0));
}

function nbJours(annee, mois) {
    let n = 31;
    if ((mois == 4) || (mois == 6) || (mois == 9) || (mois == 11)) {
        n = 30;
    } else if (mois == 2) {
        if (estBissextile(annee)) {
            n = 29;
        } else {
            n = 28;
        }
    }
    return n;
}

function getMonthName(monthNumber) {
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    const date = new Date();
    date.setMonth(monthNumber - 1);
    return capitalize(date.toLocaleString('fr-fr', {month: 'long'}));
}

function mettreajourcalendrier() {

    let annee = document.getElementById('selectA').value;
    let mois = document.getElementById('selectM').value;
    creerCalendrier(annee, mois);

    const now = new Date();
    const currentYear = now.getFullYear();

    if (currentYear - 51 == annee) {
        document.getElementById('reculerY').disabled = true;
    } else {
        document.getElementById('reculerY').disabled = false;
    }

    if (currentYear + 98 == annee) {
        document.getElementById('avancerY').disabled = true;
    } else {
        document.getElementById('avancerY').disabled = false
    }

    if (currentYear - 51 == annee && mois == 1) {
        document.getElementById("reculerM").disabled = true;
    } else {
        document.getElementById('reculerM').disabled = false;
    }

    if (currentYear + 98 == annee && mois == 12) {
        document.getElementById('avancerM').disabled = true;
    } else {
        document.getElementById('avancerM').disabled = false
    }

    document.getElementById("texteC").innerText = `Voici le calendrier de ${getMonthName(mois)} de ${annee}`;
}

function avancer(i) {
    console.log(i);
    let annee = document.getElementById('selectA').value;
    let mois = document.getElementById('selectM').value;
    let newM = parseInt(mois);
    let newA = parseInt(annee);
    if (i == 12) {
        newA += 1;
    } else {
        newM += i;
        if (newM % 13 == 0) {
            newA += 1;
            newM -= 12;
        }
    }

    document.getElementById('selectM').value = newM;
    document.getElementById('selectA').value = newA;
    mettreajourcalendrier();
}

function reculer(i) {
    let annee = document.getElementById('selectA').value;
    let mois = document.getElementById('selectM').value;
    let newM = parseInt(mois);
    let newA = parseInt(annee);
    if (i == 12) {
        newA -= 1;
    } else {
        newM -= i;
        if (newM == 0) {
            newA -= 1;
            newM += 12;
        }
    }
    document.getElementById('selectM').value = newM;
    document.getElementById('selectA').value = newA;
    mettreajourcalendrier();
}

function creerSelectA() {
    const selectA = document.getElementById("selectA");
    const start = 2022;
    for (let i = -50; i < 100; i++) {
        const option = document.createElement("option");
        option.value = 2022 + i;
        option.innerText = 2022 + i;
        selectA.append(option);
    }
}

function creerSelectM() {
    const selectM = document.getElementById("selectM");
    for (let i = 1; i <= 12; i++) {
        const option = document.createElement("option");
        option.value = i;
        option.innerText = getMonthName(i);
        selectM.append(option);
    }
}

function toutCreer() {
    creerSelectA();
    creerSelectM();
    setInterval(() => actualiser_heure(), 1000);
    mettreajourcalendrier();
}

function LMMJVSD(annee, mois, jour) {
    let date = new Date(annee, mois - 1, jour);
    let jourSemaine = date.getDay();
    let jourSemaineNom = "";
    switch (jourSemaine) {
        case 0:
            jourSemaineNom = "Dimanche";
            break;
        case 1:
            jourSemaineNom = "Lundi";
            break;
        case 2:
            jourSemaineNom = "Mardi";
            break;
        case 3:
            jourSemaineNom = "Mercredi";
            break;
        case 4:
            jourSemaineNom = "Jeudi";
            break;
        case 5:
            jourSemaineNom = "Vendredi";
            break;
        case 6:
            jourSemaineNom = "Samedi";
            break;
    }
    return jourSemaineNom;
}

function creerCalendrier(annee, mois) {
    let nbJoursMois = nbJours(annee, mois);
    let date = new Date(annee, mois - 1, 1);
    let jourSemaine = date.getDay();
    let jourSemaineNom = "";
    switch (jourSemaine) {
        case 0:
            jourSemaineNom = "Dimanche";
            break;
        case 1:
            jourSemaineNom = "Lundi";
            break;
        case 2:
            jourSemaineNom = "Mardi";
            break;
        case 3:
            jourSemaineNom = "Mercredi";
            break;
        case 4:
            jourSemaineNom = "Jeudi";
            break;
        case 5:
            jourSemaineNom = "Vendredi";
            break;
        case 6:
            jourSemaineNom = "Samedi";
            break;
    }
    let html = "";
    html += "<table>";
    html += "<tr class='entete'>";
    html += "<th>Dimanche</th>";
    html += "<th>Lundi</th>";
    html += "<th>Mardi</th>";
    html += "<th>Mercredi</th>";
    html += "<th>Jeudi</th>";
    html += "<th>Vendredi</th>";
    html += "<th>Samedi</th>";
    html += "</tr>";
    html += "<tr>";
    for (let i = 0; i < jourSemaine; i++) {
        html += "<td class='gris'></td>";
    }

    // add yellow class in dimanche


    for (let i = 1; i <= nbJoursMois; i++) {
        if (jourSemaine == 7) {
            html += "</tr><tr>";
            jourSemaine = 0;
        }
        if (jourSemaine == 0) {
            html += `<td class='dimanche'>${i}</td>`;
        } else {
            html += `<td>${i}</td>`;
        }

        jourSemaine++;
    }

    for (let i = jourSemaine; i < 7; i++) {
        html += "<td class='gris'></td>";
    }

    html += "</tr>";
    html += "</table>";
    document.getElementById("calendrier").innerHTML = html;

}

function actualiser_heure() {
    const now = new Date();
    const annee = now.getFullYear();
    const mois = add0(now.getMonth() + 1);
    const jour = add0(now.getDate());
    const heure = add0(now.getHours());
    const minute = add0(now.getMinutes());
    const seconde = add0(now.getSeconds());

    function add0(val) {
        if (("" + val).length == 1) {
            return "0" + val;
        }
        return val
    }

    const str = `${heure}:${minute}:${seconde} - ${jour}/${mois}/${annee}`
    document.getElementById("affichage_heure").innerText = str;
}


