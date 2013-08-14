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

				$display = 'style="display:none;"';

				if($msg == 'excluido_sucesso'){
					echo '<div class="alert alert-success">';
						echo '<p>Parceiro excluido com sucesso !</p>';
					echo '</div>';
				}

				if($msg == 'ok'){
					echo '<div class="alert alert-success">';
						echo '<p>Parceiro salvo com sucesso !</p>';
					echo '</div>';
				}				
				
				else if ($msg == 'erro'){
					echo '<div class="alert alert-error">';
						echo '<p>ERRO ao salvar parceiro - Contate o Suporte Técnico CLICSERVER - AGENCIA10CLI !</p>';
					echo '</div>';					
				}

				else if ($msg == 'nao_validou') { 

					$display = 'style="display:block;"';

				} 				

			?>

			<h3><a href="#" class="inserir_novo_parceiro">Cadastrar novo parceiro</a></h3>

			<div id="parceiros" <?php echo $display;?>>

				<form action="<?php echo base_url();?>clicserver/parceiros/inserir" method="post" enctype="multipart/form-data">

					<fieldset>

						<legend>Cadastro de Parceiros</legend>

						<?php echo validation_errors(); ?>

						<label for="str_nome">Nome</label>
						<input id="str_nome" type="text" placeholder="nome" class="input-xxlarge" name="str_nome" value="<?php echo set_value('str_nome'); ?>" />

						<label for="str_url">URL</label>
						<input id="str_url" type="text" placeholder="URL" class="input-xxlarge" name="str_url" value="<?php echo set_value('str_url'); ?>" />						

						<label for="txt_descricao">Descrição</label>
						<textarea style="width:500px;height:100px;" name="txt_descricao"><?php echo set_value('txt_descricao'); ?></textarea>

						<br style="clear:both;" />

						<legend>Imagens do Parceiro</legend>
						
						<div style="float:left;" class="fileupload0 fileupload-new" data-provides="fileupload">
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

						<legend>Status do Parceiro</legend>

						<label class="checkbox">
							<input type="checkbox" checked name="int_ativo" value="1"> Ativo
						</label>

						<br />

						<button type="submit" class="btn btn-primary">CADASTRAR PARCEIRO</button>
					
					</fieldset>
				
				</form>	

			</div>



			<!-- INICIO # TABELA -->
			<div id="table">
				<table id="tabela_produtos" class="table table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>URL</th>
							<th>Descrição</th>
							<th>Ativo</th>
							<th>Ação</th>
						</tr>
					</thead>
					<tbody>

					<?php

						foreach($parceiros as $pc):

							echo '<tr>';

								echo '<td><span class="badge">' . $pc->id . '</span></td>';
								echo '<td>' . $pc->str_nome . '</td>';
								echo '<td>' . $pc->str_url . '</td>';
								echo '<td>' . word_limiter($pc->txt_descricao, '4') . '</td>';

									# ATIVO

									if ($pc->int_ativo == 1) {

										$int_ativo = '<span onclick="muda_ativo(' . $pc->id . ');" class="prod_sit_' . $pc->id . ' label label-important" id="ativ_' . $pc->id . '"><i class="icone_' . $pc->id . ' icon-stop link"> </i></span>';

									}

									elseif ($pc->int_ativo == 0) {

										$int_ativo = '<span onclick="muda_ativo(' . $pc->id . ');" class="prod_sit_' . $pc->id . ' label label-success" id="ativ_' . $pc->id . '"><i class="icone_' . $pc->id . ' icon-play link"></i></span>';

									}

								echo '<td>' . $int_ativo . '</td>';

						 		echo '<td><a style="cursor:pointer;" onclick="return confirm(\'Editar parceiro: ' . $pc->str_nome . ' ?\')";" href="' . base_url() . 'clicserver/parceiros/editar/' . $pc->id . '"><i class="icon-edit"></i></a> / <a style="cursor:pointer;" onclick="return confirm(\'Excluir parceiro: ' . $pc->str_nome . ' ?\')";" href="' . base_url() . 'clicserver/parceiros/excluir/' . $pc->id . '"><i class="icon-trash"></i></a></td>';

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

		$('.inserir_novo_parceiro').click(function(){
			$('#parceiros').toggle('slow');
			$('#table').toggle();
		})	

		$(function(){

			$('.label').css('cursor', 'pointer');

			$('.nav_parceiros').addClass('active');

			$('.menu_parceiros').show();

			$('#tabela_produtos').dataTable( {
				"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ produtos por página"
				}
			});
			$('.fileupload0').fileupload({
				uploadtype : 'file',
				name       : 'imagem0'
			});
			$('.fileupload1').fileupload({
				uploadtype : 'file',
				name       : 'imagem1'
			});
			$('.fileupload2').fileupload({
				uploadtype : 'file',
				name       : 'imagem2'
			});
			$('.fileupload3').fileupload({
				uploadtype : 'file',
				name       : 'imagem3'
			});
			setTimeout(function() {
				$('.alert').fadeOut('slow');
			}, 4000);
		});

		function muda_ativo (id) {
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/parceiros/ativos_parceiros",
				data : { id : id }
			}).done(function(msg) {
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