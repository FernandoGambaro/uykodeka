<html>
<head>
<title>Buscador de Articulos</title>
<script>
var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
function buscar() {
	if (document.getElementById("iniciopagina").value=="") {
		document.getElementById("iniciopagina").value=1;
	} else {
		document.getElementById("iniciopagina").value=document.getElementById("paginas").value;
	}
	document.getElementById("form1").submit();
	document.getElementById("tabla_resultado").style.display="";
}

function inicio() {

	var combo_familia=document.getElementById("cmbfamilia").value;
	if (combo_familia==0) {
		buscar();
	} else {
		document.getElementById("tabla_resultado").style.display="none";
	}
			
}

function paginar() {
	document.getElementById("iniciopagina").value=document.getElementById("paginas").value;
	document.getElementById("form1").submit();
}

function enviar() {
	document.getElementById("form1").submit();
}

</script>
<script language="javascript">

function pon_prefijo_a(codfamilia,pref,nombre,descripcion_corta,precio,codarticulo,moneda) {
	parent.pon_prefijo_Fb(codfamilia,pref,nombre,descripcion_corta,precio,codarticulo,moneda);
}

		function cancelar() {
			parent.$('idOfDomElement').colorbox.close();
		}
</script>

<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<?php 
include ("../conectar.php"); 
$codproveedor=$_GET["codproveedor"];
?>
<body onLoad="buscar();">
<form name="form1" id="form1" method="post" action="frame_articulos.php" target="frame_resultado" onSubmit="buscar()">
 <div align="center">
	<table class="fuente8" align="center">
     <tr>
	    <td>Familia:</td>
	    <td>
		  <select id="cmbfamilia" name="cmbfamilia" class="comboGrande">
		  <?php
		    $consultafamilia="select * from familias where borrado=0 order by nombre ASC";
			$queryfamilia=mysqli_query($GLOBALS["___mysqli_ston"], $consultafamilia);
			?><option value=0>Todos los articulos</option><?php
			while ($rowfamilia=mysqli_fetch_row($queryfamilia))
			  { 
			  	if ($anterior==$rowfamilia[0]) { ?>
					<option value="<?php echo $rowfamilia[0]?>" selected><?php echo utf8_encode($rowfamilia[1])?></option>
			<?php	} else { ?>
					<option value="<?php echo $rowfamilia[0]?>"><?php echo utf8_encode($rowfamilia[1])?></option>
			<?php	}   
		   	  };
		  ?>
	    </select></td>
		<td class="busqueda">Referencia:</td>
	    <td><input name="referencia" type="text" id="referencia" size="20" class="cajaMedia"></td></tr>
		<tr><td class="busqueda">Descripci&oacute;n:</td>
	    <td><input name="descripcion" type="text" id="descripcion" size="50" class="cajaGrande"></td>
		<td class="busqueda">Mostrar todos los art&iacute;culos:</td>
	    <td><select name="todos" id="todos" class="comboPequeno">
						<option value=0 selected="selected">No</option>
						<option value=1>Si</option>
						</select></td></tr>
		<tr>

		  <td colspan="4" align="center"><img id="botonBusqueda" src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="enviar();" onMouseOver="style.cursor=cursor"></td>
	  </tr>
</table>
</div>
  <table width="95%" id="tabla_resultado" name="tabla_resultado" style="display:none" align="center">
	<tr>
  		<td>
			<iframe width="100%" height="300" id="frame_resultado" name="frame_resultado">
				<ilayer width="100%" height="300" id="frame_resultado" name="frame_resultado"></ilayer>
			</iframe>
		</td>
	</tr>
</table>
<input type="hidden" id="iniciopagina" name="iniciopagina">
<input type="hidden" id="codproveedor" name="codproveedor" value="<?php echo $codproveedor?>">
<table width="100%" border="0">
  <tr>
    <td><div align="center">
      <img id="botonBusqueda" src="../img/botoncerrar.jpg" width="70" height="22" onClick="cancelar();" border="1" onMouseOver="style.cursor=cursor">
    </div></td>
  </tr>
</table>

</form>
</div>
</body>
</html>
