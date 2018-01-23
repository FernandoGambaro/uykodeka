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

$codarticulo=$_POST['codarticulo'];
/*
$startTime =data_first_month_day('2017-05-01'); 
$endTime = data_last_month_day('2017-05-30'); 
*/
$codarticulo=229;

$data=array();
$anio=date("Y");
for($mes=1;$mes<=12;$mes++) {
	$fechaini=data_first_month_day($anio.'-'.$mes.'-01');
	$fechafin=data_last_month_day($anio.'-'.$mes.'-01');
	
$compra="SELECT fecha, factulineap.cantidad, articulos.codarticulo FROM articulos INNER JOIN factulineap 
on articulos.codarticulo=factulineap.codigo INNER JOIN facturasp on facturasp.codfactura=factulineap.codfactura 
WHERE ( fecha BETWEEN  '$fechaini' AND '$fechafin' ) AND 	articulos.codarticulo='$codarticulo'";

			$res_resultado=mysqli_query($GLOBALS["___mysqli_ston"], $compra);
		   $contador=0;			
		   if(mysqli_num_rows($res_resultado)>0) {		   
		   while ($contador < mysqli_num_rows($res_resultado)) {
					$pro=array(
					'label'=>genMonth_Text($mes),
					'data'=>mysqli_result($res_resultado, $contador, "cantidad"));
					array_push($data, $pro);
			   	
				$contador++;
		   }
		   } else {
					$pro=array(
					'label'=>genMonth_Text($mes),
					'data'=>0);
					array_push($data, $pro);
		   	
		   }

	
}
//var_dump($data);
/*
for($x=0; $x<3;$x++) {
	$pro=array(
	'label'=>'Algo'.$x,
	'data'=>$x+10+$x*10);
	array_push($data, $pro);
}*/
//$data=json_encode($data);
echo serialize($data);
//echo json_encode($data);
    flush();  
?>