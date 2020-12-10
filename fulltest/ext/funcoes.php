<?


function fExtraiUlt_Login() {
	global $_COOKIE;
		//
	if (!$_COOKIE["ULT_LOGIN_RECEPTORIP"]) return false;

	list($aUlt_Login["rec_usu_desc"], $aUlt_Login["rec_usu_login"]) = explode("|", $_COOKIE["ULT_LOGIN_RECEPTORIP"]);

		//
	return $aUlt_Login;

}

function inclui_fav(){
global $sUrlRaiz;    
    
 echo "       
<link rel=\"shortcut icon\" href=\"$sUrlRaiz/fav/favicon.ico\" type=\"image/x-icon\">
<link rel=\"icon\" href=\"$sUrlRaiz/fav/favicon.ico\" type=\"image/x-icon\">";
    return;
}

function fRetornaPeso($ftt_tip_codigo){
global $dbsis_mysql;

$sSql = "SELECT 	
            ftt_tip_descricao,
            ftt_tip_peso
            FROM ftt_pergunta_tipo_peso 
            WHERE ftt_tip_codigo = $ftt_tip_codigo";
             
    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");

    if ($SqlResult_1->NumRows() <> 0) {
        $ftt_tip_descricao                 = $SqlResult_1->fields["ftt_tip_descricao"];   
        $ftt_tip_peso                      = $SqlResult_1->fields["ftt_tip_peso"];   
    }
    
    $aRetorno[] = $ftt_tip_descricao;
    $aRetorno[] = $ftt_tip_peso;
    
    
    return $aRetorno;
}

function fRetornaCorrecao($ftt_tst_id){
global $dbsis_mysql;
    $sSql = "
    SELECT 
    ftt_per_id,
    ftt_per_tipo, 
    ftt_tsp_corrigido, 
    ftt_tsp_id, 
    ftt_tsp_ordem, 
    ftt_tsp_resp_dissertativa,
    ftt_tsp_correto,
    ftt_tsp_anulada_tmp_expirado,
    ftt_tsp_anulada,
    ftt_per_nivel
    from ftt_teste_perguntas 
    inner join ftt_pergunta on ftt_per_id = ftt_tsp_id_pergunta
    where 
    ftt_tsp_id_teste = $ftt_tst_id 
    order by ftt_tsp_ordem
     ";  
                                        //echo $sSql."<BR>";

     $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    

     
     $iTotalPerguntas = $SqlResult_1->NumRows();

     if ($SqlResult_1->NumRows() > 0) {

         $iTotalCorreto = 0;   
         $iTotalErrado  = 0;
         while (!$SqlResult_1->EOF) {

             $ftt_per_id                        = $SqlResult_1->fields["ftt_per_id"];    
             $ftt_tsp_id                        = $SqlResult_1->fields["ftt_tsp_id"];                              
             $ftt_tsp_ordem                     = $SqlResult_1->fields["ftt_tsp_ordem"]; 
             $ftt_tsp_resp_dissertativa         = $SqlResult_1->fields["ftt_tsp_resp_dissertativa"]; 
             $ftt_per_tipo                      = $SqlResult_1->fields["ftt_per_tipo"]; 
             $ftt_tsp_corrigido                 = $SqlResult_1->fields["ftt_tsp_corrigido"]; 
             $ftt_tsp_correto                   = $SqlResult_1->fields["ftt_tsp_correto"]; 
             $ftt_tsp_anulada_tmp_expirado      = $SqlResult_1->fields["ftt_tsp_anulada_tmp_expirado"]; 
             $ftt_tsp_anulada                   = $SqlResult_1->fields["ftt_tsp_anulada"]; 
             $ftt_per_nivel                     = $SqlResult_1->fields["ftt_per_nivel"]; 

             ## CONFERE RESPOSTA ############################################################################    

             
             
             $sFlagCorrecao_Qtd = Correcao_Quantidade($ftt_tsp_id, $ftt_per_id);
             
             if ($ftt_tsp_anulada_tmp_expirado == 1){
                 $ResultadoFinal = "anulado_tempo";
             }
             else if ($ftt_tsp_anulada == 1) {
                 $ResultadoFinal = "anulado_candidato";
             }
             else {
                    if ($sFlagCorrecao_Qtd) {
                        if ($ftt_per_tipo == 1){
                            if ($ftt_tsp_correto == "S"){
                                $ResultadoFinal = "correto";
                                
                            }
                            else {
                                 $ResultadoFinal = "errado";
                            }
                        }
                        else if ($ftt_per_tipo == 2 || $ftt_per_tipo == 3){
                            if (Correcao_ResultadoAlternativas($ftt_tsp_id)){
                                $ResultadoFinal = "correto";
                            }
                            else {
                                $ResultadoFinal = "errado";
                            }
                        }

                    }
                    else {
                        $ResultadoFinal = "errado";
                    }
             }
             
             
             if ($ResultadoFinal == "correto"){
                 $aRetornaPontos = fRetornaPeso($ftt_per_nivel);
                 $iTotalPontos = $iTotalPontos + $aRetornaPontos[1];
                 $iTotalCorreto++;
             }
             else if ($ResultadoFinal == "errado"){
                 $iTotalErrado++;
             }
             else if ($ResultadoFinal == "anulado_candidato"){
                 $iTotalAnuladoCandidato++;
             }
             else if ($ResultadoFinal == "anulado_tempo"){
                 $iTotalAnuladoTempo++;
             }
             
             $aResultadoFinal[$ftt_tsp_id] = $ResultadoFinal;
             
             $SqlResult_1->MoveNext();

         }   
         
     }  
     
     $aRetorno["iTotalPerguntas"]           = $iTotalPerguntas;
     $aRetorno["aResultadoFinal"]           = $aResultadoFinal;
     $aRetorno["iTotalPontos"]              = $iTotalPontos;
     $aRetorno["iTotalCorreto"]             = $iTotalCorreto;
     $aRetorno["iTotalErrado"]              = $iTotalErrado;
     $aRetorno["iTotalAnuladoCandidato"]    = $iTotalAnuladoCandidato;
     $aRetorno["iTotalAnuladoTempo"]        = $iTotalAnuladoTempo;
     
     return $aRetorno;

}

function Correcao_Quantidade($ftt_tsp_id, $ftt_per_id){
global $dbsis_mysql; 

             $sFlagCorrecao_Qtd = false;

             //Pega as alternativas respondidas na pergunta do teste
             $sSql = "
             select 
             ftt_tsp_id_pergunta, 
             ftt_tsa_id_alternativa_selecionada 
             from ftt_teste_perguntas_alt_selec 
             inner join ftt_teste_perguntas on ftt_tsp_id = ftt_tsa_id_teste_perguntas
             where ftt_tsa_id_teste_perguntas = $ftt_tsp_id
             ";  

             $SqlResult_5 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");   
             
             //echo "1: ".$sSql."<BR>";

             $QtdRespondida = $SqlResult_5->NumRows();


             $sSql = "
             select 
             ftt_alt_id, 
             ftt_alt_correta 
             from ftt_pergunta_alternativas 
             where ftt_alt_id_pergunta = $ftt_per_id and 
             ftt_alt_correta = 'S'
             ";  

             $SqlResult_6 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");   

             //echo "2: ".$sSql."<BR>";
             
             $QtdCorretas = $SqlResult_6->NumRows();

             
             //echo "resp ($ftt_tsp_id): ".$QtdRespondida." - correta ($ftt_per_id): ".$QtdCorretas."<BR>";
             
             if ($QtdRespondida == $QtdCorretas){
                 $sFlagCorrecao_Qtd = true;
             }    
    
             return $sFlagCorrecao_Qtd;
             
}

function Correcao_ResultadoAlternativas($ftt_tsp_id){
global $dbsis_mysql; 

             //Pega as alternativas respondidas na pergunta do teste
             $sSql = "
             select 
             ftt_tsp_id_pergunta, 
             ftt_tsa_id_alternativa_selecionada 
             from ftt_teste_perguntas_alt_selec 
             inner join ftt_teste_perguntas on ftt_tsp_id = ftt_tsa_id_teste_perguntas
             where ftt_tsa_id_teste_perguntas = $ftt_tsp_id
             ";  

             $SqlResult_5 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");   
             
             if ($SqlResult_5->NumRows() > 0) {

                     $iQtdErradas = 0;   
                     while (!$SqlResult_5->EOF) {

                        $ftt_tsp_id_pergunta                  = $SqlResult_5->fields["ftt_tsp_id_pergunta"];    
                        $ftt_tsa_id_alternativa_selecionada   = $SqlResult_5->fields["ftt_tsa_id_alternativa_selecionada"];                              

                        $sSql = "
                                select 
                                ftt_alt_id, 
                                ftt_alt_correta 
                                from ftt_pergunta_alternativas 
                                where ftt_alt_id = $ftt_tsa_id_alternativa_selecionada 
                                ";  

                        $SqlResult_6 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    
                        
                        $ftt_alt_correta = $SqlResult_6->fields["ftt_alt_correta"];
                        
                        if ($ftt_alt_correta == "N"){
                            $iQtdErradas++;
                        }
                         
                        $SqlResult_5->MoveNext();

                     }
                     
                     if ($iQtdErradas > 0){
                         $Resultado = false;
                     }
                     else {
                         $Resultado = true;
                     }
             }                   

             return $Resultado;
             
}

function cabecalho(){
global $sUrlRaiz;

echo "
     <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td style='border-bottom: thin solid #CCCCCC;' height=30>
                <img src='".$sUrlRaiz."atena/logoft.png'>
            </td>
        </tr>
     </table>   
    ";
}

function SorteiaPerguntas($ftt_can_id){
global $dbsis_mysql; 

    $aIDQuestoesSelecionadas = array();
    $aOrdemAlternativas = array();
    
    $sSql = "delete from ftt_view_alternativas where ftt_vwa_id_candidato = $ftt_can_id";
    $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);
    
    $sSql = "SELECT 	
            ftt_tst_id, 
            ftt_tst_id_candidato, 
            ftt_tst_status, 
            ftt_tst_data_cadastro, 
            ftt_tst_data_inicio, 
            ftt_tst_data_fim, 
            ftt_tst_id_prova,
            ftt_prv_id, 
            ftt_prv_descricao, 
            ftt_prv_tempo, 
            ftt_prv_nivel, 
            ftt_prv_data_cadastro, 
            ftt_prv_data_ultalt, 
            ftt_prv_nome
            FROM ftt_teste 
            INNER JOIN ftt_prova ON ftt_prv_id = ftt_tst_id_prova
            WHERE ftt_tst_id_candidato = $ftt_can_id AND ftt_tst_status = 1";
             
    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");

    if ($SqlResult_1->NumRows() <> 0) {
    $ftt_tst_id                 = $SqlResult_1->fields["ftt_tst_id"];                           
    $ftt_tst_id_candidato       = $SqlResult_1->fields["ftt_tst_id_candidato"]; 
    $ftt_tst_status             = $SqlResult_1->fields["ftt_tst_status"];  
    $ftt_tst_data_cadastro      = $SqlResult_1->fields["ftt_tst_data_cadastro"]; 
    $ftt_tst_data_inicio        = $SqlResult_1->fields["ftt_tst_data_inicio"]; 
    $ftt_tst_data_fim           = $SqlResult_1->fields["ftt_tst_data_fim"]; 
    $ftt_tst_id_prova           = $SqlResult_1->fields["ftt_tst_id_prova"]; 
    
    $ftt_prv_id                 = $SqlResult_1->fields["ftt_prv_id"]; 
    $ftt_prv_descricao          = $SqlResult_1->fields["ftt_prv_descricao"]; 
    $ftt_prv_tempo              = $SqlResult_1->fields["ftt_prv_tempo"]; 
    $ftt_prv_nivel              = $SqlResult_1->fields["ftt_prv_nivel"]; 
    $ftt_prv_data_cadastro      = $SqlResult_1->fields["ftt_prv_data_cadastro"]; 
    $ftt_prv_data_ultalt        = $SqlResult_1->fields["ftt_prv_data_ultalt"]; 
    $ftt_prv_nome               = $SqlResult_1->fields["ftt_prv_nome"]; 

            //echo "Prova: $ftt_prv_descricao Tempo: $ftt_prv_tempo <BR>";
    
            $sSql = "select 	
                    ftt_prc_id, 
                    ftt_prc_id_especialidade, 
                    ftt_prc_nivel, 
                    ftt_prc_quantidade, 
                    ftt_prc_id_prova,
                    ftt_esp_id,
                    ftt_esp_descricao
                    from ftt_prova_conteudo 
                    inner join ftt_especialidade on ftt_esp_id = ftt_prc_id_especialidade
                    where ftt_prc_id_prova = $ftt_prv_id
                    ";

                $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:CarregaConfiguracoes");

                if ($SqlResult_2->NumRows() <> 0) {
                    
                        $iCount = 1;
                        
                        while (!$SqlResult_2->EOF) {    
                            $ftt_prc_id                 = $SqlResult_2->fields["ftt_prc_id"]; 
                            $ftt_prc_id_especialidade   = $SqlResult_2->fields["ftt_prc_id_especialidade"]; 
                            $ftt_prc_nivel              = $SqlResult_2->fields["ftt_prc_nivel"]; 
                            $ftt_prc_quantidade         = $SqlResult_2->fields["ftt_prc_quantidade"]; 
                            $ftt_prc_id_prova           = $SqlResult_2->fields["ftt_prc_id_prova"]; 
                            $ftt_esp_id                 = $SqlResult_2->fields["ftt_esp_id"]; 
                            $ftt_esp_descricao          = $SqlResult_2->fields["ftt_esp_descricao"]; 
                                
                                //echo "<BR>";
                                //echo "      $ftt_prc_quantidade Questoes de $ftt_esp_descricao do nivel $ftt_prc_nivel <BR>";
        
                                $sSql = "select
                                            ftt_per_id, 
                                            ftt_per_descricao, 
                                            ftt_per_tipo, 
                                            ftt_per_nivel, 
                                            ftt_per_data_cadastro, 
                                            ftt_per_id_especialidade, 
                                            ftt_per_data_alteracao
                                        from ftt_pergunta 
                                        where 
                                            ftt_per_id_especialidade = $ftt_prc_id_especialidade AND
                                            ftt_per_nivel = $ftt_prc_nivel    
                                    ";

                                $SqlResult_3 = $dbsis_mysql->Execute($sSql) or die("ERRx003:CarregaConfiguracoes <BR> $sSql ");

                                
                                if ($SqlResult_3->NumRows() <> 0) {
                                        $aQuestoes = array();
                                        $aCorrecao = array();
                                       
                                        while (!$SqlResult_3->EOF) {    
                                        $ftt_per_id                 = $SqlResult_3->fields["ftt_per_id"]; 
                                        $ftt_per_descricao          = $SqlResult_3->fields["ftt_per_descricao"];  
                                        $ftt_per_tipo               = $SqlResult_3->fields["ftt_per_tipo"]; 
                                        $ftt_per_nivel              = $SqlResult_3->fields["ftt_per_nivel"];  
                                        $ftt_per_data_cadastro      = $SqlResult_3->fields["ftt_per_data_cadastro"]; 
                                        $ftt_per_id_especialidade   = $SqlResult_3->fields["ftt_per_id_especialidade"]; 
                                        $ftt_per_data_alteracao     = $SqlResult_3->fields["ftt_per_data_alteracao"]; 
                                        
                                            $aQuestoes[] = $ftt_per_id;
                                            
                                            if ($ftt_per_tipo == 1){
                                                $aCorrecao[$ftt_per_id] = "S";
                                            }
                                            //echo "                      #Id Pergunta: $ftt_per_id Tipo: $ftt_per_tipo <BR>";
                                            $SqlResult_3->MoveNext();
                                        }  
                                        
                                }    
                                
                                
                                $NecessitaCorrecao = "N";
                                if ($aQuestoes){
                                    $rand_keys = array_rand($aQuestoes, $ftt_prc_quantidade);
                                    //echo "Perguntas sorteadas: <BR>";
                                    
                                    for ($i = 0; $i < $ftt_prc_quantidade; $i++) {
                                        //echo "                                  #".$aQuestoes[$rand_keys[$i]]."<BR>";
                                        
                                        if ($aCorrecao[$aQuestoes[$rand_keys[$i]]] == "S"){
                                              $NecessitaCorrecao = "S";
                                              $ftt_tsp_corrigido = "'N'";
                                        }                              
                                        else {
                                              $ftt_tsp_corrigido = "NULL";
                                        }
                                        
                                        $ftt_tsp_id_pergunta = $aQuestoes[$rand_keys[$i]];

                                        $_SESSION['aPaginacaoTesteCandidato'][] = $ftt_tsp_id_pergunta;                                        

                                        $sSql = "INSERT INTO ftt_teste_perguntas (
                                                ftt_tsp_id_teste,
                                                ftt_tsp_id_pergunta,
                                                ftt_tsp_ordem,
                                                ftt_tsp_corrigido
                                               ) VALUES (
                                               $ftt_tst_id,
                                               $ftt_tsp_id_pergunta,
                                               $iCount,
                                               $ftt_tsp_corrigido    
                                               )";        

                                               $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);  
                                               
                                               
                                               //
                                               $sSql = "
                                                          select 
                                                             ftt_alt_id, 
                                                             ftt_alt_desc, 
                                                             ftt_alt_correta, 
                                                             ftt_alt_id_pergunta, 
                                                             ftt_alt_ordem
                                                          from ftt_pergunta_alternativas 
                                                          where 
                                                              ftt_alt_id_pergunta = $ftt_tsp_id_pergunta and 
                                                              ftt_alt_desc <> '<p><br></p>' 
                                                          order by rand()
                                                    ";  
  //                                                                                          echo $sSql."<BR>";

                                               $SqlResult_4 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    

                                               $aEspecialidade = array();

                                               if ($SqlResult_4->NumRows() > 0) {

                                                     $iCountAlt = 1;

                                                     while (!$SqlResult_4->EOF) {
                                                      $ftt_alt_id               = $SqlResult_4->fields["ftt_alt_id"];                              
                                                      $ftt_alt_desc             = $SqlResult_4->fields["ftt_alt_desc"]; 
                                                      $ftt_alt_correta          = $SqlResult_4->fields["ftt_alt_correta"];
                                                      //$ftt_alt_ordem            = $SqlResult_1->fields["ftt_alt_ordem"];

                                                        $sSql = "
                                                       insert into ftt_view_alternativas 
                                                       (ftt_vwa_id_pergunta, ftt_vwa_id_teste, ftt_vwa_id_alterativa, ftt_vwa_id_candidato, ftt_vwa_ordem)
                                                        values
                                                       ($ftt_tsp_id_pergunta, $ftt_tst_id, $ftt_alt_id, $ftt_tst_id_candidato, $iCountAlt)                                                        
                                                       ";
                                                        
                                                       $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);
                                                        
                                                       $iCountAlt++; 
                                                       $SqlResult_4->MoveNext();
                                                     }
                                               }     
                                               
                                               $iCount++;
                                               
                                               
                                    }
                                    

                                    
                                    
                                }
                                
                            
                            
                            $SqlResult_2->MoveNext();
                        }   
                }       
                
                        
                $sSql = "UPDATE ftt_teste SET ftt_tst_status = 2, ftt_tst_carrecao = '$NecessitaCorrecao', ftt_tst_data_inicio = NOW() WHERE ftt_tst_id = $ftt_tst_id";
                $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);
                
                return true;
                
    }
    else {
        
        return false;
    }
    
    
}

function sCarrgaSessaoTesteEmExecucao($ftt_can_id){
global $dbsis_mysql; 

    $aDadosTeste = array();

    $sSql = "SELECT 	
            TIME_TO_SEC(TIMEDIFF(now(), ftt_tst_data_inicio)) AS seg_execucao,
            ftt_tst_id, 
            ftt_tst_id_candidato, 
            ftt_tst_status, 
            ftt_tst_data_cadastro, 
            ftt_tst_data_inicio, 
            ftt_tst_data_fim, 
            ftt_tst_id_prova,
            ftt_tst_carrecao,
            ftt_prv_id, 
            ftt_prv_descricao, 
            ftt_prv_tempo,
            ftt_prv_tempo * 60 as ftt_prv_tempo_segundos,
            ftt_prv_nivel, 
            ftt_prv_data_cadastro, 
            ftt_prv_data_ultalt, 
            ftt_prv_nome
            FROM ftt_teste 
            INNER JOIN ftt_prova ON ftt_prv_id = ftt_tst_id_prova
            WHERE ftt_tst_id_candidato = $ftt_can_id AND ftt_tst_status = 2";
             
    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");

    if ($SqlResult_1->NumRows() <> 0) {
    $seg_execucao               = $SqlResult_1->fields["seg_execucao"];      
    $ftt_tst_id                 = $SqlResult_1->fields["ftt_tst_id"];                           
    $ftt_tst_id_candidato       = $SqlResult_1->fields["ftt_tst_id_candidato"]; 
    $ftt_tst_status             = $SqlResult_1->fields["ftt_tst_status"];  
    $ftt_tst_data_cadastro      = $SqlResult_1->fields["ftt_tst_data_cadastro"]; 
    $ftt_tst_data_inicio        = $SqlResult_1->fields["ftt_tst_data_inicio"]; 
    $ftt_tst_data_fim           = $SqlResult_1->fields["ftt_tst_data_fim"]; 
    $ftt_tst_id_prova           = $SqlResult_1->fields["ftt_tst_id_prova"]; 
    $ftt_tst_carrecao           = $SqlResult_1->fields["ftt_tst_carrecao"]; 
    
    $ftt_prv_id                 = $SqlResult_1->fields["ftt_prv_id"]; 
    $ftt_prv_descricao          = $SqlResult_1->fields["ftt_prv_descricao"]; 
    $ftt_prv_tempo              = $SqlResult_1->fields["ftt_prv_tempo"]; 
    $ftt_prv_tempo_segundos     = $SqlResult_1->fields["ftt_prv_tempo_segundos"]; 
    $ftt_prv_nivel              = $SqlResult_1->fields["ftt_prv_nivel"]; 
    $ftt_prv_data_cadastro      = $SqlResult_1->fields["ftt_prv_data_cadastro"]; 
    $ftt_prv_data_ultalt        = $SqlResult_1->fields["ftt_prv_data_ultalt"]; 
    $ftt_prv_nome               = $SqlResult_1->fields["ftt_prv_nome"]; 
    
    
            //echo "Prova: $ftt_prv_descricao Tempo: $ftt_prv_tempo <BR>";
    
               $aDadosTeste["seg_execucao"]                 = $seg_execucao; 
               $aDadosTeste["ftt_tst_id"]                   = $ftt_tst_id;
               $aDadosTeste["ftt_tst_id_candidato"]         = $ftt_tst_id_candidato;
               $aDadosTeste["ftt_tst_status"]               = $ftt_tst_status;
               $aDadosTeste["ftt_tst_data_cadastro"]        = $ftt_tst_data_cadastro;
               $aDadosTeste["ftt_tst_data_inicio"]          = $ftt_tst_data_inicio;
               $aDadosTeste["ftt_tst_data_fim"]             = $ftt_tst_data_fim;
               $aDadosTeste["ftt_tst_id_prova"]             = $ftt_tst_id_prova;
               $aDadosTeste["ftt_tst_carrecao"]             = $ftt_tst_carrecao;
               $aDadosTeste["ftt_prv_id"]                   = $ftt_prv_id;
               $aDadosTeste["ftt_prv_descricao"]            = $ftt_prv_descricao;
               $aDadosTeste["ftt_prv_tempo"]                = $ftt_prv_tempo;
               $aDadosTeste["ftt_prv_tempo_segundos"]       = $ftt_prv_tempo_segundos;
               $aDadosTeste["ftt_prv_data_cadastro"]        = $ftt_prv_data_cadastro;
               $aDadosTeste["ftt_prv_data_ultalt"]          = $ftt_prv_data_ultalt;
               $aDadosTeste["ftt_prv_nome"]                 = $ftt_prv_nome;
    
                $sSql = "SELECT SUM(ftt_prc_quantidade)	as qtd
                        FROM ftt_prova_conteudo 
                        WHERE ftt_prc_id_prova = $ftt_prv_id";
             
                $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");
                
                $Total_Questoes = $SqlResult_2->fields["qtd"]; 
                
                $aDadosTeste["Total_Questoes"]                 = $Total_Questoes;
                
    }
    
    return $aDadosTeste;
    
}

 function m2h($mins) {
    // Se os minutos estiverem negativos
    if ($mins < 0)
      $min = abs($mins); 
    else
      $min = $mins; 
    // Arredonda a hora
    $h = floor($min / 60); 
    $m = ($min - ($h * 60)) / 100; 
    $horas = $h + $m; 
    // Matemática da quinta série
    // Detalhe: Aqui também pode se usar o abs()
    if ($mins < 0)
      $horas *= -1; 
    // Separa a hora dos minutos
    $sep = explode('.', $horas); 
    $h = $sep[0]; 
    if (empty($sep[1]))
      $sep[1] = 00; 
    $m = $sep[1]; 
    // Aqui um pequeno artifício pra colocar um zero no final
    if (strlen($m) < 2)
      $m = $m . 0; 
    return sprintf('%02dh:%02dm:%02ds', $h, $m, 0); 
  } 
  


function fRetornaPeriodos2($iQtdMesesAntes, $iQtdMesesDepois){
    //Coleta as datas dos ultimos 12 meses
    $aDatasColetadas = array();
    
    for ($i=$iQtdMesesAntes;$i>=0;$i--){
        $ano = date("Y", strtotime( "-$i month"));
        $mes = date("m", strtotime( "-$i month"));
        //
        $periodo = date("m/Y", strtotime( "-$i month"));;
        //
        $primeiro_dia = date("Y-m-01", strtotime( "-$i month"));
        //
        $lastday = date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!
        $ultimo_dia = date("Y-m-$lastday", strtotime( "-$i month"));
        //
        $aPeriodo = array();
        array_push($aPeriodo, $primeiro_dia, $ultimo_dia, $periodo);
        array_push($aDatasColetadas, $aPeriodo);

    }    

    for ($i=1;$i<=$iQtdMesesDepois;$i++){
        $ano = date("Y", strtotime( "+$i month"));
        $mes = date("m", strtotime( "+$i month"));
        //
        $periodo = date("m/Y", strtotime( "+$i month"));;
        //
        $primeiro_dia = date("Y-m-01", strtotime( "+$i month"));
        //
        $lastday = date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!
        $ultimo_dia = date("Y-m-$lastday", strtotime( "+$i month"));
        //
        $aPeriodo = array();
        array_push($aPeriodo, $primeiro_dia, $ultimo_dia, $periodo);
        array_push($aDatasColetadas, $aPeriodo);

    }
    
    return $aDatasColetadas;
}


function VerPermissao($aParametros){
global $dbsis_mysql;


    //Usuario Bloqueado
    if ($_SESSION['aDadosUsuarioRECIPADM']["rec_usu_liberado"] == "N") return false;

    //Usu�rio Administrador
    if ($_SESSION['aDadosUsuarioRECIPADM']["rec_usu_admin"]    == "S") return true;

    $id_usuario    = $aParametros["id_usuario"];
    $codigo_funcao = trim($aParametros["codigo_funcao"]);

    $sSql = "
            SELECT
                gefuncao.rec_fun_id,
                gefuncao.rec_fun_codigo,
                gefuncao.rec_fun_descricao,
                gefuncao.rec_fun_restrito,
                gefuncao.rec_fun_id_grupo,
                gefuncao.rec_fun_habilitado,
                gefuncao.rec_fun_posicao,
                gepermissao.rec_per_id,
                gepermissao.rec_per_id_gefuncao,
                gepermissao.rec_per_id_geusuario
             FROM gepermissao
             INNER JOIN gefuncao ON (gefuncao.rec_fun_id = gepermissao.rec_per_id_gefuncao)
             WHERE
                gepermissao.rec_per_id_geusuario = $id_usuario AND
                gefuncao.rec_fun_codigo = '$codigo_funcao'
          ";

    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die($sSql."<br>".$dbsis_mysql->ErrorMsg());

    if ($SqlResult_1->NumRows() > 0) {
        return true;
    }
    else {
        return false;
    }

}

function fAbreMaximizado() {
      echo "
         <script>
            if (opener) {
               window.moveTo(0,0);
               if (document.layers) {
                  window.outerHeight = screen.availHeight;
                  window.outerWidth = screen.availWidth;
               }
               else {
                  window.resizeTo(screen.availWidth,screen.availHeight);
               }
            }
         </script>
      ";
}

function fFormataData_SQLSVR($dData) {
   if (!empty($dData)) {
      if (strpos($dData, "/") != 0)
			$dData = substr($dData, 6, 4).substr($dData, 3, 2).substr($dData, 0, 2);
		else
			$dData = substr($dData, 6, 2)."/".substr($dData, 4, 2)."/".substr($dData, 0, 4);
   }
   if ($dData == "00/00/0000") $dData = "";
   return $dData;
}

function fFormataData($dData) {
   if (!empty($dData)){
      if (strpos($dData, "/") != 0)
			$dData = substr($dData, 6, 4).substr($dData, 3, 2).substr($dData, 0, 2);
		else
			$dData = substr($dData, 6, 2)."/".substr($dData, 4, 2)."/".substr($dData, 0, 4);
   }
   if ($dData == "00/00/0000") $dData = "";

   return $dData;
}

function fFormataData2($dData) {
   if (!empty($dData)) {
      if (strpos($dData, "-") != 0)
			$dData = substr($dData, 8, 2)."/".substr($dData, 5, 2)."/".substr($dData, 0, 4);
      elseif (strpos($dData, "/") != 0)
			$dData = substr($dData, 6, 4).substr($dData, 3, 2).substr($dData, 0, 2);
   }
   if ($dData == "00/00/0000") $dData = "";
   return $dData;
}

function fFormataData3($dData) {
	$hHora = substr($dData, -5);

	
   if (!empty($dData)) {
      if (strpos($dData, "-") != 0)
			$dData = substr($dData, 8, 2)."/".substr($dData, 5, 2)."/".substr($dData, 0, 4);
      elseif (strpos($dData, "/") != 0)
			$dData = substr($dData, 6, 4)."-".substr($dData, 3, 2)."-".substr($dData, 0, 2);
   }
   
   if ($dData == "00/00/0000") $dData = "";
   return $dData." ".$hHora;

}

function fFormataData4($dData) {
	
   if (!empty($dData)) {
      if (strpos($dData, "-") != 0)
			$dData = substr($dData, 8, 2)."/".substr($dData, 5, 2)."/".substr($dData, 0, 4);
      elseif (strpos($dData, "/") != 0)
			$dData = substr($dData, 6, 4)."-".substr($dData, 3, 2)."-".substr($dData, 0, 2);
   }
   
   if ($dData == "00/00/0000") $dData = "";
   return $dData;

}


function fFormataMoeda($iMoeda, $iTipo, $iCasas = 2) {
   if ($iTipo) {
		$iMoeda = number_format($iMoeda, $iCasas, ',', '.');
		$iMoeda ? $iMoeda : $iMoeda = "0,00";
   }
   else {
      $iMoeda = str_replace('.', '',  $iMoeda);
      $iMoeda = str_replace(',', '.', $iMoeda);
		$iMoeda ? $iMoeda : $iMoeda = "0.00";
   }
   return $iMoeda;
}


function fArrumaDigitosCodigo($sCodigo, $iDigitos) {
		//
	if ($iDigitos) {
		if (strlen($sCodigo) > $iDigitos) return false;
		if (strlen($sCodigo) == $iDigitos) return $sCodigo;
		$iZeros = $iDigitos - strlen($sCodigo);
		for ($i = 0; $i < $iZeros; $i++){
			$sZeros .= "0";
		}
		$sCodigo = $sZeros.$sCodigo;
	}
		//
  return $sCodigo;
}

function getWorkingDays($startDate, $endDate, $issues_id)
{
    $begin = strtotime($startDate);
    $end   = strtotime($endDate);
    if ($begin > $end) {
        echo "startdate is in the future #$issues_id! <br />";

        return 0;
    } else {
        $no_days  = 0;
        $weekends = 0;
        while ($begin <= $end) {
            $no_days++; // no of days in the given interval
            $what_day = date("N", $begin);
            if ($what_day > 5) { // 6 and 7 are weekend days
                $weekends++;
            };
            $begin += 86400; // +1 day
        };
        $working_days = $no_days - $weekends;

        return $working_days;
    }
}


function fMontaCabecalho($sUrlAlvo, $sTitulo=""){
    
    $sRetorno = "
        <nav class=\"navbar navbar-default navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">
            <div class=\"navbar-header\">
               <h2> &nbsp; $sTitulo </h2>
            </div>
            <!-- /.navbar-header -->

            <ul class=\"nav navbar-top-links navbar-right\">
                
            </ul>   
       </nav>  ";   
    
    
    
    return $sRetorno;
    
}

?>
