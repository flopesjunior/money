<?php

require_once('../atena.ini.php');

    $_SESSION['aPaginacaoTesteCandidato'] = array();
    $_SESSION['PerguntaFinalizar']        = "";    
    
    if ($_SESSION['aDadosCandidatoTeste']["teste_execucao"] == true){
        echo "<script>window.location.href = '".$sUrlRaiz."atena/f3.php'</script>";
    }

    $ftt_can_id = $_SESSION['aDadosCandidatoTeste']["ftt_can_id"];

    $Retorno = SorteiaPerguntas($ftt_can_id);
    
//    exit;
    
    if ($Retorno===false){
        echo "Problemas ao processar o teste";
        exit;
    }
    else {
        if (sCarrgaSessaoTesteEmExecucao($ftt_can_id)){
            echo "<script>window.location.href = '".$sUrlRaiz."atena/f3.php'</script>";
            $_SESSION['aDadosCandidatoTeste']["teste_execucao"] = true;
        }    
        else {
            echo "Problemas ao processar o teste";
        }
    }
    
    
 ?>       
  