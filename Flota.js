export class Flota {
  constructor(tipo, max) {
    this.tipo = tipo;
    this.max = max;
    this.naves = [];
  }

  toggleNaveEventHandler(e) {
    if (
      this.naves.length === this.max &&
      !e.target.classList.contains(`${this.tipo}`)
    ) {
      return -1;
    }
    const coordenadas = JSON.parse(e.target.dataset.coordenadas);
    let indice = this.naves.findIndex((nave) => {
      // [{ x: 2, y: 'g'}]
      return nave.x === coordenadas.x && nave.y === coordenadas.y;
    });
    if (indice === -1 && this.naves.length < this.max) {
      this.naves.push(coordenadas);
    } else {
      this.naves.splice(indice, 1);
      botonComenzar.disabled = true;
      botonComenzar.textContent = "";
    }
    if (this.naves.length === this.max) {
      botonComenzar.disabled = false;
      botonComenzar.textContent = "Comenzar";
    }
    e.target.classList.toggle(`${this.tipo}`);
    e.target.classList.remove(".seleccionable");
    console.log(this.naves);
  }
}
