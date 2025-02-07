function menuView() {
    const menuMobile = document.querySelector('.aside-responsivo');
    const icon = document.querySelector(".icon");
    const body = document.body;

    // Alterna o menu e trava/destrava o scroll da página
    if (menuMobile.classList.contains('open')) {
        menuMobile.classList.remove('open');
        body.classList.remove('no-scroll');
        icon.src = "./img/menu.svg";  // Ícone de menu normal
    } else {
        menuMobile.classList.add('open');
        body.classList.add('no-scroll');
        icon.src = "./img/menu-x-icon.svg";  // Ícone de menu fechado
    }
}

// Detecta cliques fora do menu para fechar
document.addEventListener('click', function (event) {
    const menuMobile = document.querySelector('.aside-responsivo');
    const icon = document.querySelector(".icon");
    const body = document.body;
    const menuButton = document.querySelector(".button-menu");

    if (!menuMobile.contains(event.target) && !menuButton.contains(event.target)) {
        if (menuMobile.classList.contains('open')) {
            menuMobile.classList.remove('open');
            body.classList.remove('no-scroll');
            icon.src = "./img/menu.svg";  // Ícone de menu normal
        }
    }
});

// Colocando opção de visualizar e esconder senha

const inputPassword = document.getElementById("password");
const viewButton = document.getElementById("viewPassword");
const iconView = viewButton.querySelector("i");

viewButton.addEventListener("click", () => {
    if (inputPassword.type === "password") {
        inputPassword.type = "text";
        iconView.classList.remove("fa-eye");
        iconView.classList.add("fa-eye-slash");
    } else {
        inputPassword.type = "password";
        iconView.classList.remove("fa-eye-slash");
        iconView.classList.add("fa-eye");
    }
});