<!DOCTYPE html>

    <html lang="pt-br">

        <head>

            <title>ESQUECEU A SENHA ? - PORT NET - CLICSERVER</title>

            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <meta name="robots" content="nofollow" />

            <!-- Le styles -->
            <link href="<?php echo base_url();?>assets_clicserver/css/bootstrap.css" rel="stylesheet">
            <link href="<?php echo base_url();?>assets_clicserver/css/bootstrap-responsive.css" rel="stylesheet">

            <style type="text/css">
                body {
                    padding-top     : 40px;
                    padding-bottom  : 40px;
                    background-color: #f5f5f5;
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
                    margin-bottom: 10px;
                }
            </style>

            <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
            <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->

            <!-- Fav and touch icons -->
            <link rel="shortcut icon" href="<?php echo base_url();?>assets_clicserver/ico/favicon.png">

            <script> site_url = '<?php echo base_url();?>'</script>

        </head>

        <body>

            <div class="container">

                <form class="form-signin">

                    <h2 class="form-signin-heading"><a href="<?php echo base_url();?>clicserver">CLICSERVER</a></h2>

                    <div class="control-group">

                        <label class="control-label" for="inputIcon">Digite seu e-mail.</label>

                        <div class="controls">

                            <div class="input-prepend">

                                <span class="add-on"><i class="icon-envelope"></i></span>

                                <input class="span3 email" id="inputIcon" type="text" onKeyPress="return !(event.keyCode==13);">
                                
                            </div>

                        </div>

                    </div>

                    <p class="email_da" style="display:none;">Campo em branco, digite seu e-mail</p>

                    <p class="email_va" style="display:none;">Digite um e-mail válido</p>

                    <p class="email_enviado_ok" style="display:none;">

                        A senha foi enviada para o e-mail : <strong><span class="email_enviado"></span></strong>

                        <br />

                        Você será redirecionado a página principal em 10 segundos.

                    </p>

                    <p class="email_nao_achado" style="display:none">Não localizamos este e-mail. <br />Entre em contato com o suporte técnico.</p>

                    <button type="button" class="btn btn-primary botao_enviar_email" data-loading-text="Enviando...">Enviar</button>

                </form>

            </div>

            <script src="<?php echo base_url();?>assets_clicserver/js/jquery.js"></script>

            <script src="<?php echo base_url();?>assets_clicserver/js/bootstrap-button.js"></script>

            <script>

                $('.btn').click(function (event) {

                    event.preventDefault();

                    var email         = $('.email').val();

                    var emailcontagem = $('.email').val().length;

                    if (emailcontagem > 0) {

                        var expreg = /([a-z0-9_\.\-])+\@(([a-z0-9])+\.)+((gov|com|org|net|biz|info)|([a-z]{2}))$/;

                        if (!expreg.exec(email)) {

                            $('.email_va').show('slow');

                            setTimeout(function () {

                                $('.email_va').hide('slow');

                            }, 2000);

                            return false;

                        } else {

                            $.post( site_url + "clicserver/home/existe_email", { 

                                email : email

                            }).done(function(data) {

                                if(data == 'sim'){

                                    $('.email_nao_achado').hide();

                                    var btn = $(this);

                                    btn.button('loading');

                                    $('.email_enviado').html(email);

                                    btn.button('reset');

                                    $('.botao_enviar_email').hide();

                                    $('.email_enviado_ok').show('slow');

                                    setTimeout(function () {

                                        location.href=site_url + 'clicserver';

                                    }, 10000);

                                }

                                else if(data == 'nao'){

                                    $('.email_nao_achado').show('slow');

                                    return false;

                                }

                           });  

                        }

                    } else {

                        $('.email_da').show('slow');

                        setTimeout(function () {

                            $('.email_da').hide('slow');

                        }, 2000);

                    }

                });

            </script>

        </body>

    </html>