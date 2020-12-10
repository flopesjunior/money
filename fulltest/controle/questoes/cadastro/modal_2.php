<?
require_once('../../../indicadores.ini.php');

$ftt_per_id     = $_GET["ftt_per_id"];


?>

 <html>
  <head>
    <title>CADASTRO DE ALTERNATIVAS - <?=$sNomeSistema?></title>
      
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/questoes/cadastro/js.js" type="text/javascript" ></script>

    
    <script src="../../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../../../dist/js/sb-admin-2.js"></script>
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">       
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       
    
    <link href="../../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="../../../dist/css/timeline.css" rel="stylesheet">
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>    
    
    <style>
        .sla1 {
            background-color: #F0FBEF !important;
        }

        .sla2 {
            background-color: #F9EFD1 !important;
        }
        
        .sla3 {
            background-color: #ff3333 !important;
        }
        
        table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
            font-size: 12px;
        }        
        
        .body2 {
            height: 215px;
        }
        
        .row-centered {
            text-align:center;
        }
        
        .col-centered {
            display:inline-block;
            float:none;
            text-align:left;
            margin-right:-4px;
        }        
    </style>    
    
    
  </head>    
  
  <body style="margin-left: 12px; margin-right: 12px; margin-top: 12px">
  <form name="apuracao" method="post" action="<?=$PHP_SELF?>">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">
      <input type="hidden" value="<?=$ftt_per_id?>" id="apu_zon_id" name="ftt_per_id">

    <div class="row">
       <?
       $sTitulo = "CADASTRO DE QUESTÕES";
       ?>                          
   </div>
      
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                     <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-wrench fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div><h1>Cadastro de Questões</h1></div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" >
                        <div class='row'>
                            <div class='col-xs-12 text-right'>
                                <div class='huge'>
                                    <center>
                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                        <tr>
                                            <td align=left>
                                                <h4>Pergunta<h4/> 
                                            </td>
                                        </tr>    
                                        <tr>    
                                            <td align=left>
                                                <textarea class="form-control" name="txt_pergunta" id="txt_pergunta" rows="5"></textarea>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align=left>
                                                <h4>Tipo da Resposta<h4/> 
                                            </td>
                                        </tr>                                         
                                        <tr>    
                                            <td align=left>
                                                <div class="form-group">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="ftt_per_tipo" value="1" checked>Dissertativa
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="ftt_per_tipo" value="2">Alternativas
                                                        </label>
                                                    </div>
                                                </div>                                       
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align=left>
                                                <h4>Nível<h4/> 
                                            </td>
                                        </tr>                                         
                                        <tr>    
                                            <td align=left>
                                                <div class="form-group">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="ftt_per_nivel" value="1" checked>Estágio
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="ftt_per_nivel" value="2">Júnior
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="ftt_per_nivel" value="3">Pleno
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="ftt_per_nivel" value="4">Senior
                                                        </label>
                                                    </div>
                                                </div>                                       
                                            </td>
                                        </tr>
                                    </table>    
                                    </center>
                                </div>
                            </div>
                        </div>   
                    
                        <div class='row'>
                            <BR><BR><center><button onclick="registrar_pergunta();" type="button" class="btn btn-success btn-lg">AVANÇAR</button> <button onclick="window.close();" type="button" class="btn btn-default btn-lg">CANCELAR</button></center>
                        </div>                       
                       
                </div>
            </div>
        </div>
     </div>
  </form>    
  </body>
  
  
</html>

  
  
