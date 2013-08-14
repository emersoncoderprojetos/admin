<!DOCTYPE html>

    <html lang="pt-br">

        <head>

            <title><?php echo $titulo;?></title>

            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <meta name="robots" content="noindex, nofollow" />

            <!-- Le styles -->
            <link href="<?php echo base_url();?>assets_backend/css/bootstrap.css" rel="stylesheet">
            
            <style type="text/css">

                body {

                    padding-top      : 40px;
                    padding-bottom   : 40px;
                    background-color : #f5f5f5;

                }


                .form-signin {

                    max-width             : 300px;
                    padding               : 19px 29px 29px;
                    margin                : 0 auto 20px;
                    background-color      : #fff;
                    border                : 1px solid #e5e5e5;
                    -webkit-border-radius : 5px;
                    -moz-border-radius    : 5px;
                    border-radius         : 5px;
                    -webkit-box-shadow    : 0 1px 2px rgba(0,0,0,.05);
                    -moz-box-shadow       : 0 1px 2px rgba(0,0,0,.05);
                    box-shadow            : 0 1px 2px rgba(0,0,0,.05);

                }


                .form-signin .form-signin-heading, .form-signin .checkbox {

                    margin-bottom : 10px;

                }


                .form-signin input[type="text"], .form-signin input[type="password"] {

                    font-size     : 16px;
                    height        : auto;
                    margin-bottom : 15px;
                    padding       : 7px 9px;

                }

            
            </style>
            
            <link href="<?php echo base_url();?>assets_backend/css/bootstrap-responsive.css" rel="stylesheet">

            <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
            <!--[if lt IE 9]>
                <script src="../assets/js/html5shiv.js"></script>
            <![endif]-->

            <!-- Fav and touch icons -->
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>assets_backend/ico/apple-touch-icon-144-precomposed.png">
            <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>assets_backend/ico/apple-touch-icon-114-precomposed.png">
            <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>assets_backend/ico/apple-touch-icon-72-precomposed.png">
            <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>assets_backend/ico/apple-touch-icon-57-precomposed.png">
            <link rel="shortcut icon" href="<?php echo base_url();?>assets_backend/ico/favicon.png">

        </head>

        <body>

            <div class="container">

                <div class="row">

                    <div class="span4 offset4">

                        <div class="well">
                            
                            <legend style="text-align:center;">

                                RODRIGO TRANSPORTES 

                                <br />

                                ADMINSYSTEM

                            </legend>

                            <form method="POST" action="<?php echo base_url();?>admin/home/login" accept-charset="UTF-8">
                    
                                <?php echo validation_errors(); ?>

                                <input class="span3" value="<?php echo set_value('str_usuario'); ?>" placeholder="Usuário" type="text" name="str_usuario">

                                <input class="span3" placeholder="Senha" type="password" name="str_senha">

                                <label class="checkbox">

                                    <input type="checkbox" name="remember" value="1"> Lembrar login
                                    
                                </label>

                                <a href="<?php echo base_url();?>admin/home/esqueceu_senha">Esqueceu a senha ?</a>

                                <br />

                                <br />

                                <button class="btn-info btn" type="submit">Acessar >></button>
                            
                            </form>
                        
                        </div>
                    
                    </div>
                
                </div>

            </div> <!-- /container -->

        </body>
    
    </html>