<?php
if(isset($_GET['link']))
{
    $file = $_GET['link'];

    $dir = "customer_uploads/quote_uploads/";
    $file = $dir . $file;

    if (file_exists($file))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }
?>
