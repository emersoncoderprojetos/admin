<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

	<!-- INICIO # CONTEÚDO CENTRAL -->
	<div class="row-fluid">

		<!-- INICIO # MENU LATERAL ESQUERDO -->
		<?php $this->load->view('clicserver/elementos/menu', $dados_menu); ?>
		<!-- FIM # MENU LATERAL ESQUERDO -->

		<div class="span9">

			<?php

				$display        = 'display:none';
				$display_tabela = "display:block";

				if ($msg == 'erro') {

					$display        = 'display:block';
					$display_tabela = "display:none";					

					echo '<div class="alert alert-error">';
						echo '<button class="close" data-dismiss="alert" type="button">×</button>';
						echo '<strong>Erro !</strong>';
						echo ' Selecione uma imagem antes de clicar no botão.';
					echo '</div>';


				}
				
				else if ($msg == 'ok') {

					$display        = 'display:none';
					$display_tabela = "display:block";										

					echo '<div class="alert alert-success">';
						echo '<button class="close" data-dismiss="alert" type="button">×</button>';
						echo '<strong>Salvo com sucesso!</strong>';
					echo '</div>';

				}

				else if ($msg == 'excluido') {

					$display        = 'display:none';
					$display_tabela = "display:block";															

					echo '<div class="alert alert-success">';
						echo '<button class="close" data-dismiss="alert" type="button">×</button>';
						echo '<strong>Excluido com sucesso! </strong>';
					echo '</div>';

				}

			?>

			<h2 id="capas_home"><a href="#">Capas da Home</a></h2>

			<div style="<?php echo $display;?>" class="capas_home">

				<form action="<?php echo base_url();?>clicserver/capas_home/inserir" method="post" enctype="multipart/form-data">
					
					<fieldset>
						
						<legend>Nova Capa</legend>

						<label for="str_url">URL (página de destino)</label>
						<input class="input-xlarge" type="text" name="str_url" value="<?php echo set_value('str_nome');?>" id="str_url"/>
						 
						 <label class="checkbox" for="str_target">
							<input name="str_destino" type="radio" id="str_target" value="_parent"> _parent (Abre link mesma página)
						</label>

						<label class="checkbox" for="str_target1">
							<input name="str_destino" type="radio" id="str_target1" value="_blank"> _blank (Abre nova página)
						</label>

						<legend>Imagem da Capa</legend>

						<label>Imagem</label>
						<input type="file" name="userfile" />

						<legend>Status</legend>

						<label class="checkbox" for="int_ativo">
							<input type="checkbox" value="1" name="int_ativo" checked> Ativo
						</label>	    	

						<hr />			

						<div class="control-group">
							<!-- Button -->
							<div class="controls">

							<button class="btn btn-primary" type="submit"><i class="icon-save"></i> GRAVAR</button>
							<button class="btn btn-small" type="reset"><i class="icon-refresh"></i> LIMPAR</button> 

							</div>

						</div>

					</fieldset>

				</form>

			</div>

			<div style="<?php echo $display_tabela;?>" class="tabela">

				<!-- INICIO # TABELA DE DADOS -->
				<table id="tabela_academy" class="table table-hover table-striped table-bordered table-condensed">

					<thead>

						<tr>

							<th>ID</th>

							<th>URL</th>

							<th>Target</th>

							<th>Imagem</th>

							<th>Status</th>

							<th>Ação</th>

						</tr>

					</thead>

					<tbody>

						<?php

							foreach($capas as $cp):

								echo '<tr>';

									echo '<td>' . $cp->id . '</td>';

									echo '<td>' . $cp->str_url . '</td>';

									echo '<td>' . $cp->str_destino . '</td>';									

									echo '<td><img src="' . base_url() . 'capas_slider_home/thumb/' . $cp->str_imagem . '" /></td>';

									# ATIVO
									if ($cp->int_ativo == 1) {
										$status = '<span onclick="muda_status(' . $cp->id . ');" class="prod_sit_' . $cp->id . ' label label-important" id="ativ_' . $cp->id . '"><i class="icone_' . $cp->id . ' icon-stop link"> </i></span>';
									}
									elseif ($cp->int_ativo == 0) {
										$status = '<span onclick="muda_status(' . $cp->id . ');" class="prod_sit_' . $cp->id . ' label label-success" id="ativ_' . $cp->id . '"><i class="icone_' . $cp->id . ' icon-play link"></i></span>';
									}
									echo '<td>' . $status . '</td>';									

									echo '<td><a style="cursor:pointer;" onclick="return confirm(\'Editar: ' . $cp->id . ' ?\')";" href="' . base_url() . 'clicserver/capas_home/editar/' . $cp->id . '"><i class="icon-edit"></i></a> / <a style="cursor:pointer;" onclick="return confirm(\'Excluir capa : ' . $cp->id . ' ?\')";" href="' . base_url() . 'clicserver/capas_home/excluir/' . $cp->id . '"><i class="icon-trash"></i></a></td>';

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

		$(function(){

			$('.nav_capa_home').addClass('active');
			$('.menu_capa_home').show();

			$('#tabela_academy').dataTable( {
				"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ produtos por página"
				}
			});	

			setTimeout(function() {

				$('.alert').fadeOut('slow');

			}, 4000);

						$('.label').css('cursor', 'pointer');
			$('.categorias').css('cursor', 'pointer');

		});

		$('#capas_home').click(function(event){

			event.preventDefault();

			$('.capas_home').toggle('slow');

			$('.tabela').toggle('slow');

		});

		function muda_status (id) {
			
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/capas_home/status",
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

	</script>