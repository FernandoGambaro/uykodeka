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
		echo "<script>window.top.location.href='../index.php'; </script>";
	   exit;
} else {
   $loggedAt=$s->data['loggedAt'];
   $timeOut=$s->data['timeOut'];
   if(isset($loggedAt) && (time()-$loggedAt >$timeOut)){
   	$s->data['act']="timeout";
    	$s->save();  	
              echo "<script>window.parent.changeURL('../index.php' ); </script>";
	       /*/header("Location:../index.php");	*/
	       exit;
   }
   $s->data['loggedAt']= time();/*/ update last accessed time*/
   $s->save();
}

$UserID=$s->data['UserID'];
$UserNom=$s->data['UserNom'];
$UserApe=$s->data['UserApe'];
$UserTpo=$s->data['UserTpo'];

include ("../conectar.php");
include("../common/verificopermisos.php");
//header('Content-Type: text/html; charset=UTF-8'); 

$cadena_busqueda=isset($_GET["cadena_busqueda"]) ? @$_GET["cadena_busqueda"] : null ;

if (!isset($cadena_busqueda)) { $cadena_busqueda=""; } else { $cadena_busqueda=str_replace("",",",$cadena_busqueda); }

if ($cadena_busqueda<>"") {
	$array_cadena_busqueda=split("~",$cadena_busqueda);
	$codcliente=$array_cadena_busqueda[1];
	$nombre=$array_cadena_busqueda[2];
	$cboEstados=$array_cadena_busqueda[3];
	$fechainicio=$array_cadena_busqueda[4];
	$fechafin=$array_cadena_busqueda[5];
	$moneda=$array_cadena_busqueda[6];
} else {
	$codcliente="";
	$nombre="";
	$cboEstados="";
	$fechainicio="";
	$fechafin="";
	$moneda='';
}

				$sel_resultado="SELECT * FROM monedas WHERE borrado=0 AND orden <3 ORDER BY orden ASC";
			   $res_resultado=mysqli_query($GLOBALS["___mysqli_ston"], $sel_resultado);
$moneda1=mysqli_result($res_resultado,0, "descripcion")." ".mysqli_result($res_resultado,0, "simbolo");
$moneda2=mysqli_result($res_resultado,1, "descripcion")." ".mysqli_result($res_resultado,1, "simbolo");

?>
<html>
	<head>
		<title>Cobros</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		
		<script src="../calendario/jscal2.js"></script>
		<script src="../calendario/lang/es.js"></script>
		<link rel="stylesheet" type="text/css" href="../calendario/css/jscal2.css" />
		<link rel="stylesheet" type="text/css" href="../calendario/css/border-radius.css" />
		<link rel="stylesheet" type="text/css" href="../calendario/css/win2k/win2k.css" />		
		<script src="js/jquery.min.js"></script>
		<link rel="stylesheet" href="js/colorbox.css" />
		<script src="js/jquery.colorbox.js"></script>

		<script src="../js3/jquery.maskedinput.js" type="text/javascript"></script>

<!-- iconos para los botones -->       
<link rel="stylesheet" href="../css3/css/font-awesome.min.css">

<script type="text/javascript">
parent.document.getElementById("msganio").innerHTML="<i class='fa fa-long-arrow-right' aria-hidden='true'></i>&nbsp;  Cobros rápido ";

$(document).ready( function()
{
$("form:not(.filter) :input:visible:enabled:first").focus();
var body = document.body,
    html = document.documentElement;
var height = Math.max( body.scrollHeight, body.offsetHeight, 
                       html.clientHeight, html.scrollHeight, html.offsetHeight );	
var width = Math.max( body.scrollWidth, body.offsetWidth, 
                       html.clientWidth, html.scrollWidth, html.offsetWidth );
    width=width-10;

    height=height-158;

    document.getElementById("frame_rejilla").height = (height) + "px";
    document.getElementById("frame_rejilla").width = (width) + "px";


		$(".callbacks").colorbox({
			iframe:true, width:"99%", height:"99%",
			onCleanup:function(){ window.location.reload();	}
		});

});

jQuery(function($){
   $("#fechafin").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
   $("#fechainicio").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});

});
</script>
<script type="text/javascript">
function OpenNote(noteId,w,h, scrol){
	$.colorbox({
	   	href: noteId, open:true,
			iframe:true, width:w, height:h,
			scrolling: false,
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

function pon_prefijo(pref,nombre,nif) {

	$("#codcliente").val(pref);
	$("#nombre").val(nombre);
	$("#nif").val(nif);
	$('idOfDomElement').colorbox.close();
	document.getElementById("form_busqueda").submit();

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
		
	
		function inicio() {
			document.getElementById("firstdisab").style.display = 'block';
			document.getElementById("prevdisab").style.display = 'block';
			document.getElementById("last").style.display = 'block';
			document.getElementById("next").style.display = 'block';
			document.getElementById("form_busqueda").submit();			
		}
		
		function buscar() {
			var cadena;
			cadena=hacer_cadena_busqueda();
			document.getElementById("cadena_busqueda").value=cadena;
			if (document.getElementById("iniciopagina").value=="") {
				document.getElementById("iniciopagina").value=1;
			} else {
				document.getElementById("iniciopagina").value=document.getElementById("paginas").value;
			}
			document.getElementById("form_busqueda").submit();
		}
		
		function paginar() {
			document.getElementById("iniciopagina").value=document.getElementById("paginas").value;
			document.getElementById("form_busqueda").submit();
		}

		function firstpage() {
			document.getElementById("iniciopagina").value=document.getElementById("firstpagina").value;
			document.getElementById("form_busqueda").submit();
		}
		function prevpage() {
			document.getElementById("iniciopagina").value=document.getElementById("prevpagina").value;
			document.getElementById("form_busqueda").submit();
		}
		function nextpage() {
			document.getElementById("iniciopagina").value=document.getElementById("nextpagina").value;
			document.getElementById("form_busqueda").submit();
		}
		function lastpage() {
			document.getElementById("iniciopagina").value=document.getElementById("lastpagina").value;
			document.getElementById("form_busqueda").submit();
		}
		
		function hacer_cadena_busqueda() {
			var codcliente=document.getElementById("codcliente").value;
			var nombre=document.getElementById("nombre").value;
			var cboEstados=document.getElementById("cboEstados").value;			
			var fechainicio=document.getElementById("fechainicio").value;
			var fechafin=document.getElementById("fechafin").value;
			var moneda=$("#fechafin").val();
			var cadena="";
			cadena="~"+codcliente+"~"+nombre+"~"+cboEstados+"~"+fechainicio+"~"+fechafin+"~"+moneda+"~";
			return cadena;
			}

		function limpiar() {
			document.getElementById("form_busqueda").reset();
			$('#codcliente').val('');
			document.getElementById("iniciopagina").value=1;
			document.getElementById("form_busqueda").submit();
		}		
		function abreVentana(){
			$.colorbox({
	   	href: "ver_clientes.php", open:true,
			iframe:true, width:"99%", height:"99%"
			});			
		}
		
		function validarcliente(){
			var codigo=document.getElementById("codcliente").value;
			$.colorbox({
	   	href: "comprobarcliente.php?codcliente="+codigo, open:true,
			iframe:true, width:"99%", height:"99%"
			});
		}		
		</script>

<link href="../js3/jquery-ui.css" rel="stylesheet">
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

		$("#codcliente").val(pref);
		$("#nombre").val(nombre);
		 document.getElementById('form_busqueda').submit();
		}
	}).autocomplete("widget").addClass("fixed-height");
});
</script>		
	</head>
	<body onLoad="inicio();">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="frmBusqueda">
				<form id="form_busqueda" name="form_busqueda" method="post" action="rejilla.php" target="frame_rejilla">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0><tr><td valign="top" width="50%">					
						<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td valign="top" rowspan="3">
						<fieldset><legend>&nbsp;Pendiente de cobro&nbsp;</legend>
						<table class="fuente8" cellspacing=0 cellpadding=3 border=0>
						<tr><td><?php echo $moneda1;?></td><td><div id="TotalPesos"></div></td></tr>
						<tr><td><?php echo $moneda2;?></td><td><div id="TotalDolar"></div></td></tr></table>
						</fieldset></td>
							<td valign="top">Nombre</td>
							<td valign="top"><input id="codcliente" type="hidden" class="cajaPequena" name="codcliente">
							<input id="nombre" name="nombre" type="text" class="cajaGrande" maxlength="45" value="<?php echo $nombre;?>"></td>
						</tr>
						<tr>
<td valign="top">Moneda</td><td valign="top">
		 					<select  name="moneda" id="moneda" class="comboPequeno" data-index="4">
		 					<option value="">Seleccione uno</option>
<?php
						//$sel_resultado="SELECT * FROM monedas WHERE borrado=0 AND orden <3 ORDER BY orden ASC";
//						   $res_resultado=mysqli_query($GLOBALS["___mysqli_ston"], $sel_resultado);
						   $contador=0;
							$xmon=1;
						 while ($contador < mysqli_num_rows($res_resultado)) { 
						 			if ($moneda==$xmon) {
						 				?>
						 				<option value="<?php echo $xmon;?>" selected="selected"><?php echo mysqli_result($res_resultado, $contador, "simbolo");?></option>
 										<?php
						 			} else {
						 				?>
						 				<option value="<?php echo $xmon;?>"><?php echo mysqli_result($res_resultado, $contador, "simbolo");?></option>
 										<?php
									}
									$xmon++;						 
						 $contador++;
						 }						
						?>
						</select>
						<td>						
						</tr>
						</table></td><td valign="top">
						<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td>Estado</td>
							<td><select id="cboEstados" name="cboEstados" class="comboMedio">
								<option value="0" >Todos los estados</option>
								<option value="1" selected>Sin cobrar</option>
								<option value="2">Cobrada</option>			
								</select></td>
					    </tr>
					  <tr>
						  <td>Fecha de inicio</td>
						  <td><input id="fechainicio" type="text" class="cajaPequena" name="fechainicio" maxlength="10" value="<?php echo $fechainicio?>" >
						  <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'" title="Calendario"  style="vertical-align: middle; margin-top: -1px;">
								<script type="text/javascript">
						   Calendar.setup({
						     inputField : "fechainicio",
						     trigger    : "Image1",
						     align		 : "Bl",
						     onSelect   : function() { this.hide() },
						     dateFormat : "%d/%m/%Y"
						   });
						</script></td>
						  <td>
							<button class="boletin" onClick="buscar();" onMouseOver="style.cursor=cursor"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar</button>
						</td>
					  </tr>
						<tr>
						  <td>Fecha de fin</td>
						  <td><input id="fechafin" type="text" class="cajaPequena" name="fechafin" maxlength="10" value="<?php echo $fechafin?>" >
						  <img src="../img/calendario.png" name="Image11" id="Image11" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" style="vertical-align: middle; margin-top: -1px;">
								<script type="text/javascript">
						   Calendar.setup({
						     inputField : "fechafin",
						     trigger    : "Image11",
						     align		 : "Bl",
						     onSelect   : function() { this.hide() },
						     dateFormat : "%d/%m/%Y"
						   });
						</script></td>
						<td>
			 	<button class="boletin" onClick="limpiar();" onMouseOver="style.cursor=cursor"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Limpiar</button>
						</td>
					  </tr>
					</table></td></tr></table>
			  </div>
		<div id="lineaResultado">
			  <table class="fuente8" width="90%" cellspacing=0 cellpadding=3 border=0 style="max-width: 800px;">
			  	<tr>
				<td width="30%" align="left">Cobros encontrados <input id="filas" type="text" class="cajaPequena" name="filas" maxlength="5" readonly></td>
				<td width="50%" align="center">
				</td>
			<td width="20%" align="right">
		<table class="fuente8" cellspacing=1 cellpadding=1 border=0>
		<td>				
		<input type="hidden" id="firstpagina" name="firstpagina" value="1">
		<img style="display: none;" src="../img/paginar/first.gif" id="first" border="0" height="13" width="13" onClick="firstpage();" onMouseOver="style.cursor=cursor">
		<img style="display: none;" src="../img/paginar/firstdisab.gif" id="firstdisab" border="0" height="13" width="13"></td>
		<td>
		<input type="hidden" id="prevpagina" name="prevpagina" value="">
		<img style="display: none;" src="../img/paginar/prev.gif" id="prev" border="0" height="13" width="13" onClick="prevpage();" onMouseOver="style.cursor=cursor">
		<img style="display: none;" src="../img/paginar/prevdisab.gif" id="prevdisab" border="0" height="13" width="13">
		</td><td>
		<input id="currentpage" type="text" class="cajaMinima" >
		</td><td>
		<input type="hidden" id="nextpagina" name="nextpagina" value="">
		<img style="display: none;" src="../img/paginar/next.gif" id="next" border="0" height="13" width="13" onClick="nextpage();" onMouseOver="style.cursor=cursor">
		<img style="display: none;" src="../img/paginar/nextdisab.gif" id="nextdisab" border="0" height="13" width="13"></td>
		<td>
		<input type="hidden" id="lastpagina" name="lastpagina" value="">
		<img style="display: none;" src="../img/paginar/last.gif" id="last" border="0" height="13" width="13" onClick="lastpage();" onMouseOver="style.cursor=cursor">
		<img style="display: none;" src="../img/paginar/lastdisab.gif" id="lastdisab" border="0" height="13" width="13"></td>
		<td>Mostrados</td><td> <select name="paginas" id="paginas" onChange="paginar();" class="comboPequeno">
		          </select></td> 
		</table>	</td>										
				</table>
				</div>
				<input type="hidden" id="iniciopagina" name="iniciopagina">
				<input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
				<input type="hidden" id="selid" name="selid">				
			</form>
					<iframe width="95%" height="300" id="frame_rejilla" name="frame_rejilla" frameborder="0" style="max-width: 800px;">
						<ilayer width="95%" height="300" id="frame_rejilla" name="frame_rejilla"></ilayer>
					</iframe>
				<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
				</div>
		  </div>			
		</div>
	</body>
</html>