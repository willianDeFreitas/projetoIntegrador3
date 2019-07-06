<?php
// Carregar dompdf
require_once '../../lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$id=$_GET['idcompra'];

 $html=file_get_contents("http://www.fssites.com.br/projetoIntegrador3/view/compras/comprovanteCompraPdf.php?idcompra=".$id);

// Instanciamos um objeto da classe DOMPDF.
$pdf = new DOMPDF();
 
// Definimos o tamanho do papel e orientação.
$pdf->set_paper(array(0,0,125,250));
 
// Carregar o conteúdo html.
$pdf->load_html($html, 'UTF-8');
 
// Renderizar PDF.
$pdf->render();
 
// Enviamos pdf para navegador.
$pdf->stream('comprovante'.$id.'.pdf');