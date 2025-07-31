<?php
if($_GET['id']) {
      $pedido = $pedidoNegocio->recuperar($_GET['id']);
      $itemsPedido = $pedido->getItemsPedido();

      require_once('negocio/encargadoNegocio.php');
      $encargadoNegocio = new EncargadoNegocio();

      $encargado = $encargadoNegocio->recuperar($pedido->getIdEncargado());
      require_once('negocio/productoNegocio.php');
      $productoNegocio = new ProductoNegocio();

      $fecha = Util::dbToDate($pedido->getFecha());
      require_once('negocio/envioNegocio.php');
      $envioNegocio = new EnvioNegocio();
      $envio = $envioNegocio->recuperar($fecha);

      require_once('pdf/fpdf/fpdf.php');
      ob_end_clean(); //    the buffer and never prints or returns anything.
      ob_start();

      class PDF extends FPDF
      {
          function Header()
          {

            $this->SetFont('Arial', 'UI', 8);
            $this->Cell(80, 10, utf8_decode("La Casa del Tiramisú"), 0, 0, 'L');
            $this->Cell(110, 10, utf8_decode("Tel: 243-0348 - Entre Rios 1415 - Rosario"), 0, 1, 'R');

            $this->SetFont('Helvetica', '', 16);
            $this->Cell(30);
            $this->Cell(130, 10, 'Detalle de Venta', 0, 0, 'C');

            $this->Line(10, 30, 200, 30);

            $this->Ln(15);

          }
      


      }

  $pdf = new PDF('P', 'mm', 'A4');
  $pdf->SetTitle('Reporte de Venta');
  $pdf->AddPage();
 

  $pdf->SetX(35);
  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Fecha de Venta:', 0, 0, 'R', 0);
  
  $fecha = Util::dbToDate($pedido->getFecha());
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(60, 6, $fecha, 0, 0, 'L', 0);


  $pdf->SetFont('Helvetica', '', 10);
  $pdf->Cell(20, 6, 'Encargado:', 0, 0, 'R', 0);
  
  $encargado = ucwords($encargado->getApellido()).', '.ucwords($encargado->getNombre());
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(80, 6, utf8_decode($encargado), 0, 1, 'L', 0);


      if( count($itemsPedido) > 0 ){



  $pdf->SetX(7);
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(60, 6, 'Producto', 1, 0, 'C', 0);
  $pdf->Cell(18, 6, 'Cantidad', 1, 0, 'C', 0);
  $pdf->Cell(85, 6, utf8_decode("Observación"), 1, 0, 'C', 0);
  $pdf->Cell(30, 6, 'Precio Sugerido', 1, 1, 'C', 0);


            foreach ($itemsPedido as $item) {

  $pdf->SetX(7);
  $pdf->SetFont('Helvetica', '', 9);
  $producto = ucwords($productoNegocio->recuperar($item['id_producto'])->getNombre()) . ' ' . ucfirst($productoNegocio->recuperar($item['id_producto'])->getDescripcion());
  $pdf->Cell(60, 6, utf8_decode($producto), 1, 0, 'L', 0);

  $pdf->Cell(18, 6, $item['cantidad'], 1, 0, 'L', 0);

  $pdf->Cell(85, 6, utf8_decode(ucfirst($item['observacion'])), 1, 0, 'L', 0);

  $precioSug = '$ ' . number_format($item['precioSugerido'], 2);
  $pdf->Cell(30, 6, utf8_decode($precioSug), 1, 1, 'L', 0);

  }

  $pdf->SetX(7);
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(163, 6, 'Precio Total', 1, 0, 'R', 0);

  $pdf->SetFont('Helvetica', 'B', 10);
  $total = '$ ' . number_format($pedido->getPrecio(), 2);
  $pdf->Cell(30, 6, utf8_decode($total), 1, 1, 'L', 0);


    } else {

  $pdf->SetX(82);
  $pdf->SetFont('Helvetica', 'B', 10);
  $pdf->Cell(50, 6, 'No se agregaron productos', 0, 1, 'L', 0);
      
      }

  $pdf->Output();
  ob_end_flush(); // It's printed here, because ob_end_flush "prints" what's in

    }else{
    Util::setMsj('Debe seleccionar un pedido','warning');
    header('Location: ?modulo=pedido&accion=listar');
    die();
  }
?>   