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
 

function verificopermisos($seccion, $tipo, $usuario) {
	$sql="select * from `permisos` where `seccion` = '$seccion' and `codusuarios` = '$usuario'";
	$con=mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die('Error obteniendo permisos');
	while ($res=mysqli_fetch_array($con)) {
		if($res[$tipo]==1) {
			return 'true';
		} else {
			return 'false';
		}
	}

}
?>
