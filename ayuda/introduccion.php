<?php

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title></title>
	<meta name="generator" content="Bluefish 2.2.8" />
	<meta name="created" content="2016-01-22T12:23:01.957749250"/>
	<meta name="changed" content="2017-03-09T19:41:03.538305369"/>
	<style type="text/css">
		@page { margin-left: 1.6cm; margin-right: 1.6cm; margin-top: 1.4cm; margin-bottom: 1.4cm }
		p { margin-bottom: 0.25cm; line-height: 120% }
	</style>
</head>
<body lang="es-UY" dir="ltr">
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="4" style="font-size: 14pt"><b>UYCODEKA
actualización Marzo 2017</b></font></font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><i><u><b>Nuevas
características.</b></u></i></font>

</p>

<font face="GillSans, sans-serif">Marzo 2017</font>

<br/>

</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%; text-decoration: none">
<font face="GillSans, sans-serif"><b>Inicio: </b><span style="font-weight: normal">Cambio
de la pantalla de login</span><span style="font-weight: normal">.</span></font>

<br />

<font face="GillSans, sans-serif">Febrero 2017</font>

<br/>

</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%; text-decoration: none">
<font face="GillSans, sans-serif"><b>Depuración de código: </b><span style="font-weight: normal">S</span><span style="font-weight: normal">e
</span><span style="font-weight: normal">han </span><span style="font-weight: normal">depurado
el código</span><span style="font-weight: normal">, si bien no
afectaban el funcionamiento del sistema, aparecían </span><span style="font-weight: normal">algunos
errores</span><span style="font-weight: normal"> en los logs</span><span style="font-weight: normal">,
</span><span style="font-weight: normal">como ser variables no
definidas.</span></font>

<br/>

</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%; text-decoration: none">
<font face="GillSans, sans-serif"><b>Menú <font face="Liberation Sans, sans-serif">→
</font><font face="Liberation Sans, sans-serif">Mantenimiento </font><font face="Liberation Sans, sans-serif">→</font><font face="Liberation Sans, sans-serif">
Tipo de cambio</font>:</b><span style="font-weight: normal"> </span><span style="font-weight: normal">Se
actualizo la forma de obtener la cotización del dolar, ahora se
utiliza web services del BCU</span><span style="font-weight: normal">.</span></font>

<br/>

</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%; text-decoration: none">
<font face="GillSans, sans-serif"><b>Menú</b><font face="Verdana"><span style="font-weight: normal">
</span></font><b><font face="Liberation Sans, sans-serif">→</font></b><font face="Verdana"><span style="font-weight: normal">
</span></font><b>Documentos:  </b><span style="font-weight: normal">A</span><span style="font-weight: normal">
</span><span style="font-weight: normal">la </span><span style="font-weight: normal">facturas
automáticas </span><span style="font-weight: normal">se le agrego la
posibilidad de hacerlas manualmente</span><span style="font-weight: normal">.</span></font>


</p>

<font face="GillSans, sans-serif">Noviembre 2016</font>


</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%; text-decoration: none">
<font face="GillSans, sans-serif"><b>Migrar de mysql a mysqli: </b><span style="font-weight: normal">Hemos
comenzado la migración a mysqli pensando en la próxima
actualización a php 7, </span><span style="font-weight: normal">para
ello utilizamos MySQLConverterTool-master e incorporamos una función
</span><span style="font-weight: normal">mysqli_result() para
mantener la compatibilidad con el código anterior, lo que nos
permitirá ir actualizando el código mientras realizamos mejoras,
sin forzar a cambiar todo el código.</span></font>

<br/>

</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%; text-decoration: none">
<font face="GillSans, sans-serif"><b>Menú: </b><span style="font-weight: normal">Re-diseño
y re-organización completo del menú, agrupando por categoría,
siendo mas amigable a la vista.</span></font>


</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%; text-decoration: none">
<font face="GillSans, sans-serif"><b><font face="Liberation Sans, sans-serif">Impresión</font><font face="Liberation Sans, sans-serif">
→ </font><font face="Liberation Sans, sans-serif">Facturas cliente</font>:</b><span style="font-weight: normal">
</span><span style="font-weight: normal">Modificamos la impresión de
facturas, al utilizar UYCODEKA desde la misma red del servidor y
teniendo la impresora de facturación conectada al mismo, la factura
se envía directamente a dicha impresora</span><span style="font-weight: normal">.
</span><span style="font-weight: normal">Si se esta fuera de la red
del servidor genera un PDF de la factura para poder imprimir luego.</span></font>

<br/>

</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%; text-decoration: none">
<font face="GillSans, sans-serif"><b>Menú</b><font face="Verdana"><span style="font-weight: normal">
</span></font><b><font face="Liberation Sans, sans-serif">→</font></b><font face="Verdana"><span style="font-weight: normal">
</span></font><b>Documentos:  </b><span style="font-weight: normal">Incorporamos
la posibilidad de programar facturas automáticas para aquellos
service o productos que facturamos normalmente todos los meses,
pudiendo seleccionar en que altura del mes se emite. Nota: siempre es
a mes vencido.</span></font>

<br/>

</p>

<br/>

</p>

<font face="GillSans, sans-serif">Abril 2016.</font>

<br/>

</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Productos<font face="Liberation Sans, sans-serif">
→ </font>Artículos en transito:</b><span style="font-weight: normal">
 Se incorporó la posibilidad de gestionar artículos en transito
para el traslado de los mismo a clientes, generando vía para el
</span><span style="font-weight: normal">transportista.</span></font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Venta
clientes </b><font face="Liberation Sans, sans-serif"><b>→</b></font><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt"><span style="font-weight: normal">
</span></font></font><font face="GillSans, sans-serif"><font size="3" style="font-size: 12pt"><b>Nota
de crédito</b></font></font><font face="GillSans, sans-serif"><font size="3" style="font-size: 12pt"><b>:</b></font></font><font face="GillSans, sans-serif"><font size="3" style="font-size: 12pt"><span style="font-weight: normal">
</span></font></font><font face="GillSans, sans-serif"><font size="3" style="font-size: 12pt"><span style="font-weight: normal">Gestión
independiente de las notas de crédito, </span></font></font><font size="3" style="font-size: 12pt"><span style="font-weight: normal">seleccionando
cliente, aparecen las facturas de ese cliente y para cada una de esas
facturas se pueden seleccionar los elementos.</span></font></font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Tesorería</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><b>Recibos:</b>  Nueva forma de gestionar los cobros,
donde por cada recibo pueden haber varias facturas y varios
documentos de cobro, (aún no trabaja con cobros parciales). Permite
en envío por mail de un recibo al cliente con los detalles del
mismo.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Reportes</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><b>Reportes General:</b> Reporte de liquidación de
comisiones exportable a Excel.</font>


</p>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><i><u><b>Mejoras
introducidas.</b></u></i></font>


</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%"><font face="GillSans, sans-serif"><b>En
general: </b><span style="font-weight: normal">Ajuste de tablas para
la validación de datos en la facturación electrónica en Uruguay.</span></font>
<p style="margin-bottom: 0cm; font-style: normal; font-weight: normal; line-height: 100%">
<br/>

</p>


</p>

<font face="GillSans, sans-serif"><b>Re</b><b>jillas</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><font face="Liberation Sans, sans-serif"><b>En</b></font><b>
General:</b> Se corrigió el despliegue de los ítems de cada
rejilla, habilitando mostrar el máximo óptimo posible.</font>


</p>

<font face="GillSans, sans-serif"><b>Proveedores</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><font face="Liberation Sans, sans-serif"><b>Ingreso de
facturas</b></font><b>:</b> Se corrigió el ajuste de stock al
ingresar nuva factura de combra, y al eliminar factura de compra.</font>


</p>

<font face="GillSans, sans-serif"><b>Ventas</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><font face="Liberation Sans, sans-serif"><b>Facturas</b></font><b>:</b>
Para poder seleccionar un producto tiene que haber stock suficiente.</font>


</p>

<font face="GillSans, sans-serif"><b>Tesorería</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><font face="Liberation Sans, sans-serif"><b>Pago DGI</b></font><b>:</b>
Se modificó el listado de pagos realizados, así como la búsqueda y
la impresión del listado de pagos realizados según opciones de
búsqueda.</font>


</p>

<font face="GillSans, sans-serif"><font face="Liberation Sans, sans-serif"><b>Reportes</b></font><font face="Liberation Sans, sans-serif"><b>
→ </b></font><font face="Liberation Sans, sans-serif"><b>Cierre
mes</b></font><b>:</b> Se corrigió el cálculo del IVA en el reporte
de Cierre anualizado.</font>

</p>

<font face="GillSans">Abril 2016.</font>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%"><br/>

</p>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%"><font face="GillSans, sans-serif"><b>En
general: </b><span style="font-weight: normal">Resalta la fila al
seleccionarla (en varios módulos).</span></font>
<p style="margin-bottom: 0cm; font-style: normal; font-weight: normal; line-height: 100%">
<font face="GillSans, sans-serif">	La ventana de selección de
clientes se unifico el tamaño en los módulos.</font>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%"><font face="GillSans, sans-serif"><span style="font-weight: normal">	</span><span style="font-weight: normal">Se
puede modificar la cantidad de datos a listar, por defecto son 10.</span></font>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%"><font face="GillSans, sans-serif"><span style="font-weight: normal">	</span><span style="font-weight: normal">La
cantidad de registros a mostrar se calcula según en tamaño de la
ventana </span><span style="font-weight: normal">de la página
inicio</span><span style="font-weight: normal">.</span></font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Mantenimiento</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><b>Usuarios: </b>Se agrego la característica de
Vendedor a los usuarios.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Mantenimiento</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><b>Forma de pago:</b> Se agrego un campo para el
ingreso manual de los días equivalente a la descripción.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Mantenimiento</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><font face="Liberation Sans, sans-serif"><b>Datos del
sistema</b></font><b>:</b> Se cambio el editor de texto para el
mensaje de email.</font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif">			Se
puede configurar una impresora remota para la facturación y otra
para los reportes, de modo que al abrir el PDF de la factura o
reporte éste se imprima directamente.</font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif">			Se
agrego configurar un servidor auxiliar donde guardar las imágenes.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Inter.
Comerciales:</b> Se agrego a Clientes y Proveedores mostrar la su
ubicación en googlemaps.</font>
<p style="margin-bottom: 0cm; font-style: normal; line-height: 100%"><br/>

</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Inter.
Comerciales</b><font face="Liberation Sans, sans-serif"><b> →
</b></font><b>Cliente: </b>Se incorporaron nuevos campos de datos
(Recepción de mercadería, Días de pago, Agencias de cargas),
selección de ejecutivo de cuentas, para posterior liquidación de
comisiones.</font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif">	Exportar
la lista de clientes directamente a Excel, seleccionando el nombre
del archivo.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Inter.
Comerciales</b><font face="Liberation Sans, sans-serif"><b> →
</b></font><b>Proveedores:</b> Se agrego el cambio de campo
utilizando Enter.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Productos</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><b>Artículos:</b> Se incorporaron campos nuevos y
mejoró la distribución de los campos. Campo Comisión (cada
artículo se le asigna un % de comisión para el vendedor).</font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif">	Calcula
el precio final según el IVA seleccionado y el precio público.</font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif">	Genera
un código QR con información de cada artículo, como ser datos de
la ubicación.</font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif">	Se
puede guardar las imágenes en otro servidor.</font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif">	Exportar
directamente a Excel, con varias opciones seleccionando el nombre del
archivo.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Productos</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><b>Familias de artículos:</b> Se incorporo insertar
una imagen descriptiva.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Ventas
cliente<font face="Liberation Sans, sans-serif"> → </font>Facturas:</b><span style="font-weight: normal">
Se eliminó el ingresar en n.º en forma manual, ahora se asigna en
forma automáti</span><span style="font-weight: normal">c</span><span style="font-weight: normal">a.</span></font>
<p style="margin-bottom: 0cm; font-weight: normal; line-height: 100%">
<font face="GillSans, sans-serif">	Se habilito en cambio de campo al
presionar Enter, al llegar al Código de artículo ingresa
automáticamente a seleccionar uno.</font>
<p style="margin-bottom: 0cm; font-weight: normal; line-height: 100%">
<font face="GillSans, sans-serif">	Se agregó la búsqueda automática
al escribir en el campo Descripción.</font>
<p style="margin-bottom: 0cm; font-weight: normal; line-height: 100%">
<font face="GillSans, sans-serif">	Se muestra el % de comisión a la
derecha de la acción.</font>
<p style="margin-bottom: 0cm; font-weight: normal; line-height: 100%">
<font face="GillSans, sans-serif">	El nombre del cliente aparece
compuesto por el contacto y por la empresa.</font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><span style="font-weight: normal">	</span><span style="font-weight: normal">Se
corrigió para no modificar una factura emitida al menos de ingresar
la clave.</span></font>
<p style="margin-bottom: 0cm; font-weight: normal; line-height: 100%">
<font face="GillSans, sans-serif">	Se agrego un campo para descuento
pronto pago. (Dto. PP).</font>
<p style="margin-bottom: 0cm; font-weight: normal; line-height: 100%">
<font face="GillSans, sans-serif">	Se incorporo la selección de
forma de pago y el cálculo automático de la fecha de vencimiento.</font>
<p style="margin-bottom: 0cm; font-weight: normal; line-height: 100%">
<br/>

</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Tesorería
</b><font face="Liberation Sans, sans-serif"><b>→ </b></font><b>C</b><b>obros:</b>
Se cambio la forma de gestionar los cobros, pasando a ser recibos
compuestos por las facturas canceladas y por los documentos de pago.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Tesorería
</b><font face="Liberation Sans, sans-serif"><b>→ </b></font><font face="Liberation Sans, sans-serif"><b>Recibos</b></font><b>:</b>
Nuevo sistema para registrar los cobros, manteniendo compatibilidad
con el anterior.  Un recibo se puede registrar tanto de la parte de
cobros como la de recibos. Al ingresar un nuevo recibo y seleccionar
cliente aparecen todas las facturas pendientes de cobro para dicho
cliente, se selecciona la/s que se cobrarán y luego se ingresan el o
los medios de pago.</font>


</p>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Reportes
</b><font face="Liberation Sans, sans-serif"><b>→ </b></font><b>Ventas:</b>
Se mejoraron los reportes Deudores por venta y Estado de cuenta.</font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>Reportes</b><font face="Liberation Sans, sans-serif"><b>
→ </b></font><b>Cierre Mes: </b>  Se agregó la posibilidad de
generar un reporte de cierre anualizado, exportable a Excel.</font>


</p>


</p>
<p><font face="GillSans, sans-serif"><font size="3" style="font-size: 12pt"><b>¿Por
qué Software Libre?</b></font></font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Son
múltiples las ventajas que aporta el Software Libre a la empresa. Es
por ello que desde que comenzamos nuestro proyecto, nos hemos
focalizado en la aplicación de soluciones libres en nuestros
clientes en áreas relevantes de sus sistemas informáticos,
haciéndoles partícipes de todas esas ventajas. Las más relevantes:</font></font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Ahorro
de costes. La mayoría de las aplicaciones no implican gastos de
licencia.</font></font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Flexibilidad.
La disponibilidad del código permite la adaptación de las
aplicaciones a las necesidades específicas del cliente.</font></font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Implementación.
Las soluciones libres no suelen estar sujetas a sistemas operativos
concretos, con lo cual su implementación implica menos cambios, y
consecuentemente, menos gastos.</font></font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Independencia.
Nuestros clientes no están atados a ningún proveedor. No tienen que
preocuparse de costes de actualizaciones de licencias, de la
desaparición del proveedor o la discontinuidad de los productos. La
posesión del código fuente de sus aplicaciones le garantiza no
depender de nadie.</font></font>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Seguridad.
Los sistemas operativos libres son, con mucha diferencia, los más
seguros existentes debido a su arquitectura. Mientras que un sistema
Windows está constantemente en peligro y precisa de soluciones
antivirus, los sistemas basados en GNU/Linux son seguros por
naturaleza.</font></font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Robustez
del sistema. La estabilidad es una de las señas del software libre.
El hecho de que el código esté visible para todos implica su mayor
calidad, ya que no sólo puede ser corregido y mejorado por
cualquiera, sino que no tendría sentido publicar un código
defectuoso o deficiente. </font></font>
</p>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><b>1.
INTRODUCCIÓN</b></font>


</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">El
sistema UY-CodeKa es una aplicación para controlar la facturación y
gestionar el stock de una pequeña o mediana empresa esta basada en
codeka.net. Su gran virtud está en la facilidad de uso y en cubrir
las necesidades de las PYMES que brindan venta de artículos y
service. </font></font>
</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">UY-CodeKa
es una aplicación bajo licencia GPL. Está desarrollada sobre
entorno Web, lo que la hace ser muy versátil. Es independiente del
sistema operativo y además permite el trabajo en red. </font></font>
</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Las
funciones principales del sistema son: </font></font>
</p>
<ul>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Gestión
	de Clientes y proveedores</font> </font>
	</p>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Gestión
	de Artículos y Familias </font></font>
	</p>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Gestión
	de Facturas y Ordenes de Compra de los clientes </font></font>
	</p>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Gestión
	de Facturas y Ordenes de Compra de los proveedores </font></font>
	</p>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Ventas
	en mostrador, terminal de punto de venta [TPV] </font></font>
	</p>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Gestión
	de los cobros y pagos [Tesorería] </font></font>
	</p>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Reportes
	de Ventas y Service.</font> </font>
	</p>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Creación
	y configuración de códigos de barras de los artículos </font></font>
	</p>
	<li/>
<p style="margin-bottom: 0cm"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Gestión
	de copias de seguridad </font></font>
	</p>
	<li/>
<p><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">Listados
	en formato PDF </font></font>
	</p>
</ul>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">El
funcionamiento a través de entorno Web permite su uso
multiplataforma, tanto en sistemas operativos Windows como Linux y
MAC. </font></font>
</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">El
software ha sido desarrollado en lenguaje PHP, HTML, Javascript,
jQuery y utilizando como motor de base de </font></font>
</p>
<p style="margin-bottom: 0cm; line-height: 100%"><font face="GillSans, sans-serif"><font size="2" style="font-size: 11pt">datos
MySQL. </font></font>
</p>
</body>
</html>