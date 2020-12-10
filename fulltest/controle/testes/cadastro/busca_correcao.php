<?
require_once('../../../indicadores.ini.php');

    $ftt_tsp_id   = $_POST["ftt_tsp_id"];
    
    
        $sSql = "
        SELECT 
        ftt_tsp_id, ftt_tsp_ordem,  
        ftt_per_descricao, 
        ftt_tsp_resp_dissertativa, 
        ftt_per_tipo, 
        ftt_per_id, 
        ftt_tsp_correto,    
        ftt_tsp_anulada_tmp_expirado,
        ftt_tsp_anulada,
        ftt_tsp_observacao
        from ftt_teste_perguntas 
        inner join ftt_pergunta on ftt_per_id = ftt_tsp_id_pergunta
        where ftt_tsp_id = $ftt_tsp_id 
         ";  
         
//         echo $sSql."<BR>";

         $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


         if ($SqlResult_1->NumRows() > 0) {

                 $ftt_tsp_id                        = $SqlResult_1->fields["ftt_tsp_id"];                              
                 $ftt_tsp_ordem                     = $SqlResult_1->fields["ftt_tsp_ordem"]; 
                 $ftt_tsp_resp_dissertativa         = $SqlResult_1->fields["ftt_tsp_resp_dissertativa"]; 
                 $ftt_per_descricao                 = $SqlResult_1->fields["ftt_per_descricao"]; 
                 $ftt_per_tipo                      = $SqlResult_1->fields["ftt_per_tipo"]; 
                 $ftt_per_id                        = $SqlResult_1->fields["ftt_per_id"]; 
                 $ftt_tsp_correto                   = $SqlResult_1->fields["ftt_tsp_correto"]; 
                 $ftt_tsp_anulada_tmp_expirado      = $SqlResult_1->fields["ftt_tsp_anulada_tmp_expirado"]; 
                 $ftt_tsp_anulada                   = $SqlResult_1->fields["ftt_tsp_anulada"];  
                 $ftt_tsp_observacao                = $SqlResult_1->fields["ftt_tsp_observacao"];  
                 
                 
                    if ($ftt_tsp_correto == "S"){
                        $flag_correto1 = "checked";
                        $flag_correto2 = "";
                    }
                    else if ($ftt_tsp_correto == "N"){
                        $flag_correto1 = "";
                        $flag_correto2 = "checked";
                    }
                 
                    echo "
                        <div class=\"modal-body\">
                            <table cellpadding=0 cellspacing=0 border=0 align=center>
                                  <tr>
                                      <td>
                                            <h3>Questão #$ftt_tsp_ordem</h3>
                                      </td>    
                                  </tr>    
                                  <tr>
                                      <td>
                                        <div class=\"well\">
                                            $ftt_per_descricao
                                        </div>     
                                      </td>    
                                  </tr>    
                                  <tr>
                                      <td style='border-bottom: thin solid #000000'>
                                          Resposta:
                                      </td>    
                                  </tr>    
                                  <tr><td height=5px></td></tr> 
                                  <tr>
                                      <td>
                                            <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                            ";
                                        
                                            switch ($ftt_per_tipo) {
                                                case "2":

                                                       $sSql = "
                                                                select 
                                                                   ftt_alt_id, 
                                                                   ftt_alt_desc, 
                                                                   ftt_alt_correta, 
                                                                   ftt_alt_id_pergunta, 
                                                                   ftt_alt_ordem
                                                                from ftt_pergunta_alternativas 
                                                                where ftt_alt_id_pergunta = $ftt_per_id and ftt_alt_desc <> ''
                                                                    order by ftt_alt_ordem

                                                          ";  
//                                                                                          echo $sSql."<BR>";

                                                      $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    

                                                      $aEspecialidade = array();

                                                      if ($SqlResult_1->NumRows() > 0) {

                                                           while (!$SqlResult_1->EOF) {
                                                              $ftt_alt_id               = $SqlResult_1->fields["ftt_alt_id"];                              
                                                              $ftt_alt_desc             = $SqlResult_1->fields["ftt_alt_desc"]; 
                                                              $ftt_alt_correta          = $SqlResult_1->fields["ftt_alt_correta"];
                                                              $ftt_alt_ordem            = $SqlResult_1->fields["ftt_alt_ordem"];

                                                              if ($ftt_alt_correta == "S") $sbgcolor = "bgcolor=#98FB98";
                                                              else $sbgcolor = "";       
                                                              
                                                              $sSql = "
                                                                    select ftt_tsa_id from ftt_teste_perguntas_alt_selec where ftt_tsa_id_teste_perguntas = $ftt_tsp_id and ftt_tsa_id_alternativa_selecionada = $ftt_alt_id

                                                              ";  
        //                                                                                          echo $sSql."<BR>";

                                                              $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    

                                                              if ($SqlResult_2->NumRows() > 0) {
                                                                    $sFlag = "checked";
                                                              }                        
                                                              else {
                                                                    $sFlag = "";
                                                              }
                                                              
                                                              if (trim($ftt_alt_desc)!=""){
                                                               echo "
                                                                       <tr>
                                                                          <td align=\"left\">
                                                                              <table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                                                                  <tr>
                                                                                      <td>
                                                                                         <table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\">   
                                                                                            <tr $sbgcolor>
                                                                                              <td width=1%  valign=top>".$ftt_alt_ordem.".</td>
                                                                                              <td>&nbsp;&nbsp;</td>    
                                                                                              <td width=1%  valign=top><input type=\"radio\" $sFlag disabled name=\"optionsAlternativas\" id=\"optionsAlternativas\" value=\"$ftt_alt_id\"></td>
                                                                                              <td>&nbsp;&nbsp;</td>    
                                                                                              <td width=99%  valign=bottom>
                                                                                                    $ftt_alt_desc
                                                                                              </td>
                                                                                            </tr>
                                                                                            <tr><td height=\"10px\"></td></tr> 
                                                                                         </table>   
                                                                                      </td>
                                                                                  </tr>
                                                                              </table> 
                                                                          </td>    
                                                                       </tr> 
                                                                       <tr><td height=\"3px\"></td></tr> 
                                                                       ";
                                                               }

                                                               $SqlResult_1->MoveNext();

                                                            }           

                                                      }  
                                                      
                                                      break;
                                                      
                                                    case "1":

                                                               echo "
                                                                       <tr>
                                                                          <td align=\"left\">
                                                                                $ftt_tsp_resp_dissertativa
                                                                          </td>    
                                                                       </tr>                             


                                                                       ";


                                                                break;   
                                                            
                                                    case "3":

                                                       $sSql = "
                                                                select 
                                                                   ftt_alt_id, 
                                                                   ftt_alt_desc, 
                                                                   ftt_alt_correta, 
                                                                   ftt_alt_id_pergunta, 
                                                                   ftt_alt_ordem
                                                                from ftt_pergunta_alternativas 
                                                                where ftt_alt_id_pergunta = $ftt_per_id and ftt_alt_desc <> ''
                                                                    order by ftt_alt_ordem

                                                          ";  
//                                                                                          echo $sSql."<BR>";

                                                      $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    

                                                      $aEspecialidade = array();

                                                      if ($SqlResult_1->NumRows() > 0) {

                                                           while (!$SqlResult_1->EOF) {
                                                              $ftt_alt_id               = $SqlResult_1->fields["ftt_alt_id"];                              
                                                              $ftt_alt_desc             = $SqlResult_1->fields["ftt_alt_desc"]; 
                                                              $ftt_alt_correta          = $SqlResult_1->fields["ftt_alt_correta"];
                                                              $ftt_alt_ordem            = $SqlResult_1->fields["ftt_alt_ordem"];

                                                              
                                                              if ($ftt_alt_correta == "S") $sbgcolor = "bgcolor=#98FB98";
                                                              else $sbgcolor = "";

                                                              $sSql = "
                                                                    select ftt_tsa_id from ftt_teste_perguntas_alt_selec where ftt_tsa_id_teste_perguntas = $ftt_tsp_id and ftt_tsa_id_alternativa_selecionada = $ftt_alt_id

                                                              ";  
        //                                                                                          echo $sSql."<BR>";

                                                              $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    

                                                              if ($SqlResult_2->NumRows() > 0) {
                                                                    $sFlag = "checked";
                                                              }                        
                                                              else {
                                                                    $sFlag = "";
                                                              }                                                              
                                                              
                                                              if (trim($ftt_alt_desc)!=""){
                                                               echo "
                                                                       <tr>
                                                                          <td align=\"left\" $sbgcolor>
                                                                              <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                                                                  <tr>
                                                                                      <td>
                                                                                         <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">   
                                                                                            <tr>
                                                                                              <td width=1%  valign=top>".$ftt_alt_ordem.".</td>
                                                                                              <td>&nbsp;&nbsp;</td>    
                                                                                              <td width=1%  valign=top><input type=\"checkbox\" $sFlag disabled name=\"optionsAlternativas\" id=\"optionsAlternativas\" value=\"$ftt_alt_id\"></td>
                                                                                              <td>&nbsp;&nbsp;</td>    
                                                                                              <td width=99%  valign=bottom>
                                                                                                    $ftt_alt_desc
                                                                                              </td>
                                                                                            </tr>
                                                                                            <tr><td height=\"10px\"></td></tr> 
                                                                                         </table>   
                                                                                      </td>
                                                                                  </tr>
                                                                              </table> 
                                                                          </td>    
                                                                       </tr>                             
                                                                       <tr><td height=\"3px\"></td></tr> 

                                                                       ";
                                                               }
                                                               
                                                               $SqlResult_1->MoveNext();

                                                            }

                                                      }  
                                                      
                                                      break;                                                  

                                            }
                                            
                            echo "
                                      </td>    
                                  </tr>    
                            </table>                        
                        </div>
                        <div class=\"modal-footer\">
                            <table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                 <tr>
                                     <td width=50%>";
                                        if ($ftt_per_tipo == "1" && $ftt_tsp_anulada_tmp_expirado != 1 && $ftt_tsp_anulada != 1 ){    
                                        echo "
                                            <label class=\"radio-inline\">
                                                <input type=\"radio\" name=\"optionsRadiosInline\" id=\"optionsRadiosInline1\" value=\"S\" $flag_correto1>Certo
                                            </label>    
                                            <label class=\"radio-inline\">
                                                <input type=\"radio\" name=\"optionsRadiosInline\" id=\"optionsRadiosInline2\" value=\"N\" $flag_correto2>Errado
                                            </label>
                                            ";
                                        }   
                                     echo "   
                                     </td>
                                     <td align=right width=50%>
                                            <table width=1% border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                                <tr>";
                                                     if ($ftt_per_tipo == "1" && $ftt_tsp_anulada_tmp_expirado != 1 && $ftt_tsp_anulada != 1 ){      
                                                        echo "
                                                        <td><button type=\"button\" class=\"btn btn-primary\" onclick='SalvarCorrecao($ftt_tsp_id)'>Salvar</button></td>";
                                                     }
                                                    echo "    
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Fechar</button></td>
                                                </tr>
                                            </table>    
                                     </td>
                                 </tr>
                                 <tr><td colspan=2 height=20px></td></tr>
                                 <tr>
                                     <td colspan=2>";
                            
                                     if ($ftt_per_tipo == "1" && $ftt_tsp_anulada_tmp_expirado != 1 && $ftt_tsp_anulada != 1 ){    
                                        echo "
                                         <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                            <tr>
                                                 <td style='border-bottom: thin solid #000000'>
                                                    Observação:
                                                </td>
                                            </tr>  
                                            <tr><td height=10px></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <div id=\"ftt_tsp_observacao\" name=\"ftt_tsp_observacao\">".$ftt_tsp_observacao."</div>
                                                </td>
                                            </tr>
                                        </table> ";
                                     }
                                     
                            echo "         
                                    </td>
                                  </tr>                                        
                                 
                             </table>                         
                        
                        </div>                 
                        
                          

                    ";

         }     

?>