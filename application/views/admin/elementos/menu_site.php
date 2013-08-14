<div class="span3">


    <div class="well sidebar-nav">

        <ul class="nav nav-list">

            <!-- INICIO # MENUS -->
            <li class="nav-header nav_menus"><a href="#" class="m_menus">MENUS</a></li>
            <li class="menu_menus"><a class="menus_1" href="<?php echo base_url();?>admin/menus">Gerenciar Menu</a></li>
            <li class="menu_menus"><a class="menus_2" href="<?php echo base_url();?>admin/menus/submenus">Gerenciar Sub-Menu</a></li>
            <!-- FIM    # MENUS -->

            <!-- INICIO # CAPAS DA HOME -->
            <li class="nav-header nav_seo"><a href="#" class="m_seo">SEO</a></li>
            <li class="menu_seo"><a href="<?php echo base_url();?>admin/seo">Gerenciar SEO</a></li>
            <!-- FIM    # CAPAS HOME -->            

            <!-- INICIO # MENU CONTEUDO -->
            <li class="nav-header nav_conteudo"><a href="#" class="m_conteudo">Conteúdo</a></li>

            <!-- INICIO # CAPAS DA HOME -->
            <li class="nav-header nav_capa_home"><a href="#" class="m_capa_home">Capas da Home</a></li>
            <li class="menu_capa_home"><a href="<?php echo base_url();?>admin/capas_home">Gerenciar Capas da Home</a></li>
            <!-- FIM    # CAPAS HOME -->            

            <?php

                foreach($dados_menu as $dm):

                    echo '<li class="menu_conteudo m_con_' . $dm->str_pagina . '"><a class="link_conteudo_' . $dm->id . '" href="' . base_url() . 'admin/conteudo/editar/' . $dm->id . '"><i class="icon-folder-close icon_conteudo_menu_' . $dm->id . '"></i>' . $dm->str_nome . '</a></li>';

                endforeach;

            ?>
            <!-- FIM # MENU CONTEUDO -->

        </ul>

    </div>

</div>

<script type="text/javascript">

    $(".m_capa_home").click(function() {
        $('.menu_capa_home').toggle('slow');
        $('.nav_capa_home').toggleClass('active');
    });

    $(".m_conteudo").click(function() {
        $('.menu_conteudo').toggle('slow');
        $('.nav_conteudo').toggleClass('active');
    });

    $(".m_menus").click(function() {
        $('.menu_menus').toggle('slow');
        $('.nav_menus').toggleClass('active');
    });

    $(".m_seo").click(function() {
        $('.menu_seo').toggle('slow');
        $('.nav_seo').toggleClass('active');
    });     

</script>