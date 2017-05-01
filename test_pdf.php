<?php
    include('mpdf60/mpdf.php');
    $stylesheet = file_get_contents('style_pdf.css');

    $mpdf=new mPDF();
    $mpdf->AddPage();
    $mpdf->SetFont('Arial','',12);

    $mpdf->WriteHTML("Hey",2);

    $mpdf->Output();
    $mpdf->Output('Reports/first.pdf','F');
?>
