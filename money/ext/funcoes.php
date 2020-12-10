<?php

function fCabecalho($Tela){
    
echo "
    <div class=\"row\">
         <div class=\"col-lg-12\">
             <div class=\"huge\">$Tela</div>
         </div>    
    </div>";
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

function fFormataData($dData) {

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



function fMontaGridParcelas($aDados) {
global $sUrlRaiz; 
global $dbsis_mysql;  
    
    $mny_con_data_base  = $aDados[0];
    $mny_con_valor      = $aDados[1];
    $mny_con_parcelas   = $aDados[2];
    
    $fValorTotal = $mny_con_parcelas * fFormataMoeda($mny_con_valor);

    echo "
    <div class=\"table-responsive\">
        <table class=\"table table-striped table-bordered table-hover\">
            <thead>
                <tr><th colspan=3>Relação das parcelas</th></tr>
                <tr>
                    <th width=50px style=\"vertical-align:middle; text-align: center\">#</th>
                    <th width=100px style=\"vertical-align:middle; text-align: center\">Vencimento</th>
                    <th width=100px style=\"vertical-align:middle; text-align: center\">Valor</th>
                </tr>
            </thead>
            <tbody>";     

            for ($i=0;$i <$mny_con_parcelas; $i++){

                $iParc = $i + 1;
                
                $data = new DateTime($mny_con_data_base);

                $sFator = "P".$iParc."M";

                $data->add(new DateInterval($sFator));

                
                //$sSql           = "SELECT DATE_FORMAT(DATE_ADD('$mny_con_data_base',INTERVAL $i MONTH), '%d/%m/%Y') AS venc;";  
                //$SqlResult_1    = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");   
                
                //$venc           = $SqlResult_1->fields["venc"];
                
                echo "
                    <tr>
                        <td style=\"vertical-align:middle; text-align: center\" nowrap>$iParc</td>    
                        <td style=\"vertical-align:middle; text-align: center\" nowrap>".$data->format('d/m/Y')."</td>   
                        <td style=\"vertical-align:middle; text-align: right\" nowrap>$mny_con_valor</td>     
                    </tr>    
                ";
                
            }

    echo "
                    <tr>
                        <td style=\"vertical-align:middle; text-align: right\" colspan=2><b>Total</b></td>    
                        <td style=\"vertical-align:middle; text-align: right\"><b>".fFormataMoeda($fValorTotal, "2")."</b></td>   
                    </tr>
            </tbody>
        </table>
    </div>    
    ";

}

function fRetonaArrayContasPagar($aParam){
global $sUrlRaiz; 
global $dbsis_mysql;  


    $MesAtual       = $aParam["mes"]; 
    $AnoAtual       = $aParam["ano"];
    $sWhere         = $aParam["sWhere"];
    $sNomeTabela    = $aParam["Tabela"];

    $DiasMes = cal_days_in_month(CAL_GREGORIAN, $MesAtual, $AnoAtual); 
        
    $sSql = "
            SELECT 
                mny_con_id, 
                mny_con_id_origem, 
                mny_con_data_base, 
                day(mny_con_data_base) as dia_transacao,
                month(mny_con_data_base) as mes_transacao,
                day(mny_con_data_base) as dia_transacao,
                year(mny_con_data_base) as ano_transacao,
                mny_con_tipo_movimentacao, 
                mny_con_id_peridiocidade, 
                mny_con_parcelas,
                mny_con_parcelas_detalhe,
                mny_con_observacao,
                mny_con_valor,
                mny_ori_descricao,
                mny_ori_cartao_credito,
                mny_per_descricao,
                mny_con_encerrada,
                mny_con_pausada_data,
                mny_con_id_categoria,
                mny_cat_descricao
            FROM money_contas
            INNER JOIN money_origem_transacao   ON (mny_ori_id = mny_con_id_origem)
            INNER JOIN money_periodicidade      ON (mny_per_id = mny_con_id_peridiocidade)
            LEFT JOIN money_categoria           ON (mny_cat_id = mny_con_id_categoria)
            WHERE 
                mny_con_id is not null
                $sWhere
            ORDER BY 
                DAY(mny_con_data_base), 
                mny_con_tipo_movimentacao, 
                mny_ori_cartao_credito, 
                mny_ori_descricao, 
                mny_per_descricao
        ";  
                                       // echo $sSql."<BR>";

    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

    if ($SqlResult_1->NumRows() > 0) {

        $iCount = 0;
        $sModal   = "";

        $aContasPagar = array();

        while (!$SqlResult_1->EOF) {
        $mny_con_id                 = $SqlResult_1->fields["mny_con_id"];                              
        $mny_con_id_origem          = $SqlResult_1->fields["mny_con_id_origem"]; 
        $mny_con_data_base          = $SqlResult_1->fields["mny_con_data_base"]; 
        $mny_con_data_base_f        = fFormataData($SqlResult_1->fields["mny_con_data_base"]); 
        $mny_con_tipo_movimentacao  = $SqlResult_1->fields["mny_con_tipo_movimentacao"]; 
        $mny_con_id_peridiocidade   = $SqlResult_1->fields["mny_con_id_peridiocidade"]; 
        $mny_con_parcelas           = $SqlResult_1->fields["mny_con_parcelas"]; 
        $mny_con_parcelas_detalhe   = $SqlResult_1->fields["mny_con_parcelas_detalhe"]; 
        $mny_con_observacao         = $SqlResult_1->fields["mny_con_observacao"]; 
        $mny_con_valor              = $SqlResult_1->fields["mny_con_valor"]; 
        $mny_ori_descricao          = strtoupper($SqlResult_1->fields["mny_ori_descricao"]); 
        $mny_ori_cartao_credito     = $SqlResult_1->fields["mny_ori_cartao_credito"]; 
        $mny_per_descricao          = $SqlResult_1->fields["mny_per_descricao"]; 
        $dia_transacao              = $SqlResult_1->fields["dia_transacao"]; 
        $mes_transacao              = $SqlResult_1->fields["mes_transacao"]; 
        $ano_transacao              = $SqlResult_1->fields["ano_transacao"]; 
        $mny_con_encerrada          = $SqlResult_1->fields["mny_con_encerrada"]; 
        $mny_con_pausada_data       = $SqlResult_1->fields["mny_con_pausada_data"]; 
        $mny_con_id_categoria       = $SqlResult_1->fields["mny_con_id_categoria"]; 
        $mny_cat_descricao          = $SqlResult_1->fields["mny_cat_descricao"]; 
        
        

            //echo $mny_ori_descricao."<BR>";

            $aDataBase = explode("-", $mny_con_data_base);

            $diasemana = array('todos os domingos', 'todas as segundas', 'todas as terças', 'todas as quartas', 'todas as quintas', 'todas as sextas', 'todos os sabados');
            $data = date('Y-m-d');
            $diasemana_numero = date('w', strtotime($mny_con_data_base));

            $data_vencimento   = $AnoAtual."-".$MesAtual."-".fArrumaDigitosCodigo($dia_transacao, 2);
            $data_vencimento_f = fArrumaDigitosCodigo($dia_transacao, 2)."/".fArrumaDigitosCodigo($MesAtual, 2)."/".$AnoAtual;

            $date_tmstmp = new DateTime("$data_vencimento");
            $data_vencimento_tmstmp = $date_tmstmp->getTimestamp();

            $aCampos = array("data_vencimento"          => $data_vencimento, 
                             "data_vencimento_f"        => $data_vencimento_f,
                             "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                             "origem"                   => $mny_ori_descricao, 
                             "valor"                    => $mny_con_valor,
                             "observacao"               => $mny_con_observacao,
                             "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                             "periodicidade"            => $mny_per_descricao,
                             "parcela"                  => 0,
                             "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                             "mny_con_id_origem"        => $mny_con_id_origem,
                             "mny_con_id"               => $mny_con_id,
                             "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                             "mny_con_encerrada"        => $mny_con_encerrada,
                             "mny_con_id_categoria"     => $mny_con_id_categoria,
                             "mny_cat_descricao"        => $mny_cat_descricao
                     );

            
                                        
            $aValores = array();
            
            switch ($mny_con_id_peridiocidade) {
                case 1://'1', 'DiÃ¡rio'

                    if ($mes_transacao == $MesAtual && $ano_transacao == $AnoAtual){
                        $iDiaInicio = $dia_transacao;
                    }
                    else {
                        $iDiaInicio = 1;
                    }

                    for($i=$iDiaInicio;$i<=$DiasMes;$i++){
                        $data_vencimento   = $AnoAtual."-".$MesAtual."-".fArrumaDigitosCodigo($i, 2);
                        $data_vencimento_f = fArrumaDigitosCodigo($i, 2)."/".fArrumaDigitosCodigo($MesAtual, 2)."/".$AnoAtual;         

                        
                        $MostraLancamento = true;
                        if ($mny_con_pausada_data){
                            if ($data_vencimento > $mny_con_pausada_data){
                                $MostraLancamento = false;
                            }
                        }
                        
                        if ($MostraLancamento){
                            
                            $aValores["mny_con_id"]         = $mny_con_id;
                            $aValores["data_vencimento"]    = $data_vencimento;

                            $aRetorno = array();
                            $aRetorno = fRetornaQuitacao($aValores);

                            if ($aRetorno != false){
                                $mny_pag_vencimento_pago    = $aRetorno[0];
                                $mny_pag_valor_pago         = $aRetorno[1];
                                $mny_pag_tipo_baixa         = $aRetorno[2];
                                $mny_pag_id                 = $aRetorno[3];
                            }
                            else {
                                $mny_pag_vencimento_pago    = "";
                                $mny_pag_valor_pago         = 0;
                                $mny_pag_tipo_baixa         = 0;
                                $mny_pag_id                 = 0;
                            }
                            
                            $date_tmstmp = new DateTime("$data_vencimento");
                            $data_vencimento_tmstmp = $date_tmstmp->getTimestamp();

                            $aCampos = array("data_vencimento"          => $data_vencimento, 
                                             "data_vencimento_f"        => $data_vencimento_f,
                                             "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                                             "origem"                   => $mny_ori_descricao, 
                                             "valor"                    => $mny_con_valor,
                                             "observacao"               => $mny_con_observacao,
                                             "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                                             "periodicidade"            => $mny_per_descricao,
                                             "parcela"                  => 0,
                                             "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                                             "mny_con_id_origem"        => $mny_con_id_origem,
                                             "mny_con_id"               => $mny_con_id,
                                             "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                                             "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                             "mny_pag_valor_pago"       => $mny_pag_valor_pago,
                                             "mny_pag_tipo_baixa"       => $mny_pag_tipo_baixa,
                                             "mny_pag_id"               => $mny_pag_id,
                                             "mny_con_encerrada"        => $mny_con_encerrada,
                                             "mny_con_id_categoria"     => $mny_con_id_categoria,
                                             "mny_cat_descricao"        => $mny_cat_descricao
                                    );  

                            $aContasPagar[$mny_con_id."_".$i] = $aCampos;  
                        }    
                    }

                    break;

                case 2://'2', 'Semanal'



                    if ($mes_transacao == $MesAtual && $ano_transacao == $AnoAtual){
                        $iDiaInicio = $dia_transacao;
                    }
                    else {
                        $iDiaInicio = 1;
                    }                

                    for($i=$iDiaInicio;$i<=$DiasMes;$i++){
                        $data_vencimento            = $AnoAtual."-".$MesAtual."-".fArrumaDigitosCodigo($i, 2);
                        $data_vencimento_f          = fArrumaDigitosCodigo($i, 2)."/".fArrumaDigitosCodigo($MesAtual, 2)."/".$AnoAtual;   
                        $diasemana_numero_semana    = date('w', strtotime($data_vencimento));

                        if ($diasemana_numero_semana == $diasemana_numero){
                            
                            
                            $MostraLancamento = true;
                            if ($mny_con_pausada_data){
                                if ($data_vencimento > $mny_con_pausada_data){
                                    $MostraLancamento = false;
                                }
                            }

                            if ($MostraLancamento){                            
                            
                                $aValores["mny_con_id"]         = $mny_con_id;
                                $aValores["data_vencimento"]    = $data_vencimento;

                                $aRetorno = array();
                                $aRetorno = fRetornaQuitacao($aValores);

                                if ($aRetorno != false){
                                    $mny_pag_vencimento_pago    = $aRetorno[0];
                                    $mny_pag_valor_pago         = $aRetorno[1];
                                    $mny_pag_tipo_baixa         = $aRetorno[2];
                                    $mny_pag_id                 = $aRetorno[3];

                                }
                                else {
                                    $mny_pag_vencimento_pago    = "";
                                    $mny_pag_valor_pago         = 0;
                                    $mny_pag_tipo_baixa         = 0;
                                    $mny_pag_id                 = 0;
                                }

                                $date_tmstmp = new DateTime("$data_vencimento");
                                $data_vencimento_tmstmp = $date_tmstmp->getTimestamp();

                                $aCampos = array("data_vencimento"          => $data_vencimento, 
                                                 "data_vencimento_f"        => $data_vencimento_f,
                                                 "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                                                 "origem"                   => $mny_ori_descricao, 
                                                 "valor"                    => $mny_con_valor,
                                                 "observacao"               => $mny_con_observacao,
                                                 "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                                                 "periodicidade"            => $mny_per_descricao,
                                                 "parcela"                  => 0,
                                                 "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                                                 "mny_con_id_origem"        => $mny_con_id_origem,
                                                 "mny_con_id"               => $mny_con_id,
                                                 "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                                                 "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                                 "mny_pag_valor_pago"       => $mny_pag_valor_pago,
                                                 "mny_pag_tipo_baixa"       => $mny_pag_tipo_baixa,
                                                 "mny_pag_id"               => $mny_pag_id,
                                                 "mny_con_encerrada"        => $mny_con_encerrada,
                                                 "mny_con_id_categoria"     => $mny_con_id_categoria,
                                                 "mny_cat_descricao"        => $mny_cat_descricao
                                        );  

                                $aContasPagar[$mny_con_id."_".$i] = $aCampos;   
                            }    
                        }
                    }



                    break;

                case 3://'3', 'Semanas alternadas'

                    if ($mes_transacao == $MesAtual && $ano_transacao == $AnoAtual){
                        $iDiaInicio = $dia_transacao;
                    }
                    else {
                        $iDiaInicio = 1;
                    }                

                    for($i=$iDiaInicio;$i<=$DiasMes;$i++){
                        $data_vencimento            = $AnoAtual."-".$MesAtual."-".fArrumaDigitosCodigo($i, 2);
                        $data_vencimento_f          = fArrumaDigitosCodigo($i, 2)."/".fArrumaDigitosCodigo($MesAtual, 2)."/".$AnoAtual;   
                        $diasemana_numero_semana    = date('w', strtotime($data_vencimento));

                        if ($diasemana_numero_semana == $diasemana_numero){

                            $MostraLancamento = true;
                            if ($mny_con_pausada_data){
                                if ($data_vencimento > $mny_con_pausada_data){
                                    $MostraLancamento = false;
                                }
                            }

                            if ($MostraLancamento){                            
                            
                            
                                $dateStart = new \DateTime($mny_con_data_base);
                                $dateNow   = new \DateTime($data_vencimento);

                                $dateDiff = $dateStart->diff($dateNow);

                                $QtdDias = $dateDiff->days;

                                $Resto = $QtdDias % 14;

                                if ($Resto == 0){

                                    $aValores["mny_con_id"]         = $mny_con_id;
                                    $aValores["data_vencimento"]    = $data_vencimento;

                                    $aRetorno = array();
                                    $aRetorno = fRetornaQuitacao($aValores);

                                    if ($aRetorno != false){
                                        $mny_pag_vencimento_pago    = $aRetorno[0];
                                        $mny_pag_valor_pago         = $aRetorno[1];
                                        $mny_pag_tipo_baixa         = $aRetorno[2];
                                        $mny_pag_id                 = $aRetorno[3];
                                    }
                                    else {
                                        $mny_pag_vencimento_pago    = "";
                                        $mny_pag_valor_pago         = 0;
                                        $mny_pag_tipo_baixa         = 0;
                                        $mny_pag_id                 = 0;
                                    }

                                    
                                    $date_tmstmp = new DateTime("$data_vencimento");
                                    $data_vencimento_tmstmp = $date_tmstmp->getTimestamp();
                                    
                                    $aCampos = array("data_vencimento"          => $data_vencimento, 
                                                     "data_vencimento_f"        => $data_vencimento_f,
                                                     "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                                                     "origem"                   => $mny_ori_descricao, 
                                                     "valor"                    => $mny_con_valor,
                                                     "observacao"               => $mny_con_observacao,
                                                     "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                                                     "periodicidade"            => $mny_per_descricao,
                                                     "parcela"                  => 0,
                                                     "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                                                     "mny_con_id_origem"        => $mny_con_id_origem,
                                                     "mny_con_id"               => $mny_con_id,
                                                     "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                                                     "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                                     "mny_pag_valor_pago"       => $mny_pag_valor_pago,
                                                     "mny_pag_tipo_baixa"       => $mny_pag_tipo_baixa,
                                                     "mny_pag_id"               => $mny_pag_id,
                                                     "mny_con_encerrada"        => $mny_con_encerrada,
                                                     "mny_con_id_categoria"     => $mny_con_id_categoria,
                                                     "mny_cat_descricao"        => $mny_cat_descricao
                                            );                                

                                    $aContasPagar[$mny_con_id."_".$i] = $aCampos; 
                                } 

                            }    
                        }
                    }                

                    break;

                case 4://'4', 'Mensal'
                    
                    $MostraLancamento = true;
                    if ($mny_con_pausada_data){
                        if ($data_vencimento > $mny_con_pausada_data){
                            $MostraLancamento = false;
                        }
                    }

                    if ($MostraLancamento){                            

                        $aValores["mny_con_id"]         = $mny_con_id;
                        $aValores["data_vencimento"]    = $data_vencimento;

                        $aRetorno = array();
                        $aRetorno = fRetornaQuitacao($aValores);

                        if ($aRetorno != false){
                            $mny_pag_vencimento_pago    = $aRetorno[0];
                            $mny_pag_valor_pago         = $aRetorno[1];
                            $mny_pag_tipo_baixa         = $aRetorno[2];
                            $mny_pag_id                 = $aRetorno[3];
                        }
                        else {
                            $mny_pag_vencimento_pago    = "";
                            $mny_pag_valor_pago         = 0;
                            $mny_pag_tipo_baixa         = 0;
                            $mny_pag_id                 = 0;
                        }

                        $date_tmstmp = new DateTime("$data_vencimento");
                        $data_vencimento_tmstmp = $date_tmstmp->getTimestamp();

                        $aCampos = array("data_vencimento"          => $data_vencimento, 
                                         "data_vencimento_f"        => $data_vencimento_f,
                                         "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                                         "origem"                   => $mny_ori_descricao, 
                                         "valor"                    => $mny_con_valor,
                                         "observacao"               => $mny_con_observacao,
                                         "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                                         "periodicidade"            => $mny_per_descricao,
                                         "parcela"                  => 0,
                                         "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                                         "mny_con_id_origem"        => $mny_con_id_origem,
                                         "mny_con_id"               => $mny_con_id,
                                         "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                                         "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                         "mny_pag_valor_pago"       => $mny_pag_valor_pago,
                                         "mny_pag_tipo_baixa"       => $mny_pag_tipo_baixa,
                                         "mny_pag_id"               => $mny_pag_id,
                                         "mny_con_encerrada"        => $mny_con_encerrada,
                                         "mny_con_id_categoria"     => $mny_con_id_categoria,
                                         "mny_cat_descricao"        => $mny_cat_descricao
                                );

                        $aContasPagar[$mny_con_id] = $aCampos;
                    }
                    
                    break;

                case 5://'5', 'Anual'

                    if ($MesAtual == $mes_transacao){
                        
                        
                        $MostraLancamento = true;
                        if ($mny_con_pausada_data){
                            if ($data_vencimento > $mny_con_pausada_data){
                                $MostraLancamento = false;
                            }
                        }

                        if ($MostraLancamento){                            
                        
                        
                            $aValores["mny_con_id"]         = $mny_con_id;
                            $aValores["data_vencimento"]    = $data_vencimento;

                            $aRetorno = array();
                            $aRetorno = fRetornaQuitacao($aValores);

                            if ($aRetorno != false){
                                $mny_pag_vencimento_pago    = $aRetorno[0];
                                $mny_pag_valor_pago         = $aRetorno[1];
                                $mny_pag_tipo_baixa         = $aRetorno[2];
                                $mny_pag_id                 = $aRetorno[3];
                            }
                            else {
                                $mny_pag_vencimento_pago    = "";
                                $mny_pag_valor_pago         = 0;
                                $mny_pag_tipo_baixa         = 0;
                                $mny_pag_id                 = 0;
                            }

                            $date_tmstmp = new DateTime("$data_vencimento");
                            $data_vencimento_tmstmp = $date_tmstmp->getTimestamp();

                            $aCampos = array("data_vencimento"          => $data_vencimento, 
                                             "data_vencimento_f"        => $data_vencimento_f,
                                             "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                                             "origem"                   => $mny_ori_descricao, 
                                             "valor"                    => $mny_con_valor,
                                             "observacao"               => $mny_con_observacao,
                                             "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                                             "periodicidade"            => $mny_per_descricao,
                                             "parcela"                  => 0,
                                             "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                                             "mny_con_id_origem"        => $mny_con_id_origem,
                                             "mny_con_id"               => $mny_con_id,
                                             "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                                             "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                             "mny_pag_valor_pago"       => $mny_pag_valor_pago,
                                             "mny_pag_tipo_baixa"       => $mny_pag_tipo_baixa,
                                             "mny_pag_id"               => $mny_pag_id,
                                             "mny_con_encerrada"        => $mny_con_encerrada,
                                             "mny_con_id_categoria"     => $mny_con_id_categoria,
                                             "mny_cat_descricao"        => $mny_cat_descricao
                                    );

                            $aContasPagar[$mny_con_id] = $aCampos;     

                        }
                    }    
                    break;

                case 6://'6', 'Uma vez apenas'

                    if ($MesAtual == $mes_transacao){

                        $aValores["mny_con_id"]         = $mny_con_id;
                        $aValores["data_vencimento"]    = $data_vencimento;

                        $aRetorno = array();
                        $aRetorno = fRetornaQuitacao($aValores);

                        if ($aRetorno != false){
                            $mny_pag_vencimento_pago    = $aRetorno[0];
                            $mny_pag_valor_pago         = $aRetorno[1];
                            $mny_pag_tipo_baixa         = $aRetorno[2];
                            $mny_pag_id                 = $aRetorno[3];
                        }
                        else {
                            $mny_pag_vencimento_pago    = "";
                            $mny_pag_valor_pago         = 0;
                            $mny_pag_tipo_baixa         = 0;
                            $mny_pag_id                 = 0;
                        }

                        $date_tmstmp = new DateTime("$data_vencimento");
                        $data_vencimento_tmstmp = $date_tmstmp->getTimestamp();

                        $aCampos = array("data_vencimento"          => $data_vencimento, 
                                         "data_vencimento_f"        => $data_vencimento_f,
                                         "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                                         "origem"                   => $mny_ori_descricao, 
                                         "valor"                    => $mny_con_valor,
                                         "observacao"               => $mny_con_observacao,
                                         "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                                         "periodicidade"            => $mny_per_descricao,
                                         "parcela"                  => 0,
                                         "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                                         "mny_con_id_origem"        => $mny_con_id_origem,
                                         "mny_con_id"               => $mny_con_id,
                                         "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                                         "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                         "mny_pag_valor_pago"       => $mny_pag_valor_pago,
                                         "mny_pag_tipo_baixa"       => $mny_pag_tipo_baixa,
                                         "mny_pag_id"               => $mny_pag_id,
                                         "mny_con_encerrada"        => $mny_con_encerrada,
                                         "mny_con_id_categoria"     => $mny_con_id_categoria,
                                         "mny_cat_descricao"        => $mny_cat_descricao
                                );
                                                
                        
                        $aContasPagar[$mny_con_id] = $aCampos;     

                    }

                    break;

                case 7://'7', 'Parcelado (Mensal)'

                    $aParc = json_decode(str_replace("|","\"",$mny_con_parcelas_detalhe));

                    foreach ($aParc as $value) {
                        $aDataBase = explode("-", $value->data);

                        $dMesAnoParc  = $aDataBase[0]."-".fArrumaDigitosCodigo($aDataBase[1], 2);
                        $dMesAnoAtual = $AnoAtual."-".fArrumaDigitosCodigo($MesAtual, 2);
                        
                        //echo "mny_con_id: ".$mny_con_id." => Data: ".$value->data." => Parc:".$value->parcela."<BR>";
                        
                        //$sFlag = "";
                        if ($dMesAnoParc == $dMesAnoAtual){

                            $aValores["mny_con_id"]         = $mny_con_id;
                            $aValores["data_vencimento"]    = $value->data;
                            $aValores["parcela"]            = $value->parcela;

                            $aRetorno = array();
                            $aRetorno = fRetornaQuitacao($aValores);

                            if ($aRetorno != false){
                                $mny_pag_vencimento_pago    = $aRetorno[0];
                                $mny_pag_valor_pago         = $aRetorno[1];
                                $mny_pag_tipo_baixa         = $aRetorno[2];
                                $mny_pag_id                 = $aRetorno[3];
                            }
                            else {
                                $mny_pag_vencimento_pago    = "";
                                $mny_pag_valor_pago         = 0;
                                $mny_pag_tipo_baixa         = 0;
                                $mny_pag_id                 = 0;
                            }                             
                            //echo "Data: ".$value->data." ".$value->valor."<BR>";
                            $date_tmstmp = new DateTime("$data_vencimento");
                            $data_vencimento_tmstmp = $date_tmstmp->getTimestamp();

                            $aCampos = array("data_vencimento"          => $data_vencimento, 
                                             "data_vencimento_f"        => $data_vencimento_f,
                                             "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                                             "origem"                   => $mny_ori_descricao, 
                                             "valor"                    => $value->valor,
                                             "observacao"               => $mny_con_observacao,
                                             "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                                             "periodicidade"            => $mny_per_descricao,
                                             "parcela"                  => $value->parcela,
                                             "parcela_total"            => count($aParc),
                                             "pago"                     => $value->pago,
                                             "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                                             "mny_con_id_origem"        => $mny_con_id_origem,
                                             "mny_con_id"               => $mny_con_id,
                                             "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                                             "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                             "mny_pag_valor_pago"       => $mny_pag_valor_pago,
                                             "mny_pag_tipo_baixa"       => $mny_pag_tipo_baixa,
                                             "mny_pag_id"               => $mny_pag_id,
                                             "mny_con_encerrada"        => $mny_con_encerrada,
                                             "mny_con_id_categoria"     => $mny_con_id_categoria,
                                             "mny_cat_descricao"        => $mny_cat_descricao
                                    );   

                            $aContasPagar[$mny_con_id] = $aCampos;   

                        }

                    }

                    break;

                case 10://'10', 'Trimestral'

                    $data_inicio    = new DateTime($mny_con_data_base);      
                    $data_final     = new DateTime($data_vencimento);      

                    $iQtdMeses = $data_final->diff($data_inicio);

                    $Resto = $iQtdMeses->m % 3;
                    //echo "resto: ".$Resto."<BR>";

                    if ($Resto == 0){
                        
                        $MostraLancamento = true;
                        if ($mny_con_pausada_data){
                            if ($data_vencimento > $mny_con_pausada_data){
                                $MostraLancamento = false;
                            }
                        }

                        if ($MostraLancamento){                            
                        
                            $aValores["mny_con_id"]         = $mny_con_id;
                            $aValores["data_vencimento"]    = $data_vencimento;

                            $aRetorno = array();
                            $aRetorno = fRetornaQuitacao($aValores);

                            if ($aRetorno != false){
                                $mny_pag_vencimento_pago    = $aRetorno[0];
                                $mny_pag_valor_pago         = $aRetorno[1];
                                $mny_pag_tipo_baixa         = $aRetorno[2];
                                $mny_pag_id                 = $aRetorno[3];
                            }
                            else {
                                $mny_pag_vencimento_pago    = "";
                                $mny_pag_valor_pago         = 0;
                                $mny_pag_tipo_baixa         = 0;
                                $mny_pag_id                 = 0;
                            }

                            $date_tmstmp = new DateTime($data_vencimento);
                            $data_vencimento_tmstmp = $date_tmstmp->format('U');

                            $aCampos = array("data_vencimento"          => $data_vencimento, 
                                             "data_vencimento_f"        => $data_vencimento_f,
                                             "data_vencimento_tmstmp"   => $data_vencimento_tmstmp,
                                             "origem"                   => $mny_ori_descricao, 
                                             "valor"                    => $mny_con_valor,
                                             "observacao"               => $mny_con_observacao,
                                             "tipo_movimentacao"        => $mny_con_tipo_movimentacao,
                                             "periodicidade"            => $mny_per_descricao,
                                             "parcela"                  => 0,
                                             "mny_ori_cartao_credito"   => $mny_ori_cartao_credito,
                                             "mny_con_id_origem"        => $mny_con_id_origem,
                                             "mny_con_id"               => $mny_con_id,
                                             "mny_con_id_peridiocidade" => $mny_con_id_peridiocidade,
                                             "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                             "mny_pag_valor_pago"       => $mny_pag_valor_pago,
                                             "mny_pag_tipo_baixa"       => $mny_pag_tipo_baixa,
                                             "mny_pag_id"               => $mny_pag_id,
                                             "mny_con_encerrada"        => $mny_con_encerrada,
                                             "mny_con_id_categoria"     => $mny_con_id_categoria,
                                             "mny_cat_descricao"        => $mny_cat_descricao
                                    );

                            $aContasPagar[$mny_con_id."_".$dia_transacao] = $aCampos; 
                        }    
                    }

                    break;
            }     
            
            $iCount++;


            $SqlResult_1->MoveNext();

        }

    }   
    
    //print_r($aContasPagar);
    //echo "-------------<BR>";
    
    return $aContasPagar;
}

function fRetornaQuitacao($aValores){
global $sUrlRaiz; 
global $dbsis_mysql;

    $mny_con_id      = $aValores["mny_con_id"];
    $data_vencimento = $aValores["data_vencimento"];

    $sWhere = "";    
    if ($aValores["parcela"] != ""){
        $sWhere .= " AND mny_pag_parcela = ".$aValores["parcela"]; 
    }
    
    ///Verifica se tem pagamento
    $sSql = "
            SELECT mny_pag_id,
                mny_pag_id_contas,
                mny_pag_id_extrato,
                mny_pag_vencimento_original,
                mny_pag_vencimento_pago,
                mny_pag_valor_original,
                mny_pag_valor_pago,
                mny_pag_parcela,
                mny_pag_tipo_baixa
            FROM money_pagamentos
            WHERE 
                mny_pag_id_contas = $mny_con_id AND 
                (mny_pag_vencimento_original = '$data_vencimento' OR  
                mny_pag_vencimento_pago = '$data_vencimento')     
                $sWhere    
        ";  
      //                                 if ($mny_con_id == 26) echo $sSql."<BR>";

    $SqlResult_3 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

    if ($SqlResult_3->NumRows() > 0) {   
        $mny_pag_vencimento_pago    =   $SqlResult_3->fields["mny_pag_vencimento_pago"]; 
        $mny_pag_valor_pago         =   $SqlResult_3->fields["mny_pag_valor_pago"]; 
        $mny_pag_tipo_baixa         =   $SqlResult_3->fields["mny_pag_tipo_baixa"]; 
        $mny_pag_id                 =   $SqlResult_3->fields["mny_pag_id"]; 
        
        $aRetorno[] = $mny_pag_vencimento_pago;
        $aRetorno[] = $mny_pag_valor_pago;
        $aRetorno[] = $mny_pag_tipo_baixa;
        $aRetorno[] = $mny_pag_id;
        
        return $aRetorno;
    } 
    else {
        return false;
    }
    
}

function fMontaGridContasPagar($aParam) {
global $sUrlRaiz; 
global $dbsis_mysql;  

$sNomeTabela    = $aParam["Tabela"];

$aContasPagar = fRetonaArrayContasPagar($aParam);

$iCount   = 0;
$sDisplay = "";

$sDisplay .= "    
        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
                <td width=\"1%\" nowrap  align=\"center\">
                                ";  
                            
                            
                            $aValores           = array();
                            $fValorTotal        = 0;
                            $fValorTotalGeral   = 0;
                            foreach ($aContasPagar as $value) {
                                
                                

                                if ($iCount > 0 && $value["mny_ori_cartao_credito"] == 1 && $value["mny_con_id_origem"] != $mny_con_id_origem_ULT){
                                                /*
                                                 */  
                                    
                                    if ($iCount > 0){    
                                        $sDisplay .= "
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\" align=right nowrap><font size=3><b>TOTAL:</b><font></th>
                                                    <td width=\"1%\" align=right nowrap><font size=3><b>R$ ".fFormataMoeda($fValorTotal, 2)."</b><font></th>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"97%\"></td>
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                </tr>  
                                            </tfoot>        
                                        </table>";    
                                        
                                        $fValorTotal = 0;
                                    }

                                    $sDisplay .= "    
                                    <table id=\"tabela".$value["mny_con_id_origem"]."\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                         <thead>
                                            <tr>
                                                <th width=\"1%\"></th>                  <!--0-->
                                                <th width=\"1%\">Status</th>            <!--1-->
                                                <th width=\"1%\">Vencimento</th>        <!--2-->
                                                <th width=\"1%\">Deb/Crd</th>           <!--3-->
                                                <th width=\"1%\">Origem</th>            <!--4-->
                                                <th width=\"1%\">Valor</th>             <!--5-->
                                                <th width=\"1%\">Periodicidade</th>     <!--6-->
                                                <th width=\"1%\">Parcela</th>           <!--7-->
                                                <th width=\"1%\">Categoria</th>         <!--8-->
                                                <th width=\"1%\">Observação</th>        <!--9-->
                                                <th width=\"97%\">&nbsp;</th>           <!--10-->
                                                <th width=\"1%\">&nbsp;</th>            <!--11-->
                                                <th width=\"1%\">&nbsp;</th>            <!--12-->
                                                <th width=\"1%\">&nbsp;</th>            <!--13-->
                                                <th width=\"1%\">&nbsp;</th>            <!--14-->
                                                <th width=\"1%\">&nbsp;</th>            <!--15-->
                                                <th width=\"1%\">&nbsp;</th>            <!--16-->
                                                <th width=\"1%\">&nbsp;</th>            <!--17-->
                                                <th width=\"1%\">&nbsp;</th>            <!--18-->
                                            </tr>    
                                         </thead>  
                                         <tbody>
                                        ";  
                                }
                                else {
                                    if ($value["mny_ori_cartao_credito"] == 1){
                                       $sNomeTabela = $value["mny_con_id_origem"];  
                                    }
                                    if ($iCount == 0){
                                        $sDisplay .= "    
                                        <table id=\"tabela".$sNomeTabela."\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                            <thead>
                                                   <tr>
                                                       <th width=\"1%\"></th> 
                                                       <th width=\"1%\"></th> 
                                                       <th width=\"1%\">Vencimento</th>
                                                       <th width=\"1%\">Deb/Crd</th>
                                                       <th width=\"1%\">Origem</th>
                                                       <th width=\"20%\">Valor</th>
                                                       <th width=\"1%\">Periodicidade</th>
                                                       <th width=\"1%\">Parcela</th>
                                                       <th width=\"1%\">Categoria</th>
                                                       <th width=\"1%\">Observação</th>
                                                       <th width=\"97%\">&nbsp;</th>
                                                       <th width=\"1%\">&nbsp;</th>
                                                       <th width=\"1%\">&nbsp;</th>
                                                       <th width=\"1%\">&nbsp;</th>
                                                       <th width=\"1%\">&nbsp;</th>
                                                       <th width=\"1%\">&nbsp;</th>
                                                       <th width=\"1%\">&nbsp;</th>
                                                       <th width=\"1%\">&nbsp;</th>
                                                       <th width=\"1%\">&nbsp;</th>
                                                   </tr>    
                                            </thead>  
                                            <tbody>
                                           "; 
                                    }
                                }
                                
                                
                                if ($value["parcela_total"]){
                                    $sParcelas = fArrumaDigitosCodigo($value["parcela"],2)."/".fArrumaDigitosCodigo($value["parcela_total"],2);
                                }
                                else {
                                    $sParcelas = "-";
                                }
                                
                                if ($value["pago"] == "") $value["pago"] = 0;
                                
                                //$linkEdit = "onclick=\"fCompensar('".$value["data_vencimento"]."', '".$value["tipo_movimentacao"]."', '".$value["mny_con_id_origem"]."', '".$value["valor"]."', '".$value["origem"]."', '".$value["origem"]."');\" data-toggle=\"modal\" data-target=\"#myModal\"";
                                $linkEdit = "onclick=\"$('#iPopUpCompensa').val('1');\"";
                                
                                     // "mny_pag_vencimento_pago"  => $mny_pag_vencimento_pago,
                                     // "mny_pag_valor_pago"       => $mny_pag_valor_pago
                                
                                if ($value["mny_pag_vencimento_pago"] != ""){
                                    if ($value["mny_pag_tipo_baixa"] == 1){
                                        $sEstiloBotao = "btn-success";
                                    }
                                    else {
                                        $sEstiloBotao = "btn-primary";
                                    }
                                    
                                    if ($value["mny_con_encerrada"] == 1){
                                        $sTextoBotao = "Pago <i class=\"fa  fa-star-o fa-fw\"></i>";
                                    }
                                    else {
                                        $sTextoBotao = "Pago";
                                    }
                                    
                                    
                                    
                                    $sDataConta  = fFormataData($value["mny_pag_vencimento_pago"]);
                                    $sValorConta = $value["mny_pag_valor_pago"];
                                    
                                    $fValorTotal        = $fValorTotal + fFormataMoeda($sValorConta);  
                                    $fValorTotalGeral   = $fValorTotalGeral + fFormataMoeda($sValorConta);   
                                    $aValores[$value["tipo_movimentacao"]] = $aValores[$value["tipo_movimentacao"]] + fFormataMoeda($sValorConta);
                                    
                                }
                                else {
                                    $sDataConta  = $value["data_vencimento_f"];
                                    $sValorConta = $value["valor"];      
                                    
                                    if ($value["mny_pag_tipo_baixa"] == 3){
                                        $sEstiloBotao = "btn-warning";
                                        $sTextoBotao  = "Cancel";      
                                    }
                                    else {
                                        
                                        if ($value["data_vencimento"] >= Date("Y-m-d")){
                                        
                                            $sEstiloBotao = "btn-default";
                                            $sTextoBotao  = "Aberto";      
                                            
                                        }
                                        else {
                                            $sEstiloBotao = "btn-danger";
                                            $sTextoBotao  = "Atrasado";  
                                        }
                                        
                                        //echo $value["data_vencimento"]." - ".Date("Y-m-d")."- $sTextoBotao<BR>";
                                        
                                        $fValorTotal        = $fValorTotal + fFormataMoeda($sValorConta);  
                                        $fValorTotalGeral   = $fValorTotalGeral + fFormataMoeda($sValorConta);  
                                        $aValores[$value["tipo_movimentacao"]] = $aValores[$value["tipo_movimentacao"]] + fFormataMoeda($sValorConta);
                                    
                                        
                                        
                                        
                                    }
                                    
                                }
                                
                                $sDisplay .= "
                                           <tr>  
                                             <td nowrap width=1% align=center> 
                                                <button type=\"button\" class=\"btn $sEstiloBotao\" $linkEdit data-toggle=\"modal\" data-target=\"#myModal\">$sTextoBotao</button>
                                             </td>
                                             <td width=1%> 
                                                
                                             </td>
                                             <td nowrap width=1% align=center> 
                                                ".$sDataConta."  
                                             </td>
                                             <td nowrap width=1% align=center> 
                                                ".$value["tipo_movimentacao"]." 
                                             </td>
                                             <td nowrap width=1% nowrap> 
                                                ".$value["origem"]."  
                                             </td>
                                             <td nowrap width=10% nowrap align=right> 
                                                R$ ".$sValorConta."    
                                             </td>
                                             <td nowrap width=% nowrap> 
                                                ".$value["periodicidade"]."    
                                             </td>
                                             <td nowrap width=1% nowrap> 
                                                ".$sParcelas."    
                                             </td>
                                             <td nowrap width=1% nowrap> 
                                                ".$value["mny_cat_descricao"]."       
                                             </td>
                                             <td nowrap> 
                                                ".$value["observacao"]."    
                                             </td>                                                         
                                             <td> 
                                                 &nbsp;
                                             </td>
                                             <td> 
                                                 ".$value["mny_con_id_origem"]."
                                             </td>
                                             <td> 
                                                 ".$value["mny_con_id"]."
                                             </td>
                                             <td> 
                                                 ".$value["parcela"]."
                                             </td>
                                             <td> 
                                                 ".$value["data_vencimento"]."
                                             </td>
                                             <td> 
                                                 ".$value["mny_con_id_peridiocidade"]."
                                             </td>
                                             <td> 
                                                 ".$value["valor"]."
                                             </td>
                                             <td> 
                                                 ".$value["pago"]."
                                             </td>
                                             <td> 
                                                 ".$value["mny_pag_id"]."
                                             </td>
                                           </tr>

                                ";
                                
                                $mny_con_id_origem_ULT          = $value["mny_con_id_origem"];
                                
                                $iCount++;
                            }

                                                /*
                                                <tr>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\" align=right nowrap><font size=3><b>TOTAL:</b><font></td>
                                                    <td width=\"1%\" align=right nowrap><font size=3><b>R$ ".fFormataMoeda($fValorTotal, 2)."</b><font></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"97%\">&nbsp;</td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                </tr>   
                                                 */                             
                            
                            $sDisplay .= "
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\" align=right nowrap><font size=3><b>TOTAL:</b><font></th>
                                                    <td width=\"1%\" align=right nowrap><font size=3><b>R$ ".fFormataMoeda($fValorTotal, 2)."</b><font></th>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"1%\"></td>
                                                    <td width=\"97%\"></td>
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                    <td width=\"1%\"></td>            
                                                </tr>  
                                            </tfoot>        
                                            
                                        </table>    
                </td>
            </tr>
            <tr><td align=\"right\" height=\"10px\"></td></tr>
            <tr><td height=\"30px\"></td></tr>
        </table>";

    $aRetorno[] = $aValores;
    $aRetorno[] = $sDisplay;
    $aRetorno[] = $fValorTotalGeral;
    
    return $aRetorno;                        
}

function fRetornaSaldoInicial($MesAtual, $AnoAtual){
global $sUrlRaiz; 
global $dbsis_mysql; 


        $dData = $AnoAtual."-".$MesAtual."-01";
        $sSql = "SELECT MONTH(DATE_SUB('$dData', INTERVAL 1 MONTH)) AS mes, YEAR(DATE_SUB('$dData', INTERVAL 1 MONTH)) as ano";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
        $_mes_ANT  = $SqlResult_1->fields["mes"]; 
        $_ano_ANT  = $SqlResult_1->fields["ano"];
        
        $sSql = "SELECT 
                mny_exc_valor,
                mny_exc_tipo_mov
            FROM money_extrato_cc
            WHERE 
                MONTH(mny_exc_data) = $_mes_ANT AND 
                YEAR(mny_exc_data) = $_ano_ANT AND 
                mny_exc_numdocumento = '-1'";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
        $aValoresSI["mny_exc_valor"]  = $SqlResult_1->fields["mny_exc_valor"];  
        $aValoresSI["mny_exc_tipo_mov"] = $SqlResult_1->fields["mny_exc_tipo_mov"];
        
        
        return $aValoresSI;
}

?>


