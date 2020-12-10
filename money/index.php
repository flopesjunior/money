<?php
require_once "money.ini.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$sNomeSistema?></title>
    
    <link rel="icon" type="image/png" href="<?=$sUrlRaiz?>favicon.ico"/>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
    <!-- Bootstrap Core CSS -->
    <link href="<?=$sUrlRaiz?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?=$sUrlRaiz?>dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=$sUrlRaiz?>dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?=$sUrlRaiz?>bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=$sUrlRaiz?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="https://app.wehelpsoftware.com/js/built/production/widget.js"></script>
            
</head>
        
<body>

    <input type="hidden" id="sUrlRaiz" value="<?=$sUrlRaiz?>">    

    
  
    
    
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?=$sUrlRaiz?>">MONEY.WEB</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?=$sUrlRaiz?>login/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>  
            
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> MONEY <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#"><i class="fa fa-wrench fa-fw"></i> CONTA CORRENTE <span class="fa arrow"></span></a> 
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/import/index.php" target="import_extrato"> <i class="fa fa-ellipsis-v fa-fw"></i>Importar Extrato</a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/extrato/cadastro/index.php" target="extrato"> <i class="fa fa-ellipsis-v fa-fw"></i>Extrato</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-wrench fa-fw"></i> CADASTRO <span class="fa arrow"></span></a> 
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/contas/cadastro/index.php" target="cadcontas"> <i class="fa fa-ellipsis-v fa-fw"></i>Contas</a>
                                        </li>
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/origem/cadastro/index.php" target="cadorigem"> <i class="fa fa-ellipsis-v fa-fw"></i>Origem</a>
                                        </li>
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/periodicidade/cadastro/index.php" target="cadperiodicidade"> <i class="fa fa-ellipsis-v fa-fw"></i>Periodicidade</a>
                                        </li>
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/categoria/cadastro/index.php" target="cadcategoria"> <i class="fa fa-ellipsis-v fa-fw"></i>Categoria</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-wrench fa-fw"></i> MOVIMENTAÇÃO <span class="fa arrow"></span></a> 
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/contas_pagar/index.php" target="cadcontaspagar"> <i class="fa fa-ellipsis-v fa-fw"></i>Contas a pagar</a>
                                        </li>
                                    </ul>
                                </li>                                
                                <li>
                                    <a href="#"><i class="fa fa-wrench fa-fw"></i> RELATÓRIO <span class="fa arrow"></span></a> 
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/relatorio/previsao.php" target="relatprevisao"> <i class="fa fa-ellipsis-v fa-fw"></i>Previsão</a>
                                        </li>
                                        <li>
                                            <a href="<?=$sUrlRaiz?>sis/relatorio/gastos.php" target="relatgastos"> <i class="fa fa-ellipsis-v fa-fw"></i>Gastos</a>
                                        </li>
                                    </ul>
                                </li>                                
                            </ul>

                        </li>                        
                    </ul>
                    
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DASHBOARD <?=$aDesc_Mes."/".$AnoAtual?>
                        </div>
                        <div class="panel-body">
                                                     
                        </div>
                    </div>
                </div>
            </div>            
        </div>


        
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?=$sUrlRaiz?>bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$sUrlRaiz?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.js"></script>


    <!-- Custom Theme JavaScript -->
    <script src="<?=$sUrlRaiz?>dist/js/sb-admin-2.js"></script>
    
    
   
</body>

</html>
