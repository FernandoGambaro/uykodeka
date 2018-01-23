<?php 
include ("../conectar.php");
include ("../funciones/fechas.php");
date_default_timezone_set("America/Montevideo"); 
 
$codfactura=$_GET["codfactura"];

$select_facturas="SELECT clientes.codcliente,clientes.nombre,clientes.apellido,clientes.empresa,facturas.codfactura,estado,fechavencimiento,totalfactura,facturas.moneda, cobros.resguardo 
FROM facturas LEFT JOIN cobros ON facturas.codfactura=cobros.codfactura INNER JOIN clientes ON facturas.codcliente=clientes.codcliente WHERE facturas.codfactura='$codfactura'";
$rs_facturas=mysqli_query($GLOBALS["___mysqli_ston"], $select_facturas);

$hoy=date("d/m/Y");

$sel_cobros="SELECT sum(importe) as aportaciones FROM cobros WHERE codfactura='$codfactura'";
$rs_cobros=mysqli_query($GLOBALS["___mysqli_ston"], $sel_cobros);
$aportaciones=mysqli_result($rs_cobros, 0, "aportaciones");

?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		
		<script type="text/javascript" src="../funciones/validar.js"></script>	

    <script src="../calendario/jscal2.js"></script>
    <script src="../calendario/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/css/win2k/win2k.css" />		

		<script src="js/jquery.min.js"></script>
		<link rel="stylesheet" href="js/colorbox.css" />
		<script src="js/jquery.colorbox.js"></script>	
				
		<script language="javascript">
		var cursor;
		if (document.all) {
		/*/ Está utilizando EXPLORER*/
		cursor='hand';
		} else {
		/*/ Está utilizando MOZILLA/NETSCAPE*/
		cursor='pointer';
		}
		
		
		function cancelar() {
			parent.$('idOfDomElement').colorbox.close();
		}
		
		function cambiar_estado() {
			var estado=document.getElementById("cboEstados").value;
			var codfactura=document.getElementById("codfactura").value;
			miPopup = window.open("actualizarestado.php?estado="+estado+"&codfactura="+codfactura,"frame_datos","width=700,height=80,scrollbars=yes");
		}
		
		function cambiar_vencimiento() {
			var fechavencimiento=document.getElementById("fechavencimiento").value;
			var codfactura=document.getElementById("codfactura").value;
			miPopup = window.open("actualizarvencimiento.php?fechavencimiento="+fechavencimiento+"&codfactura="+codfactura,"frame_datos","width=700,height=80,scrollbars=yes");
		}

function OpenMiniNote(noteId){

	$.colorbox({
	   	href: noteId, open:true,
			iframe:true, width:"300px", height:"200px",
	});
}
function busco_tipocambio() {
			var fecha=$("#fechacobro").val();
				$.post("busco_tipocambio.php?fecha="+fecha,  function(data){
				$("#tipocambio").val(data);
			})(jQuery);	
}
function pago() {
		var pendiente=$("#pendiente").val();
		if (pendiente<=0) {
		$('select>option:eq(1)').attr('selected', true);
		}
}
	
		</script>
	</head>
	<body onload="busco_tipocambio();">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">COBROS </div>
				<div id="frmBusqueda">
				<form id="formdatos" name="formdatos" method="post" action="guardar_cobro.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0><tr><td valign="top" width="50%">
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
					<?php 
					 	$codcliente=mysqli_result($rs_facturas, 0, "codcliente");
						$nombre=mysqli_result($rs_facturas, 0, "nombre"). ' '. mysqli_result($rs_facturas, 0, "apellido"). ' / '. mysqli_result($rs_facturas, 0, "empresa");
						$nombre=str_replace(" ", "&nbsp;", $nombre);
						$codfactura=mysqli_result($rs_facturas, 0, "codfactura");
						$totalfactura=mysqli_result($rs_facturas, 0, "totalfactura");
						$estado=mysqli_result($rs_facturas, 0, "estado"); 
						$moneda=mysqli_result($rs_facturas, 0, "moneda"); 
						$fechavencimiento=mysqli_result($rs_facturas, 0, "fechavencimiento");
						$resguardo= mysqli_result($rs_facturas, 0, "resguardo");
						
						if ($fechavencimiento=="0000-00-00") { $fechavencimiento=""; } else { $fechavencimiento=implota($fechavencimiento); } 						
						?>
						<tr>
							<td width="15%">C&oacute;digo&nbsp;de&nbsp;cliente</td>
						    <td width="43%"><?php echo $codcliente?></td>
						</tr>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="43%"><?php echo $nombre?></td>
						</tr>	
						<tr>
							<td width="15%">C&oacute;digo&nbsp;de&nbsp;factura</td>
						    <td width="43%"><?php echo $codfactura?></td>
						</tr>
						<tr>
							<td width="15%">Importe&nbsp;de&nbsp;la&nbsp;factura</td>
						    <td width="43%"><input value="<?php echo number_format($totalfactura,2)?>" class="cajaTotales" readonly>&nbsp;
					<?php $tipofa = array(  1=>"Pesos", 2=>"U\$S");
					foreach ($tipofa as $key => $i ) {
					  	if ( $moneda==$key ) {
							echo "$i";
						}
					}
					?>
					</td>

</td>
						</tr>
						</table><td valign="top" width="50%">
						<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%">Estado&nbsp;de&nbsp;la&nbsp;factura</td>
						    <td width="43%"><select id="cboEstados" name="cboEstados" class="comboMedio" onChange="cambiar_estado()">
								<?php if ($estado==1) { ?><option value="1" selected="selected">Sin Pagar</option>
								<option value="2">Pagada</option><?php } else { ?>
								<option value="1">Sin Pagar</option>
								<option value="2" selected="selected">Pagada</option>
								<?php } ?> 			
								</select></td>
						</tr>	
						<tr>
							<td width="15%">Fecha&nbsp;de&nbsp;vencimiento</td>
						    <td width="43%"><input id="fechavencimiento" type="text" class="cajaPequena" NAME="fechavencimiento" maxlength="10" value="<?php echo $fechavencimiento?>" readonly>
						    <img src="../img/calendario.png" name="Image11" id="Image11" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario" style="vertical-align: middle; margin-top: -1px;">
								<script type="text/javascript">//<![CDATA[
						   Calendar.setup({
						     inputField : "fechavencimiento",
						     trigger    : "Image11",
						     align		 : "Bl",
						     onSelect   : function() { this.hide(); busco_tipocambio(); },
						     dateFormat : "%d/%m/%Y"
						   });
						//]]></script>						    
						<img src="../img/disco.png" name="Image2" id="Image2" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Guardar fecha" onClick="cambiar_vencimiento();" style="vertical-align: middle; margin-top: -1px;"></td>
						</tr>
						<?php $pendiente=$totalfactura-$aportaciones; ?>
						<tr>
							<td width="15%">Pendiente&nbsp;por&nbsp;pagar</td>
						    <td width="43%"><input type="text" name="pendiente" id="pendiente" value="<?php echo number_format($pendiente,2,".","")?>" onchange="pago();" readonly="yes" class="cajaTotales">
						    &nbsp;					<?php $tipofa = array(  1=>"Pesos", 2=>"U\$S");
					foreach ($tipofa as $key => $i ) {
					  	if ( $moneda==$key ) {
							echo "$i";
						}
					}
					?>
							</td>
						</tr>
						
								
					</table></td></tr>								
					</table>
					</form>
			  </div>
			  <br>
			  <div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="frame_cobros.php" target="frame_cobros">
					<table class="fuente8" cellspacing=0 cellpadding=3 border=0><tr><td valign="top">
						<table class="fuente8" cellspacing=0 cellpadding=1 border=0 >
						<tr>
							<td>Fecha&nbsp;de&nbsp;cobro</td>
						    <td ><input id="fechacobro" type="text" class="cajaPequena" NAME="fechacobro" maxlength="10" value="<?php echo $hoy?>" onchange="busco_tipocambio();" readonly>
						    <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0"  onMouseOver="this.style.cursor='pointer'" title="Calendario" style="vertical-align: middle; margin-top: -1px;">

								<script type="text/javascript">//<![CDATA[
						   Calendar.setup({
						     inputField : "fechacobro",
						     trigger    : "Image1",
						     align		 : "Bl",
						     onSelect   : function() { this.hide(); busco_tipocambio(); },
						     dateFormat : "%d/%m/%Y"
						   });
						//]]></script></td>

						</tr>
						<tr>
							<td>Importe</td>
						    <td><input id="Rimporte" type="text" class="cajaPequena" NAME="Rimporte" maxlength="12"> </td>
						</tr>	
					</table></td><td valign="top">
					<table class="fuente8" cellspacing=0 cellpadding=1 border=0>
						<?php
					  	$query_fp="SELECT * FROM formapago WHERE borrado=0 ORDER BY nombrefp ASC";
						$res_fp=mysqli_query($GLOBALS["___mysqli_ston"], $query_fp);
						$contador=0;
					  ?>
						<tr>
							<td>Forma&nbsp;de&nbsp;pago</td>
							<td><select id="AcboFP" name="AcboFP" class="comboGrande">
							
								<option value="0">Seleccione una forma de pago</option>
								<?php
								while ($contador < mysqli_num_rows($res_fp)) { ?>
								<option value="<?php echo mysqli_result($res_fp, $contador, "codformapago")?>"><?php echo mysqli_result($res_fp, $contador, "nombrefp")?></option>
								<?php $contador++;
								} ?>				
								</select>							</td>
				        </tr>
						<tr>
							<td >Nº&nbsp;Documento</td>
						    <td><input id="anumdocumento" type="text" class="cajaMedia" NAME="anumdocumento" maxlength="30"></td>
						</tr>	
					</table></td><td valign="top">
					<table class="fuente8" cellspacing=0 cellpadding=1 border=0>
						<tr>
						
						<td>Moneda</td><td>
						 <select name="Amoneda" id="Amoneda" class="cajaPequena2">
					<?php $tipofa = array( 0=>"Seleccione uno", 1=>"Pesos", 2=>"U\$S");
					foreach ($tipofa as $key => $i ) {
					  	if ( $moneda==$key ) {
							echo "<OPTION value=$key selected>$i</option>";
						} else {
							echo "<OPTION value=$key>$i</option>";
						}

					}
					?>
					</select>
  							</td>						
							<td align="right" >Resguardo</td>
							<td>
									<?php
									if ($resguardo==1){
									?>
									<input type="checkbox" name="resguardo" id="resguardo" value="1" checked style="vertical-align: middle; margin-top: -1px;">
									<?php	
									} else {
									?>
									<input type="checkbox" name="resguardo" id="resguardo" value="1" style="vertical-align: middle; margin-top: -1px;">
									<?php
									}
									?>							
								<label>U$S -> $&nbsp;</label><span>
								<input name="tipocambio" class="cajaPequena2" id="tipocambio" size="5" maxlength="5"  readonly=""></span>							
							</td>
						</tr>
						<tr>
							<td valign="top" >Observaciones</td>
						    <td colspan="3"><textarea rows="2" cols="40" class="areaTexto" name="observaciones" id="observaciones"></textarea></td>
						</tr>							
					</table></td></tr></table>
			  </div>
				<div>
					<input type="hidden" name="id" id="id">
					<input type="hidden" name="accion" id="accion" value="insertar">
					<input type="hidden" name="codcliente" id="codcliente" value="<?php echo $codcliente?>">
					<input type="hidden" name="codfactura" id="codfactura" value="<?php echo $codfactura?>">
					<img id="botonBusqueda" src="../img/botonaceptar.jpg" width="85" height="22" onClick="javascript:validar(formulario,true);" border="1" onMouseOver="style.cursor=cursor">
					<img id="botonBusqueda" src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar();" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </form>
			  <div id="frmBusqueda">
					<iframe width="100%" height="200" id="frame_cobros" name="frame_cobros" frameborder="0" src="frame_cobros.php?accion=ver&codfactura=<?php echo $codfactura?>">
						<ilayer width="100%" height="200" id="frame_cobros" name="frame_cobros"></ilayer>
					</iframe>
					<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
				</div>
			  </div>
		  </div>
		</div>
		<div id="ErrorBusqueda" class="fuente8">
 <ul id="lista-errores" style="display:none; 
	clear: both; 
	max-height: 75%; 
	overflow: auto; 
	position:relative; 
	top: 85px; 
	margin-left: 30px; 
	z-index:999; 
	padding-top: 10px; 
	background: #FFFFFF; 
	width: 585px; 
	-moz-box-shadow: 0 0 5px 5px #888;
	-webkit-box-shadow: 0 0 5px 5px#888;
 	box-shadow: 0 0 5px 5px #888; 
 	bottom: 10px;"></ul>	
 
 	</div>		
	</body>
</html>
