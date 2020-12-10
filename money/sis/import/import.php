<?php

require_once "../../money.ini.php";


header('Content-type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");

set_time_limit(0);

ob_implicit_flush(1);

//session_start();
//echo $_SESSION['csv_file_name'];
if(isset($_SESSION['csv_file_name'])){

	$file_data = fopen('file/' . $_SESSION['csv_file_name'], 'r');

	//print_r(fgetcsv($file_data));
        
        $bd = new BancoDados();        
        $iCount = 0;
	while($row = fgetcsv($file_data)){
            
            if ($iCount > 0){
                
                $aData = explode("/", $row[0]);
                $mny_exc_data = $aData[2]."-".$aData[1]."-".$aData[0];
                
                $mny_exc_numdocumento = $row[4];
                
                $mny_exc_historico    = str_replace("'", "", $row[2]);
                
                if ($mny_exc_historico == "Encargos" && $mny_exc_numdocumento == "0"){
                    $mny_exc_numdocumento = "xpto";
                }
                
                $fValor = $row[5];
                
                if ($fValor < 0) {
                    $mny_exc_tipo_mov = "D";
                    $mny_exc_valor = $fValor * (-1);
                }
                else { 
                    $mny_exc_tipo_mov = "C";
                    $mny_exc_valor = $fValor;
                }
                
                $sSql = "SELECT * FROM money_extrato_cc WHERE mny_exc_numdocumento = '$mny_exc_numdocumento' AND mny_exc_data = '$mny_exc_data' AND mny_exc_valor = '$mny_exc_valor'";

                $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
                
                if ($mny_exc_numdocumento != "0" && $SqlResult_1->NumRows() == 0){

                    $aDados = array(
                        "mny_exc_data"          => $mny_exc_data, 
                        "mny_exc_historico"     => $mny_exc_historico, 
                        "mny_exc_numdocumento"  => $mny_exc_numdocumento,                     
                        "mny_exc_valor"         => $mny_exc_valor,
                        "mny_exc_tipo_mov"      => $mny_exc_tipo_mov
                    );

                    $bd->fSisInsereRegistroBanco("money_extrato_cc", $aDados);      

                    if(ob_get_level() > 0){
                        
                            ob_end_flush();
                            
                    }
                    
                }
                else if ($mny_exc_historico == "Saldo Anterior"){
                    
                    $mny_exc_numdocumento = "-1";
                    
                    $sSql = "SELECT * FROM money_extrato_cc WHERE mny_exc_numdocumento = '$mny_exc_numdocumento' AND mny_exc_data = '$mny_exc_data' AND mny_exc_valor = '$mny_exc_valor'";

                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
                    
                    if ($SqlResult_1->NumRows() == 0){
                        
                        $aDados = array(
                            "mny_exc_data"          => $mny_exc_data, 
                            "mny_exc_historico"     => $mny_exc_historico, 
                            "mny_exc_numdocumento"  => $mny_exc_numdocumento,                     
                            "mny_exc_valor"         => $mny_exc_valor,
                            "mny_exc_tipo_mov"      => $mny_exc_tipo_mov
                        );

                        $bd->fSisInsereRegistroBanco("money_extrato_cc", $aDados);      

                        if(ob_get_level() > 0){

                                ob_end_flush();

                        }
                    }    
                    
                }
                else if ($mny_exc_historico == "S A L D O"){
                    
                    $bd->fSisRemoveRegistroBanco("money_extrato_cc_saldo", array("YEAR(mny_exs_data)" => $aData[2], "MONTH(mny_exs_data)" => $aData[1]));
                    
                    $aDados = array(
                        "myy_exs_saldo_atual"   => $mny_exc_valor, 
                        "mny_exs_data"          => $mny_exc_data,
                        "mny_exs_tipo_mov"      => $mny_exc_tipo_mov
                    );

                    $bd->fSisInsereRegistroBanco("money_extrato_cc_saldo", $aDados);      

                    if(ob_get_level() > 0){
                        
                            ob_end_flush();
                            
                    }
                    
                }  
                
            } 
            
            $iCount++;
                
	}

	unset($_SESSION['csv_file_name']);
        
       
}

?>