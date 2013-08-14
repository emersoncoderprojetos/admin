<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

	<!-- INICIO # CONTEÚDO CENTRAL -->
	<div class="row-fluid">

		<!-- INICIO # MENU LATERAL ESQUERDO -->
		<?php $this->load->view('clicserver/elementos/menu', $dados_menu); ?>
		<!-- FIM # MENU LATERAL ESQUERDO -->

		<div class="span9">

			<?php

				# MENSAGENS DE ALERTA #

				$display        = 'display:none;';
				$display_tabela = 'display:block;';

				if($msg == 'ok'){

					echo '<div class="alert alert-success sumir">';
						echo '<p>Categoria salvo com sucesso !</p>';
					echo '</div>';
				}
				
				else if ($msg == 'erro'){
					echo '<div class="alert alert-error sumir">';
						echo '<p>ERRO ao gravar categoria - Contate o Suporte Técnico CLICSERVER - AGENCIA10CLI !</p>';
					echo '</div>';					
				}

				else if ($msg == 'excluido'){
					echo '<div class="alert alert-error sumir">';
						echo '<p>Categoria excluido com sucesso !</p>';
					echo '</div>';					
				}

				else if ($msg == 'nao_validou_slug'){
					echo '<div class="alert alert-error sumir">';
						echo '<p>Digite um SLUG válido !</p>';
					echo '</div>';
					$display        = 'display:block;';
				}				

				else if ($msg == 'nao_validou') {
					$display        = 'display:block;';
					$display_tabela = 'display:none;';
				}

			?>

			<h3 class="categorias"><a href="#">Nova Categoria</a></h3>

			<div id="categorias" style="<?php echo $display;?>">

				<!-- INICIO # FORMULÁRIO -->
				<form action="<?php echo base_url();?>clicserver/categorias/inserir" method="post" enctype="multipart/form-data">

					<fieldset>

						<legend>Cadastro de Categorias</legend>

						<?php echo validation_errors(); ?>

					    <div class="alert">
							<strong>Primeiro Passo!</strong> Digite o nome da categoria depois aperte TAB.
						</div>

						<label for="str_nome">Categoria</label>
						<input type="text" id="str_nome" placeholder="categoria" class="input-xxlarge" name="str_nome" value="<?php echo set_value('str_nome'); ?>">

						<label for="str_slug">Slug (nome que vai aparecer na url ex: www.seusite.com.br/slug)</label>
						<input type="text" id="str_slug" placeholder="slug" class="input-xxlarge" name="str_slug" value="<?php echo set_value('str_slug'); ?>">						

						<legend>SEO</legend>

						<label for="str_title">title</label>
						<input type="text" id="str_title" class="input-xxlarge" placeholder="title" value="<?php echo set_value('str_title'); ?>" name="str_title" >
					
						<label for="str_keywords">keywords</label>
						<input type="text" id="str_keywords" class="input-xxlarge" placeholder="keywords" value="<?php echo set_value('str_keywords'); ?>" name="str_keywords">

						<label for="str_description">description</label>
						<textarea id="str_description"  placeholder="description" style="width:500px;" name="str_description"><?php echo set_value('str_description'); ?></textarea>

						<legend>Status</legend>

						<label class="checkbox" for="int_ativo">
	      					<input type="checkbox" value="1" name="int_ativo" checked> Ativo
	    				</label>

						<label class="checkbox" for="int_destaque">
	      					<input type="checkbox" value="1" name="int_destaque"> Destaque
	    				</label>	    				

	    				<input type="hidden" value="" id="confirma_slug" name="confirma_slug" />

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
				<!-- FIM # FORMULÁRIO -->

			</div>

			<div id="tabela" style="<?php echo $display_tabela;?>">

				<!-- INICIO # TABELA DE DADOS -->
				<table id="tabela_linha" class="table table-hover table-striped table-bordered table-condensed">

					<caption>Categorias</caption>

					<thead>

						<tr>

							<th>ID</th>

							<th>Nome</th>

							<th>Ativo</th>

							<th>Destaque</th>

							<th>Ação</th>

						</tr>

					</thead>

					<tbody>

						<?php

							foreach($categorias as $cat):

								echo '<tr>';

									echo '<td><span class="badge">' . $cat->id . '</span></td>';

									echo '<td>' . $cat->str_nome . '</td>';

									# ATIVO
									if ($cat->int_ativo == 1) {
										$status = '<span onclick="muda_status(' . $cat->id . ');" class="prod_sit_' . $cat->id . ' label label-important" id="ativ_' . $cat->id . '"><i class="icone_' . $cat->id . ' icon-stop link"> </i></span>';
									}
									elseif ($cat->int_ativo == 0) {
										$status = '<span onclick="muda_status(' . $cat->id . ');" class="prod_sit_' . $cat->id . ' label label-success" id="ativ_' . $cat->id . '"><i class="icone_' . $cat->id . ' icon-play link"></i></span>';
									}
									echo '<td>' . $status . '</td>';

									# DESTAQUE
									if ($cat->int_destaque == 1) {
										$destaque = '<span onclick="muda_destaque(' . $cat->id . ');" class="cat_des_' . $cat->id . ' label label-warning" id="ativ_des_' . $cat->id . '"><i class="icone_des' . $cat->id . ' icon-star link"> </i></span>';
									}
									elseif ($cat->int_destaque == 0) {
										$destaque = '<span onclick="muda_destaque(' . $cat->id . ');" class="cat_des_' . $cat->id . ' label label-inverse" id="ativ_des_' . $cat->id . '"><i class="icone_des' . $cat->id . ' icon-star "></i></span>';
									}
									echo '<td>' . $destaque . '</td>';									

									echo '<td><a style="cursor:pointer;" onclick="return confirm(\'Editar categoria: ' . $cat->str_nome . ' ?\')";" href="' . base_url() . 'clicserver/categorias/editar/' . $cat->id . '"><i class="icon-edit"></i></a> / <a style="cursor:pointer;" onclick="return confirm(\'Excluir categoria: ' . $cat->str_nome . ' ?\')";" href="' . base_url() . 'clicserver/categorias/excluir/' . $cat->id . '"><i class="icon-trash"></i></a></td>';
								echo '</tr>';
							endforeach;

						?>

					</tbody>

				</table>

				<!-- FIM # TABELA DE DADOS -->

			</div>

		</div>

	</div>
	<!-- FIM # CONTEÚDO CENTRAL -->

	<script type="text/javascript">

		/* ABRE O FORMULÁRIO E FECHA A TABELA */
		$('.categorias').click(function(){

			$('#categorias').toggle('slow');
			$('#tabela').toggle('slow');

		});

		/* CONSULTA SLUG */
		$('#str_nome').blur(function(){

			slug = $('#str_nome').val();

			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/categorias/existe_slug",
				data : { slug : slug }
			}).done(function( msg ) {

				if (msg == ' sim') {

					alert('já existe SLUG com esse nome, digite um diferente !');
					$('#confirma_slug').attr('value', 1);

				} else {

					$('#str_slug').attr('value', msg);
					$('#confirma_slug').attr('value', 0);

				}
				
			});

		});

		$('#str_slug').blur(function(){

			valor = $('#str_slug').val();

			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/categorias/existe_slug",
				data : { slug : valor }
			}).done(function( msg1 ) {

				if (msg == ' sim') {

					alert('já existe SLUG com esse nome, digite um diferente !');
					$('#confirma_slug').attr('value', 1);

				} else {

					$('#str_slug').attr('value', msg);
					$('#confirma_slug').attr('value', 0);

				}

			});

		});


		$(function(){

			$('.nav_categorias').addClass('active');
			$('.menu_categorias').show();

			$('#tabela_linha').dataTable({
				"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ produtos por página"
				}
			});

			$('.label').css('cursor', 'pointer');
			$('.categorias').css('cursor', 'pointer');


		});

		function muda_status (id) {
			
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/categorias/status_categorias",
				data : { id : id }
			}).done(function( msg ) {

				if(msg == 'ativo'){

					$('.icone_' + id).removeClass('icon-play');
					$('.icone_' + id).addClass('icon-stop');
					$('.prod_sit_' + id).removeClass('label-success');
					$('.prod_sit_' + id).addClass('label-important');

				}

				else if (msg == 'desativado'){

					$('.icone_' + id).removeClass('icon-stop');
					$('.icone_' + id).addClass('icon-play');
					$('.prod_sit_' + id).removeClass('label-important');
					$('.prod_sit_' + id).addClass('label-success');

				}

			});
		}


		function muda_destaque (id) {

			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/categorias/status_destaque",
				data : { id : id }
			}).done(function(msg) {

				if (msg == 'ativo') {

					$('.cat_des_' + id).addClass('label-warning');
					$('.cat_des_' + id).removeClass('label-inverse');
				}

	 			else if (msg == 'desativado') {

					$('.cat_des_' + id).addClass('label-inverse');
					$('.cat_des_' + id).removeClass('label-warning');

				}

			});
			
		}


		setTimeout(function() {
			$('.sumir').fadeOut('slow');
		}, 4000);		

	</script>