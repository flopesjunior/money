<?
require_once('../atena.ini.php');

     $ftt_tst_id                             = $_POST["ftt_tst_id"];

    $sSql = "
               select 
               ftt_tst_bloqueado
               FROM ftt_teste 
               where ftt_tst_id = $ftt_tst_id 
       ";  
//                                           echo $sSql."<BR>";

   $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    
   
   $Retorno = "false";

   if ($SqlResult_1->NumRows() > 0) {
        $ftt_tst_bloqueado                    = $SqlResult_1->fields["ftt_tst_bloqueado"];     
        
        if ($ftt_tst_bloqueado == "1"){
            $sSql = "UPDATE ftt_teste SET ftt_tst_status = 4 WHERE ftt_tst_id = $ftt_tst_id";
            $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);
            
            $Retorno = "true";
        } 
   }     
   
   echo $Retorno;
?>