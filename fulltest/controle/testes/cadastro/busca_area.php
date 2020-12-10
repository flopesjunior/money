<?
require_once('../../../indicadores.ini.php');

    $ftt_are_id   = $_POST["ftt_are_id"];
    
    $sDisplay = "";
                                     
                                    $sSql = "
                                        select 	
                                                ftt_are_responsavel, 
                                                ftt_are_email
                                                from ftt_area 
                                                WHERE ftt_are_id = $ftt_are_id
                                        ";  
//                                    echo $sSql."<BR>";
                                    
                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                    $sDisplay .= "<table width='1%' border='0' cellspacing='0' cellpadding='0'>";  
                                    
                                    if ($SqlResult_1->NumRows() > 0) {
                                            $ftt_are_responsavel                    = $SqlResult_1->fields["ftt_are_responsavel"];                              
                                            $ftt_are_email             = $SqlResult_1->fields["ftt_are_email"]; 
                                            
                                            $sDisplay .= "
                                                       <tr>  
                                                         <td colspan=3 nowrap>
                                                            <b>Resposnsável:</b> $ftt_are_responsavel 
                                                         </td>
                                                       </tr>
                                                       <tr>
                                                         <td colspan=3 nowrap>
                                                            <b>Email:</b> $ftt_are_email 
                                                         </td>
                                                       </tr>

                                            ";

                                    }
                                    
                                    $sDisplay .= "</table>";        

                                    echo $sDisplay;
        
    
?>