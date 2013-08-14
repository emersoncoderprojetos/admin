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

				$display        = 'style="display:none;"';
				$display_tabela = 'style="display:block;"';

				if ($msg == 'excluido_sucesso') {

					echo '<div class="alert alert-success">';
						echo '<p>Excluido com sucesso !</p>';
					echo '</div>';

				}

				if ($msg == 'ok') {

					echo '<div class="alert alert-success">';
						echo '<p>Salvo com sucesso !</p>';
					echo '</div>';

				}				
				
				else if ($msg == 'erro'){

					echo '<div class="alert alert-error">';
						echo '<p>ERRO - Contate o Suporte Técnico CLICSERVER - AGENCIA10CLIC !</p>';
					echo '</div>';					

				}

				else if ($msg == 'nao_validou') { 

					$display        = 'style="display:block;"';
					$display_tabela = 'style="display:none;"';
					$display_slug   = 'style="display:none;';

				} 				

				else if ($msg == 'existe_slug') { 

					$display        = 'style="display:block;"';
					$display_tabela = 'style="display:none;"';

				} 				

			?>

			<h3><a href="#" class="inserir_nova_noticia">Cadastrar nova notícia</a></h3>

			<div id="noticias" <?php echo $display;?>>

				<form action="<?php echo base_url();?>clicserver/noticias/inserir" method="post" enctype="multipart/form-data">

					<fieldset>

						<legend>Cadastro de Notícias</legend>

						<?php echo validation_errors(); ?>

						<label for="str_titulo">Título</label>
						<input id="str_titulo" type="text" placeholder="título" class="input-xxlarge" name="str_titulo" value="<?php echo set_value('str_titulo'); ?>" />

						<label for="str_slug">SLUG (texto que vai aparecer em sua URL ex: www.seusite.com.br/noticias/nome-da-noticia)</label>
						<input id="str_slug" type="text" placeholder="título" class="input-xxlarge" name="str_slug" value="<?php echo set_value('str_slug'); ?>" />						
						<p class="slug label label-important" style="display:none;">Existe slug igual, digite um diferente por favor !</p>
						<?php
							if ($msg == 'existe_slug')
								echo '<p class="slug label label-important" style="display:block;width:270px">Existe slug igual, digite um diferente por favor !</p>';
						?>

						<label for="date_data_noticia">Data</label>
						<input type="text" name="date_data_noticia" id="date_data_noticia" class="input-small" placeholder="data"/>

						<label for="txt_descricao">Texto</label>
						<textarea class="textarea" style="width:550px;height:200px;" name="txt_descricao"><?php echo set_value('txt_descricao'); ?></textarea>

						<br style="clear:both;" />

						<legend>Imagens</legend>
						
						<div style="float:left;" class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
							<div>
								<span class="btn btn-file">
									<span class="fileupload-new">Selecione a Imagem</span>
									<span class="fileupload-exists">Mudar</span>
									<input type="file" />
								</span>
								<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Excluir</a>
							</div>
						</div>

						<legend>Status</legend>

						<label class="checkbox">
							<input type="checkbox" checked name="int_ativo" value="1"> Ativo
						</label>

						<label class="checkbox" for="int_destaque">
	      					<input type="checkbox" value="1" name="int_destaque"> Destaque
	    				</label>							

	    				<hr />

						<div class="control-group">
							<!-- Button -->
							<div class="controls">

								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> INSERIR</button>
								<button class="btn btn-small" type="reset"><i class="icon-refresh"></i> LIMPAR</button> 

							</div>
							
						</div>
					
					</fieldset>
				
				</form>	

			</div>

			<!-- INICIO # TABELA -->
			<div id="table" <?php echo $display_tabela;?>>

				<table id="tabela_noticias" class="table table-hover table-striped table-bordered table-condensed">

					<thead>

						<tr>

							<th>ID</th>

							<th>Data</th>

							<th>Título</th>

							<th>Texto</th>

							<th>Imagem</th>

							<th>Ativo</th>

							<th>Destaque</th>

							<th>Ação</th>

						</tr>

					</thead>

					<tbody>

					<?php

						foreach($noticias as $nt):

							echo '<tr>';

								echo '<td><span class="badge">' . $nt->id . '</span></td>';

								echo '<td>' . data_us_to_br($nt->date_data_noticia) . '</td>';

								echo '<td>' . $nt->str_titulo . '</td>';

								echo '<td>' . word_limiter($nt->txt_descricao, '4') . '</td>';

								echo '<td><img src="' . base_url() . 'noticias_imagem/thumb/' . $nt->str_imagem . '"></td>';

									# ATIVO
									if ($nt->int_ativo == 1) {
										$int_ativo = '<span onclick="status(' . $nt->id . ');" class="status_label_' . $nt->id . ' label label-important"><i class="icone_' . $nt->id . ' icon-stop link"> </i></span>';
									}
									elseif ($nt->int_ativo == 0) {
										$int_ativo = '<span onclick="status(' . $nt->id . ');" class="status_label_' . $nt->id . ' label label-success"><i class="icone_' . $nt->id . ' icon-play link"></i></span>';
									}
								echo '<td>' . $int_ativo . '</td>';

									# DESTAQUE
									if ($nt->int_destaque == 1) {
										$int_destaque = '<span onclick="destaque(' . $nt->id . ');" class="destaque_label_' . $nt->id . ' label label-warning" id="destaque_ativo_' . $nt->id . '"><i class="icon-star link"> </i></span>';
									}
									elseif ($nt->int_destaque == 0) {
										$int_destaque = '<span onclick="destaque(' . $nt->id . ');" class="destaque_label_' . $nt->id . ' label label-inverse" id="destaque_ativo_' . $nt->id . '"><i class="icon-star link"></i></span>';
									}
								echo '<td>' . $int_destaque . '</td>';								

						 		echo '<td><a style="cursor:pointer;" onclick="return confirm(\'Editar notícia: ' . $nt->str_titulo . ' ?\')";" href="' . base_url() . 'clicserver/noticias/editar/' . $nt->id . '"><i class="icon-edit"></i></a> / <a style="cursor:pointer;" onclick="return confirm(\'Excluir notícia: ' . $nt->str_titulo . ' ?\')";" href="' . base_url() . 'clicserver/noticias/excluir/' . $nt->id . '"><i class="icon-trash"></i></a></td>';

						 	echo '</tr>';

						 endforeach;

					?>

					</tbody>

				</table>
				<!-- FIM # TABELA -->

			</div>

		</div>
		<!-- FIM # DIV DIREITA -->

	</div>
	<!-- FIM # CONTEÚDO CENTRAL -->



	<script type="text/javascript">

		$('.inserir_nova_noticia').click(function(){

			$('#noticias').toggle('slow');

			$('#table').toggle();
			
		})

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

			$('#tabela_noticias').dataTable( {
				"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ produtos por página"
				}
			});

			$('.fileupload').fileupload({
				uploadtype : 'file',
				name       : 'str_imagem'
			});

			setTimeout(function() {
				$('.alert').fadeOut('slow');
			}, 4000);

		});

		function status (id) {
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/noticias/status",
				data : { id : id }
			}).done(function(msg) {

				if(msg == 'ativo'){

					$('.icone_' + id).removeClass('icon-play');
					$('.icone_' + id).addClass('icon-stop');

					$('.status_label_' + id).removeClass('label-success');
					$('.status_label_' + id).addClass('label-important');

				}

				else if (msg == 'desativado'){

					$('.icone_' + id).removeClass('icon-stop');
					$('.icone_' + id).addClass('icon-play');

					$('.status_label_' + id).removeClass('label-important');
					$('.status_label_' + id).addClass('label-success');

				}
			});
		}

		function destaque (id) {
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/noticias/destaque",
				data : { id : id }
			}).done(function(msg) {

				if(msg == 'ativo'){
					$('.destaque_label_' + id).addClass('label-warning');
					$('.destaque_label_' + id).removeClass('label-inverse');
				}

	 			else if (msg == 'desativado'){
					$('.destaque_label_' + id).addClass('label-inverse');
					$('.destaque_label_' + id).removeClass('label-warning');
				}
				
			});
		}

		$('.textarea').wysihtml5({
			"font-styles" : true,
			"color"       : false,
			"image"       : false,
			"link"        : false,
			locale        : "pt-BR"
		});		

	</script>