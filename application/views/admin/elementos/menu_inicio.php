<div class="span3">


    <div class="well sidebar-nav">

        <ul class="nav nav-list">

            <!-- INICIO # ESTATÍSTICA -->
            <li class="nav-header nav_estatisticas"><a href="#" class="m_estatisticas">Estatísticas</a></li>
            <li class="menu_estatisticas"><a href="<?php echo base_url();?>admin/estatisticas">Gerenciar Estatísticas</a></li>
            <!-- FIM    # ESTATÍSTICA -->

            <!-- INICIO # SENHAS -->
            <li class="nav-header nav_senhas"><a href="#" class="m_senhas">Senhas</a></li>
            <li class="menu_senhas"><a href="<?php echo base_url();?>admin/senhas">Gerenciar Senhas</a></li>
            <!-- FIM    # SENHAS -->

            <!-- INICIO # VENCIMENTOS -->
            <li class="nav-header nav_vencimentos"><a href="#" class="m_vencimentos">Vencimentos</a></li>
            <li class="menu_vencimentos"><a href="<?php echo base_url();?>admin/vencimentos">Gerenciar Vencimentos</a></li>
            <!-- FIM    # VENCIMENTOS -->

            <!-- INICIO # USUÁRIOS -->
            <li class="nav-header nav_usuarios"><a href="#" class="m_usuarios">Usuários</a></li>
            <li class="menu_usuarios"><a href="<?php echo base_url();?>admin/usuarios">Gerenciar Usuários</a></li>
            <!-- FIM    # USUÁRIOS -->              

        </ul>

    </div>

</div>

<script type="text/javascript">

    $(".m_estatisticas").click(function() {
        $('.menu_estatisticas').toggle('slow');
        $('.nav_estatisticas').toggleClass('active');
    });

    $(".m_senhas").click(function() {
        $('.menu_senhas').toggle('slow');
        $('.nav_senhas').toggleClass('active');
    });       

    $(".m_vencimentos").click(function() {
        $('.menu_vencimentos').toggle('slow');
        $('.nav_vencimentos').toggleClass('active');
    });

    $(".m_usuarios").click(function() {
        $('.menu_usuarios').toggle('slow');
        $('.nav_usuarios').toggleClass('active');
    });     

</script>