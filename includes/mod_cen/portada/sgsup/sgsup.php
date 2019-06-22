<!-- Carga para Mis escuelas de cada ett -->
<link rel="stylesheet" href="includes/mod_cen/css/styleIconosSuperPrim.css">
<link rel="stylesheet" href="includes/mod_cen/css/default.css">
<link rel="stylesheet" href="includes/mod_cen/css/default.date.css">
<link rel="stylesheet" href="includes/mod_cen/portada/css/portadaEtjMisEtt.css">


<script type="text/javascript" src="includes/mod_cen/portada/cu/js/cuEscuelas.js?v=<?php echo (rand());?>"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/validarMisEscuelasSnp.js"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/informeNuevo.js"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/ajax.js"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/picker.js"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/picker.date.js"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/legacy.js"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/informes.js?v=<?php echo (rand());?>"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/jsValidarPersona.js"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/jsValidarInforme.js"></script>
<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<!-- ////////////////////// ///////////////////////////////////// -->
<script type="text/javascript" src="includes/mod_cen/documentos/panelportada.js"></script>
<script type="text/javascript">
    let referenteId2 = '<?php echo $_SESSION['referenteId'];?>'
    let tipoR = '<?php echo $_SESSION['tipo'];?>'
</script>
<link rel="stylesheet" href="includes/mod_cen/informes/css/stylesCalendar.css">
<link rel="stylesheet" href="includes/mod_cen/informes/css/stylesVisitaMensual.css"/>
<script type="text/javascript"src="includes/mod_cen/portada/js/calendarETJ.js"></script>
<style type="text/css">

.btn-default {
		color: #333;
		background-color: #E9ECEC;
		border-color: #ccc;
}
</style>
<script>
  $( function() {

		 $( "#accordion1,#accordion2,#accordion3,#accordion4,#accordion5,#accordion6,#accordion7" ).accordion({
			 active: false,
			 collapsible: true
     });

     $( "#accordionBuscar1,#accordionBuscar2,#accordionBuscar3,#accordionBuscar4,#accordionBuscar5").accordion({
      active: false,
      collapsible: true
     });

		 $( "#tabs" ).tabs({
       collapsible: true
     });
     $( "#tabsBuscar" ).tabs({
       collapsible: true
     });

  } );

  </script>
<script type="text/javascript" src="includes/mod_cen/portada/js/etjInforme.js?v=<?php echo (rand());?>"></script>
<script type="text/javascript" src="includes/mod_cen/escuelas/js/validarMisEscuelasSnp.js"></script>


<?php
require_once("includes/mod_cen/clases/informe.php");
require_once("includes/mod_cen/clases/persona.php");
require_once("includes/mod_cen/clases/referente.php");
require_once("includes/mod_cen/clases/leido.php");
require_once("includes/mod_cen/clases/escuela.php");
include_once 'includes/mod_cen/clases/Autoridades.php';
include_once "includes/mod_cen/clases/respuesta.php" ;
include_once "includes/mod_cen/clases/rtixescuela.php";
include_once "includes/mod_cen/clases/rti.php";
include_once "includes/mod_cen/clases/maestro.php";

/**
 * Obtener todas las categorias relacionadas a Supervisores de Superior
 */

$categoriasPermitidas = new TipoPermisos(null,null,'SGSUP');
$buscarPermitidas = $categoriasPermitidas->buscar();

 /**********************************************/


//create object referenteId and filter of status active
$referenteId=$_SESSION['referenteId'];

$referente= new Referente($referenteId);

if ($_SESSION['referenteId']=="0255") {
  $ett1 = $referente->Cargo("Activo");
  $ett2 = $referente->Cargo("Activo");
  $resultado_ett_acargo = $referente->Cargo("Activo");
}elseif($_SESSION['referenteId']=="0287"){
  $ett1 = $referente->CargoEtj3("Activo");
  $ett2 = $referente->CargoEtj3("Activo");
  $resultado_ett_acargo = $referente->CargoEtj3("Activo");
}else{
  $ett1 = $referente->CargoEtj2("Activo");
  $ett2 = $referente->CargoEtj2("Activo");
  $resultado_ett_acargo = $referente->CargoEtj2("Activo");
}





$informes= new informe();
////////////////////////////////////////////////
// todos los informes creados por referente Supervion Superior
$arrayReferenteConectar = array ('SGSUP','SSUP');
$informeEquipoConectar = $informes->buscar(20,null,$arrayReferenteConectar);

//busqueda de informes de proiridad alta
$informe_alta= new Informe(null,null,null,"Alta");
$buscar_alta =$informe_alta->buscar(20,null,$arrayReferenteConectar);
//var_dump($buscar_alta);
$total = mysqli_num_rows($buscar_alta);

// creación y busqueda de todos los informes


$b_informe = $informes->buscar(20);

////////////////////////////////////////////////


$mis_informes= new informe(null,null,$_SESSION["referenteId"]);

$b_mis_informe = $mis_informes->buscar(10);

echo '<div class="container">';
?>
<div class="" id="padreIr">
</div>

<div class="hidden-xs  wow zoomIn">
  <div id="tabsBuscar">
    <ul>
      <li><a  href='#tabsBuscar-1'>Buscar</a></li>
      <li><a  href='#tabsBuscar-2'>Informe prioridad Alta</a></li>
      <!-- <li><a  href='#tabsBuscar-3'>Conectividad PNCE</a></li>
      <li><a  href='#tabsBuscar-4'>Aprendizaje Competencias</a></li> -->
      <li><a  href='#tabsBuscar-5'>Documentos</a></li>
    </ul>
    <div id="tabsBuscar-1">
      <!-- <div id='accordionBuscar1'>
        <h3>Escuela</h3>
        <div>
          <p>buscar de escuelas</p>

        </div>
      </div>
      <div id='accordionBuscar2'>
          <h3>RTI</h3>
          <div>
            <p>buscar rti</p>
          </div>
      </div>
      <div id='accordionBuscar3'>
          <h3>Referente</h3>
          <div>
            <p>buscar de Referentes</p>
          </div>
      </div> -->
      <div id='accordionBuscar4'>
          <h3>Informe</h3>
          <div>
            <div id="cargando">
              <img class="img img-responsive cargando" style="display:none;margin:auto;" src="img/iconos/informes/ajax-loader.gif"><br>
              <b><p class="cargando"align="center"style="display:none;color:#068587;">Buscando Informes, por favor espere...</p></b>
            </div>

            <form class="form-inline" id="formBuscarInforme" action="" method="post">
              <input type="text" name="numero" id="numero" value="" placeholder="N° Esc." size="5" class="form-control"><br><br>
              <input type="text" name="titulo" id="titulo" value="" placeholder="Titulo Informe" class="form-control"><br><br>
              <select class="form-control" id="seleCategoria" name="categoria">
                <option value="0">Todas las Categorias...</option>
                <?php
                while ($rowCate = mysqli_fetch_object($buscarPermitidas) ) {
                  echo '<option value="'.$rowCate->tipoId.'">'.$rowCate->nombre.'</option>';
                }
                 ?>
              </select><br><br>
              <select class="form-control" id="seleSubCategoria" name="subCategoria" >
                <option value="0">Todas las subcategorias...</option>
              </select>
              <img class="img img-responsive" id="carga" src="img/iconos/informes/cargar.gif" style="display:none;margin:auto;max-width:3%;"><br>
              <br><br>
              <button type="button" id="buscarInforme" class="btn btn-primary" name="button">Buscar</button>
            </form>
            <div id="resultadoInforme">
              <table id='tableinformes'>
              <thead>
                <tr>
                  <th>Fecha Visitta</th>
                  <th>Escuela</th>
                  <th>Titulo</th>
                  <!-- <th>Resp.</th>
                  <th>Fecha</th>
                  <th>Prioridad</th> -->
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            </div>
          </div>

      </div>

    </div>
    <div id="tabsBuscar-2">
      <?php
      include 'includes/mod_cen/portada/sgsup/sgsupPrioridad.php';
       ?>
    </div>
    <div id="tabsBuscar-3">
      <?php
      //include 'includes/mod_cen/portada/etj/etjConectividad.php';
       ?>
    </div>
    <div id="tabsBuscar-4">
      <?php
      //include 'includes/mod_cen/portada/etj/etjCompetencias.php';
       ?>
    </div>
    <div id="tabsBuscar-5">
      <?php
      include 'includes/mod_cen/portada/sgsup/sgsupDocumentos.php';
       ?>
    </div>
  </div>


</div>
<!--vista mobile-->

<div class="row visible-xs wow zoomIn">
	<div class="col-xs-6"><a href="index.php?mod=slat&men=escuelas&id=18" style="text-decoration:none">
		<img class="img-responsive"src="includes/mod_cen/portada/imgPortadas/busqueda.png"><h3 align="center">Búsqueda escuelas</h3></a>
	</div>


</div>

<?php

		if(mysqli_num_rows($resultado_ett_acargo)>0){

				echo "<div id='tabs'>";
				 echo "<ul>";

							while ($fila=mysqli_fetch_object($ett1))
							{
								$informe_ett= new informe(null,null,$fila->referenteId);

								$informesNoLeidos = $informe_ett->summary('noLeido',null,null,null,null,'2019',null,$fila->referenteId,null,$_SESSION['referenteId']);
								$totalNoLeidos= mysqli_num_rows($informesNoLeidos);
								$buscar   = ' ';
								$pos = strpos($fila->apellido, $buscar);

								if ($pos===false) {
									echo "<li><a  href='#tabs-".$fila->referenteId."'>&nbsp".strtoupper($fila->apellido)." &nbsp<span id='badge-".ltrim($fila->referenteId,'0')."' class='badge badgeNoLeido'>".$totalNoLeidos."</span></a></li>";
								}else{
									echo "<li><a  href='#tabs-".$fila->referenteId."'>&nbsp".substr(strtoupper($fila->apellido),0,strpos($fila->apellido,' '))."  &nbsp<span id='badge-".ltrim($fila->referenteId,'0')."' class='badge badgeNoLeido'>".$totalNoLeidos."</span></a></li>";	# code...
								}

							}


				  echo '</ul>';
					$contador=0;
					/**
					 * Creado de tabs por ett, con contenido de sus informes, datos de contacto y calendario de visitas.
					 */
					while ($fila=mysqli_fetch_object($ett2))
					{
						$informe_ett= new informe(null,null,$fila->referenteId);
						$informesNoLeidos = $informe_ett->summary('noLeido',null,null,null,null,'2019',null,$fila->referenteId,null,$_SESSION['referenteId']);
						echo "<div id='tabs-$fila->referenteId'>";
						$leido = new Leido(null,null,$_SESSION['referenteId']);
						$buscar_alta =$informe_ett->summary('año',null,null,null,null,'2019','Alta',$fila->referenteId);
						$totalAlta = mysqli_num_rows($buscar_alta);
						$buscar_media =$informe_ett->summary('año',null,null,null,null,'2019','Media',$fila->referenteId);
						$totalMedia = mysqli_num_rows($buscar_media);
						$buscar_normal = $informe_ett->summary('año',null,null,null,null,'2019','Normal',$fila->referenteId);
						$totalNormal = mysqli_num_rows($buscar_normal);
						$actual = $informe_ett->summary('año',null,null,null,null,'2019',null,$fila->referenteId);
						$cantidadActual=mysqli_num_rows($actual);
						$cantidadNoLeidos=mysqli_num_rows($informesNoLeidos);

            // foto perfil

            $personaId1= strtoupper($fila->personaId);
            $persona1= new Persona($personaId1);
            $persona1 = $persona1->getContacto();

            $nomArchivoFoto="./img/perfil/";
            if ($persona1->getFotoPerfil() == "") {
                $nomArchivoFoto.= "0000.jpg";
            }else {
                $nomArchivoFoto.= $persona1->getFotoPerfil();
                //$nomArchivoFoto.=".jpg";
                  }
          //  echo  " ";
            // foto perfil
						echo "<h4 align='center'><p  class='nombreApellido'><img src='$nomArchivoFoto'  alt='perfil'  class=' img-responsive img-circle' style= 'width: 75px; height: 75px;' ><b> ".strtoupper($fila->apellido).", ".strtoupper($fila->nombre)."</b></p></h4>";



            echo "<hr class='hrNombreApellido'>";
						//echo "<p class='alert alert-success'>Total Informes - $cantidadActual</p>";
						$contador++;
						echo "<div id='accordion$contador'>";
            echo '<h3> <span id="badgeNoLeidos-'.ltrim($fila->referenteId,'0').'" class="badge badgeNoLeido">'.$cantidadNoLeidos.'</span>Informes No Leidos</h3>';
            //<h3>Informes No Leidos <span id='badgeNoLeidos-".$fila->referenteId."' class="badge"> <?php echo $cantidadNoLeidos;</span></h3>

						?>
							<div>
								<?php
                echo "<div class='list-group'>";
								while ($row = mysqli_fetch_object($informesNoLeidos))

								{
									switch ($row->prioridad) {
										case 'Normal':
											$class="alert alert-success";
                      $parrafo="color:#646161;";
											break;
										case 'Media':
											$class="alert alert-warning";
                      $parrafo="color:#646161;";
											break;
										case 'Alta':
											$class="alert alert-danger";
                      $parrafo="color:#646161;";
											break;
										default:
											# code...
											break;
									}

                  //echo "<div class='list-group ".$class."' id='informeId".$row->informeId."'";
                  echo "<div class='list-group-item  ".$class."'id='informeId".$row->informeId."'>";
                  echo "<h4 class='list-group-item-heading'> <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'>&nbsp</span><b>".ucwords($row->titulo)."</b></h4>";
                  echo "<p class='list-group-item-text'style='".$parrafo."'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Institución N°:  </b>".$row->numero."  <b></p><p class='list-group-item-text'style='".$parrafo."'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFecha V.:</b>".Maestro::formatoFecha($row->fechaVisita)."&nbsp<b> Fecha Carga.:</b> ".Maestro::formatoFecha($row->fechaCarga)." &nbsp<b>Id:</b>".$row->informeId." </p>";
                  echo "</div>";
                  //echo "</div>";
									//echo "<p id='informeId".$row->informeId."' class='".$class."'><b>$row->titulo</b><br>
											//	<b>Institución N°:  </b>".$row->numero."  <b>Fecha V.:</b>".$row->fechaVisita."<b> Fecha Carga.:</b> ".$row->fechaCarga." <b>Id:</b>".$row->informeId." </p>";
								}
              echo "</div>";
								 ?>

							</div>
							<h3>Informes prioridad Alta <span class="badge badgeAlta"> <?php echo $totalAlta;?></span></h3>

						  <div>

								<?php
                  echo "<div class='list-group'>";
								while ($row = mysqli_fetch_object($buscar_alta)) {
                  echo "<div class='list-group-item alert alert-danger'id='inforalta".$row->informeId."'>";
                  echo "<h4 class='list-group-item-heading'> <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'>&nbsp</span><b>".ucwords($row->titulo)."</b></h4>";
                  echo "<p class='list-group-item-text'style='".$parrafo."'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Institución N°:  </b>".$row->numero."  <b></p><p class='list-group-item-text'style='".$parrafo."' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFecha V.:</b>".Maestro::formatoFecha($row->fechaVisita)."&nbsp<b> Fecha Carga.:</b> ".Maestro::formatoFecha($row->fechaCarga)." &nbsp<b>Id:</b>".$row->informeId." </p>";
                  echo "</div>";

									// echo "<p id='inforalta".$row->informeId."' class='alert alert-danger'><b>$row->titulo</b><br>
									// 			<b>Institución N°:  </b>".$row->numero."  <b>Fecha V.:</b>".$row->fechaVisita."<b> Fecha Carga.:</b> ".$row->fechaCarga." <b>Id:</b>".$row->informeId." </p>";

								}
                echo "</div>";
								?>
						  </div>
							<h3>Informes prioridad Media <span class="badge badgeMedia"> <?php echo $totalMedia;?></span></h3>
						  <div>
							<?php
              echo "<div class='list-group'>";
								while ($row = mysqli_fetch_object($buscar_media)) {

                  echo "<div class='list-group-item alert alert-warning'id='informedi".$row->informeId."'>";
                  echo "<h4 class='list-group-item-heading'> <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'>&nbsp</span><b>".ucwords($row->titulo)."</b></h4>";
                  echo "<p class='list-group-item-text'style='".$parrafo."'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Institución N°:  </b>".$row->numero."  <b></p><p class='list-group-item-text'style='".$parrafo."' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFecha V.:</b>".Maestro::formatoFecha($row->fechaVisita)."&nbsp<b> Fecha Carga.:</b> ".Maestro::formatoFecha($row->fechaCarga)." &nbsp<b>Id:</b>".$row->informeId." </p>";
                  echo "</div>";
                    //
										// echo "<p id='informedi".$row->informeId."' class='alert alert-warning'><b>$row->titulo</b><br>
  									// 			<b>Institución N°:  </b>".$row->numero."  <b>Fecha V.:</b>".$row->fechaVisita."<b> Fecha Carga.:</b> ".$row->fechaCarga." <b>Id:</b>".$row->informeId." </p>";

								}
                echo "</div>";
							?>
						 </div>
							<h3>Informes prioridad Normal <span class="badge badgeNormal"> <?php echo $totalNormal;?></span></h3>
						  <div>
								<?php
                echo "<div class='list-group'>";
	 							 while ($row = mysqli_fetch_object($buscar_normal)) {
                   echo "<div class='list-group-item alert alert-success'id='infornorm".$row->informeId."'>";
                   echo "<h4 class='list-group-item-heading'> <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'>&nbsp</span><b>".ucwords($row->titulo)."</b></h4>";
                   echo "<p class='list-group-item-text'style='".$parrafo."'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Institución N°:  </b>".$row->numero."  <b></p><p class='list-group-item-text'style='".$parrafo."' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFecha V.:</b>".Maestro::formatoFecha($row->fechaVisita)."&nbsp<b> Fecha Carga.:</b> ".Maestro::formatoFecha($row->fechaCarga)." &nbsp<b>Id:</b>".$row->informeId." </p>";
                   echo "</div>";
                     // id='infornorm".$row->informeId."' class='alert alert-success'><b>$row->titulo</b><br>
   								// 				<b>Institución N°:  </b>".$row->numero."  <b>Fecha V.:</b>".$row->fechaVisita."<b> Fecha Carga.:</b> ".$row->fechaCarga." <b>Id:</b>".$row->informeId." </p>";

	 							 }
                   echo "</div>";
	 						 ?>
						  </div>

							<h3>Calendario de Visitas realizadas</h3>
						  <div>
	 							<p>

                  <?php
                  include'includes/mod_cen/portada/sgsup/calendarioSsup.php';
                   ?>
              </p>
						  </div>

              <!-- //
              // //  echo $fila->referenteId;
              //   $escuelasCargo = new EscuelaReferentes(null,null,null,$fila->referenteId);
              // //  var_dump($escuelasCargo);
              //   $buscarEscuelas = $escuelasCargo->buscar2();
              //   $totalEscuelas = mysqli_num_rows($buscarEscuelas);
              //  echo "<h3>Escuelas a cargo <span class='badge'>$totalEscuelas</span></h3>";
              // echo '<div>';
              //
              //   while ($fila2 = mysqli_fetch_object($buscarEscuelas)) {
              //     echo "<p>$fila2->numero - $fila2->cue -".substr($fila2->nombre,0,35)."</p>";
              //   } -->
              <?php
              $escuelasCargo = new EscuelaReferentes(null,null,null,$fila->referenteId);
              //ar_dump($escuelasCargo);
              $buscarEscuelas = $escuelasCargo->buscar2();
              $totalEscuelas = mysqli_num_rows($buscarEscuelas);
              echo "<h3>Escuelas a cargo <span class='badge badgeEscuelaCargo'>$totalEscuelas</span></h3>";
              echo '<div>';
               ?>

              <div class="row">

              <!-- <div class="container"> -->


              <table class="table table-bordered hidden-xs">
                <thead>
                  <tr class='danger' >
                    <th>CUE</th>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Informes</th>
                    <th>Autoridades</th>
                    <th>RTI</th>
                  </tr>
                </thead>


                <tbody>
                  <?php

                    //Seleccino todas las escuelas que tiene a cargo el referente loegado mediante el dato de personaId
                  //  $escuelasCargo = new EscuelaReferentes(null,null,'19',$_SESSION['referenteId']);
                  //  $buscarEscuelas = $escuelasCargo->buscar();

                    $escuela = new Escuela();

                    while ($row = mysqli_fetch_object($buscarEscuelas)) {

                      $rtix= new rtixescuela($row->escuelaId);

                      $buscar_rti=$rtix->buscar();

                      $cantidadRti=mysqli_num_rows($buscar_rti);


                      $informe = new informe(null,$row->escuelaId);

                      $arrayReferente= ['CU','CAS'];

                      $buscarInforme= $informe->buscar(null,null,$arrayReferente);

                      $cantidadInforme = mysqli_num_rows($buscarInforme);

                      $autoridad = new Autoridades(null,$row->escuelaId);
                      $buscarAutoridad = $autoridad->buscarAutoridad3('all');
                      $cantidadAutoridades = mysqli_num_rows($buscarAutoridad);

                      $escuela->escuelaId=$row->escuelaId;
                      $buscarEscuela = $escuela->buscar();
                      $infoEscuela = mysqli_fetch_object($buscarEscuela);

                      //echo $infoEscuela->numero."<br>";
                      echo '<tr class="'.$fila->referenteId.'">';


                      echo '<td>'.$infoEscuela->cue.'</td>';
                      echo '<td>'.$infoEscuela->numero.'</td>';
                      //echo '<td>'.substr($infoEscuela->nombre,0,30).'</td>';
                      echo '<td><a href="index.php?mod=slat&men=escuelas&id=3&escuelaId='.$infoEscuela->escuelaId.'">'.substr($infoEscuela->nombre,0,30).'</a></td>';
                      echo '<td id="informes'.$infoEscuela->escuelaId.'"><button type="button" class="btn btn-warning" id="info'.$infoEscuela->escuelaId.'" name="button">'.$cantidadInforme.'</button></td>';
                      echo '<td id="row'.$infoEscuela->escuelaId.'"><button type="button" class="btn btn-success" id="autoridad'.$infoEscuela->escuelaId.'" name="button">'.$cantidadAutoridades.' </button><span id="verAutoridad'.$infoEscuela->escuelaId.'" class="pull-right clickable"></span></td>';
                      if ($cantidadRti > 0 ) {
                        echo '<td id="tecnico'.$infoEscuela->escuelaId.'"><button type="button" class="btn btn-success" id="rti'.$infoEscuela->escuelaId.'" name="button">'.$cantidadRti.' </button><span id="verRti'.$infoEscuela->escuelaId.'" class="pull-right clickable"></span></td>';
                      }else{
                        echo '<td id="tecnico'.$infoEscuela->escuelaId.'"><button type="button" class="btn btn-success" name="button">'.$cantidadRti.' </button><span id="verRti'.$infoEscuela->escuelaId.'" class="pull-right clickable"></span></td>';
                      }



                      echo '</tr>';

                    }
                  ?>

                </tbody>
              </table>

              </div>

              <!-- </div> </div container> --> -->

              </div>

						</div>



						<?php


					  echo "</div>";
					}
				  echo "</div>";



				}
?>

<!--
<div class="alert alert-info" role="alert">
	<h4> <span class="badge">1 </span>&nbsp;<a href="index.php?mod=slat&men=referentes&id=10">Atención!! Nuevo -> Buscador de RTI, por nombre, apellido, etc.</a>  </h4>
</div>
-->




<br><br><br>
<?php
	echo '<div class="row">';
	?>
	<!-- <div class="col-md-12 hidden-xs">
			<p class="alert alert-success">Presentación Proyecto trabajo 2018</p>
			<iframe allowFullScreen frameborder="0" height="564" mozallowfullscreen src="https://player.vimeo.com/video/258948009" webkitAllowFullScreen width="640"></iframe>
			 <p><a href="https://vimeo.com/user72995653">Mensaje para el equipo</a></p>
		</div>
		<div class="col-md-12 visible-xs">
		 <p class="alert alert-success">Presentación Proyecto trabajo 2018</p>
		 <iframe allowFullScreen frameborder="0" height="240" mozallowfullscreen src="https://player.vimeo.com/video/258948009" webkitAllowFullScreen width="320"></iframe>
			<p><a href="https://vimeo.com/user72995653">Mensaje para el equipo</a></p>
	</div> -->


<script type="text/javascript" src="includes/mod_cen/portada/js/animatePortadas.js"></script>
