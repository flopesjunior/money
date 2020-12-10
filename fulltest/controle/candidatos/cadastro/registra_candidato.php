<?
require_once('../../../indicadores.ini.php');

     $ftt_can_id                             = $_POST["ftt_can_id"];
     $ftt_can_nome                           = $_POST["ftt_can_nome"];
     $ftt_can_email                          = $_POST["ftt_can_email"];
     $ftt_can_celular                        = $_POST["ftt_can_celular"];
     $ftt_can_endereco                       = $_POST["ftt_can_endereco"];
     $ftt_can_cidade                         = $_POST["ftt_can_cidade"];
     $ftt_can_uf                             = $_POST["ftt_can_uf"];
     $ftt_can_telefone                       = $_POST["ftt_can_telefone"];
     $ftt_can_instuicao_ensino               = $_POST["ftt_can_instuicao_ensino"];
     $ftt_can_curso                          = $_POST["ftt_can_curso"];
     $ftt_can_escolaridade                   = $_POST["ftt_can_escolaridade"];
     $ftt_can_escolaridade_ano_conclusao     = $_POST["ftt_can_escolaridade_ano_conclusao"];
     $ftt_can_escolaridade_situacao          = $_POST["ftt_can_escolaridade_situacao"];
     $ftt_can_proc_status                    = $_POST["ftt_can_proc_status"];
     
     
   
    if (!$ftt_can_id){
        
        $sSql = "
            select ftt_can_email
            from ftt_candidato
            where 
            ftt_can_email = '".trim($ftt_can_email)."'";  
    //                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    

        if ($SqlResult_1->NumRows() > 0) {    
            echo "existe";
            exit;
        }         
        
        $sSql = "INSERT INTO ftt_candidato (
                ftt_can_nome,                            
                ftt_can_email,                           
                ftt_can_celular,                         
                ftt_can_endereco,                        
                ftt_can_cidade,                       
                ftt_can_uf,                              
                ftt_can_telefone,                        
                ftt_can_instuicao_ensino,                
                ftt_can_curso,                           
                ftt_can_escolaridade,                    
                ftt_can_escolaridade_ano_conclusao,      
                ftt_can_escolaridade_situacao,
                ftt_can_proc_status     
                ) VALUES (           
                '$ftt_can_nome',
                '$ftt_can_email',
                '$ftt_can_celular',
                '$ftt_can_endereco',
                '$ftt_can_cidade',
                '$ftt_can_uf',
                '$ftt_can_telefone',
                '$ftt_can_instuicao_ensino',
                '$ftt_can_curso',
                $ftt_can_escolaridade,
                '$ftt_can_escolaridade_ano_conclusao',
                $ftt_can_escolaridade_situacao,
                $ftt_can_proc_status
                )";    
        
            $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA CONTREUDO - \n ".$sSql);  
            
    } 
    else { 
        $sSql = "UPDATE ftt_candidato SET 
                ftt_can_nome                           = '$ftt_can_nome',
                ftt_can_email                          = '$ftt_can_email',
                ftt_can_celular                        = '$ftt_can_celular',
                ftt_can_endereco                       = '$ftt_can_endereco',
                ftt_can_cidade                         = '$ftt_can_cidade',
                ftt_can_uf                             = '$ftt_can_uf',
                ftt_can_telefone                       = '$ftt_can_telefone',
                ftt_can_instuicao_ensino               = '$ftt_can_instuicao_ensino',
                ftt_can_curso                          = '$ftt_can_curso',
                ftt_can_escolaridade                   = $ftt_can_escolaridade,
                ftt_can_escolaridade_ano_conclusao     = '$ftt_can_escolaridade_ano_conclusao',
                ftt_can_escolaridade_situacao          = $ftt_can_escolaridade_situacao,
                ftt_can_proc_status                    = $ftt_can_proc_status
                WHERE ftt_can_id = $ftt_can_id";

            $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA CONTREUDO - \n ".$sSql);  
    }    
    echo "true";

?>