"use strict";

const formComenzar = document.querySelector("#comenzar");

formComenzar.addEventListener("submit", function (event) {
  event.preventDefault();
  confirmarTableroPropio(event);
});

let botonComenzar = document.querySelector("#btnComenzar");
let botonDisparar = document.querySelector("#btnDisparar");
botonDisparar.addEventListener("click", disparar);

let coordenadaDisparo = null;

let resultadoFinal = document.querySelector("#resultado");

const tableroPropio = {
  id_tablero: -1,
  id_juego: -1,
  flota: [],
  maxFragatas: 9,
};

async function renderizarTablero() {
  let response = await fetch("api/tablero");
  let resultado = await response.text();
  let tablero = document.querySelector("#tableroPropio");
  tablero.innerHTML = resultado;
}

// confirmar jugador y recibir id del juego
async function confirmarTablero() {
  let inputJugador = document.querySelector("#jugador").value;
  console.log(inputJugador);
  const response = await fetch("api/confirmarTablero", {
    method: "POST",
    body: inputJugador,
  });

  tableroPropio.id_tablero = await response.json();
  console.log(tableroPropio);
}

async function calcularEstadoDelJuego() {
  let response = await fetch("api/estado");
  if (response.ok) {
    if (parseInt(response.text()) === tableroPropio.maxFragatas) {
      resultadoFinal.classList.add("ganador");
    }
  }
}

async function disparar() {
  let response = await fetch("api/disparar", {
    method: "POST",
    body: {
      id_tablero: tableroPropio.id_tablero,
      id_juego: tableroPropio.id_juego,
      coordenadas: coordenadaDisparo,
    },
  });
  if (response.ok) {
    response.text().then(function (resultado) {
      let objetivoAlcanzado = document.querySelector(
        'td[data-coordenadas=\'{"x": 6, "y": "g"}\']'
      );
      if (Boolean(resultado) === true) {
        objetivoAlcanzado.classList.add("hundido");
        calcularEstadoDelJuego();
      } else {
        objetivoAlcanzado.classList.add("agua");
      }
    });
    coordenadaDisparo = null;
  }
}

function toggleDisparoHandler(e) {
  if (
    tableroPropio.disparos.length <= tableroPropio.maxDisparos &&
    tableroPropio.disparoSeleccionado === false
  ) {
    coordenadaDisparo = JSON.parse(e.target.dataset.coordenadas);
    e.target.classList.add("disparo");
    botonDisparar.textContent = "Disparar";
    botonDisparar.disabled = false;
  }
}

//renderizar radar para seleccionar ataques al enemigo
async function renderizarRandar() {
  let response = await fetch("api/tablero");
  let resultado = await response.text();
  let radar = document.querySelector("#radar");
  radar.classList.add("radar");
  radar.innerHTML = resultado;
  let coordenadasRadar = document.querySelectorAll(".seleccionable");
  coordenadasRadar.forEach((coordenada) => {
    coordenada.addEventListener("click", toggleDisparoHandler);
  });
}

// confirmar unicación definitiva de flota propia
async function insertarFlotaEnTablero() {
  const response = await fetch("api/insertarFlotaEnTablero", {
    method: "POST",
    body: JSON.stringify(tableroPropio),
    headers: {
      "Content-type": "application/json",
    },
  });

  console.log(await response.text());

  if (response.ok) {
    let celdasFijas = document.querySelectorAll(".seleccionable");
    console.log(celdasFijas);
    celdasFijas.forEach((celda) => {
      celda.classList.remove("seleccionable");
    });
    renderizarRandar();
  } else {
    throw new Error("Error para comenzar");
  }
}

// restfull
async function confirmarTableroPropio() {
  await confirmarTablero();
  await insertarFlotaEnTablero();
}

// selección de casillas y ubicación de fragatas
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

// una vez renderizado el tablero, preparar las casillas para la selección
function seleccionarUbicacionFlota() {
  let celdas = document.querySelectorAll(".seleccionable");
  celdas.forEach((el) => {
    el.addEventListener("click", toggleNaveEventHandler);
  });
}

renderizarTablero().then(seleccionarUbicacionFlota);
