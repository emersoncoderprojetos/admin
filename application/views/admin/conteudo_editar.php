<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

	<!-- INICIO # CONTEÚDO CENTRAL -->
	<div class="row-fluid">

		<!-- INICIO # MENU LATERAL ESQUERDO -->
		<?php $this->load->view('clicserver/elementos/menu', $dados_menu); ?>
		<!-- FIM # MENU LATERAL ESQUERDO -->

		<div class="span9">

			<h2>Edição de conteúdo da página</h2>
			<h3><?php echo $conteudo[0]->str_nome;?></h3>

			<?php

				if($msg == 'ok'){
					echo '<div class="alert alert-success">';
						echo '<p>Conteúdo salvo com sucesso !</p>';
					echo '</div>';
				}
				else if ($msg == 'erro'){
					echo '<div class="alert alert-error">';
						echo '<p>ERRO ao gravar conteúdo - Contate o Suporte Técnico CLICSERVER - AGENCIA10CLI !</p>';
					echo '</div>';					
				}

					
			?>

			<form action="<?php echo base_url();?>clicserver/conteudo/gravar" method="post">
				
				<fieldset>
					
					<legend>SEO</legend>

					<label for="str_title">title</label>
					<input type="text" id="str_title" class="input-xxlarge" placeholder="title" value="<?php echo $conteudo[0]->str_title;?>" name="str_title" >
					
					<label for="str_keywords">keywords</label>
					<input type="text" id="str_keywords" class="input-xxlarge" placeholder="keywords" value="<?php echo $conteudo[0]->str_keywords;?>" name="str_keywords">

					<label for="str_description">description</label>
					<textarea id="str_description"  placeholder="description" style="width:500px;" name="str_description"><?php echo $conteudo[0]->str_description;?></textarea>

					<legend>Conteúdo</legend>

					<label for="str_titulo">título do conteúdo</label>
					<input type="text" id="str_titulo" placeholder="título do conteúdo" name="str_titulo" value="<?php echo $conteudo[0]->str_titulo;?>">
					
					<label for="txt_texto">texto do conteúdo</label>
					<textarea id="txt_texto" class="textarea"  placeholder="texto do conteúdo" style="width:600px;height:150px;" name="txt_texto"><?php echo $conteudo[0]->txt_texto;?></textarea>

					<br />					

					<input type="hidden" value="<?php echo $conteudo[0]->id;?>" name="id" />

					<button type="submit" class="btn btn-primary">Salvar</button>

				</fieldset>

			</form>

		</div>

	</div>
	<!-- FIM # CONTEÚDO CENTRAL -->

	<script type="text/javascript">

		$('.gdf_toggle').click(function(event){
			event.preventDefault();
			$('#galeria_de_fotos').toggle();
		});

		$(function(){

			$('.nav_conteudo').addClass('active');
			$('.menu_conteudo').show();
			$('.icon_conteudo_menu_<?php echo $conteudo[0]->id;?>').removeClass('icon-folder-close');
			$('.icon_conteudo_menu_<?php echo $conteudo[0]->id;?>').addClass('icon-folder-open');
			$('.link_conteudo_<?php echo $conteudo[0]->id;?>').css('color', 'black');
			$('.m_con_<?php echo $conteudo[0]->str_pagina;?> > a').css('background-color', '#EEEEEE');
			$('.textarea').wysihtml5({
				"font-styles" : true,
				"color"       : false,
				"image"       : false,
				"link"        : false,
				locale        : "pt-BR"
			});

			setTimeout(function() {
				$('.alert').fadeOut('slow');
			}, 4000);


		});
	</script>