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

setlocale('LC_ALL', 'es_ES');

include ("../conectar.php");
include ("../funciones/fechas.php");
date_default_timezone_set('America/Montevideo');

$codcliente=@$_POST['cod'];
$tipoconsulta=@$_POST['tipo'];
$control=0;
//$tipoconsulta=1;
//$codcliente=8;

if(!isset($_POST['anio'])) {
	$anio=date("Y");
} else {
	$anio=$_POST['anio'];
}

$total=0;
 $pro="[ ";	
for($mes=1;$mes<=12;$mes++) {
	$fechaini=data_first_month_day($anio.'-'.$mes.'-01');
	$fechafin=data_last_month_day($anio.'-'.$mes.'-01');

//Si no se selecciona cliente reccoro todos
	if($codcliente=='') {
		//$Descripcion='Todos los clientes activos';
		$query_busqu="SELECT * FROM clientes WHERE borrado=0 AND service=2";
		$rs_busqu=mysqli_query($GLOBALS["___mysqli_ston"], $query_busqu);
		$contador=0;
	
		$totalhoras='00:00';
	/* Para cada cliente calculo la cantidad de horas y las sumo entre todos */
		while ($contador < mysqli_num_rows($rs_busqu)) {
		$codcliente=mysqli_result($rs_busqu, $contador, "codcliente");
		 	$query="SELECT * FROM horas WHERE codcliente=$codcliente AND borrado=0 AND fecha >= '$fechaini' AND fecha <='$fechafin' ";
			$rs=mysqli_query($GLOBALS["___mysqli_ston"], $query);
			$cont=0;
			if(mysqli_num_rows($rs)>0) {
					while ($cont < mysqli_num_rows($rs)) {
						$parcial=mysqli_result($rs, $cont, "horas").':00';
						if(mysqli_result($rs, $cont, "horas")!='0:00') {
						$totalhoras=SumaHoras($parcial,$totalhoras);
						}
						$cont++;
					}
					if($totalhoras!='00:00') {
					$total= str_replace(",",".",time2seconds($totalhoras)/60/60);
					}
			}
			$contador++;
		}
		$totalhoras='00:00';
	$codcliente='';
		
	} else {
	/*Para un solo cliente*/
		$query_busqu="SELECT * FROM clientes WHERE borrado=0 AND codcliente=$codcliente";
		$rs_busqu=mysqli_query($GLOBALS["___mysqli_ston"], $query_busqu);
		$Descripcion=mysqli_result($rs_busqu, 0, "nombre")." ".mysqli_result($rs_busqu, 0, "apellido");
		if(mysqli_result($rs_busqu, 0, "empresa")!='') {
		$Descripcion.=" - ".mysqli_result($rs_busqu, 0, "empresa");
		}
		 	$query="SELECT * FROM horas WHERE codcliente=$codcliente AND borrado=0 AND fecha >= '$fechaini' AND fecha <='$fechafin' ";
			$rs=mysqli_query($GLOBALS["___mysqli_ston"], $query);
			$cont=0;
			if(mysqli_num_rows($rs)>0) {
					while ($cont < mysqli_num_rows($rs)) {
						$parcial=mysqli_result($rs, $cont, "horas").':00';
						if(mysqli_result($rs, $cont, "horas")!='0:00') {
						$totalhoras=SumaHoras($parcial,$totalhoras);
						}
						$cont++;
					}
					if($totalhoras!='00:00') {
					$total= str_replace(",",".",time2seconds($totalhoras)/60/60);
					}
			}
	$totalhoras='00:00';
	}
	
   if($total<>0) {		   
			$pro.='["'.genMonthAb_Text($mes).'",'.$total;
			$control=1;
   } else {
			$pro.='["'.genMonthAb_Text($mes).'",0';
   }
   if($mes<12) {
   	$pro.='],';
		$control=1;
   } else {
   	$pro.=']';
   }
$total=0;

}
$pro.=" ]";
			$arr['control'] = $control;
			$arr['valu']= $Descripcion;
        	$arr['data']= $pro;
        	$arr['tipo']= $tipoconsulta;
        	$arr['datoTxt']= $pro;
        	
	       //$da[] = $arr;
//var_dump($pro);

header("Content-Type: application/json");
echo json_encode($arr);
  
?>