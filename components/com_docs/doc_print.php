<?php require_once('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
    // GET HTML
	ob_start();
    include('reporteDoc.php');
    $content = ob_get_clean();
    // convert in PDF
    try{
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('Documentos_'.$id.'.pdf');
    }catch(HTML2PDF_exception $e) { echo $e; exit; }
	ob_end_flush();
?>