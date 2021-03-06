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

date_default_timezone_set("America/Montevideo"); 

$baseimponible='';
$tipocambio='';
$modif='';

$codautofacturatmp=$codautofactura=$_GET["codautofactura"];
$sel_alb="SELECT * FROM autofacturas WHERE codautofactura='$codautofactura'";
$rs_alb=mysqli_query($GLOBALS["___mysqli_ston"], $sel_alb);
$codcliente=mysqli_result($rs_alb, 0, "codcliente");
$tipo=mysqli_result($rs_alb, 0, "tipo");
$moneda=mysqli_result($rs_alb, 0, "moneda");
$tipocambio=mysqli_result($rs_alb, 0, "tipocambio");
$iva=mysqli_result($rs_alb, 0, "iva");
$fecha=mysqli_result($rs_alb, 0, "fecha");
$codformapago=mysqli_result($rs_alb, 0, "codformapago");
$observacion=mysqli_result($rs_alb, 0, "observacion");
$descuentogral=mysqli_result($rs_alb, 0, "descuento");

$emitida=mysqli_result($rs_alb, 0, "emitida");
$activa=mysqli_result($rs_alb, 0, "activa");
$diafacturacion=mysqli_result($rs_alb, 0, "diafacturacion");
$semanafacturacion=mysqli_result($rs_alb, 0, "semanafacturacion");

$sel_cliente="SELECT nombre,apellido,empresa,nif,agencia FROM clientes WHERE codcliente='$codcliente'";
$rs_cliente=mysqli_query($GLOBALS["___mysqli_ston"], $sel_cliente);
$nombre=mysqli_result($rs_cliente, 0, "nombre");
$nombre=mysqli_result($rs_cliente, 0, "nombre")." ".mysqli_result($rs_cliente, 0, "apellido")." - ".mysqli_result($rs_cliente, 0, "empresa");
$agencia=mysqli_result($rs_cliente, 0, "agencia");
$nif=mysqli_result($rs_cliente, 0, "nif");

$fechahoy=date("Y-m-d");
/*
$sel_albaran="INSERT INTO autofacturastmp (codautofactura,fecha) VALUE ('','$fechahoy')";
$rs_albaran=mysql_query($sel_albaran);
$codautofacturatmp=mysql_insert_id();
*/
$sel_lineas="SELECT * FROM autofactulinea WHERE codautofactura='$codautofactura' ORDER BY numlinea ASC";
$rs_lineas=mysqli_query($GLOBALS["___mysqli_ston"], $sel_lineas);

$sel_borrar = "DELETE FROM autofactulineatmp WHERE codautofactura='$codautofactura'";
$rs_borrar = mysqli_query($GLOBALS["___mysqli_ston"], $sel_borrar);

$contador=0;
//echo mysql_num_rows($rs_lineas);
while ($contador < mysqli_num_rows($rs_lineas)) {
	$codfamilia=mysqli_result($rs_lineas, $contador, "codfamilia");
	$codigo=mysqli_result($rs_lineas, $contador, "codigo");
	$codservice=mysqli_result($rs_lineas, $contador, "codservice");
	$cantidad=mysqli_result($rs_lineas, $contador, "cantidad");
	$detallestmp=mysqli_result($rs_lineas, $contador, "detalles");
	$precio=mysqli_result($rs_lineas, $contador, "precio");
	$importe=mysqli_result($rs_lineas, $contador, "importe");
	$baseimponible=$baseimponible+$importe;
	$dcto=mysqli_result($rs_lineas, $contador, "dcto");

	$descuentopp=mysqli_result($rs_lineas, $contador, "dctopp");
	$comision=mysqli_result($rs_lineas, $contador, "comision");
	
	$sel_tmp="INSERT INTO autofactulineatmp (codautofactura,numlinea,codfamilia,codigo,codservice,detalles,cantidad,moneda,precio,importe,dcto,dctopp,comision) 
				VALUES ('$codautofactura','','$codfamilia','$codigo','$codservice','$detallestmp','$cantidad','$moneda','$precio','$importe','$dcto','$descuentopp','$comision')";	
	$rs_tmp=mysqli_query($GLOBALS["___mysqli_ston"], $sel_tmp);
	$contador++;
}
//$baseimpuestos=$baseimponible*($iva/100);
//$preciototal=$baseimponible+$baseimpuestos;
//$preciototal=number_format($preciototal,2);
$shoedetalle=1;

		  	$query_iva="SELECT * FROM impuestos WHERE codimpuesto=".$iva;
			$res_iva=mysqli_query($GLOBALS["___mysqli_ston"], $query_iva);
			$baseimpuestos=$baseimponible*(mysqli_result($res_iva, 0, "valor")/100);
			$preciototal=$baseimponible+$baseimpuestos;
//$preciototal=number_format($preciototal,2);

			$sel_resultado="SELECT * FROM monedas WHERE borrado=0 AND orden <3 ORDER BY orden ASC";
		   $res_resultado=mysqli_query($GLOBALS["___mysqli_ston"], $sel_resultado);
			$moneda1=mysqli_result($res_resultado,0, "simbolo");
			$moneda2=mysqli_result($res_resultado, 1, "simbolo");

?>
<html>
	<head>
		<title>Principal</title>
		<link href="../../css3/estilos.css" type="text/css" rel="stylesheet">
    <script src="../../js3/calendario/jscal2.js"></script>
    <script src="../../js3/calendario/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../../js3/calendario/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../../js3/calendario/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../../js3/calendario/css/win2k/win2k.css" />		
			<script src="../../js3/jquery.min.js"></script>
		<link rel="stylesheet" href="../js/colorbox.css" />
		<script src="../../js3/jquery.colorbox.js"></script>
		
<link rel="stylesheet" href="../../js3/jquery.toastmessage.css" type="text/css">
<script src="../../js3/jquery.toastmessage.js" type="text/javascript"></script>
<script src="../../js3/message.js" type="text/javascript"></script>
<link rel="stylesheet" href="../../js3/colorbox.css" />
<script src="../../js3/jquery.colorbox.js"></script>

<!-- iconos para los botones -->       
<link rel="stylesheet" href="../../css3/css/font-awesome.min.css">


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
			  if (index==5) {
		     		var codigo=document.getElementById("articulos").value;
		      	if (codigo=='') {
		        		ventanaArticulos();
		        		$('[data-index="' + (index + 3).toString() + '"]').focus();	
		     		}
		     }
		     if (index==9) {
		     	validarstock(9);
		     }		     
			  if (index==13) {
		        		validar();
		        		$('[data-index="5"]').focus();	
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
			  if (index==5) {
		     		var codigo=document.getElementById("articulos").value;
		      	if (codigo=='') {
		        		ventanaArticulos();
		        		$('[data-index="' + (index + 3).toString() + '"]').focus();	
		     		}
		     }
		     if (index==9) {
		     	validarstock(9);
		     }		     
			  if (index==13) {
		        		validar();
		        		$('[data-index="5"]').focus();
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

		$(".callbacks").colorbox({
			iframe:true, width:"720px", height:"98%",
			onCleanup:function(){ window.location.reload();	}
		});

});

		var top;
		function callGpsDiag(xx,numfactura){
			parent.callGpsDiag(xx,numfactura,top);
		}
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

function pon_prefijo_b(pref,nombre,nif,agencia) {
	$("#aCliente").val(pref);
	$("#nombre").val(nombre);
	$("#nif").val(nif);
	$("#agencia").val(agencia);
	$('idOfDomElement').colorbox.close();
}

function pon_prefijo_Fb(codfamilia,referencia,codigobarras,nombre,precio,codarticulo,moneda,codservice,detalles,comision) {
	var monArray = new Array();
	monArray[0]="Selecione uno";
	monArray[1]="Pesos";
	monArray[2]="U\$S";
	$("#codfamilia").val(codfamilia);
	if (codigobarras!='') {
		$("#codbarras").val(codigobarras);
	} else {
		$("#codbarras").val(referencia);
	}
	$("#articulos").val(referencia);

	$("#codservice").val(codservice);
	$("#detalles").val(detalles);
	$("#comision").val(comision);
	
	$("#descripcion").val(nombre);
	$("#precio").val(precio);
	$("#moneda").val(moneda);
	$("#monedaShow").val(monArray[moneda]);
	$("#importe").val(precio);
	$("#codarticulo").val(codarticulo);
	$('idOfDomElement').colorbox.close();
	cambio();
	actualizar_importe();
}

function pon_baseimponible(baseimponible) {
	$("#baseimponible").val(baseimponible);
	actualizo_descuento();
}

function validarstock(index){
//Función para validad stock, utilizando el código de producto y la cantidad seleccionada
	var codarticulo=document.getElementById("codarticulo").value;
	var cantidad=document.getElementById("cantidad").value;

	jQuery.ajax({
		 type: "POST",
		 url: "monitoreostock.php",
		 data: {codarticulo:codarticulo, cantidad:cantidad },
		 async: true,
		 	 cache: false,
		 success: function(data){ 
		 if (data<cantidad) {
			showWarningToast("Error, no hay stock suficiente, hay: "+data);
			$('[data-index="' + (index).toString() + '"]').focus();
		 } else {
		 	actualizar_importe();
		 }
		},
		  error: function() {
		   showWarningToast("Error");
		}
	});        
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
			document.getElementById("modif").value=1;
			document.formulario_lineas.submit();
			document.getElementById("modif").value=0;
		}
		
		function ventanaArticulos(){
			var codigo=document.getElementById("aCliente").value;
			if (codigo=="") {
				showWarningToast("Debe introducir el código del cliente");
			} else {
				$.colorbox({href:"ver_articulos.php",
					iframe:true, width:"95%", height:"95%",
					onCleanup:function() {
					$('#precio').focus();
					}				
				});
			}
		}
		function ventanaService(){
			var codigo=document.getElementById("aCliente").value;
			if (codigo=="") {
				showWarningToast("Debe introducir el código del cliente");
				limpiar();
				
			} else {
				$.colorbox({href:"ver_service.php?codcliente="+codigo,
				iframe:true, width:"95%", height:"95%",
				});
			}
		}		
		function validarArticulo() {
			var codigo=document.getElementById("aCliente").value;
			if (codigo=="") {
				showWarningToast("Debe introducir el código del cliente");
				limpiar();
				$('[data-index="1"]').focus();
			} else {			
			var codbarras=document.getElementById("articulos").value;
				if (codbarras!="") {
					$.colorbox({href:"comprobararticulos.php?codbarras="+codbarras,
					iframe:true, width:"350", height:"200",
					});
				}
			}			
		}
				
		function validarcliente() {
			var codigo=document.getElementById("aCliente").value;
				$.colorbox({href:"comprobarcliente.php?codcliente="+codigo,
				iframe:true, width:"350", height:"200",
				
				});
		}
		
		function cancelar() {
			parent.$('idOfDomElement').colorbox.close();
			preventDefault();
		}
		
		function limpiarcaja() {
			document.getElementById("nombre").value="";
			document.getElementById("nif").value="";
		}

		function limpiar() {
					document.getElementById("codbarras").value="";
					document.getElementById("articulos").value="";
					document.getElementById("detalles").value="";
					document.getElementById("descripcion").value="";
					document.getElementById("precio").value="";
					document.getElementById("cantidad").value="";
					document.getElementById("moneda").value="";
					document.getElementById("monedaShow").value="";
					document.getElementById("importe").value="";
					document.getElementById("descuento").value=0;	
					document.getElementById("comision").value=0;
					document.getElementById("descuentopp").value=0;
		}		


		function actualizar_importe() {
				/*Si la factura es en pesos y el articulo esta en dolares aplico el tipo de cambio*/
				var tipocambiofactura=document.formulario.Amoneda.options[document.formulario.Amoneda.selectedIndex].value;
				var tipocambioarcticulo=document.getElementById("moneda").value;
				if (tipocambiofactura==1 && tipocambioarcticulo == 2){
					var precio=document.getElementById("precio").value * parseFloat(document.getElementById("tipocambio").value);
				}
				if (tipocambiofactura==2 && tipocambioarcticulo == 1){
					var precio=document.getElementById("precio").value / parseFloat(document.getElementById("tipocambio").value);
				}
				if ((tipocambiofactura==1 && tipocambioarcticulo == 1) || (tipocambiofactura==2 && tipocambioarcticulo == 2)){
				var precio=document.getElementById("precio").value;
				}
				var cantidad=document.getElementById("cantidad").value;
				var descuento=document.getElementById("descuento").value;
				var descuentopp=document.getElementById("descuentopp").value;
				descuento=descuento/100;
				descuentopp=descuentopp/100;
				
				total=precio*cantidad;

				descuento=total*descuento;
				total=total-descuento;

				descuentopp=total*descuentopp;
				total=total-descuentopp;

				var original=parseFloat(total);
				var result=round(original,2) ;
				document.getElementById("importe").value=result;
			}
			
		function validar_cabecera() {
			event.preventDefault();
				var mensaje="";
				if (document.getElementById("nombre").value=="") mensaje+="  - Nombre<br>";
				if (document.getElementById("fecha").value=="") mensaje+="  - Fecha<br>";
				if (mensaje!="") {
					showWarningToast("Errores detectados:<br>"+mensaje);
				} else {
					document.getElementById("descuentogral").value=document.getElementById("descuentogralaux").value;
					document.getElementById("observacion").value=document.getElementById("observacionaux").value;
					document.getElementById("formulario").submit();
				}
			}			
		
		function validar() {
				var mensaje="";
				var entero=0;
				var enteroo=0;
		
				if (document.getElementById("codbarras").value=="") mensaje="  - Codigo de barras<br>";
				if (document.getElementById("descripcion").value=="") mensaje+="  - Descripción<br>";
				if (document.getElementById("precio").value=="") { 
							mensaje+="  - Falta el precio<br>"; 
						} else {
							if (isNaN(document.getElementById("precio").value)==true) {
								mensaje+="  - El precio debe ser numérico<br>";
							}
						}
				if (document.getElementById("cantidad").value=="") 
						{ 
						mensaje+="  - Falta la cantidad<br>";
						} else {
							enteroo=parseInt(document.getElementById("cantidad").value);
							if (isNaN(enteroo)==true) {
								mensaje+="  - La cantidad debe ser numérica<br>";
							} else {
									document.getElementById("cantidad").value=enteroo;
								}
						}
				if (document.getElementById("descuento").value=="") 
						{ 
						document.getElementById("descuento").value=0 
						} else {
							entero=parseInt(document.getElementById("descuento").value);
							if (isNaN(entero)==true) {
								mensaje+="  - El descuento debe ser numérico<br>";
							} else {
								document.getElementById("descuento").value=entero;
							}
						}
				if (document.getElementById("descuentopp").value=="") 
						{ 
						document.getElementById("descuentopp").value=0 
						} else {
							entero=parseInt(document.getElementById("descuentopp").value);
							if (isNaN(entero)==true) {
								mensaje+="  - El descuento pronto pago debe ser numérico<br>";
							} else {
								document.getElementById("descuentopp").value=entero;
							}
						}						 
				if (document.getElementById("importe").value=="") mensaje+="  - Falta el importe<br>";
				
				if (mensaje!="") {
					showWarningToast("Errores detectados:<br>"+mensaje);
				} else {
					var descuentogral=document.getElementById("descuentogralaux").value;
					document.getElementById("baseimponible").value=parseFloat(document.getElementById("baseimponible").value) + parseFloat(document.getElementById("importe").value);
					
					document.getElementById("baseimponibledescuento").value=	round((parseFloat(document.getElementById("baseimponible").value) / (1+descuentogral/100)),2);
					cambio_iva();
					document.getElementById("formulario_lineas").submit();
					document.getElementById("codbarras").value="";
					document.getElementById("articulos").value="";
					document.getElementById("detalles").value="";
					document.getElementById("descripcion").value="";
					document.getElementById("precio").value="";
					document.getElementById("cantidad").value="";
					document.getElementById("moneda").value="";
					document.getElementById("monedaShow").value="";
					document.getElementById("importe").value="";
					document.getElementById("descuento").value=0;						
					document.getElementById("descuentopp").value=0;						
				}
				$('#codbarras').focus();
			}

		function actualizo_descuento() {
				var descuentogral=parseFloat(document.getElementById("descuentogralaux").value);
				document.getElementById("baseimponibledescuento").value=	round((parseFloat(document.getElementById("baseimponible").value) * (1-descuentogral/100)),2);
				cambio_iva();
		}			
			
		function cambio_iva() {
			var original=parseFloat(document.getElementById("baseimponible").value);
			var tipoiva=document.formulario.Aiva.options[document.formulario.Aiva.selectedIndex].value;
			var valorimpuesto = tipoiva.split("~")[1];
			var codimpuesto = tipoiva.split("~")[0];
			var result=round(original,2) ;
			document.getElementById("baseimponible").value=result;
			document.getElementById("impuesto").value=codimpuesto;
			
			document.getElementById("baseimpuestos").value=parseFloat(result * valorimpuesto / 100);
			var original1=parseFloat(document.getElementById("baseimpuestos").value);
			var result1=Math.round(original1*100)/100 ;
			document.getElementById("baseimpuestos").value=result1;
			var original2=parseFloat(result + result1);
			var result2=Math.round(original2*100)/100 ;
			document.getElementById("preciototal").value=result2;
		}	
		
		function busco_tipocambio() {
			var fecha=$("#fecha").val();
				$.post('busco_tipocambio.php', {fecha : fecha },  function(data){
				$("#tipocambio").val(data);
			});			
	 		
		}		
		var tipoaux='';
		function cambio() {
			var Index = document.formulario.Amoneda.options[document.formulario.Amoneda.selectedIndex].value;
			var monArray = new Array();
			monArray[0]="Selecione uno";
			monArray[1]="Pesos";
			monArray[2]="U\$S";
			$("#monShow").val(monArray[Index]);
			$("#monSho").val(monArray[Index]);
			$("#monSh").val(monArray[Index]);

				if (tipoaux==1 && Index == 2){
					document.getElementById("baseimponible").value=round(($("#baseimponible").val() / parseFloat($("#tipocambio").val())) , 2);
					document.getElementById("baseimpuestos").value=round(($("#baseimpuestos").val() / parseFloat($("#tipocambio").val())) , 2);
					document.getElementById("preciototal").value=round(($("#preciototal").val() / parseFloat($("#tipocambio").val())) , 2);
				}
				if (tipoaux==2 && Index == 1){
					document.getElementById("baseimponible").value=round(($("#baseimponible").val() * parseFloat($("#tipocambio").val())) , 2);
					document.getElementById("baseimpuestos").value=round(($("#baseimpuestos").val() * parseFloat($("#tipocambio").val())) , 2);
					document.getElementById("preciototal").value=round(($("#preciototal").val() * parseFloat($("#tipocambio").val())) , 2);
				}
			tipoaux=Index;
		}		
		</script>

<script type="text/javascript" >
function actualizovencimeinto() {
	var pago = document.getElementById("codformapago").value;
	var d = pago.split("~")[1];
	var fecha=document.getElementById('fecha').value;
	var Fecha = new Date();
	var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
	var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
	var aFecha = sFecha.split(sep);
	var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
	fecha= new Date(fecha);
	fecha.setDate(fecha.getDate()+parseInt(d));
	var anno=fecha.getFullYear();
	var mes= fecha.getMonth()+1;
	var dia= fecha.getDate();
	mes = (mes < 10) ? ("0" + mes) : mes;
	dia = (dia < 10) ? ("0" + dia) : dia;
	var fechaFinal = dia+sep+mes+sep+anno;
	document.getElementById('vencimiento').value=fechaFinal;
}
</script>	


<link href="../js/jquery-ui.css" rel="stylesheet">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
 	
    $("#descripcion").autocomplete({
        source: 'busco2.php',
        minLength:2,
        autoFocus:true,
        select: function(event, ui) {
			var codigo=document.getElementById("aCliente").value;
			if (codigo=="") {
				showWarningToast("Debe introducir el código del cliente");
				$("#descripcion").val('');
				$('[data-index="1"]').focus();
				return false;
			}           	
         var name = ui.item.value;
         var thisValue = ui.item.data;
			var codfamilia=thisValue.split("~")[0];
			var codigobarras=thisValue.split("~")[1];
			var referencia=thisValue.split("~")[2];
			var nombre=thisValue.split("~")[3];
			var precio=thisValue.split("~")[4];
			var codarticulo=thisValue.split("~")[5];
			var moneda=thisValue.split("~")[6];
			var codservice=thisValue.split("~")[7];
			var detalles=thisValue.split("~")[8];
			var comision=thisValue.split("~")[9];
		
			var monArray = new Array();
			monArray[0]="Selecione uno";
			monArray[1]="Pesos";
			monArray[2]="U\$S";
			$("#codfamilia").val(codfamilia);
			if (codigobarras!='') {
				$("#codbarras").val(codigobarras);
			} else {
				$("#codbarras").val(referencia);
			}
			$("#articulos").val(referencia);
			$("#codservice").val(codservice);
			$("#detalles").val(detalles);
			$("#comision").val(comision);
			
			$("#descripcion").val(nombre);
			$("#precio").val(precio);
			$("#moneda").val(moneda);
			$("#monedaShow").val(monArray[moneda]);
			$("#importe").val(precio);
			$("#codarticulo").val(codarticulo);
			cambio();
			actualizar_importe();
	 		$('[data-index="8"]').focus();
		}
	}).autocomplete("widget").addClass("fixed-height");


    $("#nombre").autocomplete({
        source: 'busco.php',
        minLength:2,
        autoFocus:true,
        select: function(event, ui) {

		var name = ui.item.value;
		var thisValue = ui.item.data;
		var pref=thisValue.split("~")[0];
		var nombre=thisValue.split("~")[1];
		var nif=thisValue.split("~")[2];
		var agencia=thisValue.split("~")[2];

		$("#aCliente").val(pref);
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
				<div id="tituloForm" class="header">MODIFICAR FACTURA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_factura.php">
					<table class="fuente8" cellspacing=0 cellpadding=2 border=0>
						<tr>
							<td>Nombre</td>
						    <td colspan="2"><input name="nombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45" value="<?php echo $nombre;?>" readonly data-index="1">
						    <input name="codcliente" type="hidden" class="cajaPequena" id="aCliente" value="<?php echo $codcliente?>"></td>
							<td>Nº&nbsp;</td><td>
							<input id="codautofacturatmp" class="cajaPequena" name="codautofacturatmp" value="<?php echo $codautofacturatmp?>" disabled="true">						  
						  </input></td>						  
							<td>Día de facturación</td>	
						  <td><select id="semanafacturacion" name="Asemanafacturacion" class="comboPequeno2" data-index="2">

					<?php $tipof = array(1=>"1º", 2=>"2º", 3=>"3º", 4=>"4º");

					$x=1;
					$NoEstado=0;
					foreach($tipof as $i) {
					  	if ( $x==$semanafacturacion) {
							echo "<option value=$x selected>$i</option>";
						} else {
							echo "<option value=$x>$i</option>";
						}
						$x++;
					}
					?>
					</select>
					<select id="diafacturacion" name="Adiafacturacion" class="comboPequeno" data-index="3">

					<?php $tipof = array(1=>"Lunes", 2=>"Martes", 3=>"Miércoles", 4=>"Jueves", 5=>"Viernes");

					$x=1;
					$NoEstado=0;
					foreach($tipof as $i) {
					  	if ( $x==$diafacturacion) {
							echo "<option value=$x selected>$i</option>";
						} else {
							echo "<option value=$x>$i</option>";
						}
						$x++;
					}
					?>
						</select>								
						</td>	<td>	
						<input type="hidden" name="activa" value="0">
						<label>  Estado
						<?php						
						 if ( $activa==1) {
						?>
						<input type="checkbox" name="activa" value="1" checked style="vertical-align: middle; margin-top: -1px;"> Activo
						<?php } else {
						?>
						<input type="checkbox" name="activa" value="1" style="vertical-align: middle; margin-top: -1px;"> Activo
						<?php }
						?>
							<span></span>
						</label>							
						&nbsp;Acción;&nbsp;
					<select id="emitida" name="emitida" class="comboMedio">

					<?php $tipof = array(1=>"Solo registrar", 2=>"Registrar y emitir", 3=>"Registrar y enviar", 4=>"Registrar, emitir y enviar");

					$x=1;
					$NoEstado=0;
					foreach($tipof as $i) {
					  	if ( $x==$emitida) {
							echo "<option value=$x selected>$i</option>";
						} else {
							echo "<option value=$x>$i</option>";
						}
						$x++;
					}
					?>
						</select>						
						
						</td>					  				         					        					
						</tr>
						<tr>
				            <td>RUT</td>
				            <td colspan="2"><input name="nif" type="text" class="cajaMedia" id="nif" size="20" maxlength="15" value="<?php echo $nif?>" readonly></td>
								<td>Tipo</td>
				            <td>
				            <select id="tipo" name="atipo" class="cajaPequena" data-index="2">

					<?php $tipof = array(0=>"Contado", 1=>"Credito");
					if ($tipo==" ")
					{
					echo '<option value="" selected>Selecione uno</option>';
					}
					$x=0;
					$NoEstado=0;
					foreach($tipof as $i) {
					  	if ( $x==$tipo) {
							echo "<option value=$x selected>$i</option>";
							$NoEstado=1;
						} else {
							echo "<option value=$x>$i</option>";
						}
						$x++;
					}
					?>
								</select>
						</td><td>Forma&nbsp;de&nbsp;pago</td><td>
														<?php
					  	$query_fp="SELECT * FROM formapago WHERE borrado=0 ORDER BY dias ASC";
						$res_fp=mysqli_query($GLOBALS["___mysqli_ston"], $query_fp);
						$contador=0;
					  ?>
								<select id="codformapago" name="codformapago" class="comboMedio simpleinput" onchange="actualizovencimeinto();" data-index="3">
							
								<option value="0">Seleccione una</option>
								<?php
								while ($contador < mysqli_num_rows($res_fp)) { 
								if (mysqli_result($res_fp, $contador, "codformapago")==$codformapago) { ?>
								<option value="<?php echo mysqli_result($res_fp, $contador, "codformapago").'~'.mysqli_result($res_fp, $contador, "dias");?>" selected><?php echo mysqli_result($res_fp, $contador, "nombrefp")?></option>
								<?php 
									} else {
								?>
								<option value="<?php echo mysqli_result($res_fp, $contador, "codformapago").'~'.mysqli_result($res_fp, $contador, "dias");?>" ><?php echo mysqli_result($res_fp, $contador, "nombrefp")?></option>
								<?php
								}
								 $contador++;
								} ?>				
								</select>									
								
								</td>
						<td>Moneda&nbsp; <select onchange="cambio();" name="Amoneda" id="Amoneda" class="comboMedio" data-index="4">
					<?php
					 $tipofa = array(  1=>$moneda1, 2=>$moneda2);
					if ($moneda==" ")
					{
					echo '<option value="" selected>Selecione uno</option>';
					}
					foreach ($tipofa as $key => $i ) {
					  	if ( $moneda==$key ) {
							echo "<option value=$key selected>$i</option>";
						} else {
							echo "<option value=$key>$i</option>";
						}

					}
					?>
					</select>
					</td>
						</tr>
						<?php $hoy=date("d/m/Y"); ?>
						<tr>
							<td>Fecha</td><td>
							<input name="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<?php echo implota($fecha)?>" readonly> 
						    <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'" style="vertical-align: middle; margin-top: -1px;">
								<script type="text/javascript">
						   Calendar.setup({
						     inputField : "fecha",
						     trigger    : "Image1",
						     align		 : "Bl",
						     onSelect   : function() { actualizovencimeinto(); this.hide(); },
						     dateFormat : "%d/%m/%Y"
						   });
						</script>
						</td><td>
						Vencimiento <input name="vencimiento" type="text" class="cajaPequena" id="vencimiento" size="10" maxlength="10" value="<?php echo $hoy;?>" readonly>
						</td>
				      <td>IVA</td>
						<td>
				            <?php 
					  	$query_iva="SELECT * FROM impuestos WHERE borrado=0 ORDER BY nombre ASC";
						$res_iva=mysqli_query($GLOBALS["___mysqli_ston"], $query_iva);
						$contador=0;
					  ?>
					  			<input name="impuesto" type="hidden"  id="impuesto" value="<?php echo $iva;?>">
								<select id="Aiva" name="Aiva" class="comboPequeno simpleinput" onchange="cambio_iva();" data-index="5">
							
								<option value="0">Seleccione una</option>
								<?php
								while ($contador < mysqli_num_rows($res_iva)) {
									if(mysqli_result($res_iva, $contador, "codimpuesto") == $iva) {
									?>
								<option value="<?php echo mysqli_result($res_iva, $contador, "codimpuesto").'~'.mysqli_result($res_iva, $contador, "valor");?>" selected="selected"><?php echo mysqli_result($res_iva, $contador, "nombre")?></option>
								<?php
									} else {
									?>
								<option value="<?php echo mysqli_result($res_iva, $contador, "codimpuesto").'~'.mysqli_result($res_iva, $contador, "valor");?>"><?php echo mysqli_result($res_iva, $contador, "nombre")?></option>
								<?php
									} 	
								 $contador++;
								} ?>				
								</select>						            
								</td>					      
				       <td>Tipo&nbsp;Cambio</td><td>
								<label><?php echo $moneda1;?>&nbsp;->&nbsp;	<?php echo $moneda2;?></label><span>
								<input name="tipocambio" type="text" class="cajaPequena" id="tipocambio" size="5" maxlength="5" value="<?php echo $tipocambio; ?>" onChange="cambio();"></span>
								<!--<input type="checkbox" name="usartc" style="vertical-align: middle; margin-top: -1px;">Buscar T/C</input>-->
						</td>
						<td><label>Agencia&nbsp;</label><span><input name="agencia" type="text" class="cajaGrande" id="agencia" size="5" maxlength="5" value="<?php echo $agencia; ?>"></span>
						  &nbsp;</td>				         					        					
						
				            
						</tr>
					</table>										
			  </div>
			  <input id="codautofacturatmp" name="codautofacturatmp" value="<?php echo $codautofacturatmp;?>" type="hidden">
			  <!--<input id="codautofactura" name="codautofactura" value="<?php echo $codautofactura?>" type="hidden">-->
			  <input id="baseimpuestos2" name="baseimpuestos" value="<?php echo $baseimpuestos;?>" type="hidden">
			  <input id="baseimponible2" name="baseimponible" value="<?php echo $baseimponible;?>" type="hidden">
			  <input id="preciototal2" name="preciototal" value="<?php echo $preciototal;?>" type="hidden">
			  <input id="descuentogral" name="descuentogral" value="<?php echo $descuentogral;?>" type="hidden">
			  <input id="observacion" name="observacion" value="<?php echo $observacion;?>" type="hidden">
			  <input id="accion" name="accion" value="modificar" type="hidden">			  
			  </form>
			  <br style="line-height:5px">
			  <div id="frmBusqueda">
				<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" target="frame_lineas">
				<table class="fuente8" cellspacing=0 cellpadding=2 border=0>
				  <tr>
					<td >Codigo </td>
					<td colspan="3" valign="middle">
					<input type="hidden" name="codbarras" class="cajaMedia" id="codbarras" size="15" maxlength="15">
					<input type="text" size="26" maxlength="60" value="" id="articulos" autocomplete="off" class="cajaMedia" onBlur="validarArticulo();" data-index="5"/>
					 <img id="botonBusqueda" src="../../img/ver.png" width="16" height="16" onClick="ventanaArticulos();" onMouseOver="style.cursor=cursor" title="Buscar articulo" style="vertical-align: middle; margin-top: -1px;">
					 <img id="botonBusqueda" src="../../img/service.png" width="16" height="16" onClick="ventanaService();" onMouseOver="style.cursor=cursor" title="Buscar Service" style="vertical-align: middle; margin-top: -1px;">
					&nbsp;Descripcion</td>
					<td colspan="5" ><input name="descripcion" type="text" class="cajaGrande" id="descripcion" size="45" maxlength="50" data-index="6"></td>
					<td>Moneda&nbsp;&nbsp;&nbsp;</td>					 
					 <td colspan="2">
					 <input name="monedaShow" type="text" class="cajaPequena2" id="monedaShow" size="10" maxlength="10" readonly>&nbsp;&nbsp;&nbsp;
					 <input name="moneda"  id="moneda" type="hidden" >
					 </td>
				  </tr>
				  <tr>
  				  <?php if($shoedetalle==1) { ?>
					<td valign="top">Detalles</td>
					<td colspan="2"><textarea name="detalles" rows="2" cols="40" class="areaTexto" id="detalles" data-index="7"> </textarea></td>
					<?php } ?>
					<td colspan="2" valign="top" >Precio&nbsp;<input name="precio" type="text" class="cajaPequena2" id="precio" size="10" maxlength="10" onChange="actualizar_importe();" data-index="8"></td>
					<td colspan="2" valign="top" >Cantidad&nbsp;<input name="cantidad" type="text" class="cajaMinima" id="cantidad" size="10" maxlength="10" value="" data-index="9"></td>
					<td colspan="2" valign="top" >Dcto.&nbsp;<input name="descuento" type="text" class="cajaMinima" id="descuento" size="10" maxlength="10" onChange="actualizar_importe();" data-index="10"> %</td>
					<td colspan="2" valign="top" >Dcto.&nbsp;PP&nbsp;<input name="descuentopp" type="text" class="cajaMinima" id="descuentopp" size="10" maxlength="10" onChange="actualizar_importe();" data-index="11">&nbsp;%</td>
					<td colspan="2" valign="top">Comisión&nbsp;<input name="comision" type="text" class="cajaMinima" id="comision" size="10" maxlength="10" data-index="12" style="background-color: yellow;" >&nbsp;%</td>
					<td colspan="2" valign="top" >Importe&nbsp;<input name="importe" type="text" class="cajaPequena2" id="importe" size="10" maxlength="10" readonly data-index="13"></td>
					<td valign="top" align="right">
					<button class="boletin" onClick="validar();" onMouseOver="style.cursor=cursor"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar</button>
					</td>
					<td valign="top" align="right">
					<button class="boletin" onClick="limpiar();" onMouseOver="style.cursor=cursor"><i class="fa fa-paint-brush" aria-hidden="true"></i>&nbsp;Limpiar</button>
					</td>

				  </tr>
				</table>
				</div>
				<input name="codarticulo" value="" type="hidden" id="codarticulo">
				<input name="codservice" value="" type="hidden" id="codservice">
				<br style="line-height:5px">
				<div id="frmBusqueda">
				<table class="fuente8" width="100%" cellspacing=0 cellpadding=2 border=0 ID="Table1">

						<tr><td width="100%" colspan="11">
					<iframe width="100%" height="160" id="frame_lineas" name="frame_lineas" frameborder="0">
						<ilayer width="100%" height="160" id="frame_lineas" name="frame_lineas"></ilayer>
					</iframe>
				</td></tr>					
				</table>
				</div>
			  <div id="frmBusqueda">
				<table border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
				<tr>
				<td valign="top">Observaciones</td>
				<td valign="top" rowspan="3"><textarea id="observacionaux" rows="4" cols="40" class="areaTexto"><?php echo $observacion;?></textarea>
				</td>
				<td colspan="5"></td>
			    <td class="busqueda">Sub-total</td>
				<td align="left"><div align="left">
				 <input type="text" class="cajaPequena2" id="monShow" readonly>
			      <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" size="12" value=0 align="right" readonly> 
		        </div></td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="busqueda" >Descuento</td>
				<td class="busqueda" ><input id="descuentogralaux" name="descuentogral" value="<?php echo $descuentogral;?>" class="cajaMinima" onChange="actualizo_descuento();"></td>
				<td class="busqueda">&nbsp;%</td>
				<td>	
				<input class="cajaTotales" name="baseimponibledescuento" type="text" id="baseimponibledescuento" size="12" value=0 align="right" readonly> 
				</td>
				<td class="busqueda">IVA</td>
				<td align="left"><div align="left">
				 <input type="text" class="cajaPequena2" id="monSho" readonly>
			      <input class="cajaTotales" name="baseimpuestos" type="text" id="baseimpuestos" size="12" align="right" value=0 readonly>
		        </div></td>
 				</tr>
				<tr>
				<td></td>
				<td>

				</td>
				<td colspan="4"></td>
				<td class="busqueda">Precio&nbsp;Total</td>
				<td align="left"><div align="left">
				 <input type="text" class="cajaPequena2" id="monSh" readonly>
			      <input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" value=0 readonly> 
		        </div></td>				
				</tr>
<tr><td>
				</td>
				<td>
					<div align="center">
						<button class="boletin" onClick="validar_cabecera();" onMouseOver="style.cursor=cursor"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Aceptar</button>	
						<button class="boletin" onClick="event.preventDefault();parent.$('idOfDomElement').colorbox.close();" onMouseOver="style.cursor=cursor"><i class="fa fa-window-close-o" aria-hidden="true"></i>&nbsp;Salir</button>	
				    	<input id="codfamilia" name="codfamilia" value="<?php echo $codfamilia?>" type="hidden">
				    	<input id="codautofacturatmp" name="codautofacturatmp" value="<?php echo $codautofacturatmp?>" type="hidden">	
						<input id="preciototal2" name="preciototal" value="<?php echo $preciototal?>" type="hidden">
						<input id="modif" name="modif" value="0" type="hidden">				    
					</div>
				</td>				
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
		<script type="text/javascript">
		cambio();
		actualizovencimeinto();
		</script>	
			
	</body>
</html>