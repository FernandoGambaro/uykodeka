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

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

////header('Cache-Control: no-cache');
////header('Pragma: no-cache'); 
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
include ("../conectar.php"); 

$accion=$_POST["accion"];

if (!isset($accion)) { $accion=$_GET["accion"]; }


$nombre=$_POST["Anombre"];
$nif=$_POST["anif"];
$codpais=@$_POST['codpais'];
$direccion=$_POST["adireccion"];
$localidad=$_POST["alocalidad"];
$codprovincia=$_POST["cboProvincias"];
$codentidad=$_POST["cboBanco"];
$cuentabancaria=$_POST["acuentabanco"];
$codpostal=$_POST["acodpostal"];
$telefono=$_POST["atelefono"];
$movil=$_POST["amovil"];
$rubro=$_POST["arubro"];
$email=$_POST["aemail"];
$web=$_POST["aweb"];
$horario=$_POST["horario"];

if ($accion=="alta") {
	$query_operacion="INSERT INTO proveedores (codproveedor, nombre, nif, codpais, direccion, codprovincia, localidad, codentidad, cuentabancaria, codpostal, telefono, movil,rubro, email, web, borrado) 
					VALUES ('', '$nombre', '$nif', '$codpais', '$direccion', '$codprovincia', '$localidad', '$codentidad', '$cuentabancaria', '$codpostal', '$telefono', '$movil', '$rubro', '$email', '$web', '0')";					
	$rs_operacion=mysqli_query($GLOBALS["___mysqli_ston"], $query_operacion);
	if ($rs_operacion) { $mensaje="El proveedor ha sido dado de alta correctamente"; }
	$cabecera1="Inicio >> Proveedores &gt;&gt; Nuevo Proveedor ";
	$cabecera2="INSERTAR PROVEEDOR ";
	$sel_maximo="SELECT max(codproveedor) as maximo FROM proveedores";
	$rs_maximo=mysqli_query($GLOBALS["___mysqli_ston"], $sel_maximo);
	$codproveedor=mysqli_result($rs_maximo, 0, "maximo");
}

if ($accion=="modificar") {
	$codproveedor=$_POST["codproveedor"];
	$query="UPDATE proveedores SET nombre='$nombre', nif='$nif', codpais='$codpais', direccion='$direccion', codprovincia='$codprovincia', localidad='$localidad', codentidad='$codentidad', cuentabancaria='$cuentabancaria', codpostal='$codpostal', telefono='$telefono', movil='$movil', rubro='$rubro', email='$email', web='$web', borrado=0 WHERE codproveedor='$codproveedor'";
	$rs_query=mysqli_query($GLOBALS["___mysqli_ston"], $query);
	if ($rs_query) { $mensaje="Los datos del proveedor han sido modificados correctamente"; }
	$cabecera1="Inicio >> Proveedores &gt;&gt; Modificar Proveedor ";
	$cabecera2="MODIFICAR PROVEEDOR ";
}

if ($accion=="baja") {
	$codproveedor=$_POST["codproveedor"];
	$query="UPDATE proveedores SET borrado=1 WHERE codproveedor='$codproveedor'";
	$rs_query=mysqli_query($GLOBALS["___mysqli_ston"], $query);
	if ($rs_query) { $mensaje="El proveedor ha sido eliminado correctamente"; }
	$cabecera1="Inicio >> Proveedores &gt;&gt; Eliminar Proveedor ";
	$cabecera2="ELIMINAR PROVEEDOR ";
	$query_mostrar="SELECT * FROM proveedores WHERE codproveedor='$codproveedor'";
	$rs_mostrar=mysqli_query($GLOBALS["___mysqli_ston"], $query_mostrar);
	$nombre=mysqli_result($rs_mostrar, 0, "nombre");
	$nif=mysqli_result($rs_mostrar, 0, "nif");
	$codpais=mysqli_result($rs_mostrar, 0, "codpais");
	$direccion=mysqli_result($rs_mostrar, 0, "direccion");
	$localidad=mysqli_result($rs_mostrar, 0, "localidad");
	$codprovincia=mysqli_result($rs_mostrar, 0, "codprovincia");
	$codentidad=mysqli_result($rs_mostrar, 0, "codentidad");
	$cuentabancaria=mysqli_result($rs_mostrar, 0, "cuentabancaria");
	$codpostal=mysqli_result($rs_mostrar, 0, "codpostal");
	$telefono=mysqli_result($rs_mostrar, 0, "telefono");
	$movil=mysqli_result($rs_mostrar, 0, "movil");
	$rubro=mysqli_result($rs_mostrar, 0, "rubro");
	$email=mysqli_result($rs_mostrar, 0, "email");
	$web=mysqli_result($rs_mostrar, 0, "web");
	$horario=mysqli_result($rs_mostrar, 0, "horario");	
}

?>

<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="js/jquery.toastmessage.css" type="text/css">
<script src="js/jquery.toastmessage.js" type="text/javascript"></script>
<script src="js/message.js" type="text/javascript"></script>
<!-- iconos para los botones -->       
<link rel="stylesheet" href="../css3/css/font-awesome.min.css">

<script type="text/javascript">
$(document).keydown(function(e) {
    switch(e.keyCode) { 
        case 13:
			parent.$('idOfDomElement').colorbox.close();
        break;
        case 112:
            showWarningToast('Ayuda aún no disponible...');
        break; 
	 }
});
</script>		
<script type="text/javascript">
    function Resize_Box(){
        var x = $('body').width();
        var y = $('body').height();
        parent.$('idOfDomElement').colorbox.resize({
            innerWidth: x,
            innerHeight: y
        });
    }

    $(document).ready(function(){
        Resize_Box();
    });
</script>	
		
		<script language="javascript">
		
		function aceptar() {
			parent.$('idOfDomElement').colorbox.close();
		}
		
		var cursor;
		if (document.all) {
		/*/ Está utilizando EXPLORER*/
		cursor='hand';
		} else {
		/*/ Está utilizando MOZILLA/NETSCAPE*/
		cursor='pointer';
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php echo $cabecera2;?></div>
				<div id="frmBusqueda">
				<table class="fuente8" width="100%" border="0">
						<tr>
							<td width="100%" colspan="2" class="mensaje"><?php echo $mensaje;?></td>
					    </tr>
							<tr><td width="50%" valign="top">
					    <table class="fuente8" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%">C&oacute;digo</td>
							<td width="85%" colspan="2"><?php echo $codproveedor;?></td>
					    </tr>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombre;?></td>
					    </tr>
						<tr>
						  <td>RUT</td>
						  <td colspan="2"><?php echo $nif;?></td>
					  </tr>
					  <?php
					  	$query_pais="SELECT * FROM paises WHERE codpais=".$codpais;
						$res_pais=mysqli_query($GLOBALS["___mysqli_ston"], $query_pais);
						$contador=0;
					  ?>	<tr>				  
							<td width="15%">País</td>
							<td colspan="3"><?php
 								echo @mysqli_result($res_pais, 0, "nombre");?>
							</td>
						</tr>						  
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td colspan="2"><?php echo $direccion;?></td>
					  </tr>
						<tr>
						  <td>Localidad</td>
						  <td colspan="2"><?php echo $localidad;?></td>
					  </tr>
					  <?php
					  	if ($codprovincia<>0) {
							$query_provincias="SELECT * FROM provincias WHERE codprovincia='$codprovincia'";
							$res_provincias=mysqli_query($GLOBALS["___mysqli_ston"], $query_provincias);
							$nombreprovincia=mysqli_result($res_provincias, 0, "nombreprovincia");
						} else {
							$nombreprovincia="Sin determinar";
						}
					  ?>
						<tr>
							<td width="15%">Departamento</td>
							<td width="85%" colspan="2"><?php echo $nombreprovincia?></td>
					    </tr>
						<?php
						if ($codentidad<>0) {
							$query_entidades="SELECT * FROM entidades WHERE codentidad='$codentidad'";
							$res_entidades=mysqli_query($GLOBALS["___mysqli_ston"], $query_entidades);
							$nombreentidad=mysqli_result($res_entidades, 0, "nombreentidad");
						} else {
							$nombreentidad="Sin determinar";
						}
					  ?>
						<tr>
							<td width="15%">Entidad Bancaria</td>
							<td width="85%" colspan="2"><?php echo $nombreentidad;?></td>
					    </tr>
						<tr>
							<td>Cuenta bancaria</td>
							<td colspan="2"><?php echo $cuentabancaria;?></td>
						</tr>
						</table></td><td width="50%" valign="top">					    
					    <table class="fuente8" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td>C&oacute;digo postal</td>
							<td colspan="2"><?php echo $codpostal;?></td>
						</tr>
						<tr>
							<td>Tel&eacute;fono</td>
							<td><?php echo $telefono;?>&nbsp;M&oacute;vil&nbsp;<?php echo $movil;?>
							</td>
						</tr>
						<tr>
							<td>Rubro</td>
							<td colspan="2"><?php echo $rubro;?></td>
						</tr>
						<tr>
							<td>Correo electr&oacute;nico  </td>
							<td colspan="2"><?php echo $email;?></td>
						</tr>
							<tr>
							<td>Direcci&oacute;n web </td>
							<td colspan="2"><?php echo $web;?></td>
						</tr>
						<tr>
							<td>Cuenta&nbsp;bancaria</td>
							<td><?php echo $cuentabancaria;?></td>
					    </tr>	
						<tr>
							<td>Horario de atención</td>
							<td><?php echo $horario;?></td>
					    </tr>						
					</table>
				</td></tr></table>
			  </div>
			  <br style="line-height:5px">
				<div>
						<button class="boletin" onClick="aceptar();" onMouseOver="style.cursor=cursor"><i class="fa fa-chech-circle-o" aria-hidden="true"></i>&nbsp;Salir</button>
			  </div>
			  </div>
		  </div>
		</div>
	</body>
</html>
