<?php
require_once "../../money.ini.php";


$data_vencimento_f          = $_POST["data_vencimento_f"];
$tipo_movimentacao          = $_POST["tipo_movimentacao"];
$origem                     = $_POST["origem"];
$valor                      = $_POST["valor"];
$periodicidade              = $_POST["periodicidade"];
$observacao                 = $_POST["observacao"];
$mny_con_id_origem          = $_POST["mny_con_id_origem"];
$mny_con_id                 = $_POST["mny_con_id"];
$parcela                    = $_POST["parcela"];
$data_vencimento            = $_POST["data_vencimento"];
$mny_con_id_peridiocidade   = $_POST["mny_con_id_peridiocidade"];
$pago                       = $_POST["pago"];   
$parcela_f                  = $_POST["parcela_f"]; 
$mes_atual                  = $_POST["mes_atual"]; 
$ano_atual                  = $_POST["ano_atual"]; 
$mny_pag_id                 = $_POST["mny_pag_id"]; 


$sSql = "
            SELECT 
                mny_ori_cartao_credito 
            FROM money_origem_transacao
            WHERE 
                mny_ori_id = $mny_con_id_origem 
    ";  
                                   // echo $sSql."<BR>";

$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

if ($SqlResult_1->NumRows() > 0) {
    $mny_ori_cartao_credito = $SqlResult_1->fields["mny_ori_cartao_credito"]; 
}

$sSql = "
            SELECT 
                mny_pag_id, 
                mny_pag_id_contas, 
                mny_pag_id_extrato, 
                mny_pag_vencimento_original, 
                mny_pag_vencimento_pago, 
                mny_pag_valor_original, 
                mny_pag_valor_pago, 
                mny_pag_parcela, 
                mny_pag_tipo_baixa, 
                mny_pag_mes, 
                mny_pag_ano
            FROM money_pagamentos
            WHERE 
                mny_pag_id = $mny_pag_id 
    ";  
//                                    echo $sSql."<BR>";

$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

if ($SqlResult_1->NumRows() > 0) {
    
    $mny_pag_tipo_baixa = $SqlResult_1->fields["mny_pag_tipo_baixa"]; 
    $mny_pag_id         = $SqlResult_1->fields["mny_pag_id"]; 
    
    if ($mny_pag_tipo_baixa == 1){
        
        $mny_pag_id_extrato = $SqlResult_1->fields["mny_pag_id_extrato"]; 
        
        $sSql = "
            SELECT 
                mny_exc_id,
                mny_exc_data, 
                mny_exc_historico, 
                mny_exc_tipo_mov, 
                mny_exc_valor,
                mny_exc_numdocumento
            FROM money_extrato_cc
            WHERE 
                mny_exc_id = $mny_pag_id_extrato 
        ";  
                           //         echo $sSql."<BR>";

        $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql); 
        $mny_exc_tipo_mov       = $SqlResult_2->fields["mny_exc_tipo_mov"]; 
        $mny_exc_data           = $SqlResult_2->fields["mny_exc_data"]; 
        $mny_exc_historico      = utf8_encode($SqlResult_2->fields["mny_exc_historico"]); 
        $mny_exc_valor          = $SqlResult_2->fields["mny_exc_valor"]; 
        $mny_exc_numdocumento   = $SqlResult_2->fields["mny_exc_numdocumento"]; 
        
        
        $sExtrato = "<table class=table><tbody><tr><td width=1% align=center><b>".$mny_exc_tipo_mov."</b></td><td nowrap width=1%>".fFormataData($mny_exc_data)."</td><td nowrap  width=95%>".$mny_exc_historico."</td><td nowrap  width=1%>Doc: ".$mny_exc_numdocumento."</td><td nowrap align=right>R$ ".fFormataMoeda($mny_exc_valor, 2)."</td></tr> </tbody></table> ";     
        
        $data_vencimento_f  = fFormataData($mny_exc_data);
        $valor              = $mny_exc_valor;
        
    }
    
    $fFlagBaixado = true;
    
}
else {
    
    $fFlagBaixado = false;
    
}

$sDisplay  = ""; 
$sDisplay .= "
        <input type=\"hidden\" value=\"$mny_pag_id\" id=\"mny_pag_id_modal\" name=\"mny_pag_id_modal\">
        <form id=\"frmBaixa\" name=\"frmBaixa\">
            <div class=\"row\"> 
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            Vencimento
                        </div>
                        <div class=\"panel-body\">
                            $data_vencimento_f
                        </div>
                    </div>
                </div> 
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            Deb/Crd
                        </div>
                        <div class=\"panel-body\">
                            $tipo_movimentacao
                        </div>
                    </div>
                </div> 
               
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            Valor
                        </div>
                        <div class=\"panel-body\">
                            <b>R$ $valor</b>
                        </div>
                    </div>
                </div>                
            </div>
            <div class=\"row\">  
                <div class=\"col-lg-6 col-md-6\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            Origem
                        </div>
                        <div class=\"panel-body\">
                            <b>$origem</b>
                        </div>
                    </div>
                </div>  
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            Periodicidade
                        </div>
                        <div class=\"panel-body\">
                            $periodicidade
                        </div>
                    </div>
                </div>    
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            Parcela
                        </div>
                        <div class=\"panel-body\">
                            $parcela_f
                        </div>
                    </div>
                </div>                 
            </div>";

    if  ($observacao != ""){     
        
        $sDisplay .= "    
            <div class=\"row\">  
                <div class=\"col-lg-12 col-md-6\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            Observação
                        </div>
                        <div class=\"panel-body\">
                            $observacao
                        </div>
                    </div>
                </div>                             
            </div>
        "; 
    }    

    if ($mny_ori_cartao_credito == 1 && $fFlagBaixado == false){
        $sDisplay .= "    
            <div class=\"row\">  
                <div class=\"col-lg-12\" align=right>
                    <button type=\"button\" onClick=\"fBaixarContaPagarReceber('2')\" class=\"btn btn-primary\"><i class=\"fa fa-check fa-fw\"></i> Marcar como pago</button>&nbsp;&nbsp;
                    <button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-default\"><i class=\"fa fa-sign-out fa-fw\"></i> Cancelar</button>
                </div>
            </div> 
            <BR>
        ";
        
    }
    else {
        if ($fFlagBaixado == false){
            $sDisplay .= "    
                <div class=\"row\">  
                    <div class=\"col-lg-12\" align=right>
                        <button type=\"button\" onClick=\"fBaixarContaPagarReceber('1')\" class=\"btn btn-success\"><i class=\"fa fa-check fa-fw\"></i> Conciliar</button>&nbsp;&nbsp;
                        <button type=\"button\" onClick=\"fBaixarContaPagarReceber('2')\" class=\"btn btn-primary\"><i class=\"fa fa-check fa-fw\"></i> Marcar como pago</button>&nbsp;&nbsp;
                        <button type=\"button\" onClick=\"fBaixarContaPagarReceber('3')\" class=\"btn btn-warning\"><i class=\"fa fa-times fa-fw\"></i> Ignorar lançamento</button>&nbsp;&nbsp;
                        <button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-default\"><i class=\"fa fa-sign-out fa-fw\"></i> Cancelar</button>
                    </div>
                </div> 
                <BR>
            ";
        }
        else {
            $sDisplay .= "    
                <div class=\"row\">  
                    <div class=\"col-lg-12\" align=right>
                        <button type=\"button\" onClick=\"fExtornarContaPagarReceber()\" class=\"btn btn-info\"><i class=\"fa fa-undo fa-fw\"></i> Extronar</button>&nbsp;&nbsp;
                        <button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-default\"><i class=\"fa fa-sign-out fa-fw\"></i> Cancelar</button>
                    </div>
                </div> 
                <BR>
            ";        
        }
    }    
    
    if ($fFlagBaixado == false && $mny_ori_cartao_credito == 0){
    
        $sSql = "
                SELECT 
                    mny_exc_id, 
                    mny_exc_data, 
                    mny_exc_historico, 
                    mny_exc_id_tipo, 
                    mny_exc_valor, 
                    mny_exc_numdocumento, 
                    mny_exc_tipo_mov,
                    mny_pag_id_extrato
                FROM money_extrato_cc
                LEFT JOIN money_pagamentos ON mny_pag_id_extrato = mny_exc_id
                WHERE 
                    month(mny_exc_data) = $mes_atual AND 
                    year(mny_exc_data) = $ano_atual AND  
                    mny_exc_numdocumento <> '-1'
                ORDER BY 
                    mny_exc_data, 
                    mny_exc_tipo_mov
        ";  
    //                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

        if ($SqlResult_1->NumRows() > 0) {

            $iCount = 0;
            $iCountTable = 0;
            $sModal   = "";

            $sDisplay .= "    
                <div class=\"row\">  
                    <div class=\"col-lg-12 col-md-6\">
                        <div class=\"panel panel-primary\">
                            <div class=\"panel-heading\">
                                Lançamento Selecionado
                            </div>
                            <div class=\"panel-body\">
                                <div id=\"mostra_lancamento\"></div>
                            </div>
                            <div class=\"panel-footer\">
                                <div id=\"botao_mostra_lancamento\"></div>
                            </div>

                        </div>
                    </div>                             
                </div>
                <div class=\"row\">  
                    <div class=\"col-lg-12 col-md-6\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                Extrato da Conta Corrente
                            </div>
                            <div class=\"panel-body\">
                                <table id=\"tabela_extrato\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                     <thead>
                                        <tr>
                                            <th width=\"1%\"></th>
                                            <th width=\"1%\">Tipo</th>
                                            <th width=\"1%\">Data</th>
                                            <th width=\"1%\">Histórico</th>
                                            <th width=\"1%\" align=right>Valor</th>
                                        </tr>    
                                     </thead>  
                                     <tbody>
                        ";  

            while (!$SqlResult_1->EOF) {
            $mny_exc_id             = $SqlResult_1->fields["mny_exc_id"];                              
            $mny_exc_data           = fFormataData($SqlResult_1->fields["mny_exc_data"]); 
            $mny_exc_historico      = utf8_encode($SqlResult_1->fields["mny_exc_historico"]); 
            $mny_exc_id_tipo        = $SqlResult_1->fields["mny_exc_id_tipo"]; 
            $mny_exc_numdocumento   = $SqlResult_1->fields["mny_exc_numdocumento"]; 
            $mny_exc_tipo_mov       = $SqlResult_1->fields["mny_exc_tipo_mov"]; 
            $mny_exc_valor          = $SqlResult_1->fields["mny_exc_valor"]; 
            $mny_pag_id_extrato     = $SqlResult_1->fields["mny_pag_id_extrato"]; 

                $linkEdit = "onClick=\"JavaScript:window.open('".$sUrlRaiz."sis/contas/cadastro/modal.php?mny_con_id=$mny_con_id','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                $linkDel  = "onClick=\"deleta_candidato($mny_con_id);\"";

                $aValoresTipoMov[$mny_exc_tipo_mov] = $aValoresTipoMov[$mny_exc_tipo_mov] + $mny_exc_valor;


                switch ($mny_exc_tipo_mov) {
                    case "C":
                        $ColorFont = "blue";
                        break;
                    case "D":
                        $ColorFont = "red";
                        break;
                    default:
                        $ColorFont = "black";
                        break;
                } 

                if ($mny_pag_id_extrato == ""){
                    $sMostraCheck = "<div class=\"form-check\">
                                                <input onClick=\"fLancamentoSelected('$mny_exc_id', '$mny_exc_data', '$mny_exc_historico', '$mny_exc_tipo_mov', '".fFormataMoeda($mny_exc_valor, 2)."')\" class=\"form-check-input\" type=\"radio\" name=\"IdExtratoSelected\" id=\"IdExtratoSelected_$mny_exc_id\" value=\"$mny_exc_id\">
                                     </div>";
                }
                else {
                    $sMostraCheck = "<i class=\"fa fa-check fa-fw\"></i>";
                }
                
                
                $sDisplay .= "
                                        <tr>  
                                          <td width=1%>
                                             $sMostraCheck
                                          </td>
                                          <td width=1% align=center>
                                             <font color=$ColorFont><b>$mny_exc_tipo_mov</b></font>
                                          </td>
                                          <td nowrap width=1%>
                                             $mny_exc_data 
                                          </td>
                                          <td nowrap  width=95%>
                                             $mny_exc_historico 
                                          </td>
                                          <td nowrap align=right>
                                             ".fFormataMoeda($mny_exc_valor, 2)."  
                                          </td>
                                        </tr>

                ";

                $iCount++;

                $SqlResult_1->MoveNext();

            }

            $sDisplay .= "          </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                             
                </div>
                <input type=\"hidden\" value=\"\" id=\"mny_exc_id\"     name=\"mny_exc_id\">
            </form>
            <script>
                $('#tabela_extrato').DataTable( {
                    \"className\": 'details-control',
                    \"paging\":   false,
                    \"info\":     false,
                    \"ordering\": false,  
                    \"language\": {
                        \"url\": \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json\"
                    }
                } ); 
            </script>    

            "; 

        }
    }    
    else if ($mny_pag_tipo_baixa == 1){
        
        
            $sDisplay .= "    
                <div class=\"row\">  
                    <div class=\"col-lg-12 col-md-6\">
                        <div class=\"panel panel-primary\">
                            <div class=\"panel-heading\">
                                Lançamento Selecionado do Extrato
                            </div>
                            <div class=\"panel-body\">
                                $sExtrato
                            </div>
                        </div>
                    </div>                             
                </div>";        
    }
    
    
echo $sDisplay;

?>
        

