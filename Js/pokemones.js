// Si desea implementar en la base de datos los pokemones coloque en la siguiente url esta url https://pokeapi.co/api/v2/pokemon?limit=1283&offset=0 

function getAllPokemon() {
  return fetch('https://pokeapi.co/api/v2/pokemon?limit=1&offset=0')
    .then(response => response.json())
    .then(data => data.results);
}

function getPokemonDetails(url) {
  return fetch(url)
    .then(response => response.json());
}

function getPokemon() {
  return getAllPokemon().then(results => {
    const pokemonPromises = results.map(pokemon => {
      return getPokemonDetails(pokemon.url);
    });

    return Promise.all(pokemonPromises);
  });
}

function enviarAControlador(pokemonData) {
  // Crear un array para almacenar los datos de cada Pokémon
  const pokemonDataArray = [];

  // Recorrer los datos de los Pokémon
  pokemonData.forEach(pokemon => {
    // Obtener los valores necesarios de cada Pokémon
    let id = pokemon.id;
    let nombrePo = pokemon.name;
    let precioPo = pokemon.base_experience ? pokemon.base_experience * 100 : getRandomNumber(1000, 20000);
    let cantidadPo = Math.floor(Math.random() * 1000) + 1; // Generar una cantidad aleatoria entre 1 y 1000
    let abilities = pokemon.abilities.slice(0, 3).map(ability => ability.ability.name);
    let descripPo = abilities.join(', ');

    // Crear un objeto con los datos del Pokémon
    const pokemonDataObj = {
      "id": id,
      "nombrePo": nombrePo,
      "precioPo": precioPo,
      "cantidadPo": cantidadPo,
      "descripPo": descripPo
    };

    // Agregar el objeto al array
    pokemonDataArray.push(pokemonDataObj);
  });

  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(pokemonDataArray)
  }

  let urlPo = "./controlador/pokemones.datos.php";
  // Enviar los datos al controlador de PHP
  fetch(urlPo, options)
    .then((response) => response.json())
    .then((data) => {
      if (data.ok) {
        console.log('Datos enviados correctamente al controlador.');
      } else {
        throw new Error('Error al enviar los datos al controlador.');
      }
    })
    .catch(error => {
      console.log(error);
    });
}

function getRandomNumber(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function cargarPokemones() {
  // Realizar una solicitud GET al servidor para obtener la lista de pokemones
  fetch('./controlador/pokemones.read.php')
    .then(response => response.json())
    .then(data => {
      // Obtener el elemento select
      const selectPokemones = document.getElementById('selectPokemones');

      // Limpiar opciones existentes
      selectPokemones.innerHTML = '';

      // Generar opciones para cada pokemon
      data.forEach(pokemon => {
        const option = document.createElement('option');
        option.value = pokemon.id;
        option.textContent = pokemon.nombrePo;
        selectPokemones.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error al cargar los pokemones', error);
    });
}


cargarPokemones()

//compraPokemones.html
function compraPokemones() {
  let selectPokemon = selectPokemones.value;
  let cantidad = numCantidad.value;

  // Crear un objeto FormData para enviar los datos
  let data = new FormData();
  data.append('selectPokemones', selectPokemon);
  data.append('numCantidad', cantidad);

  let option = {
    method: "POST",
    body: data
  };

  let url = "./controlador/compra.pokemones.php";

  fetch(url, option)
    .then(response => response.json())
    .then(data => {
      // Obtener el ID de la compra
      let idCom = data.idCom;

      // Enviar el ID de la compra junto con los demás datos al controlador compra.pedido.php
      enviarPedido(idCom, selectPokemon, cantidad);
    })
    .catch(error => {
      console.error('Error al comprar el Pokémon', error);
    });
}

function enviarPedido(idCom, idPokemon, cantidad) {
  let data = new FormData();
  data.append('idCom', idCom);
  data.append('idPo', idPokemon);
  data.append('cantidadPoCom', cantidad);

  let option = {
    method: "POST",
    
    body: data
  };

  let url = "./controlador/compra.pedido.php";

  fetch(url, option)
    .then(response => response.json())
    .then(data => {
      console.log(data);
      Swal.fire('Pokemon', 'Comprado correctamente', 'success');
      numCantidad.value = "";
    })
    .catch(error => {
      console.error('Error al enviar el pedido', error);
    });
}



// Llamar a la función getPokemon() para obtener los datos de los Pokémon
getPokemon()
  .then(data => {
    // Enviar los datos al controlador de PHP
    enviarAControlador(data);
  })
  .catch(error => {
    console.log(error);
  });

let buy = []
let totalCard = 0
let countPokemon = 0

let allContainerCart = document.querySelector('.pokemones')
let containerBuytCart = document.querySelector('.card-items')
let priceTotal = document.querySelector('.price-total')
let amountPokemon = document.querySelector('.count-pokemon')

loadEventListeners()
function loadEventListeners() {
  allContainerCart.addEventListener('click', AgregarPokemon)
  containerBuytCart.addEventListener('click', deletePokemon);
}

function AgregarPokemon(e) {
  e.preventDefault();
  if (e.target.classList.contains('btn-add-cart')) {
    readThecontent(e.target.parentElement.parentElement.parentElement.parentElement.parentElement)
  }
}

function deletePokemon(e) {
  if (e.target.classList.contains('delete-pokemon')) {
    const deleteId = e.target.getAttribute('data-id');
    buy.forEach(value => {
      if (value.id == deleteId) {
        let priceReduce = parseFloat(value.price) * parseFloat(value.cantidad)
        totalCard = totalCard - priceReduce;
        totalCard = totalCard.toFixed(2)
      }
    })

    buy = buy.filter(pokemon => pokemon.id !== deleteId);

    countPokemon--
    if (buy.length === 0) {
      priceTotal.innerHTML = 0;
      amountPokemon.innerHTML = 0;
    }
  }

  loadHtml();
}

function readThecontent(pokemon) {
  const infoPokemon = {
    image: pokemon.querySelector('div img').src,
    title: pokemon.querySelector('.card-title').textContent,
    price: pokemon.querySelector('.price').textContent,
    id: pokemon.querySelector('div button').getAttribute('name'),
    cantidad: parseInt(pokemon.querySelector('.product-quantity').value)

  }
  console.log(infoPokemon)
  const exist = buy.some(pokemon => pokemon.id === infoPokemon.id);
  if (exist) {
    const pro = buy.map(pokemon => {
      if (pokemon.id === infoPokemon.id) {
        pokemon.cantidad += infoPokemon.cantidad;
        return pokemon;
      } else {
        return pokemon;
      }
    });
    buy = [...pro];
  } else {
    buy = [...buy, infoPokemon];
    countPokemon++
    loadHtml();
    console.log(buy);
  }


  totalCard = buy.reduce((total, product) => {
    return total + parseFloat(product.price) * parseInt(product.cantidad);
  }, 0);
  totalCard = totalCard.toFixed(2);

  loadHtml();
}

function enviarDatosAlControlador() {
  const usuario = JSON.parse(localStorage.getItem('usuario'));

  // Verifica si el usuario ha iniciado sesión
  if (!usuario) {
    Swal.fire('Carrito', 'Debes iniciar sesión para realizar la compra', 'error');
    return;
  }

  // Comprueba si hay productos en el carrito
  if (buy.length === 0) {
    Swal.fire('Carrito', 'No se puede comprar ya que está vacío', 'error');
    return;
  }

  // Obtén los datos del usuario que ha iniciado sesión
  const datosUsuario = {
    id: usuario.id,
    nombre: usuario.nombre,
    direccion: usuario.direccion,
    telefono: usuario.telefono
  };

  // Calcula el total de la compra
  const totalCompra = parseFloat(totalCard).toFixed(2);

  // Crea un objeto con los datos a enviar
  const datos = {
    pokemones: buy,
    usuario: datosUsuario,
    total: totalCompra // Agrega el campo 'total' al objeto
  };

  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(datos)
  };

  let url = "./controlador/pedido.datosUsuario.php";

  // Realiza una solicitud POST al controlador
  fetch(url, options)
    .then(response => response.json())
    .then(data => {
      // Maneja la respuesta del controlador
      if (data.success) {
        // La compra se realizó correctamente
        Swal.fire('Carrito', 'Comprado correctamente', 'success');
        buy = [];
        clearHtml();
        priceTotal.innerHTML = 0;
        amountPokemon.innerHTML = 0;
        reiniciarContador();

        // Después de obtener el ID del pedido generado
        const idPedido = data.idPedidos[0].idPedido;

        // Agrega el ID del pedido al objeto 'datos.pedido'
        datos.pedido = { id: idPedido };

        // Actualiza la URL y realiza la solicitud POST al controlador de 'pedido.pokemones.php'
        url = "./controlador/pedido.pokemones.php";

        // Actualiza el body de la solicitud con el objeto 'datos' actualizado
        options.body = JSON.stringify(datos);

        // Realiza una solicitud POST al controlador de 'pedido.pokemones.php' con el payload actualizado
        fetch(url, options)
          .then(response => response.json())
          .then(data => {
            // Maneja la respuesta del controlador de 'pedido.pokemones.php'
            if (data.success) {
              // Los datos se agregaron correctamente
              console.log('Datos de pokemones agregados correctamente');
            } else {
              // Hubo un error al agregar los datos
              console.error('Error al agregar los datos de los pokemones');
            }
          })
          .catch(error => {
            // Maneja los errores de la solicitud
            console.error('Error al enviar los datos de los pokemones al controlador', error);
          });

      } else {
        // Hubo un error al realizar la compra
        Swal.fire('Carrito', 'Error al realizar la compra', 'error');
      }
    })
    .catch(error => {
      // Maneja los errores de la solicitud
      console.error('Error al enviar los datos al controlador', error);
    });
}

document.getElementById('comprarAhoraBtn').addEventListener('click', function () {
  enviarDatosAlControlador();
});

function loadHtml() {
  clearHtml();
  buy.forEach(pokemon => {
    const { image, title, price, cantidad, id } = pokemon
    const row = document.createElement('div')
    row.classList.add('item')
    row.innerHTML = `
      <img src="${image}" alt="">
      <div class="item-content">
        <h3>Nombre:${title}</h3>
        <h5>Precio: ${price}</h5>
        <h6>Cantidad: ${cantidad}</h6>
      </div>
      
      <span class="delete-pokemon" data-id="${id}">X</span>`
    containerBuytCart.appendChild(row)

    priceTotal.innerHTML = totalCard;
    amountPokemon.innerHTML = countPokemon
  });
}

function clearHtml() {
  containerBuytCart.innerHTML = '';
}

function showCart(x) {
  document.getElementById("pokemons-id").style.display = "block";
}
function closeBtn() {
  document.getElementById("pokemons-id").style.display = "none";
}

function reiniciarContador() {
  countPokemon = 0;
}

let caracter = "."
if (localStorage.getItem('carrito')) {
  buy = JSON.parse(localStorage.getItem('carrito')) || [];
  totalCard = parseFloat(localStorage.getItem('total')) || 0;
  countPokemon = parseFloat(localStorage.getItem('contador')) || 0;
  console.log(buy)
  loadHtml();
}

window.addEventListener('beforeunload', function () {
  localStorage.setItem('carrito', JSON.stringify(buy));
  localStorage.setItem('total', totalCard.toString() + "." + "00");
  localStorage.setItem('contador', countPokemon.toString());
});

//DetallePokemon.html

function loadUrlPokemon() {

  let urlPokemon = localStorage.getItem("urlPokemon");
  fetch(urlPokemon)
    .then((response) => response.json())
    .then(data => {
      console.log(data)
      document.getElementById("pokemon").innerHTML =
        `<div class="card mb-2" style="width: 25rem; ">
              <img src="${data.sprites.other.home.front_default}" class="card-img-top " alt="..." style="height: 400px; width: 400px">
              <div class="card-body">
                  <h3 class="card-title">${data.name}</h3>
                  <h5 class="card-title"> Pokemon: ${data.id}</h5>
                  <p class="card-text">Habilidades: ${data.abilities[0].ability.name} </p>
                  <p class="card-text">Tipo de Pokemon: ${data.types[0].type.name} </p>
                  <h5 class="price" id="precio${data.name}"></h5>
                  <div class="row">
                      <div class="col-6 d-grid gap-2">
                        <button class="btn btn-outline-warning btn-add-cart" name="${data.id}">Agregar</button>
                      </div>
                      <div class="col-6">
                        <input type="number" class="form-control product-quantity" value="1" min="0" name="txtcantidad" id="txtcantidad" placeholder="Cantidad">
                      </div>
                  </div> 
              </div>      
          </div>`
      document.getElementById("Pokemongif").innerHTML =
        `<img src="${data.sprites.versions["generation-v"]["black-white"].animated.back_default}" alt="..." style="height: 150px; width: 200px; bottom">`

      // Llamar a la función readDetallePokemon y pasar el objeto data
      readDetallePokemon(data);

      // Limpiar la URL después de guardar los datos
      limpiarUrlPokemon();
    });
}

function readDetallePokemon(poke) {
  let url = "./controlador/pokemones.read.php";
  let precio2; // Variable global para almacenar el precio

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      data.forEach((element, index) => {
        if (element.nombrePo === poke.name) {
          precio2 = element.precioPo; // Asignar el precio a la variable global
        }
      });
      document.getElementById(`precio${poke.name}`).textContent = precio2; // Asignar el precio al elemento correspondiente
    });
}

readDetallePokemon();

//Tipos.html

const listaPoke = [];
const listaTipo = [];

function poke() {
  return new Promise((resolve) => {
    for (let i = 0; i < localStorage.length; i++) {
      let key = localStorage.key(i);
      let tipo = localStorage.getItem(key);

      fetch(tipo)
        .then((response) => response.json())
        .then((data) => {
          listaTipo.push(data.name);
          if (data.pokemon) {
            data.pokemon.forEach((element) => {
              listaPoke.push(element.pokemon);
            });
          }
          resolve("Ok");
        });
    }
  });
}

function slidePoke() {
  poke().then(() => {
    let slideNombre = "";
    let slideTipo;
    listaPoke.forEach((element, index) => {
      slideNombre += `
        <div class="card mb-3 mx-3" style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
                <img onclick="detallePokemon('${element.url}')" id="img${element.name}" src="..." class="img-fluid rounded-start">    
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">${element.name}</h5>
                <p class="card-text" id="descripcion${element.name}"></p>
                <h5 class="price" id="precio${element.name}"></h5>
                <p class="card-text">
                  <div class="row">
                    <div class="col-6 d-grid gap-2">
                      <button class="btn btn-outline-warning btn-add-cart" id="data-id${element.name}" name="">Agregar</button>
                    </div>
                    <div class="col-6">
                      <input type="number" class="form-control product-quantity" value="1" min="0" name="txtcantidad" id="txtcantidad" placeholder="Cantidad">
                    </div>
                  </div>  
                </p>
              </div>
            </div>
          </div>
        </div>`;
      descripcionPokemon(element);
      readPokemones(element);
    });
    listaTipo.forEach((e, index) => {
      slideTipo = `<h1 id="titulo">Pokemon de Tipo ${e}</h1>`;
    });

    document.getElementById("type").innerHTML = slideTipo;
    document.getElementById("name").innerHTML = slideNombre;
    limpiarUrlPokemon();
  });
}

function readPokemones(poke) {
  let url = "./controlador/pokemones.read.php";
  let precio; // Variable global para almacenar el precio

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      data.forEach((element, index) => {
        if (element.nombrePo === poke.name) {
          precio = element.precioPo; // Asignar el precio a la variable global
        }
      });
      document.getElementById(`precio${poke.name}`).textContent = precio; // Asignar el precio al elemento correspondiente
    });
}
readPokemones()

function descripcionPokemon(poke) {
  fetch(poke.url)
    .then((response) => response.json())
    .then((data) => {
      let id = data.id;
      let imagenPoke = data.sprites.other["official-artwork"].front_default;
      let peso = data.weight * 0.1;
      let altura = data.height * 0.1;
      let pokeTipo1;
      let pokeTipo2;
      data.types.forEach((element, index) => {
        if (index === 0) {
          pokeTipo1 = element.type.name;
        } else {
          pokeTipo2 = `/ ${element.type.name}`;
        }
        if (pokeTipo2 === undefined) {
          pokeTipo2 = "";
        }
      });
      document.getElementById(`data-id${poke.name}`).name = id
      document.getElementById(`img${poke.name}`).src = imagenPoke;
      document.getElementById(`descripcion${poke.name}`).innerHTML = `peso: ${peso.toFixed(1)}kg <br> altura: ${altura.toFixed(2)} Mts`;
    });
}

function detallePokemon(urlPokemon) {
  localStorage.setItem("urlPokemon", urlPokemon);
  window.location.href = "detallepokemon.html";
}

function limpiarUrlPokemon() {
  localStorage.removeItem("urlPokemon");
}

// window.onbeforeunload = function () {
//   localStorage.removeItem("urlPokemon");
// };

//Index.html

function carousel() {
  let myCarousel = document.querySelectorAll(
    "#featureContainer .carousel .carousel-item"
  );
  myCarousel.forEach((el) => {
    const minPerSlide = 4;
    let next = el.nextElementSibling;
    for (var i = 1; i < minPerSlide; i++) {
      if (!next) {
        // wrap carousel by using first child
        next = myCarousel[0];
      }
      let cloneChild = next.cloneNode(true);
      el.appendChild(cloneChild.children[0]);
      next = next.nextElementSibling;
    }
  });
}




