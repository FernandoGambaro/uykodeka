<?php
include ("../conectar.php");
include("../common/verificopermisos.php");
//header('Content-Type: text/html; charset=UTF-8'); 



require 'tad/lib/TADFactory.php';
require 'tad/lib/TAD.php';
require 'tad/lib/TADResponse.php';
require 'tad/lib/Providers/TADSoap.php';
require 'tad/lib/Providers/TADZKLib.php';
require 'tad/lib/Exceptions/ConnectionError.php';
require 'tad/lib/Exceptions/FilterArgumentError.php';
require 'tad/lib/Exceptions/UnrecognizedArgument.php';
require 'tad/lib/Exceptions/UnrecognizedCommand.php';

$tad_factory = new TADPHP\TADFactory();

use TADPHP\TADFactory;
use TADPHP\TAD;

$comands = TAD::commands_available();

  $options = [
    'ip' => '192.168.1.13',   // '169.254.0.1' by default (totally useless!!!).
    'internal_id' => 1,    // 1 by default.
    'com_key' => 0,        // 0 by default.
    'description' => 'TAD1', // 'N/A' by default.
    'soap_port' => 80,     // 80 by default,
    'udp_port' => 4370,      // 4370 by default.
    'encoding' => 'utf-8' ,   // iso8859-1 by default.
  ];
  
function extraigodatosusuario($content, $tad) {
	$campouser=" "; 	 $valoruser=' '; 	 $campos=''; 	 $index='';
	foreach($content as $key=>$dato){
		//Extraigo datos del usuario
		$key=strtolower($key);
		if($key=='pin') {
			$query_busqueda="SELECT count(*) as filas FROM `biometricuser` WHERE `pin`='".$dato."'";
			$rs_busqueda=mysqli_query($GLOBALS["___mysqli_ston"], $query_busqueda);
			$filas=mysqli_result($rs_busqueda, 0, "filas");
			if($filas==0) {		
				$campouser.="`".$key."`";
				 $valoruser.="'".$dato."'";
			} else {
				$index="`".$key."`='".$dato."'";
			}
		}
		if($key!='pin') {
			if ($key=='fingerid'){
				$key='finger_id';
			}
			if ($key=='group'){
				$key='grupo';
			}
			if($filas==0) {
				$campouser.=", `".$key."`";
				$valoruser.=", '".$dato."'";
			}else {
				if($key!='tz3') {
					$campos.="`".$key."`='".$dato."',";
				}else {
					$campos.="`".$key."`='".$dato."'";
				}
			}			
		}
	}
	if($filas==0) {
		$sql="INSERT INTO `biometricuser` (".$campouser.") values (".$valoruser.")";
	} else {
		$sql="UPDATE `biometricuser` SET ".$campos. " WHERE ".$index;
	}
return $sql;
}  

function extraigodatoshuella($dato, $tad) {
	$campouser=''; 	 $valoruser=''; 	 $campos=''; 	 $index='';
	$insertar=''; $actualizar=[]; $alca=0;$nograbo=0;$sql='';
				//extraigo datos de la huella
				$temp=$tad->get_user_template(['pin'=>$dato])->to_array();
				if(is_array($temp['Row'])) {
					$x=1; 
					foreach($temp['Row'] as $templaterow=>$templatecontenido){
						$key=strtolower($templaterow);
						$cantidad=count($temp['Row']);
						
						if($key=='pin') {
							$query_busqueda="SELECT count(*) as filas FROM `biometricusertemplate` WHERE `pin`='".$templatecontenido."'";
							$rs_busqueda=mysqli_query($GLOBALS["___mysqli_ston"], $query_busqueda);
							$filas=mysqli_result($rs_busqueda, 0, "filas");
								if($filas==0 and !is_array($templatecontenido)) {		
									$campouser.="`".$key."`";
									$insertar.="'".$templatecontenido."'";
								} elseif( !is_array($templatecontenido)) {
									$index="`".$key."`='".$templatecontenido."'";
								}							
						}
						if($filas!=0 and $key=='fingerid' and !is_array($templatecontenido)) {
							$index.=" AND `".$clave."`='".$valor."'";
						}						
						if($filas==0 and !is_array($templatecontenido) and $key!='pin' ) {
							$campouser.=", `".$key."`";
							$insertar.=", '".$templatecontenido."'";
							
						}elseif(!is_array($templatecontenido) and $key!='fingerid') {
							if($key!='template') {
								$campos.="`".$key."`='".$templatecontenido."',";
							}else {
										if($key=='template' and $valor=='') {
											$nograbo=1;
										}
								$campos.="`".$key."`='".$templatecontenido."'";
							}
						}							
						//echo "<br>nivel2&nbsp;&nbsp;=>".$templaterow."->".$templatecontenido;
						
						//Si tiene mas de una huella extraigo el contenido
						if(is_array($templatecontenido)) {
							$alca=1;
							foreach($templatecontenido as $clave=>$valor){
								$clave=strtolower($clave);		
								if($clave=='pin') {
									$query_busqueda="SELECT count(*) as filas FROM `biometricusertemplate` WHERE `pin`='".$valor."'";
									$rs_busqueda=mysqli_query($GLOBALS["___mysqli_ston"], $query_busqueda);
									$filas=mysqli_result($rs_busqueda, 0, "filas");
										if($filas==0 ) {		
											$campouser="`".$clave."`";
											 $valoruser="'".$valor."'";
										} elseif($filas!=0) {
											$index="`".$clave."`='".$valor."'";
										}							
								}
								if($filas!=0  and $clave=='fingerid') {
									$index.=" AND `".$clave."`='".$valor."'";
								}
								if($filas==0 and $clave!='pin' ) {
									$campouser.=", `".$clave."`";
									$valoruser.=", '".$valor."'";
								}else {
									if($clave!='template' and $clave!='fingerid') {
										$campos.="`".$clave."`='".$valor."',";
									}elseif($clave!='fingerid') {
										$campos.="`".$clave."`='".$valor."'";
									}
								}
									if($clave=='template' and $valor=='') {
											$nograbo=1;
										}																
															
							//echo "<br>nivel3&nbsp;&nbsp;&nbsp;->".$clave."=>".$valor;

							}
							if($nograbo==0) {
								if($x<$cantidad) {
								$insertar.="(".$valoruser."),";
								} else {
								$insertar.="(".$valoruser.");";
								}
							}
							$actualizar[$templaterow]="UPDATE `biometricusertemplate` SET ".$campos. " WHERE ".$index;
						}						
						/*******************************/
					$x++;	
					}	

			}else {
				$nograbo=1;
			}
		if($filas==0 and $nograbo==0) {
			if($alca==0){$insertar="(".$insertar.")"; }
			$sql="INSERT INTO `biometricusertemplate` (".$campouser.") values ".$insertar;
			$rs_operacion=mysqli_query($GLOBALS["___mysqli_ston"], $sql);
		} elseif($nograbo==0) {
			$count=count($actualizar);
			for($i=0;$i<$count;$i++)
			   {
			    echo "<br>".$update=$actualizar[$i];
			    //$rs_operacion=mysqli_query($GLOBALS["___mysqli_ston"], $update);
			   }			

		}				
			return ;
}
  
  $tad_factory = new TADFactory($options);
  $tad = $tad_factory->get_instance(); 

// Get a full list of commands supported by TADPHP\TAD class.
$commands_list = TAD::commands_available();

// Get a list of commands implemented via TADPHP\TADSoap.
$soap_commands = TAD::soap_commands_available();
// Get a list of commands implemented via TAD\PHP\TADSoap.
$zklib_commands = TAD::zklib_commands_available();

//var_dump($soap_commands);

/*
// Getting current time and date
$dt = $tad->get_date();

// Setting device's date to '2014-01-01' (time will be set to now!)
$response = $tad->set_date(['date'=>'2014-01-01']);

// Setting device's time to '12:30:15' (date will be set to today!)
$response = $tad->set_date(['time'=>'12:30:15']);

// Setting device's date & time
$response = $tad->set_date(['date'=>'2014-01-01', 'time'=>'12:30:15']);

// Setting device's date & time to now.
$response = $tad->set_date();
*/
// Getting attendance logs from all users.
$logs = $tad->get_att_log();

// Getting attendance logs from one user.
//$logs = $tad->get_att_log(['pin'=>7]);

// Getting info from a specific user.
//$user_info = $tad->get_user_template(['pin'=>7]);
$user_info = $tad->get_user_info(['pin'=>7])->to_array();
/*Para un solo usuario*/
//echo "<br>".$sql= extraigodatosusuario($user_info['Row'], $tad) ;
//$rs_operacion=mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	//if ($rs_operacion) { $mensaje="Actualizacion exitosa"; }

	
//var_dump($user_info);
// Getting info from all users.
$all_user_info = $tad->get_all_user_info()->to_array();
//var_dump($all_user_info->to_array());
//var_dump($tad->get_user_info(['pin'=>8])->to_array());
echo "<p>";

/*Extraigo los datos del template del usuario seleccionado y lo almaceno en un array()*/


foreach($all_user_info['Row'] as $row=>$contenido){
	$pin=$contenido['PIN'];
	$sql= extraigodatosusuario($contenido, $tad);;
	$rs_operacion=mysqli_query($GLOBALS["___mysqli_ston"], $sql);
//	if ($rs_operacion) { echo "Actualizacion exitosa"; }
	extraigodatoshuella($pin, $tad);
	
}

//var_dump($template);
 /*Luego de tener los datos del template almacenados actualizo los datos del usuario*/
 /*
$r = $tad->set_user_info([
    'pin' => 7,
    'name'=> 'Fernando Gambaro',
    'privilege'=> 14,
    'password' => 1234567
]);
*/
/*Para el usuario seleccionado actualizo los datos del template que almacene previamente en un array()*/


echo "<p>";

// Getting attendance logs from all users.
$logs = $tad->get_att_log(['pin'=>7]);

$r = $tad->get_att_log(['pin'=>7]); // This employee does not have any logs!!!

if ($r->is_empty_response()) {
    echo 'The employee does not have logs recorded';
} else {
	echo $logs_number = $r->count();
}

//var_dump($logs->to_array());

// Delete all attendance logs stored.
//$tad->delete_data(['value'=>3]);




?>