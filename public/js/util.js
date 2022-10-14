
//active apres le chargement de la page
window.onload = function () {
    var loader = document.getElementById('loader-app')
    loader.style.display = 'none'
}

// Donne la date actuelle pour le copyright
document.getElementById("year").innerHTML = new Date().getFullYear();