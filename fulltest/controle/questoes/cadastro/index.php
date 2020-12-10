<?
require_once('../../../indicadores.ini.php');

$id_especialidade       = $_GET["id_especialidade"];
$id_nivel               = $_GET["id_nivel"];
$sWhere                 = "";
$_SESSION['aPaginacao'] = array();  
?>

<html>
  <head>
    <title>QUESTÕES <?=$sNomeSistema?></title>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="../../../dist/js/sb-admin-2.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/questoes/cadastro/js.js" type="text/javascript" ></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">  
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       

<!-- MetisMenu CSS -->
    <link href="../../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../../../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    
    <style type="text/css" class="init">
        div.dataTables_wrapper {
                margin-bottom: 3em;
        }      
            
        table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
            font-size: 12px;
        }      
        
        td.details-control {
            background: url('details_open.png') no-repeat center center !important;
            cursor: pointer;
        }
        
        tr.shown td.details-control {
            background: url('details_close.png') no-repeat center center !important;
        }
        
      .modal-content {
            position: relative;
            background-color: #fff;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            border: 1px solid #999;
            border: 1px solid rgba(0,0,0,.2);
            border-radius: 6px;
            outline: 0;
            -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
            box-shadow: 0 3px 9px rgba(0,0,0,.5);
            width: 1024px;
        }     
        
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
            font-size: smaller;
        }  
        
        .modal {
            position: fixed;
            top: 0;
            right: 400;
            bottom: 0;
            left: 0;
            z-index: 1050;
            display: none;
            overflow: hidden;
            -webkit-overflow-scrolling: touch;
            outline: 0;
        }      
        
        
        .fa-star:before {
            content: "\f005";
            color: #125acd;
            font-size: medium;
        }            
        
    </style>
        
    <script>
        function abrejanela(ind_prj_WBS, iEquipe){
            window.open("<?=$sUrlRaiz?>controle/projeto/prj_projetos/modal.php?ind_prj_WBS="+ind_prj_WBS+"&iEquipe="+iEquipe, 'modal');
        }
        function abrejanelaPDF(ind_prj_TipoCodigo){
            window.open("<?=$sUrlRaiz?>controle/projeto/prj_projetos/pdf.php?ind_prj_TipoCodigo="+ind_prj_TipoCodigo, 'lancamento');
        }
        function abrejanelaVencimentos(ind_prj_WBS, ind_prj_UID, iEquipe, ind_prj_ManualFinish_sf,ind_prj_ManualFinish){
            window.open("<?=$sUrlRaiz?>controle/projeto/prj_projetos/modal_venc.php?ind_prj_UID="+ind_prj_UID+"&ind_prj_WBS="+ind_prj_WBS+"&iEquipe="+iEquipe+"&ind_prj_ManualFinish_sf="+ind_prj_ManualFinish_sf+"&ind_prj_ManualFinish="+ind_prj_ManualFinish, 'modal2');
        }
    </script>  
    
    <?inclui_fav();?>
  </head>
  <body style="padding-left: 10; padding-top: 10; padding-right: 10">
      <input type="hidden" value="<?=$iEquipe?>" id="iEquipe" name="iEquipe">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">  
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
             <?
             $sTitulo = "CADASTRO DAS QUESTÕES ";
             $sUrlAlvo = $sUrlRaiz."controle/projeto/prj_projetos/";
             echo fMontaCabecalho($sUrlAlvo, $sTitulo);
             
             $link = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/questoes/cadastro/modal.php','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
             
             ?>   
          
          
             <tr><td height="30px"></td></tr>
             <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="1%">
                                <button type="button" class="btn btn-primary" <?=$link?>>NOVO</button>
                            </td>
                            <td width="1%">&nbsp;&nbsp;</td>
                            <td width="1%">
                                <button type="button" class="btn btn-success" onclick="window.location.href = '<?=$sUrlRaiz?>controle/questoes/cadastro/index.php'">ATUALIZAR</button>
                            </td>
                            <td width="1%">&nbsp;&nbsp;</td>
                            <td width="99%" align="right">
                                <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>    
                                        <td align=left>
                                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                <tr><td>Especialidade</td></tr>
                                                <tr>    
                                                  <td align=left>
                                                        <div class="form-group">
                                                            <select style="width: 200px" class="form-control" id="id_especialidade" value="">
                                                                    <option value='0'>Selecione</option>
                                                                <?
                                                                    $sSql = "
                                                                    select 
                                                                    ftt_esp_id, 
                                                                    ftt_esp_descricao 
                                                                    from 
                                                                    ftt_especialidade
                                                                    order by ftt_esp_descricao
                                                                    ";  
            //                                    echo $sSql."<BR>";

                                                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                                    if ($SqlResult_1->NumRows() > 0) {

                                                                        while (!$SqlResult_1->EOF) {

                                                                            $ftt_esp_id                          = $SqlResult_1->fields["ftt_esp_id"];                              
                                                                            $ftt_esp_descricao                   = utf8_encode($SqlResult_1->fields["ftt_esp_descricao"]); 

                                                                            if ($id_especialidade == $ftt_esp_id) $flag = "selected";
                                                                            else $flag = "";

                                                                            echo "<option value='$ftt_esp_id' $flag>$ftt_esp_descricao</option>";

                                                                            $SqlResult_1->MoveNext();

                                                                         }                                                                    
                                                                    }     
                                                                ?>
                                                            </select>
                                                        </div>                   
                                                    </td>
                                                </tr>  
                                              </table>                                              
                                        </td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left>
                                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align=left nowrap>
                                                        Nível de dificuldade:
                                                    </td>
                                                </tr>                                         
                                                <tr>    
                                                    <td align=left>
                                                        <div class="form-group">
                                                            <select style="width: 200px" class="form-control" id="id_nivel" value="">
                                                                    <option value='0'>Selecione</option>
                                                                <?
                                                                    $sSql = "
                                                                    select 
                                                                    ftt_tip_codigo, ftt_tip_descricao
                                                                    from 
                                                                    ftt_pergunta_tipo_peso
                                                                    order by ftt_tip_codigo
                                                                    ";  
            //                                    echo $sSql."<BR>";

                                                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                                    if ($SqlResult_1->NumRows() > 0) {

                                                                        while (!$SqlResult_1->EOF) {

                                                                            $ftt_tip_codigo                      = $SqlResult_1->fields["ftt_tip_codigo"];                              
                                                                            $ftt_tip_descricao                   = utf8_encode($SqlResult_1->fields["ftt_tip_descricao"]); 

                                                                            if ($id_nivel == $ftt_tip_codigo) $flag = "selected";
                                                                            else $flag = "";

                                                                            echo "<option value='$ftt_tip_codigo' $flag>$ftt_tip_descricao</option>";

                                                                            $SqlResult_1->MoveNext();

                                                                         }                                                                    
                                                                    }     
                                                                ?>
                                                            </select>
                                                        </div>                                       
                                                     </td>
                                                 </tr>                                             
                                              </table>  
                                        </td>   
                                        <td>&nbsp;&nbsp;</td>
                                        <td width="1%">
                                            <button type="button" class="btn btn-default" onclick="filtrar()">FILTRAR</button>
                                        </td>                                            
                                    </tr>     
                                </table>
                            </td>                            
                    </table>    
                </td>    
             </tr> 
             <tr>
                 <td width="1%" nowrap  align="center">
                     
                   
                        
                     
                         <?
                         
                                    $sDisplay = "";
                                     
                                    if ($id_especialidade) {
                                        if ($sWhere) $sWhere .= " AND ftt_per_id_especialidade = $id_especialidade ";
                                        else $sWhere .= " WHERE ftt_per_id_especialidade = $id_especialidade ";
                                    } 
                                    
                                    if ($id_nivel) {
                                        if ($sWhere) $sWhere .= " AND ftt_per_nivel = $id_nivel ";
                                        else $sWhere .= " WHERE ftt_per_nivel = $id_nivel ";
                                    }
                                    
                                    $sSql = "
                                        select 	ftt_per_id, ftt_per_descricao, ftt_per_tipo, ftt_per_nivel, 
                                                ftt_per_data_cadastro, 
                                                ftt_per_id_especialidade,
                                                ftt_esp_descricao
                                                from ftt_pergunta 
                                                INNER JOIN ftt_especialidade ON (ftt_esp_id = ftt_per_id_especialidade)
                                                $sWhere
                                                ORDER BY ftt_per_id_especialidade, ftt_per_nivel, ftt_per_id
                                        ";  
//                                    echo $sSql."<BR>";
                                    
                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR> $sSql");    


                                    if ($SqlResult_1->NumRows() > 0) {

                                        $iCount     = 1;
                                        $iCount2    = 1;
                                        $sModal     = "";
                                        
                                        $sDisplay .= "    
                                            <table id=\"tabela001$iCount\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                                 <thead>
                                                    <tr>
                                                        <th width=\"1%\"></th>
                                                        <th width=\"1%\"></th>
                                                        <th width=\"1%\"></th>
                                                        <th width=\"1%\">#</th>                                                        
                                                        <th width=\"1%\">Especialidade</th>
                                                        <th width=\"1%\">Nível</th>
                                                        <th width=\"1%\">Tipo</th>
                                                        <th width=\"97%\">Questão</th>
                                                    </tr>    
                                                 </thead>  
                                                 <tbody>
                                                ";  
                                        while (!$SqlResult_1->EOF) {

                                            $ftt_per_id                    = $SqlResult_1->fields["ftt_per_id"];                              
                                            $ftt_per_descricao             = $SqlResult_1->fields["ftt_per_descricao"]; 
                                            $ftt_per_tipo                  = $SqlResult_1->fields["ftt_per_tipo"];
                                            $ftt_per_nivel                 = $SqlResult_1->fields["ftt_per_nivel"];
                                            $ftt_per_data_cadastro         = $SqlResult_1->fields["ftt_per_data_cadastro"];
                                            $ftt_per_id_especialidade      = $SqlResult_1->fields["ftt_per_id_especialidade"];
                                            $ftt_esp_descricao             = utf8_encode($SqlResult_1->fields["ftt_esp_descricao"]);
                                            
                                            if (strlen($ftt_per_descricao) > 100){
                                                $ftt_per_descricao = substr($ftt_per_descricao, 0, 100)."...";
                                            }
                                            
                                            $_SESSION['aPaginacao'][] = $ftt_per_id;
                                            
                                            switch ($ftt_per_tipo) {
                                                case "1":
                                                    $tipo = "Dissertativa";
                                                    break;
                                                case "2":
                                                    $tipo = "Escolha única";
                                                    break;
                                                case "3":
                                                    $tipo = "Multipla escolha";
                                                    break;
                                            }
                                            
                                            switch ($ftt_per_nivel) {
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
                                            
                                            $linkEdit  = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/questoes/cadastro/modal.php?ftt_per_id=$ftt_per_id&pag=$iCount','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                            $linkDel   = "onClick=\"deleta_questao($ftt_per_id);\"";
                                            $link_view = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/questoes/cadastro/view.php?pag=$iCount','view','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                            
                                            $sDisplay .= "
                                                       <tr>  

                                                         <td width=1%>
                                                            <button type=\"button\" class=\"btn btn-default btn-circle\" $linkEdit><i class=\"fa fa-list\"></i></button>
                                                         </td>
                                                         <td width=1%>
                                                           <button type=\"button\" class=\"btn btn-default btn-circle\"  ><i class=\"fa  fa-times\"></i></button>
                                                         </td>
                                                         <td width=1%>
                                                           <button type=\"button\" class=\"btn btn-default btn-circle\" $link_view><i class=\"fa  fa-eye\"></i></button>
                                                         </td>
                                                         <td width=1%>
                                                            $iCount
                                                         </td>                                                         
                                                         <td nowrap>
                                                            <h6>$ftt_esp_descricao</h6> 
                                                         </td>
                                                         <td>
                                                            <h6>$nivel</h6> 
                                                         </td>
                                                         <td nowrap>
                                                            <h6>$tipo</h6> 
                                                         </td>
                                                         <td>
                                                            <h6>#$ftt_per_id </h6>
                                                         </td>
                                                       </tr>

                                            ";


                                            $iCount++;
                                            $iCount2++;
                                            
                                            $ftt_per_id_especialidade_ant = $ftt_per_id_especialidade;

                                            $SqlResult_1->MoveNext();

                                        }

                                        $sDisplay .= "</tbody></table>";        
//                                        $sDisplay .= "</div>";     
                                        
                                        echo $sDisplay;

                                    }
                                    else {
                                        echo " 
                                        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"> 
                                            <tr>
                                                <td align=center valign=bottom height=100px>
                                                       a consulta não retornou dados. 
                                                </td>
                                            </tr>
                                        </table>
                                        ";
                                        
                                    } 
                                    
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
      
      
      
  </body>
  
  
</html>