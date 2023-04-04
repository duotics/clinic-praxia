<?php require_once('../../init.php');
$idt=$_GET['idt'] ?? $_POST['idt'] ?? null;
    // GET HTML
	ob_start();
    include('receta.php');
    $content = ob_get_clean();
    // convert in PDF
    try{
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('Receta-'.$idt.'.pdf');
    }catch(HTML2PDF_exception $e) { echo $e; exit; }
	ob_end_flush();
?>