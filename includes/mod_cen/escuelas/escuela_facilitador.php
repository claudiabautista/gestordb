<style type="text/css">
hr {
    border-top: 2px solid #FF5B61;
  }

</style>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="gmap/gmaps.js"></script>
<?php
include_once("includes/mod_cen/clases/escuela.php");
include_once("includes/mod_cen/clases/FacilEscuelas.php");
include_once("includes/mod_cen/clases/referente.php");
include_once("includes/mod_cen/clases/localidades.php");
include_once("includes/mod_cen/clases/informe.php");
include_once('includes/mod_cen/clases/director.php');//Agregada Arredes
include_once('includes/mod_cen/clases/supervisor.php');//Agregada Arredes
include_once('includes/mod_cen/clases/rti.php');//Agregada Arredes


//identifica al usuario logeado y asigna dato a la variable $referenteId
$referenteId=$_SESSION['referenteId'];

switch ($_SESSION["tipo"]) {
	case 'Facilitador':
							$escuela= new FacilEscuelas(null,null,$referenteId);
							break;

	default:
		# code...
		break;
}


$escuelas_ett= $escuela->buscar();

$resultado = $escuela->Cargo($referenteId);

$referente= new Referente($referenteId);

$buscandoreferente=$referente->buscar();
$dato=mysqli_fetch_object($buscandoreferente);

$persona= new Persona($dato->personaId);
$buscandopersona=$persona->buscar();

//$dato persona tiene todos los datos de basicos de la persona - ejempl nombre dni telefono...
$dato_persona=mysqli_fetch_object($buscandopersona);


$cantidad = mysqli_num_rows($resultado);

?>
				<script type="text/javascript">
				var map;
				$(document).ready(function(){
					map = new GMaps({


					<?php
					if($dato_persona->ubicacion<>""){
						$con_ubicacion=1;
						$lat= substr($dato_persona->ubicacion,0,10);
						$lng= substr($dato_persona->ubicacion,12,10);
						?>


						el: '#map',
							lat: <?php echo $lat;?>,
							lng:  <?php echo $lng;?>,
							zoomControl : true,
							zoomControlOpt: {
								style : 'SMALL',
								position: 'TOP_LEFT'
							},
							panControl : false,
							streetViewControl : false,
							mapTypeControl: true,
							overviewMapControl: false
						});

						map.drawOverlay({
							lat: <?php echo $lat;?>,
							lng:  <?php echo $lng;?>,
						 	content: '<div class="overlay"><?php echo $dato_persona->nombre;?></div>'
						});
						map.addMarker({
							  lat: <?php echo $lat;?>,
							  lng:  <?php echo $lng;?>,
							  title: '<?php echo $dato_persona->nombre;?>',
							  infoWindow: {
										  content: '<p><?php echo "<b>Nombre</b> ".$dato_persona->nombre;?></p>'
						}
																});
					<?php }


					while ($fila = mysqli_fetch_object($escuelas_ett))
							{
							$cantidad++;
							if($fila->ubicacion<>"" && $primero==0 && $con_ubicacion==0){
									$lat= substr($fila->ubicacion,0,10);
									$lng= substr($fila->ubicacion,12,10);

					   				 ?>
									el: '#map',
									lat: <?php echo $lat;?>,
									lng:  <?php echo $lng;?>,
									zoomControl : true,
									zoomControlOpt: {
										style : 'SMALL',
										position: 'TOP_LEFT'
									},
									panControl : false,
									streetViewControl : false,
									mapTypeControl: true,
									overviewMapControl: false
									});

									map.drawOverlay({
									lat: <?php echo $lat;?>,
								    lng:  <?php echo $lng;?>,
									  content: '<div class="overlay"><?php echo $fila->numero;?></div>'
									});
									map.addMarker({
										  lat: <?php echo $lat;?>,
										  lng:  <?php echo $lng;?>,
										  title: '<?php echo $fila->nombre."- Nº ".$fila->numero;?>',
										  infoWindow: {
											  content: '<p><?php echo "<b>Nº</b> ".$fila->numero;?></p>'
									        }
										});
					       		<?php
								$primero++;
								} elseif ($fila->ubicacion<>""){
					       			$lat= substr($fila->ubicacion,0,10);
					       			$lng= substr($fila->ubicacion,12,10);
					       	?>
				       				map.drawOverlay({
		   							lat: <?php echo $lat;?>,
		   						    lng:  <?php echo $lng;?>,
		      							  content: '<div class="overlay"><?php echo $fila->numero;?></div>'
		   							});
		   							map.addMarker({
		    								  lat: <?php echo $lat;?>,
		      								  lng:  <?php echo $lng;?>,
		       								  title: '<?php echo $fila->nombre."- Nº ".$fila->numero;?>',
			       								  infoWindow: {
			       									content: '<p><?php echo "<b>Nº</b> ".$fila->numero;?></p>'
		        							        }
									});

					       <?php }
							}
						//}
					       ?>

						});

						</script>

			<?php



	echo "<div class='container wow flipInX'>";

	echo'<div class="col-md-1"><img class="img-responsive img-circle" src="includes/mod_cen/portada/imgPortadas/escuela (2).png"></div><h4><b>Mis Escuelas</b><img class="img-responsive img-circle"  onclick="history.back()" align="right" src="includes/mod_cen/portada/imgPortadas/back/flecha-mis-esc.png"></h4>';

  echo '<hr>';
  echo'</div>';
  echo'<br>';
  echo'<br>';
  echo'<br>';

		echo "<div class='container'>";

	echo '<div class="panel panel-primary">';
	//	echo '<div class="panel-heading"><h4>Mis Escuelas</h4></div>';
		echo '<div class="panel-body">';
		echo '<div class="table-responsive">';
			echo "<table class='table table-bordered'>";
					echo "<tr><th colspan='10'>Cantidad Total: ".$cantidad."</th></tr>";
			echo "</table>";
		echo "</div>";
		echo '<div class="table-responsive">';
		echo "<table id='tableEscuelas' class='table table-hover table-striped table-condensed tablesorter'>";
		  echo "<thead>";
				echo "<tr class='info' ><th>CUE</th>";
					echo "<th>Nº</th>";
					echo "<th>Nombre</th>";
					echo "<th>Nivel</th>";
					echo "<th>Localidad</th>";
					echo "<th>Horario</th>";
					echo "<th>Informe</th>";
					echo "<th>Cant</th>";
					echo "<th>Piso</th>";
					echo "<th>Autoridad</th>";
					echo "<th>Supervisor</th>";
					echo "<th>RTI</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
while ($fila = mysqli_fetch_object($resultado))
{
	echo "<tr>";
	echo "<td>"."<a href='index.php?mod=slat&men=escuelas&id=3&escuelaId=".$fila->escuelaId."'>".$fila->cue."</a></td>";
	echo "<td>"."<a class='btn btn-success' href='index.php?mod=slat&men=escuelas&id=3&escuelaId=".$fila->escuelaId."'>".$fila->numero."</a></td>";
	echo "<td>"."<a href='index.php?mod=slat&men=escuelas&id=3&escuelaId=".$fila->escuelaId."'>".$fila->nombre."</a></td>";
	echo "<td>".$fila->nivel."</td>";
	$obj_local= new Localidad($fila->localidadId,null,null);
	$dato_local=$obj_local->buscar();
	$localidad=mysqli_fetch_object($dato_local);
	echo "<td>".$localidad->nombre."</td>";

	$informe = new Informe(null,$fila->escuelaId);

	$buscar_informe = $informe->buscar();
  $cant=0;
	//$cant = mysqli_num_rows($buscar_informe);

	while ($fila1 = mysqli_fetch_object($buscar_informe)){
//var_dump($fila1);
		if($fila1->tipo=="Facilitador"){
			$cant +=1;
		}
	}
	echo '<td> <a class="btn btn-success" href="index.php?mod=slat&men=user&id=21&escuelaId='.$fila->escuelaId.'">Cargar Horario</a> </td>';
	if($cant==0){

		echo "<td><a class='btn btn-danger' href='index.php?mod=slat&men=informe&id=1&escuelaId=".$fila->escuelaId."'>
					 Crear</a>&nbsp&nbsp</td><td><a class='btn btn-danger' href='#'>0</a></td>";

	}else{
	 	echo "<td><a class='btn btn-success' href='index.php?mod=slat&men=informe&id=1&escuelaId=".$fila->escuelaId."'>
					 Crear</a></td>";
		echo  "<td><a class='btn btn-success' href='index.php?mod=slat&men=informe&id=2&tipo=facilitador&escuelaId=".$fila->escuelaId."'>$cant</a></td>";
	}

	if($fila->nivel=="Primaria Común") {
		echo "<td>"."<a class='btn btn-success' href='index.php?mod=slat&men=escuelas&id=7&escuelaId=".$fila->escuelaId."'>ADM</a>"."</td>";
	}else {
		echo "<td>"."<a class='btn btn-success' href='index.php?mod=slat&men=escuelas&id=8&escuelaId=".$fila->escuelaId."'>Piso</a>"."</td>";
	}

	echo "<td>";
	$director= director::existeAutoridad($fila->escuelaId);
	$director2 = mysqli_fetch_object($director);
	$dato_supervisor=supervisor::existeSupervisor($fila->escuelaId);
	$supervisor=mysqli_fetch_object($dato_supervisor);
	$dato_rti=Rti::existeRtixinstitucion($fila->escuelaId);
	$rti=mysqli_num_rows($dato_rti);
	if(isset($director2->directorId)>0)//Si existe director
	{
		echo "<a class='btn btn-primary' role='button' href='index.php?mod=slat&men=escuelas&id=13&personaId=".$director2->personaId."&directorId=".$director2->directorId."&escuelaId=".$fila->escuelaId."'>".$director2->tipoautoridad."</a>";
	}
	else
	{
		echo "<a class='btn btn-danger' role='button' href='index.php?mod=slat&men=escuelas&id=13&escuelaId=".$fila->escuelaId."' font-weight:bold' >Sin Autoridad</a>";
	}
	echo "</td>";
	echo "<td>";
	if($supervisor->supervisor_id>0)//Si existe supervisor para la escuela
	{
		echo "<a class='btn btn-primary' role='button' href='index.php?mod=slat&men=escuelas&id=15&personaId=".$supervisor->supervisor_id."&escuelaId=".$fila->escuelaId."'>".$supervisor->apellido.",".$supervisor->nombre."</a>";
	}
	else
	{
		echo "<a class='btn btn-danger' role='button' href='index.php?mod=slat&men=escuelas&id=15&escuelaId=".$fila->escuelaId."' font-weight:bold' >Sin Supervisor</a>";
	}
	echo "</td>";
	echo "<td>";
	if($rti>0)//Si existe rti para la escuela
	{
		//index.php?mod=slat&men=escuelas&id=17&escuelaId=0177
		echo "<a class='btn btn-primary' role='button' href='index.php?mod=slat&men=referentes&id=8&escuelaId=".$fila->escuelaId."'>".$rti."</a>";
	}
	else
	{
		echo "<a class='btn btn-danger' role='button' href='index.php?mod=slat&men=referentes&id=8&escuelaId=".$fila->escuelaId."' font-weight:bold' >0</a>";
	}
	echo "</td>";
	echo "</tr>";
	echo "\n";

}
echo "<tbody>";
echo "</table>";
echo "<div>";
echo "<div>";
echo "<div>";
echo "<div>";
echo "<div class='span11'>";
echo "<div id='map'></div>";
echo "</div>";
echo "</div>";
?>

<script type="text/javascript">
$(document).ready(function()
		{
				//$("#myTable").tablesorter();
				$("#tableEscuelas").tablesorter( {sortList: [[1,0]]} );
				//$("#myTable1").tablesorter();
				//$("#myTable1").tablesorter( {sortList: [[0,1]]} );
		}
);
</script>
<script type="text/javascript">

$("#tableEscuelas").tableExport({
		formats: ['xls'],
		bootstrap: true,
		ignoreCols: [5,7],

	});


</script>

<center>
 <img class="img-responsive img-circle wow bounceInRight" onclick="history.back()"  src="includes/mod_cen/portada/imgPortadas/back/flecha-mis-esc.png"></center>
 <script type="text/javascript" src="includes/mod_cen/portada/js/animatePortadas.js"></script>
