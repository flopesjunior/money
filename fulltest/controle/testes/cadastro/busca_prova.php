<?
require_once('../../../indicadores.ini.php');

    $ftt_prv_id   = $_POST["ftt_prv_id"];
    
    $sDisplay = "";
                                     
                                    $sSql = "
                                        select 	
                                                ftt_prv_id, 
                                                ftt_prv_descricao, 
                                                ftt_prv_nome,
                                                ftt_prv_tempo, 
                                                ftt_prv_nivel, 
                                                ftt_prv_data_cadastro, 
                                                ftt_prv_data_ultalt
                                                from ftt_prova 
                                                WHERE ftt_prv_id = $ftt_prv_id
                                                ORDER BY ftt_prv_descricao
                                        ";  
//                                    echo $sSql."<BR>";
                                    
                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                    $sDisplay .= "<table width='1%' border='0' cellspacing='0' cellpadding='0'>";  
                                    
                                    if ($SqlResult_1->NumRows() > 0) {
                                            $ftt_prv_id                    = $SqlResult_1->fields["ftt_prv_id"];                              
                                            $ftt_prv_descricao             = $SqlResult_1->fields["ftt_prv_descricao"]; 
                                            $ftt_prv_nome                  = $SqlResult_1->fields["ftt_prv_nome"]; 
                                            $ftt_prv_tempo                  = $SqlResult_1->fields["ftt_prv_tempo"];
                                            $ftt_prv_nivel                 = $SqlResult_1->fields["ftt_prv_nivel"];
                                            $ftt_prv_data_cadastro         = $SqlResult_1->fields["ftt_prv_data_cadastro"];
                                            
                                            if (strlen($ftt_prv_descricao) > 100){
                                                $ftt_prv_descricao = substr($ftt_prv_descricao, 0, 100)."...";
                                            }
                                            
                                            $sSql = "
                                                select SUM(ftt_prc_quantidade) AS qtd 	
                                                        from ftt_prova_conteudo 
                                                        where ftt_prc_id_prova = $ftt_prv_id 
                                                ";  
        //                                    echo $sSql."<BR>";

                                            $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen"); 
                                            
                                            if ($SqlResult_2->NumRows() > 0) {
                                               $qtd = $SqlResult_2->fields["qtd"];             
                                            }
                                            
                                                    
                                            
                                            $Tempo = m2h($ftt_prv_tempo);
                                            
                                            
                                            $sDisplay .= "
                                                       <tr>  
                                                         <td colspan=3 nowrap>
                                                            <b>Prova:</b> $ftt_prv_nome 
                                                         </td>
                                                       </tr>
                                                       <tr>
                                                         <td colspan=3 nowrap>
                                                            <b>Descrição:</b> $ftt_prv_descricao 
                                                         </td>
                                                       </tr>
                                                       <tr>
                                                         <td nowrap>
                                                            <b>Tempo de Prova:</b> $Tempo 
                                                         </td>
                                                         <td>&nbsp;&nbsp;</td>
                                                         <td nowrap>
                                                            <b>Qtd Questões:</b> $qtd
                                                         </td>
                                                       </tr>
                                                       <tr><td height='30px'></td></tr>

                                            ";

                                    }
                                    
                                    $sDisplay .= "</table>";        

                                    echo $sDisplay;
        
    
?>