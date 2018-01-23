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
require_once('../../class/class_session.php');
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
	echo "<script>location.href='../../index.php'; </script>";
   //header("Location:../index.php");	

} else {
   $loggedAt=$s->data['loggedAt'];
   $timeOut=$s->data['timeOut'];
   if(isset($loggedAt) && (time()-$loggedAt >$timeOut)){
   	$s->data['act']="timeout";
    	$s->save();  	
  		//header("Location:../index.php");	
		echo "<script>window.top.location.href='../../index.php'; </script>";
	   exit;
   }
   $s->data['loggedAt']= time();
   $s->save();
}

$UserID=$s->data['UserID'];
$UserNom=$s->data['UserNom'];
$UserApe=$s->data['UserApe'];
$UserTpo=$s->data['UserTpo'];
@$paginacion=$s->data['alto'];

if($paginacion<=0) {
	$paginacion=20;
}
$Seleccionados=array();
$Seleccionados=@$s->data['Selected'];

include ("../../conectar.php");
include("../../common/verificopermisos.php");
include("../../common/funcionesvarias.php");

////header('Cache-Control: no-cache');
////header('Pragma: no-cache'); 
////header('Content-Type: text/html; charset=UTF-8');


$accion =isset($_POST["accion"]) ? $_POST["accion"] : $_GET["accion"];
$codbiometric =isset($_POST["codbiometric"]) ? @$_GET["codbiometric"] : @$_POST["codbiometric"];

$codubicacion=$_POST['Acodubicacion'];
$nombre=$_POST["Anombre"];
$direccionip=$_POST["Adireccionip"];
$udp_port=$_POST["audpport"];
$internal_id=$_POST["ainternalid"];
$firmware=$_POST["afirmware"];
$serialnumber=$_POST["aserialnumber"];

$plataform=$_POST["aplataform"];
$devicename=$_POST["adevicename"];

if ($accion=="alta") {

	$query_operacion="
INSERT INTO `biometric` (`codbiometric`, `codubicacion`, `nombre`, `direccionip`, `soap_port`, `udp_port`,
 `internal_id`, `com_key`, `encoding`, `firmware`, `serialnumber`, `plataform`, `devicename`, `borrado`) 
 VALUES (NULL,  '$codubicacion', '$nombre', '$direccionip', '$soap_port', '$udp_port',
 '$internal_id', '$com_key', '$encoding', '$firmware', '$serialnumber', '$plataform', '$devicename', '0'); ";	
	
	$rs_operacion=mysqli_query($GLOBALS["___mysqli_ston"], $query_operacion);

	$sel_maximo="SELECT max(codbiometric) as maximo FROM biometric";
	$rs_maximo=mysqli_query($GLOBALS["___mysqli_ston"], $sel_maximo);
	$codbiometric=mysqli_result($rs_maximo, 0, "maximo");
}

if ($accion=="modificar") {
$codbiometric=$_POST['codbiometric'];
	$queryup="UPDATE `biometric` SET `codubicacion` = '$codubicacion', `nombre` = '$nombre', `direccionip` = '$direccionip',
 `soap_port` = '$soap_port', `udp_port` = '$udp_port', `internal_id` = '$internal_id', `com_key` = '$com_key', 
 `encoding` = '$encoding',  `firmware` = '$firmware', `serialnumber` = '$serialnumber', `plataform` = '$plataform',
  `devicename` = '$devicename'  WHERE `biometric`.`codbiometric`='$codbiometric'";
 
	$rs_query=mysqli_query($GLOBALS["___mysqli_ston"], $queryup);

}

if ($accion=="baja" and $_GET['codbiometric']!="" ) {
	$codbiometric=$_GET['codbiometric'];
	$query="UPDATE biometric SET borrado=1 WHERE codbiometric='$codbiometric'";
	$rs_query=mysqli_query($GLOBALS["___mysqli_ston"], $query);
}
	

	?>
	
	<script type="text/javascript" >
	parent.$('idOfDomElement').colorbox.close();
	</script>
	