<?
require_once('../../../indicadores.ini.php');

$ftt_prc_id_prova          = $_POST["ftt_prc_id_prova"];

?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
             <tr>
                 <td width="1%" nowrap  align="center">
                         <?
                         
                                    $sDisplay = "";
                                     
                                    $sSql = "
                                         select 
                                            ftt_prc_int, 
                                            ftt_prc_id_especialidade, 
                                            ftt_prc_nivel, 
                                            ftt_prc_quantidade, 
                                            ftt_prc_id_prova,	 
                                            ftt_esp_descricao
                                         from ftt_prova_conteudo 
                                         inner join ftt_especialidade on (ftt_prc_id_especialidade = ftt_esp_id)
                                         where ftt_prc_id_prova = $ftt_prc_id_prova
                                        ";  
//                                    echo $sSql."<BR>";
                                    
                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                    $sDisplay .= "    
                                        <table id=\"tabela001$iCount\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                             <thead>
                                                <tr>
                                                    <th width=\"1%\"></th>
                                                    <th width=\"1%\">#</th>
                                                    <th width=\"1%\">Especialidade</th>
                                                    <th width=\"1%\">Nível</th>
                                                    <th width=\"1%\">Qtd Questões</th>
                                                    <th width=\"97%\">&nbsp;</th>
                                                </tr>    
                                             </thead>  
                                             <tbody>
                                            ";  
                                    
                                    if ($SqlResult_1->NumRows() > 0) {

                                        $iCount = 1;
                                        $iCount2 = 1;
                                        $sModal   = "";
                                        
                                        while (!$SqlResult_1->EOF) {
                                            $ftt_esp_descricao             = $SqlResult_1->fields["ftt_esp_descricao"];                              
                                            $ftt_prc_nivel                 = $SqlResult_1->fields["ftt_prc_nivel"];
                                            $ftt_prc_quantidade            = $SqlResult_1->fields["ftt_prc_quantidade"];
                                            
                                            switch ($ftt_prc_nivel) {
                                                case "1":
                                                    $nivel = "Iniciante";
                                                    break;
                                                case "2":
                                                    $nivel = "Junior";
                                                    break;
                                                case "3":
                                                    $nivel = "Pleno";
                                                    break;
                                                case "4":
                                                    $nivel = "Senior";
                                                    break;
                                                
                                            }

                                            $link = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/provas/cadastro/modal.php?ftt_per_id=$ftt_per_id','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";

                                            $sDisplay .= "
                                                       <tr>  
                                                         <td width=1%>
                                                            <button type=\"button\" class=\"btn btn-default btn-circle\" $link ><i class=\"fa fa-list\"></i></button>
                                                         </td>
                                                         <td width=1%>
                                                            <h4>$iCount</h4> 
                                                         </td>
                                                         <td>
                                                            <h4>$ftt_esp_descricao</h4> 
                                                         </td>
                                                         <td>
                                                            <h4>$nivel</h4> 
                                                         </td>
                                                         <td>
                                                            <h4>$ftt_prc_quantidade</h4> 
                                                         </td>
                                                       </tr>

                                            ";


                                            $iCount++;
                                            $iCount2++;

                                            $SqlResult_1->MoveNext();

                                        }

   
                                        

                                    }
                                    
                                    $sDisplay .= "</tbody></table>";        

                                    echo $sDisplay;
                                    
                         ?>
                         
                 </td>
             </tr>
             <tr><td align="right" height="10px"></td></tr>
             <tr><td height="30px"></td></tr>
      </table>
      <?//=$sModal?>
  
      <script>
            var table = $('table.display').DataTable({
                               "className": 'details-control',
                               "paging":   false,
                               "ordering": false,
                               "info":     false,
                               "language": {
                                           "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                                       }                    
                           }   
                       );           
      </script>    