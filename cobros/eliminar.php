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
	$idmov=$_GET["idmov"];
	$codfactura=$_GET["codfactura"];
	$fechacobro=$_GET["fechacobro"];
	$importe=$_GET["importe"];
	$importe="-".$importe;
	$fecha=explota($fechacobro);
	$act_factura="DELETE FROM cobros WHERE id='$idmov' AND codfactura='$codfactura'";
	$rs_act=mysqli_query($GLOBALS["___mysqli_ston"], $act_factura);
	
	//1 compra
	//2 venta

	$sel_libro="INSERT INTO librodiario (id,fecha,tipodocumento,coddocumento,codcomercial,codformapago,numpago,moneda,total) VALUES 
	('','$fecha','2','$codfactura','','','',,'$moneda','$importe')";
	$rs_libro=mysqli_query($GLOBALS["___mysqli_ston"], $sel_libro);

?>
</body>
</html>
