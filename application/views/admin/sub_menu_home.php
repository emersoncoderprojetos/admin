<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

	<!-- INICIO # CONTEÚDO CENTRAL -->
	<div class="row-fluid">

		<!-- INICIO # MENU LATERAL ESQUERDO -->
		<?php $this->load->view('admin/elementos/menu_site', $dados_menu); ?>
		<!-- FIM # MENU LATERAL ESQUERDO -->

		<div class="span9">

			<?php

				# MENSAGENS DE ALERTA #

				$display        = 'display:none;';
				$display_tabela = 'display:block;';

				if ($msg == 'ok') {

					echo '<div class="alert alert-success sumir">';

						echo '<p>sub-menu salvo com sucesso !</p>';

					echo '</div>';

				}
				
				else if ($msg == 'erro') {

					echo '<div class="alert alert-error sumir">';

						echo '<p>ERRO ao gravar sub-menu - Contate o Suporte Técnico!</p>';

					echo '</div>';

				}

				else if ($msg == 'excluido') {

					echo '<div class="alert alert-error sumir">';

						echo '<p>sub-menu excluido com sucesso !</p>';

					echo '</div>';					

				}

				else if ($msg == 'nao_validou_slug') {

					echo '<div class="alert alert-error sumir">';

						echo '<p>Digite um SLUG válido !</p>';

					echo '</div>';

					$display        = 'display:block;';
					$display_tabela = 'display:none;';

				}				

				else if ($msg == 'nao_validou') {

					$display        = 'display:block;';
					$display_tabela = 'display:none;';

				}

			?>

			<h3 class="sub_categorias"><a href="#">Novo Sub-Menu</a></h3>

			<div id="sub_categorias" style="<?php echo $display;?>">

				<!-- INICIO # FORMULÁRIO -->
				<form action="<?php echo base_url();?>admin/menus/inserir_submenu" method="post">

					<fieldset>

						<legend>Cadastro de Sub-Menu</legend>

						<?php echo validation_errors(); ?>

						<label for="id_menu">Escolha o Menu</label>
						<select name="id_menu">
							<option value="" selected="selected">Selecione o Menu</option>

							<?php 

								foreach($menu as $mn):

									echo '<option value="' . $mn->id . '">' . $mn->str_nome . '</option>';

								endforeach;

							?>
						</select>

						<label for="str_nome">Sub-Menu</label>
						<input type="text" id="str_nome" placeholder="categoria" class="input-xxlarge" name="str_nome" value="<?php echo set_value('str_nome'); ?>">

						<label for="str_slug">Slug (nome que vai aparecer na url ex: www.seusite.com.br/slug)</label>
						<input type="text" id="str_slug" placeholder="slug" class="input-xxlarge" name="str_slug" value="<?php echo set_value('str_slug'); ?>">						

						<legend>Status</legend>

						<label class="checkbox" for="int_ativo">
	      					<input type="checkbox" value="1" name="int_ativo" checked> Ativo
	    				</label>

	    				<input type="hidden" value="" id="confirma_slug" name="confirma_slug" />

	    				<hr />

						<div class="control-group">
							<!-- Button -->
							<div class="controls">

								<button class="btn btn-info btn-small" type="button" onclick="javascript:history.go(-2);"><i class="icon-arrow-left"></i> VOLTAR</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> ADICIONAR</button>
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

					<caption>Sub-Menu</caption>

					<thead>

						<tr>

							<th>ID</th>

							<th>Menu</th>

							<th>Sub-Menu</th>

							<th>URL</th>

							<th>Ativo</th>

							<th>Ação</th>

						</tr>

					</thead>

					<tbody>

						<?php

							foreach($submenu as $sm):

								echo '<tr>';

									echo '<td><span class="badge">' . $sm->id . '</span></td>';

									echo '<td>' . $sm->str_menu . '</td>';

									echo '<td>' . $sm->str_nome . '</td>';

									echo '<td>' . base_url() . $sm->str_menu_slug . '/' . $sm->str_slug . '</td>';

									# ATIVO
									if ($sm->int_ativo == 1) {
										$status = '<span onclick="muda_status(' . $sm->id . ');" class="prod_sit_' . $sm->id . ' label label-important" id="ativ_' . $sm->id . '"><i class="icone_' . $sm->id . ' icon-stop link"> </i></span>';
									}
									elseif ($sm->int_ativo == 0) {
										$status = '<span onclick="muda_status(' . $sm->id . ');" class="prod_sit_' . $sm->id . ' label label-success" id="ativ_' . $sm->id . '"><i class="icone_' . $sm->id . ' icon-play link"></i></span>';
									}
									echo '<td>' . $status . '</td>';

									echo '<td><a style="cursor:pointer;" onclick="return confirm(\'Editar sub-menu: ' . $sm->str_nome . ' ?\')";" href="' . base_url() . 'admin/menus/editar_submenu/' . $sm->id . '"><i class="icon-edit"></i></a> / <a style="cursor:pointer;" onclick="return confirm(\'Excluir sub-menu: ' . $sm->str_nome . ' ?\')";" href="' . base_url() . 'admin/menus/excluir_submenu/' . $sm->id . '"><i class="icon-trash"></i></a></td>';

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
		$('.sub_categorias').click(function(){

			$('#sub_categorias').toggle('slow');
			$('#tabela').toggle('slow');

		});

		/* CONSULTA SLUG */
		$('#str_nome').blur(function(){

			slug = $('#str_nome').val();

			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>admin/menus/cria_slug",
				data : { slug : slug }
			}).done(function( msg ) {

				$('#str_slug').attr('value', msg);

				$('#confirma_slug').attr('value', 0);
				
			});

		});

		$(function(){

			$('.nav_menus').addClass('active');
			$('.menu_menus').show();
			$('.label').css('cursor', 'pointer');
			$('.topo_site').addClass('active');
			$('.menus_2').css('background-color', '#DBDBDB');

			$('#tabela_linha').dataTable({
				"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ produtos por página"
				}
			});


		});

		function muda_status (id) {
			
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/sub_categorias/status",
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
				url  : "<?php echo base_url();?>clicserver/sub_categorias/destaque",
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