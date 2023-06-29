function creaUsuario() {
  let tipo = selTipoDoc.value;
  let identificacion = numIdentificacion.value;
  let nombre = txtNombre.value;
  let apellido = txtApellido.value;
  let correo = txtCorreo.value;
  let contra = txtPassword.value;
  let direccion = txtDireccion.value;
  let telefono = txtTelefono.value;
  let genero = selGenero.value;


  if (tipo === '' || identificacion === '' || nombre === '' || apellido === '' || correo === '' || contra === '' || direccion === '' || telefono === ''
    || genero === '') {
    alertify.error("Por favor, completa todos los campos.");
    return;
  }

  let data = `selTipoDoc=${selTipoDoc.value}&numIdentificacion=${numIdentificacion.value}&txtNombre=${txtNombre.value}&txtApellido=${txtApellido.value}&txtCorreo=${txtCorreo.value}&txtPassword=${txtPassword.value}&txtDireccion=${txtDireccion.value}&txtTelefono=${txtTelefono.value}&selGenero=${selGenero.value}`;
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: data,
  };

  let url = "./controlador/usuarios.create.php"
  console.log(data);
  fetch(url, options)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      numIdentificacion.value = "";
      txtNombre.value = "";
      txtApellido.value = "";
      txtCorreo.value = "";
      txtPassword.value = "";
      txtDireccion.value = "";
      txtTelefono.value = "";
      selTipoDoc.selectedIndex = 0;
      selGenero.selectedIndex = 0;
    });
}

function login() {
  let data = new FormData();
  data.append('txtCorreo', txtCorreo.value);
  data.append('txtPassword', txtPassword.value);

  let url = "./controlador/login.php";
  fetch(url, {
    method: 'POST',
    body: data
  })
    .then((response) => response.json())
    .then((data) => {
      try {
        if (data[0].correo === txtCorreo.value) {
          // Almacenar datos de inicio de sesión en el almacenamiento local
          const datosUsuario = {
            "id": data[0].id,
            "nombre": data[0].correo,
            "direccion": data[0].direccion,
            "telefono": data[0].telefono
          }

          localStorage.setItem('usuario', JSON.stringify(datosUsuario));

          // Obtener el rol del usuario
          const rol = data[0].NombreDelRol;

          // Redireccionar según el rol del usuario
          if (rol === 'Administrador') {
            setTimeout(() => {
              window.location.href = "./indexAdmin.html";
            }, 500);
          } else if (rol === 'Usuario') {
            setTimeout(() => {
              window.location.href = "./index.html";
            }, 500);
          }

          // Ocultar el enlace "Iniciar Sesión" en el navbar
          const inicioSesionLi = document.querySelector('#inicioSesionLi');
          if (inicioSesionLi) {
            inicioSesionLi.style.display = 'none';
            
          }
        }
      } catch (error) {
        alert("Usuario o contraseña incorrectos");
      }
    });
}


function readLogin() {
  console.log("readLogin() se está ejecutando");
  url = "./controlador/login.read.php";
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      if (!data) {
        // No hay información de inicio de sesión, redirigir a la página de inicio de sesión
        window.location.href = "./inicioSesion.html";
      } else {
        // Hay información de inicio de sesión, ocultar el enlace "Iniciar Sesión" en el navbar
        const inicioSesionLi = document.querySelector('#inicioSesionLi');
        if (inicioSesionLi) {
          inicioSesionLi.style.display = 'none';
        }
      }
    })
    .catch((error) => {
      console.error('Error al verificar el inicio de sesión', error);
    });
}


function deleteLogin() {
  let url = "./controlador/logout.php";
  fetch(url)
    .then((response) => {
      // No es necesario llamar a response.json() aquí
      // Redirige directamente después de recibir la respuesta
      if (response.ok) {
        // Eliminar los datos del usuario del almacenamiento local
        localStorage.removeItem('carrito');
        localStorage.removeItem('total');
        localStorage.removeItem('usuario');
        window.location.href = "./inicioSesion.html";
      } else {
        console.log('Error al cerrar sesión');
      }
    })
    .catch(error => {
      console.error('Error al cerrar sesión', error);
    });
}

window.onbeforeunload = function (e) {
  readLogin();
};
