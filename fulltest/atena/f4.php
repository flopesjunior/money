<?php
$_SESSION['aDadosCandidatoTeste']["teste_execucao"] = false;

require_once('../atena.ini.php');

$ftt_can_id = $_SESSION['aDadosCandidatoTeste']["ftt_can_id"];
            
//            print_r($_SESSION['aDadosCandidatoTeste']);

                   
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
                <h3>OBRIGADO PELA PARTICIPAÇÃO</h3>
            </td>
        </tr>
        <tr><td height='20px'></td></tr>
        <tr>
            <td align='center'>
                <h5>AGORA O RESULTADO SERÁ ANALISADO PELA EQUIPE</h5>
            </td>
        </tr>
        <tr><td height='20px'></td></tr>
        <tr>
            <td align='center'>
                <h5>EM BREVE ENTRAREMOS EM CONTATO</h5>
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