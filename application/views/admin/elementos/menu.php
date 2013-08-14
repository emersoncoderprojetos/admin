<div class="span3">


    <div class="well sidebar-nav">

        <ul class="nav nav-list">

            <!-- INICIO # CAPAS DA HOME -->
            <li class="nav-header nav_capa_home"><a href="#" class="m_capa_home">Capas da Home</a></li>
            <li class="menu_capa_home"><a href="<?php echo base_url();?>admin/capas_home">Gerenciar Capas da Home</a></li>
            <!-- FIM # CAPAS HOME -->            

            <!-- INICIO # MENU CONTEUDO -->
            <li class="nav-header nav_conteudo"><a href="#" class="m_conteudo">Conteúdo</a></li>
            <?php

                foreach($dados_menu as $dm):
                    
                    echo '<li class="menu_conteudo m_con_' . $dm->str_pagina . '">

                            <a class="link_conteudo_' . $dm->id . '" href="' . base_url() . 'admin/conteudo/editar/' . $dm->id . '">

                                <i class="icon-folder-close icon_conteudo_menu_' . $dm->id . '"></i>

                                ' . $dm->str_nome . '

                            </a>

                        </li>';

                endforeach;
            ?>
            <!-- FIM # MENU CONTEUDO -->

            <!-- INICIO # MENU CATEGORIAS -->
            <li class="nav-header nav_categorias"><a href="#" class="m_categorias">Categorias</a></li>
            <li class="menu_categorias"><a href="<?php echo base_url();?>admin/categorias">Gerenciar Categorias</a></li>
            <!-- FIM # MENU CATEGORIAS -->

            <!-- INICIO # MENU SUB-CATEGORIAS -->
            <li class="nav-header nav_sub_categorias"><a href="#" class="m_sub_categorias">Sub-Categorias</a></li>
            <li class="menu_sub_categorias"><a href="<?php echo base_url();?>admin/sub_categorias">Gerenciar Sub-Categorias</a></li>
            <!-- FIM # MENU SUB-CATEGORIAS -->

            <!-- INICIO # MENU PRODUTOS -->
            <li class="nav-header nav_produtos"><a href="#" class="m_produtos">Produtos</a></li>
            <li class="menu_produtos"><a href="<?php echo base_url();?>admin/produtos">Gerenciar Produtos</a></li>
            <!-- FIM # MENU PRODUTOS -->                              

            <!-- INICIO # MENU NOTÍCIAS -->
            <li class="nav-header nav_noticias"><a href="#" class="m_noticias">Notícias</a></li>
            <li class="menu_noticias"><a href="<?php echo base_url();?>admin/noticias">Gerenciar Notícias</a></li>
            <!-- FIM    # MENU NOTÍCIAS -->                                          

            <!-- INICIO # MENU CATEGORIAS -->
            <li class="nav-header nav_usuarios"><a href="#" class="m_usuarios">Usuários</a></li>
            <li class="menu_usuarios"><a href="<?php echo base_url();?>admin/usuarios">Gerenciar Usuários</a></li>
            <!-- FIM # MENU CATEGORIAS -->            

        </ul>

    </div>

</div>

<script type="text/javascript">

    $(".m_capa_home").click(function() {
        $('.menu_capa_home').toggle('slow');
        $('.nav_capa_home').toggleClass('active');
    });

    $(".m_noticias").click(function() {
        $('.menu_noticias').toggle('slow');
        $('.nav_noticias').toggleClass('active');
    });       

    $(".m_conteudo").click(function() {
        $('.menu_conteudo').toggle('slow');
        $('.nav_conteudo').toggleClass('active');
    });

    $(".m_categorias").click(function() {
        $('.menu_categorias').toggle('slow');
        $('.nav_categorias').toggleClass('active');
    });

    $(".m_usuarios").click(function() {
        $('.menu_usuarios').toggle('slow');
        $('.nav_usuarios').toggleClass('active');
    }); 

    $(".m_sub_categorias").click(function() {
        $('.menu_sub_categorias').toggle('slow');
        $('.nav_sub_categorias').toggleClass('active');
    }); 

    $(".m_produtos").click(function() {
        $('.menu_produtos').toggle('slow');
        $('.nav_produtos').toggleClass('active');
    });                

</script>