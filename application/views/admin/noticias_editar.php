<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

	<!-- INICIO # CONTEÚDO CENTRAL -->
	<div class="row-fluid">

		<!-- INICIO # MENU LATERAL ESQUERDO -->
		<?php $this->load->view('clicserver/elementos/menu', $dados_menu); ?>
		<!-- FIM # MENU LATERAL ESQUERDO -->

		<!-- INICIO # DIV DIREITA -->
		<div class="span9">

			<?php

				/**
				* carrega label com mensagens de alertas.
				*
				*/

				if ($msg == 'erro'){
					echo '<div class="alert alert-error">';
						echo '<p>ERRO - Contate o Suporte Técnico CLICSERVER - AGENCIA10CLIC !</p>';
					echo '</div>';					
				}

			?>

			<h3><a href="#" class="inserir_nova_noticia">Editar Notícia</a></h3>

			<div id="noticias">

				<form action="<?php echo base_url();?>clicserver/noticias/gravar" method="post" enctype="multipart/form-data">

					<fieldset>

						<legend>Edição de Notícias</legend>

						<?php echo validation_errors(); ?>

						<input type="hidden" name="id" value="<?php echo $noticias[0]->id;?>" />

						<label for="str_titulo">Título</label>
						<input id="str_titulo" type="text" placeholder="título" class="input-xxlarge" name="str_titulo" value="<?php echo $noticias[0]->str_titulo;?>" />

						<label for="str_slug">SLUG (texto que vai aparecer em sua URL ex: www.seusite.com.br/noticias/nome-da-noticia)</label>
						<input id="str_slug" type="text" placeholder="slug" class="input-xxlarge" name="str_slug" value="<?php echo $noticias[0]->str_slug;?>" />						
						<?php
							if ($msg == 'existe_slug')
								echo '<p class="slug label label-important" style="display:block;width:270px">Existe slug igual, digite um diferente por favor !</p>';
						?>

						<label for="date_data_noticia">Data</label>
						<input type="text" name="date_data_noticia" value="<?php echo data_us_to_br($noticias[0]->date_data_noticia);?>" id="date_data_noticia" class="input-small" placeholder="data"/>

						<label for="txt_descricao">Texto</label>
						<textarea class="textarea" style="width:550px;height:200px;" name="txt_descricao"><?php echo $noticias[0]->txt_descricao; ?></textarea>

						<legend>Imagens</legend>

						<?php

							if ($noticias[0]->str_imagem) {

									echo '<div style="float:left;margin:5px;text-align:center;">';
										echo '<img src="' . base_url() . 'noticias_imagem/thumb/' . $noticias[0]->str_imagem . '" class="img-polaroid"/>';
										echo '<p><a onclick="return confirm(\'Excluir imagem ?\');" href="' . base_url() . 'clicserver/noticias/excluir_imagem/' . $noticias[0]->id . '/capa"><i class="icon-remove"></i></a></p>';
									echo '</div>';

							} else {

								echo '<div style="float:left;" class="fileupload fileupload-new" data-provides="fileupload">';
									echo '<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>';
									echo '<div>';
										echo '<span class="btn btn-file">';
											echo '<span class="fileupload-new">Selecione a Imagem</span>';
											echo '<span class="fileupload-exists">Mudar</span>';
											echo '<input type="file" />';
										echo '</span>';
										echo '<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Excluir</a>';
									echo '</div>';
								echo '</div>';

							}

						?>

						<legend>Status</legend>

						<label class="checkbox">
							<?php

								if($noticias[0]->int_ativo == 1)
									$x = 'checked';
								else
									$x = '';

								if($noticias[0]->int_destaque == 1)
									$y = 'checked';
								else
									$y = '';

							?>

							<input type="checkbox" name="int_ativo" value="1" <?php echo $x;?>> Ativo
						</label>

						<label class="checkbox" for="int_destaque">
	      					<input type="checkbox" value="1" name="int_destaque" <?php echo $y;?>> Destaque
	    				</label>							

	    				<hr />

						<div class="control-group">
							<!-- Button -->
							<div class="controls">

								<button class="btn btn-info btn-small" type="button" onclick="javascript:history.go(-1);"><i class="icon-arrow-left"></i> VOLTAR</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> GRAVAR</button>
								<button class="btn btn-small" type="reset"><i class="icon-refresh"></i> LIMPAR</button> 

							</div>

						</div>
					
					</fieldset>
				
				</form>	

			</div>

		</div>
		<!-- FIM # DIV DIREITA -->

	</div>
	<!-- FIM # CONTEÚDO CENTRAL -->

	<script type="text/javascript">

		$('#str_titulo').blur(function(){
			titulo = $('#str_titulo').val();
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/noticias/slug",
				data : { titulo : titulo }
			}).done(function(msg) {
				if(msg == ' sim'){
					$('#str_slug').attr('value', titulo);
					$('.slug').show('slow');
				} else {
					$('#str_slug').attr('value', msg);
				}
			});			
		});

		$(function(){

			$('#date_data_noticia').datepicker({
				format : 'dd/mm/yyyy'
			});			

			$('.label').css('cursor', 'pointer');

			$('.nav_noticias').addClass('active');

			$('.menu_noticias').show();

			$('.fileupload').fileupload({
				uploadtype : 'file',
				name       : 'str_imagem'
			});

			setTimeout(function() {
				$('.alert').fadeOut('slow');
			}, 4000);

		});

		$('.textarea').wysihtml5({
			"font-styles" : true,
			"color"       : false,
			"image"       : false,
			"link"        : false,
			locale        : "pt-BR"
		});		

	</script>