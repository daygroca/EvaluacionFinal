/*
  Creación de una función personalizada para jQuery que detecta cuando se detiene el scroll en la página
*/
$.fn.scrollEnd = function(callback, timeout) {
  $(this).scroll(function(){
    var $this = $(this);
    if ($this.data('scrollTimeout')) {
      clearTimeout($this.data('scrollTimeout'));
    }
    $this.data('scrollTimeout', setTimeout(callback,timeout));
  });
};
/*
  Función que inicializa el elemento Slider
*/

function inicializarSlider(){
  $("#rangoPrecio").ionRangeSlider({
    type: "double",
    grid: false,
    min: 0,
    max: 100000,
    from: 200,
    to: 80000,
    prefix: "$"
  });
}
/*
  Función que reproduce el video de fondo al hacer scroll, y deteiene la reproducción al detener el scroll
*/
function playVideoOnScroll(){
  var ultimoScroll = 0,
      intervalRewind;
  var video = document.getElementById('vidFondo');
  $(window)
    .scroll((event)=>{
      var scrollActual = $(window).scrollTop();
      if (scrollActual > ultimoScroll){
       video.play();
     } else {
        //this.rewind(1.0, video, intervalRewind);
        video.play();
     }
     ultimoScroll = scrollActual;
    })
    .scrollEnd(()=>{
      video.pause();
    }, 10)
}

inicializarSlider();
playVideoOnScroll();
document.addEventListener('DOMContentLoaded', () => {
  const formulario = document.getElementById('formulario-busqueda');
  const resultados = document.getElementById('resultados');
  const mostrarTodos = document.getElementById('mostrar-todos');

  formulario.addEventListener('submit', async (e) => {
      e.preventDefault();
      console.log('Formulario enviado'); // Depuración
      const formData = new FormData(formulario);
      try {
          const response = await fetch('buscar.php', {
              method: 'POST',
              body: formData
          });
          if (!response.ok) {
              throw new Error(`Error HTTP: ${response.status}`);
          }
          const data = await response.json();
          console.log('Datos recibidos:', data); // Depuración
          mostrarResultados(data);
      } catch (error) {
          console.error('Error en la solicitud:', error); // Depuración
      }
  });

  mostrarTodos.addEventListener('click', async () => {
      console.log('Mostrando todos los registros'); // Depuración
      try {
          const response = await fetch('buscar.php', {
              method: 'POST',
              body: new FormData()
          });
          if (!response.ok) {
              throw new Error(`Error HTTP: ${response.status}`);
          }
          const data = await response.json();
          console.log('Datos recibidos:', data); // Depuración
          mostrarResultados(data);
      } catch (error) {
          console.error('Error en la solicitud:', error); // Depuración
      }
  });

  function mostrarResultados(data) {
      resultados.innerHTML = '';
      if (data.length === 0) {
          resultados.innerHTML = '<p>No se encontraron resultados</p>';
          return;
      }
      data.forEach(item => {
          const div = document.createElement('div');
          div.className = 'resultado';
          div.innerHTML = `
              <h2>${item.Tipo} en ${item.Ciudad}</h2>
              <p>Precio: ${item.Precio}</p>
              <p>Dirección: ${item.Direccion}</p>
          `;
          resultados.appendChild(div);
      });
  }
});
