//Toggle mode style(day or night)
const modeStyle = document.querySelector("[toggle-mode]");
if (modeStyle) {
    modeStyle.addEventListener("click", () => {
        const body = document.getElementsByTagName("body")[0];

        if (body.classList.contains("night-mode")) {
            body.classList.remove("night-mode");
            setModePreference("day");
        } else {
            body.classList.add("night-mode");
            setModePreference("night");
        }
    });
}

//Load mode style
window.addEventListener("DOMContentLoaded", () => {
    const modePreference = getModePreference();

    if (modePreference === "night") {
        const body = document.getElementsByTagName("body")[0];
        body.classList.add("night-mode");
    }
});

//Set mode style
function setModePreference(mode) {
    const expiryDate = new Date();
    expiryDate.setFullYear(expiryDate.getFullYear() + 10); // Define a data de expiração para 10 anos no futuro

    document.cookie = `modo=${mode}; expires=${expiryDate.toUTCString()}; path=/`;
}

//get mode style
function getModePreference() {
    const cookieValue = document.cookie.replace(
        /(?:(?:^|.*;\s*)modo\s*=\s*([^;]*).*$)|^.*$/,
        "$1"
    );
    return cookieValue;
}

window.addEventListener("DOMContentLoaded", () => {
    const dropdowns = document.querySelectorAll(".navbar .dropdown");

    // Adiciona o evento de passar o mouse para abrir o dropdown
    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener("mouseover", function () {
            dropdown.querySelector(".dropdown-menu").classList.add("show");
        });

        // Fecha o dropdown quando o mouse sai dele
        dropdown.addEventListener("mouseleave", function () {
            dropdown.querySelector(".dropdown-menu").classList.remove("show");
        });
    });
});

//fixed menu on top
let mainHeaderInitialPosition = 0;

window.addEventListener("scroll", function () {
    const menuTopo = document.querySelector("#menu-topo");
    const mainHeader = document.querySelector(".main-menu");
    const menuTopoHeight = menuTopo.offsetHeight;
    const mainHeaderPosition = mainHeader.getBoundingClientRect().top;
    const currentScrollPos =
        window.pageYOffset || document.documentElement.scrollTop;

    if (mainHeaderInitialPosition === 0) {
        mainHeaderInitialPosition = mainHeaderPosition;
    }

    if (
        mainHeaderPosition <= menuTopoHeight &&
        currentScrollPos > mainHeaderInitialPosition
    ) {
        mainHeader.classList.add("fixed");
    } else if (currentScrollPos <= mainHeaderInitialPosition) {
        mainHeader.classList.remove("fixed");
    }
});

//close feedback message toast
const closeButtons = document.querySelectorAll(
    '[data-dismiss="toast"][aria-label="Close"]'
);
closeButtons.forEach((closeButton) =>
    closeButton.addEventListener("click", (event) =>
        event.target.closest(".toast-feedback").classList.remove("show")
    )
);

let width = 0;
const toastSuccess = document.querySelector(".toast-feedback .progress-close");

if (toastSuccess) {
    const hideMessage = setInterval(() => {
        width++;
        toastSuccess.style.width = `${width}%`;
        if (width >= 100) {
            toastSuccess.closest(".toast-feedback").classList.remove("show");
            clearInterval(hideMessage);
        }
    }, 40);
}
const toastError = document.querySelector(".toast-feedback .progress-close");

if (toastError) {
    const hideMessage = setInterval(() => {
        width++;
        toastError.style.width = `${width}%`;
        if (width >= 100) {
            toastError.closest(".toast-feedback").classList.remove("show");
            clearInterval(hideMessage);
        }
    }, 40);
}

//Code to increase and decrease font

let totalChangeSizeFontIn = 0;
let changeSizeFontIn = 2;
const maxChangeFontSize = 14;
const minChangeFontSize = -8;

const fontChangeElements = [
    document.querySelectorAll('button[type="button"]'),
    document.querySelectorAll("h1"),
    document.querySelectorAll("h2"),
    document.querySelectorAll("h3"),
    document.querySelectorAll("a"),
    document.querySelectorAll("p"),
    document.querySelectorAll("span")
];

const btnIncreaseFont = document.querySelector(".increase-font");
const btnDecreaseFont = document.querySelector(".decrease-font");
const btnRestoreDefaultFontSize = document.querySelector(".restore-default-font");

function changeFontSize(nList, operator, restore = false) {
    
    nList.forEach((item) => {
        let currentFontSize = window.getComputedStyle(item, null).getPropertyValue("font-size");

        let newSize = '';
        newSize = restore ? parseFloat(currentFontSize) - totalChangeSizeFontIn : 
            (operator == '+' ? parseFloat(currentFontSize) + changeSizeFontIn : parseFloat(currentFontSize) - changeSizeFontIn);

        item.style.fontSize = newSize + "px";
    });
}

// Increase Font
btnIncreaseFont.addEventListener("click", increaseFont);

// Decrease Font
btnDecreaseFont.addEventListener("click", decreaseFont);

// Restore Default font Size
btnRestoreDefaultFontSize.addEventListener("click", restoreFont);

//hot keys
document.addEventListener('keydown', event => {

    if(event.altKey && event.shiftKey){
        if(event.key == 'F'){
            increaseFont();
        }
        if(event.key == 'G'){
            decreaseFont();
        }
        if(event.key == 'R'){
            restoreFont();
        }
        if (event.key === 'H') {
            redirectToHome();
        }
        if (event.key === 'K') {
            scrollToTop();
        }
        if (event.key === 'N') {
            if(modeStyle){
                modeStyle.click();
            }
        }
    }
});

function increaseFont(){
    if(totalChangeSizeFontIn < maxChangeFontSize){
        totalChangeSizeFontIn = totalChangeSizeFontIn + changeSizeFontIn;
        fontChangeElements.forEach(element => changeFontSize(element, '+'));
    }
}

function decreaseFont(){
    if(totalChangeSizeFontIn > minChangeFontSize ){
        totalChangeSizeFontIn = totalChangeSizeFontIn - changeSizeFontIn;
        fontChangeElements.forEach(element => changeFontSize(element, '-'));
    }
}

function restoreFont(){
    if(totalChangeSizeFontIn != 0 ){
        fontChangeElements.forEach(element => changeFontSize(element, '', true));
        totalChangeSizeFontIn = 0;
    }
}

function redirectToHome() {
    window.location.href = '/';
}

function scrollToTop() {
    window.scrollTo(0, 0);
}