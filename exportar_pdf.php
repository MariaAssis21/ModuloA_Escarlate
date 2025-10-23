<?php

//usa o autoload do composer para tornar em pdf
require 'vendor/autoload.php'; 
require 'conexao.php';

//transforma em pdf
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false); // Instancia a TCPDF

$pdf->AddPage();

//mostra o pdf
$pdf->Output('relatorio_ativos.pdf', 'D');

?>