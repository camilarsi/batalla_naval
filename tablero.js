"use strict";

const formComenzar = document.querySelector("#comenzar");

formComenzar.addEventListener("submit", function (event) {
  event.preventDefault();
  confirmarTableroPropio(event);
});

let botonComenzar = document.querySelector("#btnComenzar");

const tableroPropio = {
  id: -1,
  flota: [],
  maxFragatas: 9,
};

async function renderizarTablero() {
  let response = await fetch("api/tablero");
  let resultado = await response.text();
  let tablero = document.querySelector("#tableros");
  tablero.innerHTML = resultado;
}

async function confirmarTablero() {
  let inputJugador = document.querySelector("#jugador").value;
  console.log(inputJugador);
  const response = await fetch("api/confirmarTablero", {
    method: "POST",
    body: inputJugador,
  });
  tableroPropio.id = await response.text();
}

async function insertarFlotaEnTablero() {
  const response = await fetch("api/insertarFlotaEnTablero", {
    method: "POST",
    body: JSON.stringify(tableroPropio),
    headers: {
      "Content-type": "application/json",
    },
    // tableroPropio.ids_barcos
  });

  console.log(await response.text());

  if (!response.ok) {
    throw new Error("Error e comenzar");
  }
}

async function confirmarTableroPropio() {
  await confirmarTablero();
  await insertarFlotaEnTablero();
}

function toggleNaveEventHandler(e) {
  if (
    tableroPropio.flota.length === tableroPropio.maxFragatas &&
    !e.target.classList.contains("fragata")
  ) {
    return -1;
  }
  const coordenadas = JSON.parse(e.target.dataset.coordenadas);
  let indice = tableroPropio.flota.findIndex((fragata) => {
    // [{ x: 2, y: 'g'}]
    return fragata.x === coordenadas.x && fragata.y === coordenadas.y;
  });
  if (indice === -1 && tableroPropio.flota.length < tableroPropio.maxFragatas) {
    tableroPropio.flota.push(coordenadas);
  } else {
    tableroPropio.flota.splice(indice, 1);
    botonComenzar.disabled = true;
    botonComenzar.textContent = "";
  }
  if (tableroPropio.flota.length === tableroPropio.maxFragatas) {
    botonComenzar.disabled = false;
    botonComenzar.textContent = "Comenzar";
  }
  e.target.classList.toggle("fragata");
  e.target.classList.remove(".seleccionable");
  console.log(tableroPropio.flota);
}

function escucharCeldas() {
  let celdas = document.querySelectorAll(".seleccionable");
  celdas.forEach((el) => {
    el.addEventListener("click", toggleNaveEventHandler);
  });
}

renderizarTablero().then(escucharCeldas);
