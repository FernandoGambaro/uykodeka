<?php
//header('Cache-Control: no-cache');
//header('Pragma: no-cache'); 
?>
<html>
<head>
</head>
<?php include ("../conectar.php"); 
include ("../funciones/fechas.php");
?>
<body>
<?php
	$fechavencimiento=$_GET["fechavencimiento"];
	$fechavencimiento=explota($fechavencimiento);
	$codfactura=$_GET["codfactura"];
	$act_factura="UPDATE facturas SET fechavencimiento='$fechavencimiento' WHERE codfactura='$codfactura'";
	$rs_act=mysqli_query($GLOBALS["___mysqli_ston"], $act_factura);
?>
</body>
</html>
