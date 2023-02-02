/* ==============================
 Autor      : Luigui A. Parodi
 Web        : github.com/LPDev93
 Fecha      : 17/01/2023
 Versión    : 1.00
 Idioma     : Español - Latino
 Proyecto   : Real Estate 
============================== */

//-- Variables - Selectores
let header = document.querySelector(".header");

//-- Propiedades - Menu hamburguesa - Abrir
document.querySelector("#menu-btn").onclick = () => {
  header.classList.add("active");
};

//-- Propiedades - Menu hamburguesa - Cerrar
document.querySelector("#close-btn").onclick = () => {
  header.classList.remove("active");
};

//-- Propiedades - Menu hamburguesa - Ocultar
window.onscroll = () => {
  header.classList.remove("active");
};

//-- Propiedades - Validar tipo de variable numérica
document.querySelectorAll('input[type="number"]').forEach((inputNumbmer) => {
  inputNumbmer.oninput = () => {
    if (inputNumbmer.value.length > inputNumbmer.maxLength)
      inputNumbmer.value = inputNumbmer.value.slice(0, inputNumbmer.maxLength);
  };
});