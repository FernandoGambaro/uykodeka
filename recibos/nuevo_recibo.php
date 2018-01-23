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
 
include ("../conectar.php"); 
include ("../funciones/fechas.php"); 

date_default_timezone_set("America/Montevideo"); 


$modif='';
$total=0;

//$hoy=date("d/m/Y");

$hoy=$fechahoy=isset($_GET['fecha']) ? $_GET['fecha'] : date("Y-m-d");
$recibo=isset($_GET['num']) ? $_GET['num'] : null;


if(@$_GET['fecha']=='') {
	$fechahoy=date("Y-m-d");
	$hoy=implota($fechahoy);
	$sel_fact="SELECT codrecibo FROM `recibos` ORDER BY codrecibo DESC, fecha DESC LIMIT 1 ";
	$rs_fact=mysqli_query($GLOBALS["___mysqli_ston"], $sel_fact);
	$codrecibo=(int)mysqli_result($rs_fact, 0, "codrecibo")+1;
} else {
	$fechahoy=explota($fechahoy);
}

//$fechahoy=date("Y-m-d");

$codentidad=0;
$tipo=0;
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

    <script src="../js3/jquery.msgBox.js" type="text/javascript"></script>
    <link href="../js3/msgBoxLight.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="js/jquery.toastmessage.css" type="text/css">
<script src="js/jquery.toastmessage.js" type="text/javascript"></script>
<script src="js/message.js" type="text/javascript"></script>

<!-- iconos para los botones -->       
<link rel="stylesheet" href="../css3/css/font-awesome.min.css">


<script type="text/javascript">
var index;

$(document).keydown(function(e) {
    switch(e.keyCode) { 
        case 9:
			e.preventDefault();
        var $this = $(e.target);
        var index = parseFloat($this.attr('data-index'));
	        if (index==1) {
	        	var codigo=document.getElementById("aCliente").value;
	        		if (codigo=='') {
						abreVentana();
	        			$('[data-index="' + (index + 1).toString() + '"]').focus();
		        		} else {
		        		validarcliente();
		        		}
		     }
			  if (index==14) {
		        		validar();
		     }		     
		     		$('[data-index="' + (index + 1).toString() + '"]').focus();

        break;
        case 13:
			e.preventDefault();
        var $this = $(e.target);
        var index = parseFloat($this.attr('data-index'));
	        if (index==1) {
	        	var codigo=document.getElementById("aCliente").value;
	        		if (codigo=='') {
						abreVentana();
	        			$('[data-index="' + (index + 1).toString() + '"]').focus();
		        		} else {
		        		validarcliente();
		        		}
		     }
			  if (index==14) {
		        		validar();
		     }		     
		     		$('[data-index="' + (index + 1).toString() + '"]').focus();

        break;
        case 112:
            showWarningToast('Ayuda aún no disponible...');
        break;
       
	 }
});

</script>		

<script type="text/javascript">
$(document).ready( function()
{
$("form:not(.filter) :input:visible:enabled:first").focus();


});
</script>		

<script type="text/javascript">
$(document).ready( function()
{
$("form:not(.filter) :input:visible:enabled:first").focus();

		$(".callbacks").colorbox({
			iframe:true, width:"720px", height:"98%",
			onCleanup:function(){ window.location.reload();	}
		});

});
</script>
<script type="text/javascript">
function OpenNote(noteId){

	$.colorbox({
	   	href: noteId, open:true,
			iframe:true, width:"90%", height:"80%",
			onCleanup:function(){ document.getElementById("form_busqueda").submit(); }
	});

}
function OpenList(noteId){

	$.colorbox({
	   	href: noteId, open:true,
			iframe:true, width:"99%", height:"99%",
			onCleanup:function(){ document.getElementById("form_busqueda").submit(); }
	});

}

function pon_prefijo_b(pref,nombre,nif) {
	$("#aCliente").val(pref);
	$("#nombre").val(nombre);
	$("#nif").val(nif);
	$('idOfDomElement').colorbox.close();

	$("#codcliente").val(pref);
	//var moneda=document.formulario.Amoneda.options[document.formulario.Amoneda.selectedIndex].value;
	//$("#moneda").val(moneda);
	document.formulario_facturas.submit();
}

function cambiomoneda() {
	var moneda=document.formulario.Amoneda.options[document.formulario.Amoneda.selectedIndex].value;
	$("#moneda").val(moneda);
	$("#Cmoneda").val(moneda);
	document.formulario_facturas.submit();
}

function cambionumero() {
	var num=$("#codrecibo").val();
	$("#acodrecibo").val(num);
	$("#bcodrecibo").val(num);
	$("#recibo").text(num);
}
function agregar_factura(codfactura,moneda, codcliente, nombre, nif,totalfactura) {

	document.getElementById("codfactura").value=codfactura;
	$("#aCliente").val(codcliente);
	$("#codcliente").val(codcliente);
	$("#nombre").val(nombre);
	$("#nif").val(nif);
	$("#totalfactura").val(totalfactura);
		
	$("#Amoneda").val(moneda);
	$("#moneda").val(moneda);
	$("#Cmoneda").val(moneda);
	document.formulario_facturas_sel.submit();
	document.formulario_facturas.submit();
	
}

function pon_importe(importe) {
	if (importe!="undefined" && !isNaN(importe)) {
		importe=round(importe, 2);
		$("#totalrecibo").val(importe);
	} else {
		$("#totalrecibo").val(0);
	}	
		var saldo=$("#apagar").val()-$("#totalrecibo").val();
		saldo=round(saldo, 2);
		$("#saldo").val(saldo);
}
function pon_apagar(importe) {
	importe=round(importe, 2);
	$("#apagar").val(importe);
	var saldo=$("#apagar").val()-$("#totalrecibo").val();
	saldo=round(saldo, 2);
	$("#saldo").val(saldo);
}
function pon_cantidad(cant) {
	$("#cantidad").val(cant);
}
</script>			
<script type="text/javascript">
function round(value, exp) {
  if (typeof exp === 'undefined' || +exp === 0)
    return Math.round(value);

  value = +value;
  exp  = +exp;

  if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
    return NaN;

  // Shift
  value = value.toString().split('e');
  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

  // Shift back
  value = value.toString().split('e');
  return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}
</script>		
		<script language="javascript">
		var cursor;
		if (document.all) {
		/*/ Está utilizando EXPLORER*/
		cursor='hand';
		} else {
		/*/ Está utilizando MOZILLA/NETSCAPE*/
		cursor='pointer';
		}

		function abreVentana(){
			$.colorbox({
	   	href: "ventana_clientes_ini.php", open:true,
			iframe:true, width:"580", height:"450",
			onCleanup:function() {
				$('#tipo').focus();
				}			
			});
			
			
		}		
		
		function inicio() {
			document.formulario_facturas.submit();
			
			document.getElementById("modiffactu").value=1;
			document.formulario_facturas_sel.submit();
			document.getElementById("modiffactu").value=0;
			
			document.getElementById("modifpago").value=1;
			document.formulario_pago.submit();
			document.getElementById("modifpago").value=0;
			
			var fecha=$("#fecha").val();
				$.post('busco_tipocambio.php', {fecha : fecha },  function(data){
				$("#tipocambio").val(data);
			});				
		}
				
		function validarcliente() {
			var codigo=document.getElementById("aCliente").value;
				$.colorbox({href:"comprobarcliente.php?codcliente="+codigo+"&codrecibo=<?php echo $codrecibo;?>",
				iframe:true, width:"350", height:"200",
				});

		}
		
		function cancelar(codrecibo) {
			var codcliente = $('#aCliente').val();

				$.post('eliminotmp.php', { codrecibo: codrecibo, codcliente:codcliente }, function(data){
        		});

			parent.$('idOfDomElement').colorbox.close();	
		}
			
		function validar_cabecera() {
				var mensaje="";
				var saldo=$("#saldo").val();
				if (saldo>5) {
					var iframeMain = $("#formulario_facturas_sel").contents().find('#facturas');
				jQuery.msgBox({
				    title: "El importe del recibo es menor que el total de las facturas",
				    content: "Quiere marcarlas como cobro parcial? ",
				    type: "confirm",
				    buttons: [{ value: "Si" }, { value: "Cancelar"}],
				    success: function (result) {
				        if (result == "Si") {					
				  			mensaje+="  - Nombre<br>";									    	
						}
					}
					});	
									
				}

				if (document.getElementById("nombre").value=="") mensaje+="  - Nombre<br>";
				if (document.getElementById("fecha").value=="") mensaje+="  - Fecha<br>";
				if (mensaje!="") {
					showWarningToast("Errores detectados:<br>"+mensaje);
					return false;	
				} else {
					document.getElementById("importe").value=document.getElementById("totalrecibo").value;
					document.getElementById("formulario").submit();
				}
			}			
		
		function validar() {
				var mensaje="";

				if (document.getElementById("nombre").value=="") mensaje+="  - Cliente<br>";
				if (document.getElementById("codrecibo").value=="") mensaje+="  - Nº Recibo<br>";
				if (document.getElementById("cantidad").value<1) mensaje+="  - Agregue una factura a cobrar<br>";
				
				var tipo=document.formulario_pago.Atipo.options[document.formulario_pago.Atipo.selectedIndex].value;

				if (tipo==0) mensaje+="  - Tipo de pago<br>";
				if (document.getElementById("fecha").value=="") mensaje+="  - Falta fecha<br>"; 
				var Amonedapago=document.formulario_pago.Amonedapago.options[document.formulario_pago.Amonedapago.selectedIndex].value;
				if (Amonedapago==0) mensaje+="  - Seleccione moneda<br>";
							 
				if (document.getElementById("Atipo").value==2) 
						{
						var cboBanco=document.formulario_pago.cboBanco.options[document.formulario_pago.cboBanco.selectedIndex].value;
						if (cboBanco==0) mensaje+="  - Entidad bancaria<br>";											 
						if (document.getElementById("anumeroserie").value=="") mensaje+="  - Nº serie<br>";
						if (document.getElementById("anumero").value=="") mensaje+="  - Nº documento<br>";
						}

				if (document.getElementById("Rimportedoc").value=="") mensaje+="  - Falta el importe<br>";
				
				if (mensaje!="") {
					showWarningToast("Errores detectados:<br>"+mensaje);
				} else {

					document.getElementById("formulario_pago").submit();
					document.getElementById("Atipo").value=0;
					document.getElementById("fechapago").value="";
					document.getElementById("anumeroserie").value="";
					document.getElementById("anumero").value="";
					document.getElementById("cboBanco").value=0;
					document.getElementById("Rimportedoc").value="";
					document.getElementById("total").value="";
					document.getElementById("observaciones").value="";
					
				}
			}
		
		function busco_tipocambio() {
			var fecha=$("#fecha").val();
				$.post("busco_tipocambio.php?fecha="+fecha,  function(data){
				$("#tipocambio").val(data);
			})(jQuery);			
		}		
		
		function cambio() {
			var Index = document.formulario.Amoneda.options[document.formulario.Amoneda.selectedIndex].value;
			var tipoaux = document.formulario_pago.Amonedapago.options[document.formulario_pago.Amonedapago.selectedIndex].value;

				if (tipoaux==1 && Index == 2){
					document.getElementById("total").value=round(($("#Rimportedoc").val() / parseFloat($("#tipocambio").val())),2);
				} else { 
					if (tipoaux==2 && Index == 1) {
					document.getElementById("total").value=round(($("#Rimportedoc").val() * parseFloat($("#tipocambio").val())),2);
					} else {
					document.getElementById("total").value=round($("#Rimportedoc").val());
					}
				}
		}	
		</script>
	
<link href="../js3/jquery-ui.css" rel="stylesheet">
<script src="../js3/jquery-ui.js"></script>
  <style type="text/css">
  
		.fixed-height {
			padding: 1px;
			max-height: 200px;
			overflow: auto;
		}  
/****** jQuery Autocomplete CSS *************/

.ui-corner-all {
  -moz-border-radius: 0;
  -webkit-border-radius: 0;
  border-radius: 0;
}

.ui-menu {
  border: 1px solid lightgray;
  font-family: Verdana, Arial, Helvetica, sans-serif;
  font-size: 10px;
}

.ui-menu .ui-menu-item a {
  color: #000;
}

.ui-menu .ui-menu-item:hover {
  display: block;
  text-decoration: none;
  color: #3D3D3D;
  cursor: pointer;
 /* background-color: lightgray;
  background-image: none;*/
  border: 1px solid lightgray;
}

.ui-widget-content .ui-state-hover,
.ui-widget-content .ui-state-focus {
  border: 1px solid lightgray;
  /*background-image: none;
  background-color: lightgray;*/
  font-weight: bold;
  color: #3D3D3D;
}
  
  </style>
<script>
$.ui.autocomplete.prototype._renderItem = function(ul, item) {
  var re = new RegExp($.trim(this.term.toLowerCase()));
  var t = item.label.replace(re, "<span style='color:#5C5C5C;'>" + $.trim(this.term.toLowerCase()) +
    "</span>");
  return $("<li></li>")
    .data("item.autocomplete", item)
    .append("<a>" + t + "</a>")
    .appendTo(ul);
};

 $(document).ready(function () {
 	
    $("#nombre").autocomplete({
        source: '../common/busco.php',
        minLength:2,
        autoFocus:true,
        select: function(event, ui) {

		var name = ui.item.value;
		var thisValue = ui.item.data;
		var pref=thisValue.split("~")[0];
		var nombre=thisValue.split("~")[1];
		var nif=thisValue.split("~")[2];
		var agencia=thisValue.split("~")[3];

		$("#aCliente").val(pref);
		$("#codcliente").val(pref);
		$("#nombre").val(nombre);
		$("#nif").val(nif);

		$("#agencia").val(agencia);
	
		$('[data-index="2"]').focus();
		}
	}).autocomplete("widget").addClass("fixed-height");
});
</script>	
		
	</head>
	<body onLoad="inicio();">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">NUEVO RECIBO Nº <span id="recibo"> <?php echo $codrecibo;?></span></div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_recibo.php">
				<input name="importe" id="importe" value="<?php echo $total;?>" type="hidden">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=2 border=0>
						<tr>
							<td>Cliente</td>
						    <td><input name="nombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45" data-index="1"></td>
						    <td width="5%"><input name="codcliente" type="hidden" class="cajaPequena" id="aCliente" size="6" maxlength="5" readonly >
					      </td>						</tr>
						<tr>
				            <td width="5%">RUT</td>
				            <td><input name="nif" type="text" class="cajaMedia" id="nif" size="20" maxlength="15" value="" readonly></td>
				            
						<td>Moneda</td><td width="26%">
						<select name="Amoneda" id="Amoneda" class="cajaPequena2" onchange="cambiomoneda(); cambio();" data-index="2">
					<?php
							/*Genero un array con los simbolos de las monedas*/
							$tipomon = array();
							$sel_monedas="SELECT * FROM monedas WHERE borrado=0 AND orden <3 ORDER BY orden ASC";
						   $res_monedas=mysqli_query($GLOBALS["___mysqli_ston"], $sel_monedas);
						   $con_monedas=0;
							$xmon=1;
						 while ($con_monedas < mysqli_num_rows($res_monedas)) {
						 	$descripcion=split(" ", mysqli_result($res_monedas, $con_monedas, "simbolo"));
						 	 $tipomon[$xmon]= $descripcion[0];
						 	 $con_monedas++;
						 	 $xmon++;
						 }						
					
					echo '<option value="" selected>Selecione uno</option>';
					foreach ($tipomon as $key => $i ) {
							echo "<option value=$key>$i</option>";
					}
					?>
					</select></td>
								
				            
						</tr>
						<?php $hoy=date("d/m/Y"); ?>
						<tr>
							<td width="6%">Fecha</td>
						    <td width="27%"><input name="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<?php echo $hoy;?>" readonly data-index="3"> 
						    <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'" style="vertical-align: middle; margin-top: -1px;">
								<script type="text/javascript">
						   Calendar.setup({
						     inputField : "fecha",
						     trigger    : "Image1",
						     align		 : "Bl",
						     onSelect   : function() { this.hide(); busco_tipocambio(); },
						     dateFormat : "%d/%m/%Y"
						   });
						</script></td>
								<td width="5%">Nº recibo</td>
				            <td><input name="codrecibo" type="text" class="cajaPequena" id="codrecibo" onchange="cambionumero();" value="<?php echo $codrecibo;?>" size="20" maxlength="15" data-index="5" ></td>
						</tr>
											
					</table>									
			  </div>

			  <input id="accion" name="accion" value="alta" type="hidden">	
			  		  
			  </form>
			  <br style="line-height:5px">
			  <div id="frmBusqueda">
				<table class="fuente8" cellspacing=0 cellpadding=2 border=0>

				  <tr><td>
			  <!-- Sección listado de facturas pendientes de cobro -->
			  
				<form id="formulario_facturas" name="formulario_facturas" method="post" action="frame_facturas.php" target="frame_facturas">
				<input id="codcliente" name="cdocliente" value="" type="hidden">
				<input id="moneda" name="moneda" value="" type="hidden">
				<table class="fuente8" cellspacing=0 cellpadding=2 border=0 width="300" >
				  <tr>
					<td width="100%" >
					<iframe width="300" height="100" id="frame_facturas" name="frame_facturas" frameborder="0">
						<ilayer width="300" height="100" id="frame_facturas" name="frame_facturas"></ilayer>
					</iframe>					
					</td>
				  </tr>
				</table>
				
				</form>
				</td>
				<!-- Sección ingreso detalles del recibo -->
				<td>
				<form id="formulario_pago" name="formulario_pago" method="post" action="frame_pagos.php" target="frame_pago">
					<input name="bcodrecibo" id="bcodrecibo" value="<?php echo $codrecibo;?>" type="hidden">
					<input type="hidden" name="modifpago" id="modifpago" value="0">
				<input id="Cmoneda" name="Cmoneda" value="" type="hidden">
					
					<table class="fuente8" cellspacing=1 cellpadding=2 border=0 width="100%"><tr><td valign="top">
						<table class="fuente8" cellspacing=1 cellpadding=1 border=0 >
						<tr>
						
						<td>Tipo</td>
						<td>
						 <select name="Atipo" id="Atipo" class="cajaPequena" data-index="6">
					<?php $tipofa = array( 0=>"Seleccione uno", 1=>"Contado", 2=>"Cheque",3=>"Giro Bancario", 4=>"Giro RED cobranza", 5=>"Resguardo");
					foreach ($tipofa as $key => $i ) {
					  	if ( @$tipo==$key ) {
							echo "<option value=$key selected>$i</option>";
						} else {
							echo "<option value=$key>$i</option>";
						}

					}
					?>
					</select>
  						</td>
						<td>Fecha&nbsp;vencimiento</td>
						    <td ><input id="fechapago" type="text" class="cajaPequena" name="fechapago" maxlength="10" value="<?php echo $hoy?>" onchange="busco_tipocambio();" readonly data-index="7">
						    <img src="../img/calendario.png" name="Image2" id="Image2" width="16" height="16" border="0"  onMouseOver="this.style.cursor='pointer'" title="Calendario" style="vertical-align: middle; margin-top: -1px;">

								<script type="text/javascript">
						   Calendar.setup({
						     inputField : "fechapago",
						     trigger    : "Image2",
						     align		 : "Bl",
						     onSelect   : function() { this.hide(); busco_tipocambio(); },
						     dateFormat : "%d/%m/%Y"
						   });
						</script></td>  								
							<td colspan="2">
						
								<label><?php echo $tipomon[2];?> -> <?php echo $tipomon[1];?>&nbsp;</label>
								<input name="tipocambio" type="text" class="cajaPequena2" id="tipocambio" size="5" maxlength="5" onblur="cambio();" data-index="8">							
							</td> 
						<td>Moneda</td><td>
						 <select name="Amonedapago" id="Amonedapago" class="cajaPequena2" data-index="9" onchange="cambio();">
							<?php 
							foreach ( $tipomon as $key => $i ) {
									echo "<option value=$key>$i</option>";
							}
							?>
						</select>
  							</td>							 					    
						<?php
					  	$query_entidades="SELECT * FROM entidades WHERE borrado=0 ORDER BY nombreentidad ASC";
						$res_entidades=mysqli_query($GLOBALS["___mysqli_ston"], $query_entidades);
						$cont=0;
					  	?>
					  	</tr><tr>
							<td>Entidad&nbsp;Bancaria</td>
							<td colspan="3"><select id="cboBanco" name="cboBanco" class="comboGrande" data-index="10">
							<option value="0">Seleccione&nbsp;una&nbsp;Entidad&nbsp;Bancaria</option>
								<?php
								while ($cont < mysqli_num_rows($res_entidades)) { 
									if ($codentidad == mysqli_result($res_entidades, $cont, "codentidad")) { ?>
								<option value="<?php echo mysqli_result($res_entidades, $cont, "codentidad")?>" selected="selected"><?php echo mysqli_result($res_entidades, $cont, "nombreentidad");?></option>
								<?php } else { ?>
								<option value="<?php echo mysqli_result($res_entidades, $cont, "codentidad")?>"><?php echo mysqli_result($res_entidades, $cont, "nombreentidad");?></option>
								<?php } $cont++;
								} ?>
								</select></td>					  	
					  		<td >Nº&nbsp;Serie</td>
						   <td><input id="anumeroserie" type="text" class="cajaPequena2" name="anumeroserie" maxlength="30" data-index="11"></td>
							<td >Nº&nbsp;documenro</td>
						   <td><input id="anumero" type="text" class="cajaMedia" name="anumero" maxlength="30" data-index="12"></td>
						</tr></table></tr><tr><td>
						<table class="fuente8" cellspacing=1 cellpadding=1 border=0 >
						<tr>
							<td>Importe Doc.</td>
						    <td><input id="Rimportedoc" type="text" class="cajaPequena" name="Rimportedoc" maxlength="12" data-index="13" onblur="cambio();"> </td>
							<td>Total</td>
						    <td><input id="total" type="text" class="cajaPequena" name="total" maxlength="12" readonly disabled> </td>
							<td>Observaciones</td>
						    <td colspan="3"><textarea rows="2" cols="40" class="areaTexto" name="observaciones" id="observaciones" data-index="14"></textarea></td>
						</tr>							    
					</table></td></tr></table>
				  </form>
					</td>
					<td rowspan="2">
					<div>
						<button class="boletin" onClick="javascript:validar();" onMouseOver="style.cursor=cursor"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Aceptar</button>
			  </div>
				</td></table>
				</div>
				<!-- Detalles del recibo -->
				<br style="line-height:5px">
				<div id="frmBusqueda">
				<table class="fuente8" cellspacing=0 cellpadding=2 border=0>
				<tr><td valign="top">
				
				<form id="formulario_facturas_sel" name="formulario_facturas_sel" method="post" action="frame_facturas_sel.php" target="frame_facturas_sel">
				<input id="codfactura" name="codfactura" value="" type="hidden">
				<input id="cantidad" name="cantidad" value="0" type="hidden">
				<input name="acodrecibo" id="acodrecibo" value="<?php echo $codrecibo;?>" type="hidden">
				<input id="modiffactu" name="modiffactu" value="0" type="hidden">				    
				<input id="totalfactura" name="totalfactura" value="" type="hidden">

				<table class="fuente8" cellspacing=0 cellpadding=2 border=0 width="300">
				<tr>
				<td width="100%" >
					<iframe width="350" height="100" id="frame_facturas_sel" name="frame_facturas_sel" frameborder="0">
						<ilayer width="350" height="100" id="frame_facturas_sel" name="frame_facturas_sel"></ilayer>
					</iframe>					
				</td>
				</tr>
				<tr><td>
				<label><input type="checkbox" style=" margin-top: 2px;" checked="checked">Selecione para indicar pago parcial
				<span></span></label>				
				</td></tr>
				</table>
				</form>
				</td>
				<td>
				<table class="fuente8" cellspacing=0 cellpadding=2 border=0 width="100%" height="160" >
				<tr>
				<td width="100%" valign="top" >
					<iframe width="550" height="160" id="frame_pago" name="frame_pago" frameborder="0">
						<ilayer width="550" height="160" id="frame_pago" name="frame_pago"></ilayer>
					</iframe>					
				</td>
				</tr>
				</table>				
				</td>
				</tr></table>
				</div>
				<br style="line-height:5px">
				<table class="fuente8" cellspacing=0 cellpadding=3 border=0>
					<tr>
						<td align="right">Total a pagar&nbsp;<input type="text" id="apagar" value="0" name="apagar" class="cajaPequena" readonly></td>
						<td align="right">Total recibo&nbsp;<input type="text" id="totalrecibo" value="0" name="totalrecibo" class="cajaPequena" readonly></td>
						<td align="right">Saldo&nbsp;<input type="text" id="saldo" name="saldo" value="0" class="cajaPequena" readonly></td>
						<td>
					<div align="center">
						<button class="boletin" onClick="validar_cabecera();" onMouseOver="style.cursor=cursor"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Guardar</button>
						<button class="boletin" onClick="event.preventDefault();cancelar('<?php echo $codrecibo;?>');" onMouseOver="style.cursor=cursor"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Salir</button>
						<input id="modif" name="modif" value="0" type="hidden">				    
					</div>
				</td>
				</tr> 				
				</table>			  
			 
									
			  
			  		<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
			  </form>
			 </div>
		  </div>
		</div>
	
			
	</body>
</html>
