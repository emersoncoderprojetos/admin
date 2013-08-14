<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <title><?php echo $titulo;?></title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="nofollow" />

        <?php
            if($css_pagina)
                echo '<link href="' . base_url() . 'assets_backend/css/' . $css_pagina . '" rel="stylesheet">';
        ?>

        <style type="text/css">

            body {

                padding-top    : 60px;
                padding-bottom : 40px;

            }


            .sidebar-nav {

                padding : 9px 0;

            }


            @media (max-width: 980px) {

                /* Enable use of floated navbar text */
                .navbar-text.pull-right {

                    float         : none;
                    padding-left  : 5px;
                    padding-right : 5px;

                }

            }


        </style>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="shortcut icon" href="../assets/ico/favicon.png">
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets_backend/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets_backend/css/bootstrap-responsive.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets_backend/css/datatables.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets_backend/css/bootstrap-wysihtml5.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets_backend/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets_backend/css/datepicker.css" />

        
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/bootstrap-tooltip.js"></script>

        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/bootstrap-datepicker.js"></script>        
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/datatables-bootstrap.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/datatables.js"></script>

        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/bootstrap-wysihtml5.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/prettify.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/locales/bootstrap-wysihtml5.pt-BR.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets_backend/js/maskedinput.js"></script>

        <!-- UPLOAD -->
        <script type="text/javascript" src="<?php echo base_url();?>assets_backend/upload/bootstrap-fileupload.js" /></script>
        <link rel="stylesheet" href="<?php echo base_url();?>assets_backend/upload/bootstrap-fileupload.css" />

        <!-- COLORPICKER -->
        <script type="text/javascript" src="<?php echo base_url();?>assets_backend/colorpicker/js/colorpicker.js" /></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets_backend/colorpicker/js/eye.js" /></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets_backend/colorpicker/js/layout.js" /></script>

        <link rel="stylesheet" href="<?php echo base_url();?>assets_backend/colorpicker/css/colorpicker.css" />

        <script> var site_url = "<?php echo base_url();?>";</script>
            
    </head>

    <body>

        <!-- # INICIO # BARRA DO TOPO -->
        <div class="navbar navbar-inverse navbar-fixed-top">

            <div class="navbar-inner">

                <div class="container-fluid">

                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                    </button>

                    <a class="brand nav" href="<?php echo base_url();?>admin/inicio">RODRIGO TRANSPORTES - ADMINSYSTEM</a>

                    <div class="nav-collapse collapse">

                        <p class="navbar-text pull-right">

                            Logado como 

                            <a href="<?php echo base_url();?>admin/usuarios" class="navbar-link">

                                <?php echo $this->session->userdata('usuario');?>

                            </a>

                             | 

                             <a href="<?php echo base_url();?>admin/home/logout">

                                Sair

                            </a>

                        </p>

                        <ul class="nav">

                            <li class="topo_site"><a href="<?php echo base_url();?>admin/conteudo">SITE</a></li>

                            <li class="topo_os"><a href="<?php echo base_url();?>admin/os">ORDEM DE SERVIÇO</a></li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>
        <!-- # FIM # BARRA DO TOPO -->