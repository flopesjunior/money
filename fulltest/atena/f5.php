<?php
$_SESSION['aDadosCandidatoTeste']["teste_execucao"] = false;
require_once('../atena.ini.php');

$ftt_can_id = $_SESSION['aDadosCandidatoTeste']["ftt_can_id"];
//print_r($_SESSION['aDadosCandidatoTeste']);


$aRetorno = array();
$aRetorno = sCarrgaSessaoTesteEmExecucao($ftt_can_id);

 if ($aRetorno["ftt_tst_id"]){
    $sSql = "
               select 
               ftt_tsp_id,
               ftt_per_id, 
               ftt_per_descricao, 
               ftt_per_tipo, 
               ftt_per_nivel, 
               ftt_per_data_cadastro, 
               ftt_per_id_especialidade,
               ftt_esp_descricao,
               ftt_tsp_ordem
               from ftt_pergunta 
               INNER JOIN ftt_especialidade ON (ftt_esp_id = ftt_per_id_especialidade)
               INNER JOIN ftt_teste_perguntas ON (ftt_tsp_id_pergunta = ftt_per_id)
               where ftt_tsp_id_teste = ".$aRetorno["ftt_tst_id"]." AND ftt_tsp_respondida = 0
               ORDER BY ftt_tsp_ordem asc
               LIMIT 1
       ";  
//                                           echo $sSql."<BR>";

   $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    


   if ($SqlResult_1->NumRows() > 0) {
        $ftt_tsp_id                    = $SqlResult_1->fields["ftt_tsp_id"];         
        $ftt_per_id                    = $SqlResult_1->fields["ftt_per_id"];                              
        $ftt_per_descricao             = $SqlResult_1->fields["ftt_per_descricao"]; 
        $ftt_per_tipo                  = $SqlResult_1->fields["ftt_per_tipo"];
        $ftt_per_nivel                 = $SqlResult_1->fields["ftt_per_nivel"];
        $ftt_per_data_cadastro         = $SqlResult_1->fields["ftt_per_data_cadastro"];
        $ftt_per_id_especialidade      = $SqlResult_1->fields["ftt_per_id_especialidade"];
        $ftt_esp_descricao             = $SqlResult_1->fields["ftt_esp_descricao"];   
        $ftt_tsp_ordem                 = $SqlResult_1->fields["ftt_tsp_ordem"];  
        
//        echo "<script>startCountdown();</script>";
        
   }      
                   
    $sSql = "UPDATE ftt_teste SET ftt_tst_status = 4, ftt_tst_data_fim = NOW(), ftt_tst_tempo_excedido = 1 WHERE ftt_tst_id = ".$aRetorno["ftt_tst_id"];
    $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);  

    $sSql = "UPDATE ftt_teste_perguntas SET ftt_tsp_anulada_tmp_expirado = 1  WHERE ftt_tsp_id_teste = ".$aRetorno["ftt_tst_id"]." AND ftt_tsp_respondida = 0";
    $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);  
 }
 else {
     echo "<script>window.location.href = '".$sUrlRaiz."atena/login1/logout.php'</script>";
 }
?>

<html>
  <head>
    <title><?=$sNomeSistema?></title>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    <script language="JavaScript" src="<?=$sUrlRaiz?>atena/js.js" type="text/javascript" ></script>   
    
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/questoes/cadastro/js.js" type="text/javascript" ></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">  
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       

<!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">        
    
       <?inclui_fav();?>
    
  </head>
  <body style="background-color: #ffffff; padding-left: 10px; padding-top: 10px; padding-right: 10px">
      <input type="hidden" value="<?=$iEquipe?>" id="iEquipe" name="iEquipe">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">  
      <BR><BR>
      
      <table align='center' width='50%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td style='border-bottom: thin solid #CCCCCC;' height=60px align='center'>
                <img src='<?=$sUrlRaiz?>atena/logoft200.png' >
            </td>
        </tr>
        <tr><td height='20px'></td></tr>
        <tr>
            <td align='center'>
                <h3>O TEMPO DA PROVA ACABOU!!!</h3>
            </td>
        </tr>
        <tr><td height='20px'></td></tr>
        <tr>
            <td align='center'>
                <h5>OBRIGADO PELA PARTICIPAÇÃO</h5>
            </td>
        </tr>
        <tr><td height='20px'></td></tr>
        <tr>
            <td align='center'>
                <button type="button" onClick="window.location.href = '<?=$sUrlRaiz?>atena/login1/logout.php'" class="btn btn-default">ENCERRAR</button>
            </td>
        </tr>
     </table>   
      
  </body>
  
</html>