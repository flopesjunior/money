<?php


class atena{

    var $tInicioProcesso;
    var $tFinalProcesso;
    var $ArquivoLog         = "";
    var $iTotal             = 0;

    function  __construct() {

    }

    function EnviaEmailFeedbackTeste(){
    global $dbsis_mysql;
    global $sDiretorioRaiz;
    
            $sSql = "
                    select 
                    TIMEDIFF(ftt_tst_data_fiM,ftt_tst_data_inicio) as tempo_teste,
                    ftt_tst_id, 
                    ftt_tst_id_candidato, 
                    ftt_tst_status, 
                    ftt_tst_data_cadastro, 
                    ftt_tst_data_inicio, 
                    ftt_tst_data_fim, 
                    ftt_tst_id_prova,
                    ftt_tst_carrecao,
                    ftt_can_nome, 
                    ftt_can_email,
                    ftt_prv_nome,
                    ftt_tst_id_area,
                    ftt_prv_tempo
                    from ftt_teste 
                    inner join ftt_candidato on ftt_can_id = ftt_tst_id_candidato
                    inner join ftt_prova on ftt_prv_id = ftt_tst_id_prova
                    where ftt_tst_status = 4 and ftt_tst_emailfeedback = 0
                    ";   
                                              //     echo $sSql."<BR>";

               $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    

               $aRetorno = array();
               if ($SqlResult_1->NumRows() > 0) {
                   
                    while (!$SqlResult_1->EOF) {
                       
                        $ftt_tst_id                  = $SqlResult_1->fields["ftt_tst_id"];                              
                        $ftt_tst_id_candidato        = $SqlResult_1->fields["ftt_tst_id_candidato"]; 
                        $ftt_tst_status              = $SqlResult_1->fields["ftt_tst_status"]; 
                        $ftt_tst_data_cadastro       = $SqlResult_1->fields["ftt_tst_data_cadastro"];
                        $ftt_tst_data_inicio         = $SqlResult_1->fields["ftt_tst_data_inicio"];
                        $ftt_tst_data_fim            = $SqlResult_1->fields["ftt_tst_data_fim"];
                        $ftt_tst_id_prova            = $SqlResult_1->fields["ftt_tst_id_prova"];
                        $ftt_tst_carrecao            = $SqlResult_1->fields["ftt_tst_carrecao"];
                        $ftt_tst_id_area             = $SqlResult_1->fields["ftt_tst_id_area"];
                        $ftt_can_nome                = utf8_encode($SqlResult_1->fields["ftt_can_nome"]);
                        $ftt_can_email               = $SqlResult_1->fields["ftt_can_email"];
                        $ftt_prv_nome                = $SqlResult_1->fields["ftt_prv_nome"];
                        $tempo_teste                 = $SqlResult_1->fields["tempo_teste"];
                        $ftt_prv_tempo               = $SqlResult_1->fields["ftt_prv_tempo"];

                        $Tempo = m2h($ftt_prv_tempo);

                        switch ($ftt_tst_status) {
                            case 1:
                                $sStatus = "Aberto";
                                $flag_campo = "";
                                break;
                            case 2:
                                $sStatus = "Em execução";
                                $flag_campo = "disabled";
                                break;
                            case 3:
                                $sStatus = "Pendente";
                                $flag_campo = "disabled";

                                $aRetorno                   = fRetornaCorrecao($ftt_tst_id);
                                $iTotalPerguntas            = $aRetorno["iTotalPerguntas"];
                                $aResultadoFinal            = $aRetorno["aResultadoFinal"]; 
                                $iTotalPontos               = $aRetorno["iTotalPontos"]; 
                                $iTotalCorreto              = $aRetorno["iTotalCorreto"];
                                $iTotalErrado               = $aRetorno["iTotalErrado"];
                                $iTotalAnuladoCandidato     = $aRetorno["iTotalAnuladoCandidato"];
                                $iTotalAnuladoTempo         = $aRetorno["iTotalAnuladoTempo"];               
                                break;
                            case 4:
                                $sStatus = "Finalizado";
                                $flag_campo = "disabled";


                                $aRetorno                   = fRetornaCorrecao($ftt_tst_id);
                                $iTotalPerguntas            = $aRetorno["iTotalPerguntas"];
                                $aResultadoFinal            = $aRetorno["aResultadoFinal"]; 
                                $iTotalPontos               = $aRetorno["iTotalPontos"]; 
                                $iTotalCorreto              = $aRetorno["iTotalCorreto"];
                                $iTotalErrado               = $aRetorno["iTotalErrado"];
                                $iTotalAnuladoCandidato     = $aRetorno["iTotalAnuladoCandidato"];
                                $iTotalAnuladoTempo         = $aRetorno["iTotalAnuladoTempo"];               

                                break;            
                        }

                        $aResultadoTotalTeste = array();
                        $aResultadoTotalTeste["correto"] = 0;
                        $aResultadoTotalTeste["errado"] = 0;
                        $aResultadoTotalTeste["anulado_candidato"] = 0;
                        $aResultadoTotalTeste["anulado_tempo"] = 0;

                        if ($aResultadoFinal){
                             foreach ($aResultadoFinal as $value) {
                                 switch ($value) {
                                     case "correto":
                                         $aResultadoTotalTeste["correto"]++;
                                         break;
                                     case "errado":
                                         $aResultadoTotalTeste["errado"]++;
                                         break;
                                     case "anulado_candidato":
                                         $aResultadoTotalTeste["anulado_candidato"]++;
                                         break;
                                     case "anulado_tempo":
                                         $aResultadoTotalTeste["anulado_tempo"]++;
                                         break;
                                 }
                             }
                        }   

                        
                        
//                        $sMail_To        = strtolower($rec_usu_email);
                        $sMail_To       = "flopesjunior@gmail.com";
                        
                        $sMail_From     = "workflow@fulltime.com.br";
                        
                        $sMail_Assunto  = "## FEEDBACK TESTE ## ";
                        
                        $sMail_Mensagem = "<font face=verdana><h4>".$ftt_can_nome."</h4></font>";
                        $sMail_Mensagem .= "<font face=Verdana size=2><p>Segue abaixo o resultado do teste realizado ".$ftt_tst_data_inicio." ";
                        $sMail_Mensagem .= "<table border=0 cellspacing=1 cellpading=0>";
                        $sMail_Mensagem .= "<tr bgcolor=darkgray>";
                        $sMail_Mensagem .= "<td><font color=white face=verdana size=2><b>Correto</b></font></td>";
                        $sMail_Mensagem .= "<td><font color=white face=verdana size=2>".$aResultadoTotalTeste["correto"]."</font></td>";
                        $sMail_Mensagem .= "</tr>";
                        $sMail_Mensagem .= "</table>";
                        
                        $aMail_To = explode(";", $sMail_To);


                        foreach ($aMail_To as $valor) {

                            $email_send = new CI_Email();

                            $config['protocol']         = 'smtp';
                            $config['charset']          = 'iso-8859-1';
                            $config['wordwrap']         = TRUE;
                            $config['smtp_host']        = 'smtp.fulltime.com.br';
                            $config['smtp_user']        = 'fernando.lopes@fulltime.com.br';
                            $config['smtp_pass']        = 'ft12dt28'; 		
                            $config['smtp_port']        = '587';
                            $config['smtp_timeout']     = '7';
                            $config['mailtype']         = 'html';

                            $To = trim($valor);

                            $email_send->initialize($config);     

                            $email_send->from($sMail_From, 'Workflow');
                            $email_send->to($To); 

                            $email_send->subject($sMail_Assunto);
                            $email_send->message($sMail_Mensagem);
                            
                            $enviou = $email_send->send();
                            if ($enviou) echo "mail to: $To \n";
                            else echo "mail FAIL to: $To \n";                            
                            
                        }

                        $SqlResult_1->MoveNext();
                   }
               }

               
    }
    
    function EnviaEmailFeedbackTeste_(){
    global $dbsis_mysql;
    global $sDiretorioRaiz;

        $dData = date("Y-m-d");
        $tHora = date("His");

        //Cria a pasta com a data do arquivo de log
//        if (!file_exists("$sDiretorioRaiz\\log\\$dData")) {
//            mkdir("$sDiretorioRaiz\\log\\$dData");
//        }

        //Cria o arquivo de log
        //$this->ArquivoLog = fopen("$sDiretorioRaiz\\log\\$dData\\log-chip-online-$dData-$tHora.csv", "a");

        $this->tInicioProcesso = date("d/m/Y h:i:s");

            //SELECT NOS EVENTOS N�O BAIXADOS, VERIFICA��O DO TEMPO EM SEGUNDOS
            $sSql = "
                    SELECT
                        serial.INDICE,
                        MIN(serial.data) AS ultima_data,
                        UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(MIN(serial.data)) AS segundos_off,
                        TIMEDIFF(NOW(), MIN(serial.data)) AS tempo_decorrido,
                        geusuario.rec_usu_desc,
                        geusuario.rec_usu_email
                    FROM serial
                    INNER JOIN geusuario ON (geusuario.INDICE = serial.INDICE)
                    WHERE geusuario.rec_usu_liberado = 'S' AND 
                    geusuario.rec_usu_wkf_offline = 1
                    GROUP BY serial.INDICE
            ";

            $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die($dbsis_mysql->ErrorMsg());

            if ($SqlResult_1->NumRows() > 0) {

                while (!$SqlResult_1->EOF) {

                        $INDICE = $SqlResult_1->fields["INDICE"];
                        $ultima_data = fFormataData3($SqlResult_1->fields["ultima_data"]);
                        $segundos_off = $SqlResult_1->fields["segundos_off"];
                        $rec_usu_desc = $SqlResult_1->fields["rec_usu_desc"];
                        $rec_usu_email = $SqlResult_1->fields["rec_usu_email"];
                        $tempo_decorrido = $SqlResult_1->fields["tempo_decorrido"];

                        $aTempoCorrido = explode(":", $tempo_decorrido);

                        $TempoCorridoFormatado = $aTempoCorrido[0]."h ".$aTempoCorrido[1]."m ".$aTempoCorrido[2]."s ";

                        if ($segundos_off > 600){

                            $sMail_To        = strtolower($rec_usu_email);
                            //$sMail_To       = "fernando.lopes@fulltime.net.br";
                            $sMail_From     = "workflow@fulltime.net.br";
                            $sMail_Assunto  = "## AVISO PLUS ## EVENTOS DO CLIENTE RS232 PENDENTES";
                         /*   $sMail_Mensagem = "<font face=verdana><h4>Sr. Cliente</h4></font>"
                            .$sMail_Mensagem = "<font face=Verdana size=2><p>O ultimo evento baixado pelo software "
                            .$sMail_Mensagem = "cliente do PLUS, foi na data ".$ultima_data." por favor verifique se "
                            .$sMail_Mensagem = "todas as configura��es do software est�o corretas e verifique sua comunica��o.</p></font>";*/
                            $sMail_Mensagem = "<font face=verdana><h4> $INDICE - ".$rec_usu_desc."</h4></font>";
                            $sMail_Mensagem .= "<font face=Verdana size=2><p>O ultimo evento baixado pelo software cliente do FULLARM, foi na data ";
                            $sMail_Mensagem .= "<B>".$ultima_data."</B> por favor verifique se todas as configura��es do software est�o corretas e verifique sua comunica��o.</p></font>";
                            $sMail_Mensagem .= "<table border=0 cellspacing=1 cellpading=0>";
                            $sMail_Mensagem .= "<tr bgcolor=darkgray>";
                            $sMail_Mensagem .= "<td><font color=white face=verdana size=2><b>Ultimo Evento</b></font></td>";
                            $sMail_Mensagem .= "<td><font color=white face=verdana size=2><b>Tempo na Fila</b></font></td>";
                            $sMail_Mensagem .= "</tr>";
                            $sMail_Mensagem .= "<tr bgcolor=silver>";
                            $sMail_Mensagem .= "<td><font face=verdana size=2>".$ultima_data."</font></td>";
                            $sMail_Mensagem .= "<td><font face=verdana size=2>".$TempoCorridoFormatado."</font></td>";
                            $sMail_Mensagem .= "</tr>";
                            $sMail_Mensagem .= "</table>";
                            $aMail_To = explode(";", $sMail_To);


                            //Emails para os clientes -----------------------------
                            $To_Historico = "<tr><td><font color=black face=verdana size=2><b>Email enviado para: </b></font></td></tr>";
                            foreach ($aMail_To as $valor) {
                                
                                $email_send = new CI_Email();

                                $config['protocol'] = 'smtp';
                                $config['charset'] = 'iso-8859-1';
                                $config['wordwrap'] = TRUE;
                                $config['smtp_host'] = '192.168.1.4';
                                $config['smtp_user'] = 'tecnico@fulltime.net.br';
                                $config['smtp_pass'] = 'tecft72010'; 		
                                $config['smtp_port'] = '2525';
                                $config['smtp_timeout'] = '7';
                                $config['mailtype'] = 'html';

                                $To = trim($valor);
                                $To_Historico .= "<tr><td><font color=black face=verdana size=2>$To</font></td><tr>";
                                
                                $email_send->initialize($config);     

                                $email_send->from($sMail_From, 'Workflow');
                                $email_send->to($To); 

                                $email_send->subject($sMail_Assunto);
                                $email_send->message($sMail_Mensagem);	
                                if (!empty($To)){
                                    $enviou = $email_send->send();
                                }else {
                                         echo "$To - NAO ENVIADO";
                                     //   if ($enviou) $this->out("mail to: $To");
                                   //     else $this->out("mail FAIL to: $To");
                                }

                            }

                            //Emails para FULL TIME -----------------------------
                            $sMail_To_FullTime  = "plantao24horas@fulltime.com.br";
                            //$sMail_To_FullTime .= "fernando.lopes@fulltime.net.br";

                            $aMail_To = explode(";", $sMail_To_FullTime);

                            //Concatena os email do cliente que foi enviados e chumba na mensagem
                            $sMail_Mensagem_FullTime = $sMail_Mensagem."<table>".$To_Historico."</table>";
                            $sMail_Assunto  = "## AVISO PLUS ## EVENTOS DO CLIENTE RS232 PENDENTES - $rec_usu_desc";

                            foreach ($aMail_To as $valor) {

                                $email_send = new CI_Email();

                                $config['protocol'] = 'smtp';
                                $config['charset'] = 'iso-8859-1';
                                $config['wordwrap'] = TRUE;
                                $config['smtp_host'] = '192.168.1.4';
                                $config['smtp_user'] = 'tecnico@fulltime.net.br';
                                $config['smtp_pass'] = 'tecft72010'; 		
                                $config['smtp_port'] = '2525';
                                $config['smtp_timeout'] = '7';
                                $config['mailtype'] = 'html';

                                $To = trim($valor);

                                $email_send->initialize($config);     

                                $email_send->from($sMail_From, 'Workflow');
                                $email_send->to($To); 

                                $email_send->subject($sMail_Assunto);
                                $email_send->message($sMail_Mensagem_FullTime);	
                                if (!empty($To)){
                                    $enviou = $email_send->send();
                                    echo "$To - ENVIADO \n";
                                }else {
                                         echo "$To - NAO ENVIADO";
                                     //   if ($enviou) $this->out("mail to: $To");
                                   //     else $this->out("mail FAIL to: $To");
                                }

                            }

                          }


                    $SqlResult_1->MoveNext();

                }

            }

    }

}

