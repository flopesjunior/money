<?
require_once('../../../indicadores.ini.php');

    $ftt_prc_id_especialidade   = $_POST["ftt_prc_id_especialidade"];
    $ftt_prc_nivel              = $_POST["ftt_prc_nivel"];
    
    
    
    $sSql = "
        select 
        count(*) as qde
        from ftt_pergunta
        where 
        ftt_per_id_especialidade = $ftt_prc_id_especialidade AND
        ftt_per_nivel = $ftt_prc_nivel
        ";  
//                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


        if ($SqlResult_1->NumRows() > 0) {    
            $qde  = $SqlResult_1->fields["qde"];                
        }
    
        echo $qde;
        
        
    
?>