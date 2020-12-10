<?
require_once('../../../indicadores.ini.php');

//    header("Content-Type: text/html;  charset=ISO-8859-1");
//    header("Cache-Control: no-store, no-cache, must-revalidate");
//    header("Cache-Control: post-check=0, pre-check=0", false);
//    header("Pragma: no-cache");

    $ftt_per_descricao          = $_POST["ftt_per_descricao"];
    $ftt_per_tipo               = $_POST["ftt_per_tipo"];
    $ftt_per_nivel              = $_POST["ftt_per_nivel"];
    $ftt_per_id                 = $_POST["ftt_per_id"];
    $ftt_per_id_especialidade   = $_POST["ftt_per_id_especialidade"];

//    echo $ftt_per_descricao;

    $txt_alternativa_1          = $_POST["txt_alternativa_1"];
    $txt_alternativa_2          = $_POST["txt_alternativa_2"];
    $txt_alternativa_3          = $_POST["txt_alternativa_3"];
    $txt_alternativa_4          = $_POST["txt_alternativa_4"];
    $txt_alternativa_5          = $_POST["txt_alternativa_5"];

    $ftt_alt_correta            = $_POST["ftt_alt_correta"];
    
    $chk_alternativa_1          = $_POST["chk_alternativa_1"];
    $chk_alternativa_2          = $_POST["chk_alternativa_2"];
    $chk_alternativa_3          = $_POST["chk_alternativa_3"];
    $chk_alternativa_4          = $_POST["chk_alternativa_4"];
    $chk_alternativa_5          = $_POST["chk_alternativa_5"];
    
    if ($chk_alternativa_1 == "true") $ftt_alt_correta_1 = "S";
    else $ftt_alt_correta_1 = "N";
    
    if ($chk_alternativa_2 == "true") $ftt_alt_correta_2 = "S";
    else $ftt_alt_correta_2 = "N";
    
    if ($chk_alternativa_3 == "true") $ftt_alt_correta_3 = "S";
    else $ftt_alt_correta_3 = "N";
    
    if ($chk_alternativa_4 == "true") $ftt_alt_correta_4 = "S";
    else $ftt_alt_correta_4 = "N";
    
    if ($chk_alternativa_5 == "true") $ftt_alt_correta_5 = "S";
    else $ftt_alt_correta_5 = "N";

    if (!$ftt_per_id){    
        //$sSql = "DELETE FROM apu_apuracao WHERE apu_apu_id_zon = $apu_zon_id AND apu_apu_id_ses = $apu_ses_id";
        //$dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA");    

        $sSql = "INSERT INTO ftt_pergunta (ftt_per_descricao, ftt_per_tipo, ftt_per_nivel, ftt_per_data_cadastro, ftt_per_id_especialidade, ftt_per_data_alteracao) VALUES 
                ('$ftt_per_descricao', $ftt_per_tipo, $ftt_per_nivel, NOW(), $ftt_per_id_especialidade, NOW())";

        $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE PERGUNTA - \n ".$sSql);    

        //Pega o ultimo is inserido
        $sSql = "
                select max(ftt_per_id) as ftt_alt_id_pergunta
                from 
                ftt_pergunta
                ";  
        //                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen - \n ".$sSql);    

        if ($SqlResult_1->NumRows() > 0) {
            $ftt_alt_id_pergunta                     = $SqlResult_1->fields["ftt_alt_id_pergunta"];         
        }

        if ($ftt_per_tipo == 2 || $ftt_per_tipo == 3){

            $sSql = "insert into ftt_pergunta_alternativas (ftt_alt_ordem, ftt_alt_desc, ftt_alt_correta, ftt_alt_id_pergunta) values
                    (1, '$txt_alternativa_1', '$ftt_alt_correta_1', $ftt_alt_id_pergunta),
                    (2, '$txt_alternativa_2', '$ftt_alt_correta_2', $ftt_alt_id_pergunta),
                    (3, '$txt_alternativa_3', '$ftt_alt_correta_3', $ftt_alt_id_pergunta),
                    (4, '$txt_alternativa_4', '$ftt_alt_correta_4', $ftt_alt_id_pergunta),
                    (5, '$txt_alternativa_5', '$ftt_alt_correta_5', $ftt_alt_id_pergunta)
            ";    

            $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE ALTERNATIVA - \n ".$sSql);     

        }

    }
    else {
        $sSql = "UPDATE ftt_pergunta SET 
            ftt_per_descricao = '$ftt_per_descricao', 
            ftt_per_tipo = $ftt_per_tipo, 
            ftt_per_nivel = $ftt_per_nivel, 
            ftt_per_id_especialidade = $ftt_per_id_especialidade,
            ftt_per_data_alteracao = now()
            where ftt_per_id = $ftt_per_id";
                
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA PERGUNTA - \n ".$sSql);  
        
        $sSql = "UPDATE ftt_pergunta_alternativas SET ftt_alt_desc = '$txt_alternativa_1', ftt_alt_correta = '$ftt_alt_correta_1' WHERE ftt_alt_id_pergunta = $ftt_per_id AND ftt_alt_ordem = 1";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA ALTERNATIVA 1  - \n ".$sSql);  
        
        $sSql = "UPDATE ftt_pergunta_alternativas SET ftt_alt_desc = '$txt_alternativa_2', ftt_alt_correta = '$ftt_alt_correta_2' WHERE ftt_alt_id_pergunta = $ftt_per_id AND ftt_alt_ordem = 2";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA ALTERNATIVA 2  - \n ".$sSql);  
        
        $sSql = "UPDATE ftt_pergunta_alternativas SET ftt_alt_desc = '$txt_alternativa_3', ftt_alt_correta = '$ftt_alt_correta_3' WHERE ftt_alt_id_pergunta = $ftt_per_id AND ftt_alt_ordem = 3";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA ALTERNATIVA 3  - \n ".$sSql);  
        
        $sSql = "UPDATE ftt_pergunta_alternativas SET ftt_alt_desc = '$txt_alternativa_4', ftt_alt_correta = '$ftt_alt_correta_4' WHERE ftt_alt_id_pergunta = $ftt_per_id AND ftt_alt_ordem = 4";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA ALTERNATIVA 4  - \n ".$sSql);  
        
        $sSql = "UPDATE ftt_pergunta_alternativas SET ftt_alt_desc = '$txt_alternativa_5', ftt_alt_correta = '$ftt_alt_correta_5' WHERE ftt_alt_id_pergunta = $ftt_per_id AND ftt_alt_ordem = 5";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA ALTERNATIVA 5  - \n ".$sSql);  
    }
    
    echo "true";

?>