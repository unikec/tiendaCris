$(document).ready(function () {
  
    $('#mas').on("click", function () {
        alert('hola');
     /* $.ajax({
        url: 'http://localhost/2evAjax/CrudAlumnos/php/modificarAlumnos.php',
        data: {
          id: $('#idAlumno').val(),
          dni: $('#dni').val(),
          nombre: $('#nombre').val(),
          
        }, //end data
        type: 'get',
  
        dataType: 'json',
  
        success: function (response) {
          $('#mensaje2').append(response);
          $('#alumnos').empty();
          refresca();
        }, //end response
        error: function (response) {
          alert('Error al ejecutar la funcion')
        } //end mensaje error
  
      }); //end ajax*/
    }); //end functio ok

    $('#menos').on("click", function () {
        alert('hola');
     /* $.ajax({
        url: 'http://localhost/2evAjax/CrudAlumnos/php/modificarAlumnos.php',
        data: {
          id: $('#idAlumno').val(),
          dni: $('#dni').val(),
          nombre: $('#nombre').val(),
          
        }, //end data
        type: 'get',
  
        dataType: 'json',
  
        success: function (response) {
          $('#mensaje2').append(response);
          $('#alumnos').empty();
          refresca();
        }, //end response
        error: function (response) {
          alert('Error al ejecutar la funcion')
        } //end mensaje error
  
      }); //end ajax*/
    }); //end functio ok
  
  }); //end document ready