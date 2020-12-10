<?
require_once('../atena.ini.php');

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
            ftt_can_escolaridade_situacao          = $ftt_can_escolaridade_situacao
            WHERE ftt_can_id = $ftt_can_id";
                
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA CONTREUDO - \n ".$sSql);  
 
    echo "true";

?>