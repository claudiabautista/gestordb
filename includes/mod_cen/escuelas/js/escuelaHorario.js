$(document).ready(function() {
  let escuelaIdBorrar = $("#escuelaId").val()


  $('#formNewCourse').hide()
  $('#formNewTeacher').hide()
  $('#formNewPerson').hide()

  $('#newCourse').click(function (){
    $('#formNewCourse').toggle()
  })



  /**
   * AL PRESIONAR EL BOTON X (eliminar) DE PROFESOR
   */

  $('#teachers').on('click', '.profesor', function(){
    let profesorId =$(this).attr("id").substring(8)


    $.ajax({
      url: 'includes/mod_cen/clases/Profesores.php',
      type: 'POST',
      dataType: 'json',
      data: {profesorId: profesorId,escuelaIdBorrar:escuelaIdBorrar}
    })
    .done(function(lista) {
      console.log("success");
      let cantidad = 0
      let estado ='borrado'

      for (let item of lista) {
        estado = item.estado
      }
      if (estado=='borrado') {
        $('#teachers').empty()
        for (let item of lista) {
            console.log(item.profesorId)
            cantidad++
            $('#teachers').prepend('<p>'+item.nombre+' '+item.apellido+'</b><img class="profesor" id="profesor'+item.profesorId+'" src="img/iconos/delete.png" alt="borrar"></p>')
        }
        $('#teachers').prepend(`Total de Profesores: ${cantidad}`)
        alert('Borrado correctamente')
      }else{
        alert('Error: Existe horario asignado a este Profesor. Debe elminar primero los horarios relacionados a este profesor para poder Quitar el Profesor')
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  })



  /**
   * //AL PRESIONAR EL BOTON X PARA ELIMINAR CURSO
   */
  $('#courses').on('click', '.curso', function(){

    let cursoId =$(this).attr("id").substring(5)
    $.ajax({
      url: 'includes/mod_cen/clases/Cursos.php',
      type: 'POST',
      dataType: 'json',
      data: {cursoId: cursoId,escuelaIdBorrar:escuelaIdBorrar}
    })
    .done(function(lista) {
      let cantidad = 0
      let estado ='borrado'

      for (let item of lista) {
        estado = item.estado
      }
      if (estado=='borrado') {
        $('#courses').empty()
        for (let item of lista) {
          cantidad++
          //console.log(item.cursoId)
          $('#courses').prepend('<p>'+item.curso+' '+item.division+' Turno <b>'+item.turno+'</b><img class="curso" id="curso'+item.cursoId+'" src="img/iconos/delete.png" alt="borrar"></p>')
        }
      $('#courses').prepend(`Total de curso: ${cantidad}`)
      alert('Borrado correctamente')
    }else{
      alert('Error: Existe horario asignado a este curso. Debe elminar primero los horarios relacionados a este curso para poder Quitar el Curso')
    }

    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  })

  /**
   * AL PRESIONAR EL BOTON GUARDAR CURSO
   */
    $('#saveCourse').click(function (){
        let curso = $('#courseName').val()
        let division = $('#divisionName').val()
        let turno = $('#turn').val()

        if (curso =='0' || division =='0' || turno =='0' ) {
          alert('Falta seleccionar opcion para guardar el curso')
        }else{

        let guardado = 'no'
        let courseName = $("#courseName option:selected").val()
        let divisionName = $("#divisionName option:selected ").val()
        let turn = $("#turn option:selected").val()
        let quantityStudents = $("#quantityStudents").val()
        let escuelaId = $("#escuelaId").val()
        $.ajax({
          url: 'includes/mod_cen/clases/Cursos.php',
          type: 'POST',
          dataType: 'json',
          data: {courseName: courseName,
                divisionName: divisionName,
                turn:turn,
                quantityStudents:quantityStudents,
                escuelaId:escuelaId}
        })
      .done(function(data) {
        console.log('success')
          //console.log(data)
          for (let item of data) {
            if (item.guardado=="ok") {
              let guardado = 'si'
              let id = item.id

              //console.log(item.guardado)
              //console.log(item.id)
                //let escuelaId = $("#escuelaId").val()
              $.ajax({
                url: 'includes/mod_cen/clases/Cursos.php',
                type: 'POST',
                dataType: 'json',
                data: {escuelaIdAjaxId:escuelaId}
              })
            .done(function(lista) {
                let cantidad = 0
                $('#courses').empty()

                for (let item of lista) {
                  cantidad++
                  if (id==item.cursoId) {

                        console.log(item.cursoId)
                        $('#courses').prepend('<p class="alert alert-success">'+item.curso+' '+item.division+' Turno <b>'+item.turno+'</b><img class="curso" id="curso'+item.cursoId+'" src="img/iconos/delete.png" alt="borrar"></p>')
                  }else{
                    $('#courses').prepend('<p>'+item.curso+' '+item.division+' Turno <b>'+item.turno+'</b><img class="curso" id="curso'+item.cursoId+'" src="img/iconos/delete.png" alt="borrar"></p>')
                  }
                }
                $('#courses').prepend(`Total de Cursos: ${cantidad}`)
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });

              $('#formNewCourse').toggle()
              $('#courseName > option[value="0"]').prop('selected','true')
              $('#divisionName > option[value="0"]').prop('selected','true')
              $('#turn > option[value="0"]').prop('selected','true')
              $('#quantityStudents').val('1')
              alert('Se creo correctamente')
            }else{
              if (item.guardado=='existe') {
                alert('Error: Este curso ya existe')
              }else{
                alert('algo no esta bien')
              }

            }
          }
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });

      }
    })

    /**
     * AL PRESIONAR BOTON NUEVO PROFESOR
     */
    $('#newTeacher').click(function (){
      clearPersonaAndDni()
    })

  /**
   * al presionar el boton BUSCAR PROFESOR
   */
  $('#searchTeacher').click(function (){
    let dni = $('#teacherDni').val()
    let escuelaIdDato = $("#escuelaId").val()
    //alert($('#teacherDni').val())
    $.ajax({
      url: 'includes/mod_cen/clases/Profesores.php',
      type: 'POST',
      dataType: 'json',
      data: {dni: dni,escuelaId:escuelaIdDato}
    })
    .done(function(lista) {
      console.log("success");
      //$('#courses').empty()

      for (let item of lista) {
        if (item.dni=='error') {

          $('#searchTeacher').attr('disabled',true)
          $('#teacherDni').attr('disabled',true)

          $('#formNewPerson').toggle()
          //alert('NO EXISTE')
          $("#statusTeacher").val('create');
          $('#nameTeacher').focus()
        }else if(item.dni=='existe'){
          alert('ya existe')

        }else{
          $('#searchTeacher').attr('disabled',true)
          $('#teacherDni').attr('disabled',true)

          $('#formNewPerson').toggle()
          $("#statusTeacher").val('update');
          //alert(item.personaId+item.dni+item.nombre+item.apellido)
          $('#personaId').val(item.personaId)
          $('#nameTeacher').val(item.nombre)
          $('#surnameTeacher').val(item.apellido)
          $('#phoneTeacher').val(item.telefono)
          $('#emailTeacher').val(item.email)
          $('#cuilTeacher').val(item.cuil)
        }

      }

    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  })

/**
 * AL PRESIONAR EL BOTON GUARDAR PROFESOR
 */

  $('#saveTeacher').click(function (){

      let boton = $("#saveTeacher").attr("id")

      let action = $("#statusTeacher").val()
      //alert(action)
      let personaId= $("#personaId").val()
      let cuilTeacher= $("#cuilTeacher").val()
      let dniTeacher = $("#teacherDni").val()
      let nameTeacher = $("#nameTeacher").val()
      let surnameTeacher = $("#surnameTeacher").val()
      let phoneTeacher = $("#phoneTeacher").val()
      let emailTeacher = $("#emailTeacher").val()
      let escuelaId = $("#escuelaId").val()
      //alert(dni+nameTeacher+surnameTeacher+phoneTeacher+emailTeacher)
      $.ajax({
        url: 'includes/mod_cen/clases/Profesores.php',
        type: 'POST',
        dataType: 'json',
        data: { dniTeacher: dniTeacher,
                nameTeacher: nameTeacher,
                surnameTeacher:surnameTeacher,
                phoneTeacher:phoneTeacher,
                emailTeacher:emailTeacher,
                escuelaId:escuelaId,
                botonSaveTeacher:boton,
                statusTeacher:action,
                personaId:personaId,
                cuilTeacher:cuilTeacher
                }
      })
    .done(function(persona) {
      //console.log("okok")
        let cantidad = 0
        alert('Dato Guardado Teacher')
        $('#teachers').empty()
        clearPersonaAndDni()
        for (let item of persona) {
          cantidad++
          $('#teachers').prepend('<p>'+item.nombre+' '+item.apellido+'</b><img class="profesor" id="profesor'+item.profesorId+'" src="img/iconos/delete.png" alt="borrar"></p>')
          console.log(item.nombre)
        }
        $('#teachers').prepend(`Total de Profesores: ${cantidad}`)
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });


  })



});


function clearPersonaAndDni(){
  $('#searchTeacher').removeAttr('disabled')
  $('#teacherDni').removeAttr('disabled')
  $('#teacherDni').val("")
  $('#personaId').val("")
  $('#nameTeacher').val("")
  $('#surnameTeacher').val("")
  $('#phoneTeacher').val("")
  $('#emailTeacher').val("")
  $('#formNewTeacher').show()
  $('#formNewPerson').hide()
}
