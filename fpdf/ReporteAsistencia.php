<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      include '../db_connect.php'; //llamamos a la conexion BD

      $consulta_info = $conn->query(" SELECT * FROM system_settings "); //traemos datos de la empresa desde BD
      $dato_info = $consulta_info->fetch_object();
      $this->Image('logo.png', 25, 10, 40); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode($dato_info->name), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* UBICACION */
      $this->Cell(180);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(96, 10, utf8_decode("Ubicación : " . $dato_info->address), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(180);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono : " . $dato_info->contact), 0, 0, '', 0);
      $this->Ln(5);

      /* RUC */
      $this->Cell(180);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("CORREO : " . $dato_info->email), 0, 0, '', 0);
      $this->Ln(10);



      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(0, 95, 189);
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE ASISTENCIAS "), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(125, 173, 221); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(15, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(100, 10, utf8_decode('EMPLEADO'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('CEDULA'), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('ENTRADA'), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('SALIDA'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

include '../db_connect.php'; 
/* CONSULTA INFORMACION DEL HOSPEDAJE */

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$consulta_reporte_asistencia = $conn->query(" SELECT asistencia.entrada,asistencia.salida,employee_list.firstname,employee_list.lastname,employee_list.cedula from asistencia
inner join employee_list ON asistencia.employee_id=employee_list.id ");

while ($datos_reporte = $consulta_reporte_asistencia->fetch_object()) {
   $i = $i + 1;
   /* TABLA */
   $pdf->Cell(15, 10, utf8_decode($i), 1, 0, 'C', 0);
   $pdf->Cell(100, 10, utf8_decode($datos_reporte->firstname ." ".$datos_reporte->lastname), 1, 0, 'C', 0);
   $pdf->Cell(40, 10, utf8_decode($datos_reporte->cedula), 1, 0, 'C', 0);
   $pdf->Cell(60, 10, utf8_decode($datos_reporte->entrada), 1, 0, 'C', 0);
   $pdf->Cell(60, 10, utf8_decode($datos_reporte->salida), 1, 1, 'C', 0);
}


$pdf->Output('Reporte Asistencia.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
