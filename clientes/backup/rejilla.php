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
include ("../../conectar.php");
include ("../../funciones/fechas.php"); 

$e=$_POST["e"];

$where="1=1";
if ($e <> "") { $where.=" AND codcliente='$e'"; }

$where.=" ORDER BY fecha DESC, usuario ASC, tarea ASC ";
$query_busqueda="SELECT count(*) as filas FROM respaldospc WHERE ".$where;

$rs_busqueda=mysqli_query($GLOBALS["___mysqli_ston"], $query_busqueda);
$filas=mysqli_result($rs_busqueda, 0, "filas");

?>
<html>
	<head>
		<title>backups</title>
		<link href="../../estilos/estilos.css" type="text/css" rel="stylesheet">
		
		<script language="javascript">
		function inicio() {
			var numfilas=document.getElementById("numfilas").value;
			var indi=parent.document.getElementById("iniciopagina").value;
			var contador=1;
			var indice=0;
			if (parseInt(indi)>parseInt(numfilas)) { 
				indi=1; 
			}
			if (parseInt(numfilas) <= 10) {
					parent.document.getElementById("nextdisab").style.display = 'block';
					parent.document.getElementById("lastdisab").style.display = 'block';
					parent.document.getElementById("last").style.display = 'none';
					parent.document.getElementById("next").style.display = 'none';
			}
			parent.document.form_busqueda.filas.value=numfilas;
			parent.document.form_busqueda.paginas.innerHTML="";

			parent.document.getElementById("prevpagina").value = contador-10;
			parent.document.getElementById("currentpage").value = indice+1;
			parent.document.getElementById("nextpagina").value = contador + 10;

			while (contador<=numfilas) {
				if (parseInt(contador+9)>numfilas) {
					
				}
				texto=contador + " al " + parseInt(contador+9);
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
					parent.document.getElementById("prevpagina").value = contador-10;
					parent.document.getElementById("currentpage").value = indice + 1;
					parent.document.getElementById("nextpagina").value = contador + 10;

					parent.document.form_busqueda.paginas.options[indice]=new Option (texto,contador);
					parent.document.form_busqueda.paginas.options[indice].selected=true;
					indiaux=	indice;				
					
				} else {

					parent.document.form_busqueda.paginas.options[indice]=new Option (texto,contador);
					parent.document.getElementById("lastpagina").value = contador;
				}
				indice++;
				contador=contador+10;
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

		}	
		</script>
	</head>
	<body onload="inicio();">	
		<div id="pagina">
			<div id="zonaContenido">
			<div align="center">
			<div class="header" style="width:100%;position: fixed;">	Listado de Respaldos  </div>
<div class="fixed-table-container">
      <div class="header-background cabeceraTabla"> </div>      			
<div class="fixed-table-container-inner">
			
		<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 id="table">
		<thead>
		  <tr>
				<th width="8%"><div align="left" class="th-inner">FECHA</div></th>
				<th width="16%"><div align="left" class="th-inner">TAREA</div></th>
				<th width="10%"><div align="left" class="th-inner">EQUIPO/USUARIO</div></th>
				<th width="10%"><div align="left" class="th-inner">VERSIÓN</div></th>
				<th width="26%"><div align="left" class="th-inner">ERRORES</div></th>
				<th width="10%"><div align="left" class="th-inner">PROC.</div></th>
				<th width="10%"><div align="left" class="th-inner">RESP.</div></th>
				<th width="11%"><div align="left" class="th-inner">TAMAÑO</div></th>
				
			</tr>
		</thead>
		<tbody>
			<input type="hidden" name="numfilas" id="numfilas" value="<?php echo $filas?>">
				<?php $iniciopagina=$_POST["iniciopagina"];
				if ($iniciopagina=='') { $iniciopagina=@$_GET["iniciopagina"]; } else { $iniciopagina=$iniciopagina-1;}
				if ($iniciopagina=='') { $iniciopagina=0; }
				if ($iniciopagina>$filas) { $iniciopagina=0; }
					if ($filas > 0) { ?>
						<?php $sel_resultado="SELECT * FROM respaldospc WHERE ".$where;
						   $sel_resultado=$sel_resultado."  limit ".$iniciopagina.",10";
						   $res_resultado=mysqli_query($GLOBALS["___mysqli_ston"], $sel_resultado);
						   $contador=0;
						   while ($contador < mysqli_num_rows($res_resultado)) { 
								 if ($contador % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php echo $fondolinea?>">
							<td><div align="left"><?php echo implota(mysqli_result($res_resultado, $contador, "fecha"));?></div></td>
							<td><div align="left"><?php echo mysqli_result($res_resultado, $contador, "tarea");?></div></td>
							<td><div align="left"><?php echo mysqli_result($res_resultado, $contador, "usuario");?></div></td>
							<td><div align="left"><?php echo mysqli_result($res_resultado, $contador, "version");?></div></td>
							<td><div align="left"><?php echo mysqli_result($res_resultado, $contador, "errores");?></div></td>
							<td><div align="left"><?php echo mysqli_result($res_resultado, $contador, "procesados");?></div></td>
							<td align="left"><div ><?php echo mysqli_result($res_resultado, $contador, "respaldados");?></div></td>
							<td align="left"><div ><?php echo mysqli_result($res_resultado, $contador, "tamano");?></div></td>

						</tr>
						<?php $contador++;
							}
						?>			
					</table>
					<?php } else { ?>
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="100%" class="mensaje"><?php echo "No hay ning&uacute;n respaldo";?></td>
					    </tr>
					</tbody>
					</table>					
					<?php } ?>					
				</div>
			</div>
		  </div>	
		  </div></div>		
		</div>

		
	</body>
</html>