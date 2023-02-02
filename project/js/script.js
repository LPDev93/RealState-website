/* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
============================== */

// -- Variables
let w = window;
let d = document;
let menu = d.querySelector(".header .navbar .menu");
let menu_btn = d.querySelector("#menu-btn");
let number = d.querySelectorAll('input[type="number"]');
let faq = d.querySelectorAll(".faq .box-container .box h3");

// -- Métodos - Cambiar de estado al hacer click
menu_btn.onclick = () => menu.classList.toggle("active");

// -- Métodos - Cambiar preguntar de FAQ
faq.forEach(
  (heading) =>
    (heading.onclick = () => {
      heading.parentElement.classList.toggle("active");
    })
);

// -- Métodos - Ocultar componentes al accionar
w.onscroll = () => menu.classList.remove("active");

// -- Métodos - Validar longitud del número ingresado
number.forEach((inputNumber) => {
  inputNumber.oninput = () => {
    if (inputNumber.value.length > inputNumber.maxlength) {
      inputNumber.value = inputNumber.value.slice(0, inputNumber.maxlength);
    }
  };
});
