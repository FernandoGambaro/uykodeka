<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
/**
 * UYCODEKA
 * Copyright (C) MCC (http://www.mcc.com.uy)
 *
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General Affero de GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 *
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General Affero de GNU para
 * obtener una información más detallada.
 *
 * Debería haber recibido una copia de la Licencia Pública General Affero de GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/agpl.html>.
 */
 
session_start();
require_once('../class/class_session.php');
/*
Instantiate a new session object. If session exists, it will be restored,
otherwise, a new session will be created--placing a sid cookie on the user's
computer.
*/
if (!$s = new session()) {
  /*
  There is a problem with the session! The class has a 'log' property that
  contains a log of events. This log is useful for testing and debugging.
  */
  echo "<h2>Ocurrió un error al iniciar session!</h2>";
  echo $s->log;
  exit();
}


if((!$s->data['isLoggedIn']) || !($s->data['isLoggedIn']))
{
	/*/user is not logged in*/
	echo "<script>location.href='../index.php'; </script>";
   //header("Location:../index.php");	

} else {
   $loggedAt=$s->data['loggedAt'];
   $timeOut=$s->data['timeOut'];
   if(isset($loggedAt) && (time()-$loggedAt >$timeOut)){
   	$s->data['act']="timeout";
    	$s->save();  	
  		//header("Location:../index.php");	
		echo "<script>window.top.location.href='../index.php'; </script>";
	   exit;
   }
   $s->data['loggedAt']= time();
   $s->save();
}

$UserID=$s->data['UserID'];
$UserNom=$s->data['UserNom'];
$UserApe=$s->data['UserApe'];
$UserTpo=$s->data['UserTpo'];
$paginacion=$s->data['alto'];
if($paginacion<=0) {
	$paginacion=20;
}
include ("../conectar.php");
include("../common/verificopermisos.php");
//header('Content-Type: text/html; charset=UTF-8'); 


$codcliente=@$_POST["codcliente"];
$nombre=@$_POST["nombre"];

$nif=@$_POST["nif"];
$codprovincia=@$_POST["cboProvincias"];
$localidad=@$_POST["localidad"];
$telefono=@$_POST["telefono"];
$cadena_busqueda=@$_POST["cadena_busqueda"];

$where="1=1";
if ($codcliente <> "") { $where.=" AND codcliente='$codcliente'"; }
if ($nombre <> "") { $where.=" AND(empresa like '%".$nombre."%' or nombre like '%".$nombre."%' or apellido like '%".$nombre."%' )"; }
if ($nif <> "") { $where.=" AND nif like '%".$nif."%'"; }
if ($codprovincia > "0") { $where.=" AND codprovincia='$codprovincia'"; }
if ($localidad <> "") { $where.=" AND localidad like '%".$localidad."%'"; }
if ($telefono <> "") { $where.=" AND (telefono like '%".$telefono."%' or  movil like '%".$telefono."%')" ; }

$query_busqueda="SELECT count(*) as filas FROM clientes WHERE borrado=0 AND ".$where;
$rs_busqueda=mysqli_query($GLOBALS["___mysqli_ston"], $query_busqueda);
$filas=mysqli_result($rs_busqueda, 0, "filas");
$where.=" ORDER BY service DESC, empresa ASC, nombre ASC";

?>
<html>
	<head>
		<title>Clientes</title>
		<link href="../css3/estilos.css" type="text/css" rel="stylesheet">
		<script src="../js3/jquery.min.js"></script>
		<link rel="stylesheet" href="../js3/colorbox.css" />
		<script src="../js3/jquery.colorbox.js"></script>
		
		
<script type="text/javascript">
var estilo="background-color: #2d2d2d; border-bottom: 1px solid #000; color: #fff;";

var idstyle='';

$(document).ready(function()
{
$("form:not(.filter) :input:visible:enabled:first").focus();

$('.trigger').click(function(e){
  	if (idstyle!="") {	
		var el = document.getElementById(idstyle);
		el.setAttribute('style', '');    	
  	}
      list=this.id;

      idstyle=this.id;
		var el = document.getElementById(list);
		el.setAttribute('style', estilo); 
		parent.document.getElementById("selid").value=list;     
   }); 
});

</script>		
		<script language="javascript">

		function ver_cliente(codcliente) {
			var url="ver_cliente.php?codcliente=" + codcliente + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
			var w='900px';
			var h='510px';
			window.parent.OpenNote(url,w,h);
		}
	
		function modificar_cliente(codcliente) {
			var url="modificar_cliente.php?codcliente=" + codcliente + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
			var w='900px';
			var h='510px';
			window.parent.OpenNote(url,w,h);
		}
	
		function eliminar_cliente(codcliente) {
			var url="eliminar_cliente.php?codcliente=" + codcliente + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
			var w='900px';
			var h='510px';
			window.parent.OpenNote(url,w,h);
		}

		function vermapa_cliente(codcliente) {
			var url="vermapa.php?codcliente=" + codcliente + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
			var w='700px';
			var h='500px';
			window.parent.OpenNote(url,w,h);
		}

</script>		
		<script language="javascript">
		
		function listar_equipos(codcliente) {
			var url="equipos/index.php?codcliente=" + codcliente ;
			var w='750px';
			var h='450px';
			window.parent.OpenNote(url,w,h);
		}

		function listar_service(codcliente) {
			var url="service/index.php?e=" + codcliente ;
			var w='97%';
			var h='500px';
			window.parent.OpenNote(url,w,h);
		}

		function listar_backup(codcliente) {
			var url="backup/index.php?e=" + codcliente ;
			var w='90%';
			var h='90%';
			window.parent.OpenNote(url,w,h);
		}
		function listar_proyectos(codcliente) {
			var url="proyectos/index.php?e=" + codcliente ;
			var w='95%';
			var h='95%';
			window.parent.OpenNote(url,w,h);
		}
		function inicio() {
			var list=parent.document.getElementById("selid").value;
			var paginacion=<?php echo $paginacion;?>;
			var numfilas=document.getElementById("numfilas").value;
			var indi=parent.document.getElementById("iniciopagina").value;
			var contador=1;
			var indice=0;
			var indiaux=0;
			if (parseInt(indi)>parseInt(numfilas)) { 
				indi=1; 
			}
			if (parseInt(numfilas) <= paginacion) {
					parent.document.getElementById("nextdisab").style.display = 'block';
					parent.document.getElementById("lastdisab").style.display = 'block';
					parent.document.getElementById("last").style.display = 'none';
					parent.document.getElementById("next").style.display = 'none';
			}
			parent.document.form_busqueda.filas.value=numfilas;
			parent.document.form_busqueda.paginas.innerHTML="";

			parent.document.getElementById("prevpagina").value = contador-paginacion;
			parent.document.getElementById("currentpage").value = indice+1;
			parent.document.getElementById("nextpagina").value = contador + paginacion;
			numfilas=Math.abs(numfilas);
			while (contador<=numfilas) {
				if (parseInt(contador+paginacion-1)>numfilas) {
					texto=contador + " al " + parseInt(numfilas);
				} else {
					texto=contador + " al " + parseInt(contador+paginacion-1);
				}
				if (parseInt(indi)==parseInt(contador)) {
					if (indi==1) {
					parent.document.getElementById("first").style.display = 'none';
					parent.document.getElementById("prev").style.display = 'none';
					parent.document.getElementById("firstdisab").style.display = 'block';
					parent.document.getElementById("prevdisab").style.display = 'block';
					} else {
					parent.document.getElementById("first").style.display = 'block';
					parent.document.getElementById("prev").style.display = 'block';
					parent.document.getElementById("firstdisab").style.display = 'none';
					parent.document.getElementById("prevdisab").style.display = 'none';
					}
					parent.document.getElementById("prevpagina").value = contador-paginacion;
					parent.document.getElementById("currentpage").value = indice + 1;
					parent.document.getElementById("nextpagina").value = contador + paginacion;

					parent.document.form_busqueda.paginas.options[indice]=new Option (texto,contador);
					parent.document.form_busqueda.paginas.options[indice].selected=true;
					indiaux=	indice;				
					
				} else {

					parent.document.form_busqueda.paginas.options[indice]=new Option (texto,contador);
					parent.document.getElementById("lastpagina").value = contador;
				}
				indice++;
				contador=Math.abs(contador+paginacion);
			}	

					if (parseInt(indiaux) == parseInt(indice)-1 ) {
					parent.document.getElementById("nextdisab").style.display = 'block';
					parent.document.getElementById("lastdisab").style.display = 'block';
					parent.document.getElementById("last").style.display = 'none';
					parent.document.getElementById("next").style.display = 'none';
					} else {
					parent.document.getElementById("nextdisab").style.display = 'none';
					parent.document.getElementById("lastdisab").style.display = 'none';
					parent.document.getElementById("last").style.display = 'block';
					parent.document.getElementById("next").style.display = 'block';
					}
			
			idstyle=list;
			var el = document.getElementById(list);
			//if(jQuery("#"+list).length){
			//alert('pp')			;
			//}
			if (!document.getElementById(list)) {
			idstyle='';
			} else {
			el.setAttribute('style', estilo);   
			}
		}	

		</script>
	<script type="text/javascript">
	function addLoadEvent(func) { 
	  var oldonload = window.onload; 
  if (typeof window.onload != 'function') { 
	    window.onload = func; 
	  } else { 
	    window.onload = function() { 
	      if (oldonload) { 
	        oldonload(); 
	      } 
	      func(); 
	    } 
	  } 
	} 
	addLoadEvent(inicio); 
	</script>	

	</head>

	<body onload="inicio();">	
		<div id="pagina">
			<div id="zonaContenido">
			<div align="center">
			<div class="header" style="width:100%;position: fixed; font-size: 140%;">	LISTADO DE CLIENTES </div>
				<div class="fixed-table-container">
					<div class="header-background cabeceraTabla"> </div>      			
					<div class="fixed-table-container-inner">
					<?php 
							$leer=verificopermisos('clientes', 'leer', $UserID);
							$escribir=verificopermisos('clientes', 'escribir', $UserID);
							$modificar=verificopermisos('clientes', 'modificar', $UserID);
							$eliminar=verificopermisos('clientes', 'eliminar', $UserID);
								
							$equipos=verificopermisos('equipos', 'leer', $UserID);
							$service=verificopermisos('servicios', 'leer', $UserID);
							$respaldos=verificopermisos('respaldos', 'leer', $UserID);
							$proyectos=verificopermisos('proyectos', 'leer', $UserID);

					?>	
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=2 border=0 id="navigate" style="font-size: 100%;">
					<thead>
					  <tr>			
							<?php if ( $equipos=="true") { ?>
							<th><div align="left" class="th-inner">EQ.</div></th>
							<?php } if ( $service=="true") { ?>
							<th align="left"><div class="th-inner">HIST.</div></th>
							<?php } if ( $respaldos=="true") { ?>
							<th align="left"><div class="th-inner">HIST.</div></th>
							<?php }  else { ?>
							<td><div class="th-inner">&nbsp;</div></td>							
							<?php } if ( $proyectos=="true") { ?>
							<th align="left"><div class="th-inner">PROY.</div></th>
							<?php } else { ?>
							<td><div class="th-inner">&nbsp;</div></td>							
							<?php } ?>
							<th width="38%" colspan="2" align="left"><div class="th-inner">&nbsp;NOMBRE/RAZÓN SOCIAL</div></th>
							<th width="13%" align="left"><div class="th-inner">DOCUMENTO</div></th>
							<th width="13%" align="center"><div class="th-inner">EMAIL</div></th>
							<th width="19%" align="center"><div class="th-inner">TELEFONO</div></th>
							<th width="19%" align="center"><div class="th-inner">ABONADO</div></th>
							<th width="15px" align="left"><div align="left" class="th-inner">H.</div></th>
							<th colspan="4" align="center"><div class="th-inner" >&nbsp;&nbsp;&nbsp;ACCIÓN</div></th>
						</tr>
					</thead>
		<tbody>
			<input type="hidden" name="numfilas" id="numfilas" value="<?php echo $filas;?>">
				<?php 
				$iniciopagina=isset($_POST['iniciopagina']) ? $_POST['iniciopagina'] : null ;

				if ($iniciopagina=='') { $iniciopagina=@$_GET["iniciopagina"]; } else { $iniciopagina=$iniciopagina-1;}
				if ($iniciopagina=='') { $iniciopagina=0; }
				if ($iniciopagina>$filas) { $iniciopagina=0; }
					if ($filas > 0) { ?>
						<?php
							$tiponif = array("", "RUT","CI", "Pasaporte");
							$sel_resultado="SELECT * FROM clientes WHERE borrado=0 AND ".$where;
						   $sel_resultado=$sel_resultado."  limit ".$iniciopagina.",". $paginacion;
						   $res_resultado=mysqli_query($GLOBALS["___mysqli_ston"], $sel_resultado);
						   $contador=0;
						   while ($contador < mysqli_num_rows($res_resultado)) { 
								 if ($contador % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }
								 if (mysqli_result($res_resultado, $contador, "service")==2) {
								 	$classBold='font-weight: bold; font-size: 120%;';
								 } else {
								 	$classBold='font-weight: normal;';
								 }
								 ?>
						<tr id="<?php echo mysqli_result($res_resultado, $contador, "codcliente");?>"	 class="<?php echo $fondolinea?> trigger">

						<?php if ( $equipos=="true") { ?>	
							<td ><a href='#'><img id="botonBusqueda" src="../img/equipo.png" width="16" height="16" border="0" onClick="listar_equipos(<?php echo mysqli_result($res_resultado, $contador, "codcliente");?>);" title="Listar equipos"></a></td>
						<?php } if ( $service=="true") { ?>
							<td><a href='#'><img id="botonBusqueda" src="../img/service.png" width="16" height="16" border="0" onClick="listar_service(<?php echo mysqli_result($res_resultado, $contador, "codcliente");?>);" title="Listar services"></a></td>
						<?php } if (mysqli_result($res_resultado, $contador, "service")==2 and $respaldos=="true") { ?>
							<td><a href='#'><img id="botonBusqueda" src="../img/backup.png" width="16" height="16" border="0" onClick="listar_backup(<?php echo mysqli_result($res_resultado, $contador, "codcliente");?>);" title="Listar backups"></a></td>
						<?php } else { ?>
							<td><img src="../img/blank.png" width="22" height="16" border="0" ></td>							
							<?php } if (mysqli_result($res_resultado, $contador, "service")==2 and $proyectos=="true") { ?>
							<td><a href='#'><img id="botonBusqueda" src="../img/proyectos.png" width="16" height="16" border="0" onClick="listar_proyectos(<?php echo mysqli_result($res_resultado, $contador, "codcliente");?>);" title="Listar proyectos"></a></td>
						<?php } else { ?>
							<td><img src="../img/blank.png" width="22" height="16" border="0" ></td>							
							<?php } ?>	
							<td width="38%" colspan="2">
							<div align="left" style="<?php echo $classBold;?>"><font>
							<?php echo mysqli_result($res_resultado, $contador, "empresa"). " - ". mysqli_result($res_resultado, $contador, "nombre")
							." ". mysqli_result($res_resultado, $contador, "apellido");?></font>
							</div></td>
							
							<td class="aDerecha" width="13%"><div align="center" style="<?php echo $classBold;?>"><?php echo $tiponif[mysqli_result($res_resultado, $contador, "tiponif")]. ' '. mysqli_result($res_resultado, $contador, "nif")?></div></td>
							<td class="aDerecha" width="13%"><div align="center" style="<?php echo $classBold;?>"><?php echo mysqli_result($res_resultado, $contador, "email")?></div></td>
							<td class="aDerecha" width="19%"><div align="center" style="<?php echo $classBold;?>"><?php echo mysqli_result($res_resultado, $contador, "telefono")?>
							<?php if (mysqli_result($res_resultado, $contador, "movil")!=''  ){ echo " / ". mysqli_result($res_resultado, $contador, "movil");}?>
							</div></td>
							<td class="aDerecha" width="19%"><div align="center" style="<?php echo $classBold;?>">
							<?php
							 $tipo = array("Sin&nbsp;definir", "Común","Abonado A", "Abonado B");
								echo $tipo[mysqli_result($res_resultado, $contador, "service")];?>
							</div></td>
							<td class="aDerecha" width="19%"><div align="center" style="<?php echo $classBold;?>"><?php echo mysqli_result($res_resultado, $contador, "horas")?>
							</div></td>
							<td><div align="center"><a href="#"><?php if(mysqli_result($res_resultado, $contador, "direccion")!="") {?>
							<img id="botonBusqueda" src="../img/Google-Maps-icon.png" width="16" height="16" border="0" onClick="vermapa_cliente(<?php echo mysqli_result($res_resultado, $contador, "codcliente")?>)" title="Ver mapa"></a></div></td>
							<?php } else { ?>
							</a></div></td>
							<?php } ?>							
							<td>
	<?php if ( $modificar=="true") { ?>		
							<div align="center"><a href="#"><img id="botonBusqueda" src="../img/modificar.png" width="16" height="16" border="0" onClick="modificar_cliente(<?php echo mysqli_result($res_resultado, $contador, "codcliente")?>)" title="Modificar"></a></div></td>
	<?php } else { ?>
							<td ><div align="center"></div></td>
	<?php } if ( $leer=="true") { ?>							
							<td><div align="center"><a href="#">
							<img id="botonBusqueda" src="../img/ver.png" width="16" height="16" border="0" onClick="ver_cliente(<?php echo mysqli_result($res_resultado, $contador, "codcliente")?>)" title="Visualizar"></a></div></td>
	<?php } else { ?>
							<td ><div align="center"></div></td>
	<?php } if ( $eliminar=="true") { ?>							
							<td><div align="center"><a href="#">
							<img id="botonBusqueda" src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar_cliente(<?php echo mysqli_result($res_resultado, $contador, "codcliente")?>)" title="Eliminar"></a></div></td>
	<?php } else { ?>
							<td ><div align="center"></div></td>
	<?php } ?>							
						</tr>
						<?php $contador++;
							}
						?>	
						</tbody>								
					</table>
					<?php } else { ?>
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="100%" class="mensaje"><?php echo "No hay ning&uacute;n cliente que cumpla con los criterios de b&uacute;squeda";?></td>
					    </tr>
					</table>					
					<?php } ?>					
				</div>
			</div>
		  </div>	</div></div>		
		</div>
	</body>
</html>
