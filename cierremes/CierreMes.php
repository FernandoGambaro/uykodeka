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
	echo "<script>location.href='../index.php'; </script>";
   //header("Location:../index.php");	

} else {
   $loggedAt=$s->data['loggedAt'];
   $timeOut=$s->data['timeOut'];
   if(isset($loggedAt) && (time()-$loggedAt >$timeOut)){
   	$s->data['act']="timeout";
    	$s->save();  	
  		//header("Location:../index.php");	
		echo "<script>window.top.location.href='../index.php'; </script>";
	   exit;
   }
   $s->data['loggedAt']= time();
   $s->save();
}

$UserID=$s->data['UserID'];
$UserNom=$s->data['UserNom'];
$UserApe=$s->data['UserApe'];
$UserTpo=$s->data['UserTpo'];
$paginacion=$s->data['alto'];
if($paginacion<=0) {
	$paginacion=20;
}
$Seleccionados=array();
$Seleccionados=@$s->data['Selected'];


include ("../conectar.php");
include("../common/verificopermisos.php");
//header('Cache-Control: no-cache');
//header('Pragma: no-cache'); 
setlocale('LC_ALL', 'es_ES');

include ("../funciones/fechas.php");
 
  
$startTime =data_first_month_day('2014-'.$_GET['mes'].'-05'); 
$endTime = data_last_month_day('2014-'.$_GET['mes'].'-05'); 

$sTime=$startTime;
 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title></title>
	<meta name="generator" content="Bluefish 2.2.8" >
	<meta name="created" content="20140722;2825872280191">
	<meta name="changed" content="20140722;231034824935761">
	
	<style type="text/css"><!-- 
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Liberation Sans"; font-size:x-small }
		 -->
	</style>
	
</head>

<body text="#000000">
<table cellspacing="0" border="0">
	<colgroup width="70"></colgroup>
	<colgroup width="169"></colgroup>
	<colgroup width="83"></colgroup>
	<colgroup width="93"></colgroup>
	<colgroup width="71"></colgroup>
	<colgroup width="73"></colgroup>
	<colgroup width="52"></colgroup>
	<colgroup span="4" width="72"></colgroup>
	<tr>
		<td height="26" align="left"><br></td>
		<td colspan=8 align="center" valign=middle><b><i><font size=4>Cierre mes <?php echo genMonth_Text(date('m',strtotime($sTime)));?> de <?php echo date('Y',strtotime($sTime));?></font></i></b></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr>
		<td height="20" align="left"><br></td>
		<td colspan=8 align="center" valign=middle><b><i><font size=3>Detalles compra – venta</font></i></b></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr>
		<td height="22" align="left"><font size=3><br></font></td>
		<td align="left"><font size=3><br></font></td>
		<td align="left"><font size=3><br></font></td>
		<td align="left"><font size=3><br></font></td>
		<td align="left"><font size=3><br></font></td>
		<td align="left"><font size=3><br></font></td>
		<td align="left"><font size=3><br></font></td>
		<td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=2 align="center" valign=middle bgcolor="#B2B2B2"><b><i><font face="ZapfHumnst BT" size=3>Compras</font></i></b></td>
		<td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=2 align="center" valign=middle bgcolor="#B2B2B2"><b><i><font face="ZapfHumnst BT" size=3>Ventas</font></i></b></td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>Fecha</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>Cliente / Proveedor</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>Documento</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>Moneda</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>Importe</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>T/C</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>IVA</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>Total</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>IVA</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" bgcolor="#CCCCCC"><b><i><font face="ZapfHumnst BT" size=3>Total</font></i></b></td>
	</tr>
	
<?php

	$tipo = array( 0=>"Contado", 1=>"Credito", 2=>"Nota Credito");
	$moneda = array();
	
							/*Genero un array con los simbolos de las monedas*/
							$tipomon = array();
							$sel_monedas="SELECT * FROM monedas WHERE borrado=0 AND orden <3 ORDER BY orden ASC";
						   $res_monedas=mysqli_query($GLOBALS["___mysqli_ston"], $sel_monedas);
						   $con_monedas=0;
							$xmon=1;
						 while ($con_monedas < mysqli_num_rows($res_monedas)) {
						 	$descripcion=split(" ", mysqli_result($res_monedas, $con_monedas, "simbolo"));
						 	$moneda[$xmon]= $descripcion[0];
						 	 $con_monedas++;
						 	 $xmon++;
						 }	
	
$Iva_Compras=0;
$Iva_Ventas=0;
$Total_Compras=0;
$Total_Ventas=0;	
$Cant_Ventas=0;
$Cant_Compras=0;	

	while (strtotime($startTime) <= strtotime($endTime)) {
		$startTime = date ("Y-m-d", strtotime("+1 day", strtotime($startTime)));

			$fechaTipoCambio=date ("Y-m-d", strtotime("-1 day", strtotime($startTime)));
			
   		$sel_tipocambio="SELECT valor FROM tipocambio WHERE fecha <='".$fechaTipoCambio."'";
   		$res_tipocambio=mysqli_query($GLOBALS["___mysqli_ston"], $sel_tipocambio);
   		while ($row=mysqli_fetch_array($res_tipocambio)) {
   			$tipocambio=$row['valor'];
   		} 

			$sel_resultado="SELECT codfactura,clientes.nombre as nombre,facturas.fecha as fecha,totalfactura,estado,facturas.tipo,facturas.iva,facturas.moneda,clientes.empresa,clientes.apellido
			FROM facturas,clientes WHERE facturas.borrado=0 AND facturas.codcliente=clientes.codcliente AND fecha ='".$startTime."'";
		
			$res_resultado=mysqli_query($GLOBALS["___mysqli_ston"], $sel_resultado);
		   $contador=0;
		   $marcaestado=0;						   
		   while ($contador < mysqli_num_rows($res_resultado)) { 

				$tipoc=$tipo[mysqli_result($res_resultado, $contador, "tipo")];

				if (!empty(mysqli_result($res_resultado, $contador, "empresa"))) {
					$nombre= mysqli_result($res_resultado, $contador, "empresa");
					} elseif (empty(mysqli_result($res_resultado, $contador, "apellido"))) {
						$nombre= mysqli_result($res_resultado, $contador, "nombre");
					} else {
						$nombre= mysqli_result($res_resultado, $contador, "nombre"). ' ' . mysqli_result($res_resultado, $contador, "apellido");
					}
					
	
/* Sector ventas*/
?>	
	
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" sdval="<?php echo implota($startTime);?>" sdnum="3082;0;DD/MM/AA">
		<font face="GillSans"><?php echo implota($startTime);?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle>
		<font face="GillSans">&nbsp;<?php echo $nombre; ?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo mysqli_result($res_resultado, $contador, "codfactura");?>" sdnum="3082;0;0,00">
		<font face="GillSans"><?php echo mysqli_result($res_resultado, $contador, "codfactura");?>&nbsp;</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">
		<font face="GillSans"><?php echo $moneda[mysqli_result($res_resultado, $contador, "moneda")];?>&nbsp;</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo number_format(mysqli_result($res_resultado, $contador, "totalfactura"),2,",",".");?>" sdnum="3082;0;0,00">
		<font face="GillSans"><?php echo number_format(mysqli_result($res_resultado, $contador, "totalfactura"),2,",",".");?>&nbsp;</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo number_format($tipocambio,3,",",".")?>" sdnum="3082;0;0,00">
		<font face="GillSans"><?php echo number_format($tipocambio,3,",",".")?>&nbsp;</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" sdnum="">
		<font face="GillSans"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" sdnum="">
		<font face="GillSans"><br></font></td>
		<?php
		 $iva = mysqli_result($res_resultado, $contador, "totalfactura")*mysqli_result($res_resultado, $contador, "iva")/(100+mysqli_result($res_resultado, $contador, "iva"));
		 if (mysqli_result($res_resultado, $contador, "moneda")==1){
		 $Iva_Ventas+=$iva;		 
		 $Ventas= number_format($iva,2,",",".");
		 } else {
		 $Iva_Ventas+=$iva*$tipocambio;
		 $Ventas= number_format($iva*$tipocambio,2,",",".");
		 }
		 $iva=0;?>
		 		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo $Ventas;?>" sdnum="3082;0;0,00">
		<font face="GillSans"><?php echo $Ventas;?>&nbsp;</font></td>
		<?php $total= mysqli_result($res_resultado, $contador, "totalfactura");
		 if (mysqli_result($res_resultado, $contador, "moneda")==1){
		 $Total_Ventas+=$total;		 
			$TVentas= number_format($total,2,",","."); 
		 } else {
		 $Total_Ventas+=$total*$tipocambio;
			$TVentas= number_format($total*$tipocambio,2,",","."); 
		 }
		 $total=0; ?>		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" sdval="<?php echo $TVentas;?>" sdnum="3082;0;0,00">
		<font face="GillSans"><?php echo $TVentas;?>&nbsp;</font></td>		 
	</tr>
<?php
	 			$contador++;
	 			$Cant_Ventas++;
			}
/* Sector compras*/
				$sel_resultado="SELECT codfactura,proveedores.nombre as nombre,facturasp.fecha as fecha,proveedores.codproveedor,totalfactura,facturasp.iva,estado,moneda 
				FROM facturasp,proveedores WHERE facturasp.codproveedor=proveedores.codproveedor AND fecha ='".$startTime."'";
						   $res_resultado=mysqli_query($GLOBALS["___mysqli_ston"], $sel_resultado);
						   $contador=0;						   
						   while ($contador < mysqli_num_rows($res_resultado)) { 
?>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" sdval="<?php echo implota($startTime);?>" sdnum="3082;0;DD/MM/AA">
		<font face="GillSans"><?php echo implota($startTime);?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle>
		<font face="GillSans">&nbsp;<?php echo mysqli_result($res_resultado, $contador, "nombre")?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right">
		<font face="GillSans"><?php echo mysqli_result($res_resultado, $contador, "codfactura")?>&nbsp;</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">
		<font face="GillSans"><?php echo $moneda[mysqli_result($res_resultado, $contador, "moneda")];?>&nbsp;</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo number_format(mysqli_result($res_resultado, $contador, "totalfactura"),2,",",".")?>" sdnum="3082;0;0,00">
		<font face="GillSans"><?php echo number_format(mysqli_result($res_resultado, $contador, "totalfactura"),2,",",".")?>&nbsp;</font></td>
		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo number_format($tipocambio,3,",",".")?>" sdnum="3082;0;0,000">
		<font face="GillSans"><?php echo number_format($tipocambio,3,",",".")?>&nbsp;</font></td>
		<?php
		 $iva = mysqli_result($res_resultado, $contador, "totalfactura")*mysqli_result($res_resultado, $contador, "iva")/(100+mysqli_result($res_resultado, $contador, "iva"));
		 if (mysqli_result($res_resultado, $contador, "moneda")==1){
		 $Iva_Compras+=$iva;		 
		 $Compras= number_format($iva,2,",",".");
		 } else {
		 $Iva_Compras+=$iva*$tipocambio;
		 $Compras= number_format($iva*$tipocambio,2,",",".");
		 }
		 $iva=0;?>	
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo $Compras;?>" sdnum="3082;0;0,00">
		<font face="GillSans"><?php echo $Compras;?>&nbsp; </font></td>
		<?php $total= mysqli_result($res_resultado, $contador, "totalfactura");
		 if (mysqli_result($res_resultado, $contador, "moneda")==1){
		 $Total_Compras+=$total;		 
			$TCompras= number_format($total,2,",","."); 
		 } else {
		 $Total_Compras+=$total*$tipocambio;
			$TCompras= number_format($total*$tipocambio,2,",","."); 
		 }
		 $total=0; ?>		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" sdval="<?php echo $TCompras;?>" sdnum="3082;0;0,00">
		<font face="GillSans"><?php echo $TCompras;?>&nbsp;</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" sdnum="3082;0;0,000">
		<font face="GillSans"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" sdnum="3082;0;0,00">
		<font face="GillSans"><br></font></td>
	</tr>
<?php
		$contador++;
		$Cant_Compras++;	
		}

	}

?>	


	<tr>
		<td height="18" align="left" colspan="2">Documentos&nbsp;Compras: <?php echo $Cant_Compras;	?></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td style="border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=2 align="center" valign=middle sdnum="3082;0;0,00"><b><i><u><font face="ZapfHumnst BT">Compras</font></u></i></b></td>
		<td style="border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=2 align="center" valign=middle><b><i><u><font face="ZapfHumnst BT">Ventas</font></u></i></b></td>
		</tr>
	<tr>
		<td height="18" align="left" colspan="2">Documentos&nbsp;Ventas: <?php echo $Cant_Ventas;	?></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#FFFF00" sdval="<?php echo number_format($Iva_Compras,2,",",".");?>" sdnum="3082;0;0,00">
		<font face="ZapfHumnst BT"><?php echo number_format($Iva_Compras,2,",",".");?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#FFFF00" sdval="<?php echo number_format($Total_Compras,2,",",".");?>" sdnum="3082;0;0,00">
		<font face="ZapfHumnst BT"><?php echo number_format($Total_Compras,2,",",".");?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#FFFF00" sdval="<?php echo number_format($Iva_Ventas,2,",",".");?>" sdnum="3082;0;0,00">
		<font face="ZapfHumnst BT"><?php echo number_format($Iva_Ventas,2,",",".");?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" bgcolor="#FFFF00" sdval="<?php echo number_format($Total_Ventas,2,",",".");?>" sdnum="3082;0;0,00">
		<font face="ZapfHumnst BT"><?php echo number_format($Total_Ventas,2,",",".");?></font></td>
	</tr>
	<tr>
		<td height="17" align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr>
		<td height="17" align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr>
		<td colspan=3 height="20" align="center" valign=middle><b><font size=3>Ultimo Pago DGI: __/__/____</font></b></td>
		<td align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#B2B2B2">
		<b><font size=3><?php echo genMonth_Text(date('m',strtotime($sTime)));?></font></b></td>
		<td align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#B2B2B2">
		<b><font size=3>Resguardo <?php echo genMonth_Text(date('m',strtotime($sTime)));?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#B2B2B2">
		<b><font size=3>Acumulado <?php echo genMonth_Text(date('m',strtotime($sTime)));?></font></b></td>
		</tr>
<?php 
/*Pagos DGI*/

?>	
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="left" valign=middle>108 – IRAE Anticipo:</td>
		<td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" sdval="3270" sdnum="3082;">
		3270</td>
		<td align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" bgcolor="#CCCCCC">Saldo IVA</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo number_format($Iva_Ventas-$Iva_Compras,2,",",".");?>" sdnum="3082;0;0,00">
<?php echo number_format($Iva_Ventas-$Iva_Compras,2,",",".");?>		
		</td>
		<td align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" bgcolor="#CCCCCC">Importe</td>
<?php
/* Resguardo */

?>		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" sdnum="3082;0;0,00">&nbsp;55
<?php
/*Acumulados*/


?>	
		<br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" bgcolor="#CCCCCC">IVA</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">
		<br></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="left" valign=middle>328 – Impuesto al Patrimonio Anticipo:</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" sdval="928" sdnum="3082;">
		928</td>
		<td align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" bgcolor="#CCCCCC">Saldo Total</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="<?php echo number_format($Total_Ventas-$Total_Compras,2,",",".");?>" sdnum="3082;">
		<?php echo number_format($Total_Ventas-$Total_Compras,2,",",".");?>		
		</td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" bgcolor="#CCCCCC">Total</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">
		<br></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="left" valign=middle>546 – IVA Contribuyentes No CEDE :</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left">
		<br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="left" valign=middle>606 – ICOSA Anticipo:</td>
		<td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left">
		<br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
</table>
<!-- ************************************************************************** -->
</body>

</html>
