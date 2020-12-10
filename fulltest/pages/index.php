<?php

//echo "entrou";
//exit;

require_once('../indicadores.ini.php');


//$aDatasColetadas = array();
//$aDatasColetadas = fRetornaPeriodos(4);
//$iaDatasColetadas_Tam = count($aDatasColetadas);


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
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    
    
    
    <![endif]-->

    <?inclui_fav();?>
</head>

 
         
         
<body>

    <input type="hidden" id="sUrlRaiz" value="<?=$sUrlRaiz?>">    
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=$sUrlRaiz?>pages/">ATENA - AVALIAÇÃO DE HABILIDADE E COMPETÊNCIA</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?=$sUrlRaiz?>controle/adm/login/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> DASHBOARD <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#"><i class="fa fa-wrench fa-fw"></i> MANUTENÇÃO <span class="fa arrow"></span></a> 
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?=$sUrlRaiz?>controle/questoes/cadastro/index.php" target="perguntas"> <i class="fa fa-ellipsis-v fa-fw"></i> Cadastro das Questões</a>
                                        </li>
                                        <li>
                                            <a href="<?=$sUrlRaiz?>controle/provas/cadastro/index.php" target="provas"> <i class="fa fa-ellipsis-v fa-fw"></i> Cadastro das Provas</a>
                                        </li>
                                        <li>
                                            <a href="<?=$sUrlRaiz?>controle/candidatos/cadastro/index.php" target="candidato"> <i class="fa fa-ellipsis-v fa-fw"></i> Cadastro dos Candidatos</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-wrench fa-fw"></i> TESTES <span class="fa arrow"></span></a> 
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?=$sUrlRaiz?>controle/testes/cadastro/index.php" target="testes"> <i class="fa fa-ellipsis-v fa-fw"></i> Cadastro de Testes</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>                        
                    </ul>
                    
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DASHBOARD
                        </div>
                        <div class="panel-body">
                            <!--
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#fulltrack" data-toggle="tab">Fultrack</a>
                                </li>
                                <li><a href="#fullarm" data-toggle="tab">Fullarm</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                
                                <?
                                    //fMontaPaineisEquipe("1");
                                    //fMontaPaineisEquipe("2");
                                ?>
                                
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>            
        </div>


        
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>


    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    

</body>

</html>
