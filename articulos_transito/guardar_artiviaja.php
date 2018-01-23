<?php
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


include ("../conectar.php");
include("../common/verificopermisos.php");
include("../common/funcionesvarias.php");
include ("../funciones/fechas.php"); 
//header('Cache-Control: no-cache');
//header('Pragma: no-cache'); 
//header('Content-Type: text/html; charset=UTF-8');
$mensaje='';
$mensaje_minimo='';

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$codartiviajatmp=$_POST["codartiviajatmp"];
$codcliente=$_POST["codcliente"];
//$tipo=$_POST["atipo"];

$transportista=$_POST["transportista"];
$estado=$_POST["Aestado"];
$vehiculo=$_POST["vehiculo"];

$chofer=$_POST["chofer"];


$destino=$_POST["adestino"];
$observacion=$_POST["observacion"];
$fechaenvio=explota($_POST["fechaenvio"]);
$fecharentrega=explota($_POST["fecharentrega"]);
$hora=$_POST["hora"];



if ($accion=="alta") {
	$fecha=date("Y-m-d");
	

$query_operacion="INSERT INTO `uycodeka`.`artiviaja` (`codartiviaja`, `tipo`, `fecha`, `codcliente`, `estado`, `transportista`, `vehiculo`, `chofer`,
 `destino`, `observacion`, `fechaenvio`, `fecharentrega`, `hora`, `emitido`, `borrado`) 
 VALUES 	('$codartiviajatmp', '$tipo', '$fecha', '$codcliente', '1', '$transportista', '$vehiculo', '$chofer', '$destino', '$observacion', '$fechaenvio', '$fecharentrega', '$hora', '0', '0');";					
	$rs_operacion=mysqli_query($GLOBALS["___mysqli_ston"], $query_operacion);
	/*$codartiviaja=mysql_insert_id(); Anulo pues el nº de artiviaja lo ingreso manualmente.-*/
	$codartiviaja=$codartiviajatmp;
	if ($rs_operacion) { $mensaje="El articulo en transito ha sido dada de alta correctamente"; }
	$query_tmp="SELECT * FROM artiviajalineatmp WHERE codartiviaja='$codartiviaja' ORDER BY numlinea ASC";
	$rs_tmp=mysqli_query($GLOBALS["___mysqli_ston"], $query_tmp);
	$contador=0;
	$baseimponible=0;
	while ($contador < mysqli_num_rows($rs_tmp)) {
		$codfamilia=mysqli_result($rs_tmp, $contador, "codfamilia");
		$numlinea=mysqli_result($rs_tmp, $contador, "numlinea");
		$codigo=mysqli_result($rs_tmp, $contador, "codigo");
		$codservice=mysqli_result($rs_tmp, $contador, "codservice");
		$detalles=mysqli_result($rs_tmp, $contador, "detalles");
		$cantidad=mysqli_result($rs_tmp, $contador, "cantidad");
		$sel_insertar="INSERT INTO artiviajalinea (codartiviaja,numlinea,codfamilia,codigo,detalles,cantidad) VALUES 
		('$codartiviaja','$numlinea','$codfamilia','$codigo', '$detalles','$cantidad')";
		$rs_insertar=mysqli_query($GLOBALS["___mysqli_ston"], $sel_insertar);
		
				
		$sel_articulos="UPDATE articulos SET stock=(stock-'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_articulos=mysqli_query($GLOBALS["___mysqli_ston"], $sel_articulos);
		$sel_minimos = "SELECT stock,stock_minimo,descripcion FROM articulos where codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_minimos= mysqli_query($GLOBALS["___mysqli_ston"], $sel_minimos);
		if ((mysqli_result($rs_minimos, 0, "stock") < mysqli_result($rs_minimos, 0, "stock_minimo")) or (mysqli_result($rs_minimos, 0, "stock") <= 0))
	   		{ 
		  		$mensaje_minimo=$mensaje_minimo . " " . mysqli_result($rs_minimos, 0, "descripcion")."<br>";
				$minimo=1;
   			};
		$contador++;
	}
      	
	$cabecera1="Inicio >> Ventas &gt;&gt; Nuevo articulo en transito ";
	$cabecera2="INSERTAR ARTICULO EN TRANSITO ";
}

if ($accion=="modificar") {
	$codartiviaja=$_POST["codartiviajatmp"];
	$act_albaran="UPDATE `uycodeka`.`artiviaja` SET `codcliente` = '$codcliente', `estado` = '$estado', `transportista` = '$transportista', `vehiculo` = '$vehiculo',
	`chofer` = '$chofer', `destino` = '$destino', `observacion` = '$observacion', `fechaenvio` = '$fechaenvio', `fecharentrega` = '$fecharentrega', `hora` = '$hora'
 	WHERE `artiviaja`.`codartiviaja` ='$codartiviajatmp';";
 
	$rs_albaran=mysqli_query($GLOBALS["___mysqli_ston"], $act_albaran);
	$sel_lineas = "SELECT codigo,codfamilia,cantidad FROM artiviajalinea WHERE codartiviaja='$codartiviaja' order by numlinea";
	$rs_lineas = mysqli_query($GLOBALS["___mysqli_ston"], $sel_lineas);
	$contador=0;
	while ($contador < mysqli_num_rows($rs_lineas)) {
		$codigo=mysqli_result($rs_lineas, $contador, "codigo");
		$codfamilia=mysqli_result($rs_lineas, $contador, "codfamilia");
		$cantidad=mysqli_result($rs_lineas, $contador, "cantidad");
		$sel_actualizar="UPDATE `articulos` SET stock=(stock+'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_actualizar = mysqli_query($GLOBALS["___mysqli_ston"], $sel_actualizar);
		$contador++;
	}

	$sel_borrar = "DELETE FROM artiviajalinea WHERE codartiviaja='$codartiviaja'";
	$rs_borrar = mysqli_query($GLOBALS["___mysqli_ston"], $sel_borrar);
	$sel_lineastmp = "SELECT * FROM artiviajalineatmp WHERE codartiviaja='$codartiviaja' ORDER BY numlinea";
	$rs_lineastmp = mysqli_query($GLOBALS["___mysqli_ston"], $sel_lineastmp);
	$contador=0;
	$baseimponible=0;
	while ($contador < mysqli_num_rows($rs_lineastmp)) {
		$numlinea=mysqli_result($rs_lineastmp, $contador, "numlinea");
		$codigo=mysqli_result($rs_lineastmp, $contador, "codigo");
		$codfamilia=mysqli_result($rs_lineastmp, $contador, "codfamilia");
		$detalles=mysqli_result($rs_lineastmp, $contador, "detalles");
		$cantidad=mysqli_result($rs_lineastmp, $contador, "cantidad");
	
		$sel_insert = "INSERT INTO artiviajalinea (codartiviaja,numlinea,codigo,detalles,codfamilia,cantidad) 
		VALUES ('$codartiviaja','','$codigo', '$detalles','$codfamilia','$cantidad')";
		$rs_insert = mysqli_query($GLOBALS["___mysqli_ston"], $sel_insert);

	
		$sel_actualiza="UPDATE articulos SET stock=(stock-'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_actualiza = mysqli_query($GLOBALS["___mysqli_ston"], $sel_actualiza);
		$sel_bajominimo = "SELECT codarticulo,codfamilia,stock,stock_minimo,descripcion FROM articulos WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_bajominimo= mysqli_query($GLOBALS["___mysqli_ston"], $sel_bajominimo);
		$stock=mysqli_result($rs_bajominimo, 0, "stock");
		$stock_minimo=mysqli_result($rs_bajominimo, 0, "stock_minimo");
		$descripcion=mysqli_result($rs_bajominimo, 0, "descripcion");
		
		if (($stock < $stock_minimo) or ($stock <= 0) and $descripcion!='' )
		   { 
			  $mensaje_minimo=$mensaje_minimo . " - " . $descripcion."<br>";
			  $minimo=1;
		   };
		$contador++;
	}

	if ($rs_albaran) { $mensaje="Los datos de la articulo en transito han sido modificados correctamente"; }
	$cabecera1="Inicio >> Ventas &gt;&gt; Modificar articulo en transito ";
	$cabecera2="MODIFICAR ARTICULOS EN TRANSITO ";
}

if ($accion=="baja") {
	$codartiviaja=$_GET["codartiviaja"];
	$query="UPDATE artiviaja SET borrado=1 WHERE codartiviaja='$codartiviaja'";
	$rs_query=mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$query="SELECT * FROM artiviajalinea WHERE codartiviaja='$codartiviaja' ORDER BY numlinea ASC";
	$rs_tmp=mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$contador=0;
	$baseimponible=0;
	while ($contador < mysqli_num_rows($rs_tmp)) {
		$codfamilia=mysqli_result($rs_tmp, $contador, "codfamilia");
		$codigo=mysqli_result($rs_tmp, $contador, "codigo");
		$cantidad=mysqli_result($rs_tmp, $contador, "cantidad");
		$sel_articulos="UPDATE articulos SET stock=(stock+'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_articulos=mysqli_query($GLOBALS["___mysqli_ston"], $sel_articulos);
		$contador++;
	}
	if ($rs_query) { $mensaje="El articulo en transito ha sido eliminada correctamente"; }
	$cabecera1="Inicio >> Ventas &gt;&gt; Eliminar articulo en transito";
	$cabecera2="ELIMINAR ARTICULO EN TRANSITO";
	$query_mostrar="SELECT * FROM artiviaja WHERE codartiviaja='$codartiviaja'";
	$rs_mostrar=mysqli_query($GLOBALS["___mysqli_ston"], $query_mostrar);
	$codcliente=mysqli_result($rs_mostrar, 0, "codcliente");
	$fecha=mysqli_result($rs_mostrar, 0, "fecha");
}

	$sel_borrar = "DELETE FROM artiviajalineatmp WHERE codartiviaja='$codartiviaja'";
	$rs_borrar = mysqli_query($GLOBALS["___mysqli_ston"], $sel_borrar);

$sel_lineas="SELECT * FROM artiviajalinea WHERE codartiviaja='$codartiviaja' ORDER BY numlinea ASC";
$rs_lineas=mysqli_query($GLOBALS["___mysqli_ston"], $sel_lineas);

$sel_borrar = "DELETE FROM artiviajalineatmp WHERE codartiviaja='$codartiviaja'";
$rs_borrar = mysqli_query($GLOBALS["___mysqli_ston"], $sel_borrar);


$contador=0;
//echo mysql_num_rows($rs_lineas);
while ($contador < mysqli_num_rows($rs_lineas)) {
	$codfamilia=mysqli_result($rs_lineas, $contador, "codfamilia");
	$codarticulo=mysqli_result($rs_lineas, $contador, "codigo");
	$cantidad=mysqli_result($rs_lineas, $contador, "cantidad");
	$detalles=mysqli_result($rs_lineas, $contador, "detalles");

	$sel_tmp="INSERT INTO artiviajalineatmp (codartiviaja,numlinea,codfamilia,codigo,detalles,cantidad) 
	VALUES ('$codartiviajatmp','','$codfamilia','$codarticulo','$detalles','$cantidad')";

	$rs_tmp=mysqli_query($GLOBALS["___mysqli_ston"], $sel_tmp);
	$contador++;
}

$sel_alb="SELECT * FROM artiviaja WHERE codartiviaja='$codartiviaja'";
$rs_alb=mysqli_query($GLOBALS["___mysqli_ston"], $sel_alb);
$codcliente=mysqli_result($rs_alb, 0, "codcliente");
$estado=mysqli_result($rs_alb, 0, "estado");
$fechaenvio=implota(mysqli_result($rs_alb, 0, "fechaenvio"));
$fecha=implota(mysqli_result($rs_alb, 0, "fecha"));
$observacion=mysqli_result($rs_alb, 0, "observacion");
$destino=mysqli_result($rs_alb, 0, "destino");


$transportista=mysqli_result($rs_alb, 0, "transportista");
$vehiculo=mysqli_result($rs_alb, 0, "vehiculo");
$chofer=mysqli_result($rs_alb, 0, "chofer");
$fecharentrega=implota(mysqli_result($rs_alb, 0, "fecharentrega"));
$hora=mysqli_result($rs_alb, 0, "hora");

$sel_cliente="SELECT nombre,nif FROM clientes WHERE codcliente='$codcliente'";
$rs_cliente=mysqli_query($GLOBALS["___mysqli_ston"], $sel_cliente);
$nombre=mysqli_result($rs_cliente, 0, "nombre");
$nif=mysqli_result($rs_cliente, 0, "nif");

?>

<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <script src="../calendario/jscal2.js"></script>
    <script src="../calendario/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/css/win2k/win2k.css" />		
			<script src="js/jquery.min.js"></script>
		<link rel="stylesheet" href="js/colorbox.css" />
		<script src="js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="js/jquery.toastmessage.css" type="text/css">
<script src="js/jquery.toastmessage.js" type="text/javascript"></script>
<script src="js/message.js" type="text/javascript"></script>

		<!-- iconos para los botones -->       
<link rel="stylesheet" href="../css3/css/font-awesome.min.css">
	
	
		<script language="javascript">
		var cursor;
		if (document.all) {
		/*/ Está utilizando EXPLORER*/
		cursor='hand';
		} else {
		/*/ Está utilizando MOZILLA/NETSCAPE*/
		cursor='pointer';
		}
		
		function aceptar() {
			parent.$('idOfDomElement').colorbox.close();
		}
		
		function imprimir(codartiviaja) {
			var top = window.open("../fpdf/articulos_viaja.php?codartiviaja="+codartiviaja, "_blank");
			//top.close();
			//parent.$('idOfDomElement').colorbox.close();
		}
		
function inicio() {
			document.formulario_lineas.submit();
		}		
		</script>
	</head>
	<body onload="inicio();" >
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">Nuevo Artículos en transito </div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_artiviaja.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=2 border=0>
						<tr>
							<td width="5%">Cliente </td>
					      <td colspan="2"><input name="codcliente" type="hidden" class="cajaPequena" id="aCliente" value="<?php echo $codcliente;?>" size="6" maxlength="5">
					      <input name="nombre" type="text" class="cajaGrande" id="aNombre" size="45" maxlength="45" value="<?php echo $nombre;?>" data-index="1">
					        <img id="botonBusqueda" src="../img/ver.png" width="16" height="16" onClick="abreVentana();" title="Buscar cliente" onMouseOver="style.cursor=cursor" style="vertical-align: middle; margin-top: -1px;">
					         <img id="botonBusqueda" src="../img/cliente.png" width="16" height="16" onClick="validarcliente();" title="Validar cliente" onMouseOver="style.cursor=cursor" style="vertical-align: middle; margin-top: -1px;"></td>
						  <td>Nº&nbsp;Comprobante&nbsp;<input id="codartiviajatmp" class="cajaPequena" name="codartiviajatmp" value="<?php echo $codartiviajatmp;?>" readonly disabled="true"></td>
						  		         					        					
						</tr>
						<tr>
						<td>Estado</td>
				      <td>
			            <select id="estado" name="estado" class="cajaPequena" data-index="2">
								<?php $tipof = array(0=>"Entragado", 1=>"En transito");
								if ($estado==" ")
								{
								echo '<OPTION value="" selected>Selecione uno</option>';
								}
								$x=0;
								$NoEstado=0;
								foreach($tipof as $i) {
								  	if ( $x==$estado) {
										echo "<OPTION value=$x selected>$i</option>";
										$NoEstado=1;
									} else {
										echo "<OPTION value=$x>$i</option>";
									}
									$x++;
								}
								?>
						</select>
						</td>

						<td>Fecha&nbsp;salida</td>
						<td>
						    <input name="fechaenvio" type="text" class="cajaPequena" id="fechaenvio" size="10" maxlength="10" value="<?php echo $fechaenvio;?>" readonly data-index="3"> 
						    <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" style="vertical-align: middle; margin-top: -1px;">
								<script type="text/javascript">
						   Calendar.setup({
						     inputField : "fechaenvio",
						     trigger    : "Image1",
						     align		 : "Bl",
						     onSelect   : function() { this.hide() },
						     dateFormat : "%d/%m/%Y"
						   });
						</script></td>

						</tr>
						<tr>						
						<td colspan="4" width="100%" align="center"><div id="tituloForm" class="header">DATOS DEL TRANSPORTISTA</div></td>
						</tr>
						<tr><td>Empresa</td><td><input type="text" size="50" name="transportista" id="transportista" class="cajaGrande" maxlength="50" value="<?php echo $transportista;?>"  data-index="4"></td>
						<td>Datos&nbsp;del&nbsp;Vehículo</td><td><input type="text" name="vehiculo" id="vehiculo" class="cajaGrande" size="20" maxlength="50" value="<?php echo $vehiculo;?>" data-index="5"> </td>
						</tr>
						<tr><td>Chofer</td><td><input type="text" size="50" name="chofer" id="chofer" class="cajaGrande" maxlength="50" value="<?php echo $chofer;?>"  data-index="6"></td>
						</tr>
						<tr>						
						<td>Lugar&nbsp;de&nbsp;entrega</td><td>
						<input name="adestino" type="text" class="cajaGrande" id="destino" size="20" maxlength="50" value="<?php echo $destino;?>"  data-index="7">
						</td>
							<td width="6%">Fecha&nbsp;entrega</td><td>
						    <input name="fecharentrega" type="text" class="cajaPequena" id="fecharentrega" size="10" maxlength="10" value="<?php echo $fecharentrega;?>" readonly data-index="8"> 
						    <img src="../img/calendario.png" name="Image2" id="Image2" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" style="vertical-align: middle; margin-top: -1px;">
								<script type="text/javascript">
						   Calendar.setup({
						     inputField : "fecharentrega",
						     trigger    : "Image2",
						     align		 : "Bl",
						     onSelect   : function() { this.hide() },
						     dateFormat : "%d/%m/%Y"
						   });
						</script>
						&nbsp;Hora:&nbsp;<input type="text" name="hora" id="hora" size="10" class="cajaPequena" value="<?php echo $hora;?>" data-index="9">
						</td>
						</tr>
					</table>										
			  </div>
			  <input id="codartiviajatmp" name="codartiviajatmp" value="<?php echo $codartiviajatmp;?>" type="hidden">
			  <input id="observacion" name="observacion" value="<?php echo $observacion;?>" type="hidden">
			  <input id="accion" name="accion" value="modificar" type="hidden">
			  </form>
			  <br style="line-height:5px">
			  <div id="frmBusqueda">
				<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" target="frame_lineas">
				
<!--//fin del form incio-->

				</div>
				<input name="codarticulo" value="" type="hidden" id="codarticulo">
				<br style="line-height:5px">
				<div id="frmBusqueda">
				<table class="fuente8" width="100%" cellspacing=0 cellpadding=0 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="3%">ITEM</td>
							<td width="14%">REFERENCIA</td>
							<td width="34%">DESCRIPCION</td>
							<td width="34%">DETALLES</td>
							<td width="8%">CANTIDAD</td>
							<td width="10px">&nbsp;</td>
						</tr>
						<tr><td width="100%" colspan="9">
					<iframe width="100%" height="160" id="frame_lineas" name="frame_lineas" frameborder="0">
						<ilayer width="100%" height="160" id="frame_lineas" name="frame_lineas"></ilayer>
					</iframe>
				</td></tr>					
				</table>
			  </div>
			  <div id="frmBusqueda">
			<table width="100%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
			<tr>
			<td align="rigth" valign="top">
				<table border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
				<tr>
				<td valign="top">Observaciones</td>
				<td valign="top" rowspan="3"><textarea id="observacionaux" rows="4" cols="40"></textarea>
				</td>
				<td>
					<div align="center">
						<button class="boletin" onClick="imprimir(<?php echo $codartiviaja?>);" onMouseOver="style.cursor=cursor"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Imprimir</button>
						<button class="boletin" onClick="aceptar();" onMouseOver="style.cursor=cursor"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Salir</button>
				    	<input id="codfamilia" name="codfamilia" value="<?php echo $codfamilia?>" type="hidden">
				    	<input id="codartiviajatmp" name="codartiviajatmp" value="<?php echo $codartiviajatmp;?>" type="hidden">	
						<input id="modif" name="modif" value="0" type="hidden">				    
					</div>
				</td>
				</tr> 				
				</table>
				</td><td >
				
			  </tr>
		</table>
			  </div>
			  		<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
			  </form>
			 </div>
	 
			 </div>
		</div>
	
	</body>
</html>
