const basePath = "https://www.eugeniomariz.com.br/"
function menuView() {
    let menuMobile = document.querySelector('.mobile-menu');
    let icon = document.querySelector(".icon");

    // Verifica se o menu está aberto ou fechado e faz o toggle
    if (menuMobile.classList.contains('open')) {
        menuMobile.classList.remove('open');
        icon.src = basePath+"img/menu-mobile-icon.svg";  // Ícone de menu normal
    } else {
        menuMobile.classList.add('open');
        icon.src = basePath+"img/menu-x-icon.svg";  // Ícone de menu fechado
    }
}

// Detecta cliques fora do menu para fechar
document.addEventListener('click', function (event) {
    let menuMobile = document.querySelector('.mobile-menu');
    let icon = document.querySelector(".icon");
    let menuButton = document.querySelector(".button-menu-mobile");  // Botão que abre/fecha o menu

    // Verifica se o clique foi fora do menu e do botão
    if (!menuMobile.contains(event.target) && !menuButton.contains(event.target)) {
        // Fecha o menu se estiver aberto
        if (menuMobile.classList.contains('open')) {
            menuMobile.classList.remove('open');
            icon.src = basePath+"img/menu-mobile-icon.svg";  // Ícone de menu normal
        }
    }
});
// Fim do Menu mobile

// Configurando o slide automático

let count = 1;
document.getElementById("radio1").checked = true;

setInterval(function () {
    proxImg();
}, 3000)

function proxImg() {
    count++;
    if (count > 4) {
        count = 1;
    }
    document.getElementById("radio" + count).checked = true;
}
// Fim do slide automático

// Configurando mensagem de cookie
var msgCookies = document.getElementById('coockies');

function aparecerCoockie() {
    localStorage.lgpd = "sim"
    msgCookies.classList.remove('view')
}

if (localStorage.lgpd == 'sim') {
    msgCookies.classList.remove('view')
} else {
    msgCookies.classList.add('view')
}
// Fim da mensagem de cookie