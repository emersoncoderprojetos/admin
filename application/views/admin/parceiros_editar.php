<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

	<!-- INICIO # CONTEÚDO CENTRAL -->
	<div class="row-fluid">

		<!-- INICIO # MENU LATERAL ESQUERDO -->
		<?php $this->load->view('clicserver/elementos/menu', $dados_menu); ?>
		<!-- FIM # MENU LATERAL ESQUERDO -->

		<script type="text/javascript" src="<?php echo base_url();?>assets_clicserver/upload/bootstrap-fileupload.js" /></script>
		<link rel="stylesheet" href="<?php echo base_url();?>assets_clicserver/upload/bootstrap-fileupload.css" />

		<!-- INICIO # DIV DIREITA -->
		<div class="span9">

			<?php

				/**
				* carrega label com mensagens de alertas.
				*
				*/

				//echo $msg;

				$display_inserir = 'style="display:none;"';

				if($msg == 'ok'){
					echo '<div class="alert alert-success">';
						echo '<p>Parceiro salvo com sucesso !</p>';
					echo '</div>';
				}
				
				else if ($msg == 'erro'){
					echo '<div class="alert alert-error">';
						echo '<p>ERRO ao produto categoria - Contate o Suporte Técnico CLICSERVER - AGENCIA10CLI !</p>';
					echo '</div>';					
				}

				else if ($msg == 'nao_validou') { 

					$display_inserir = 'style="display:block;"';

				}

			?>			

			<h3><a href="#" class="inserir_novo_produto">Edição de Parceiros</a></h3>
			<h4><?php echo $parceiros[0]->str_nome;?></h4>

			<form action="<?php echo base_url();?>clicserver/parceiros/gravar" method="post" enctype="multipart/form-data">

				<fieldset>

					<legend>DADOS DO PARCEIRO</legend>

					<input type="hidden" value="<?php echo $parceiros[0]->id;?>" name="id" />

					<?php echo validation_errors(); ?>

					<label for="str_nome">Nome</label>
					<input id="str_nome" type="text" placeholder="nome" class="input-xxlarge" name="str_nome" value="<?php echo $parceiros[0]->str_nome; ?>" />

					<label for="str_url">URL</label>
					<input id="str_url" type="text" placeholder="nome" class="input-xxlarge" name="str_url" value="<?php echo $parceiros[0]->str_url; ?>" />					

					<label for="txt_descricao">Descrição</label>
					<textarea style="width:500px;height:100px;" name="txt_descricao"><?php echo $parceiros[0]->txt_descricao; ?></textarea>

					<br style="clear:both;" />

					<legend>Imagens do Parceiro</legend>

					<?php

						if($parceiros[0]->str_imagem){

								echo '<div style="float:left;margin:5px;text-align:center;">';

									echo '<img src="'.base_url().'parceiros_imagem/thumb/'.$parceiros[0]->str_imagem.'" class="img-polaroid" style="width:150px;height:100px;">';
									echo '<p><a onclick="return confirm(\'Excluir a imagem do produto ?\');" href="' . base_url() . 'clicserver/parceiros/excluir_imagem/' . $parceiros[0]->id . '"><i class="icon-remove"></i></a></p>';

								echo '</div>';

						} else {

							echo '<div style="float:left;" class="fileupload0 fileupload-new" data-provides="fileupload">';
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

					<legend>Status do Parceiro</legend>

					<label class="checkbox">

						<?php 

							if($parceiros[0]->int_ativo == 1){
								$x = 'checked';
							} else {
								$x = '';
							}
				

						?>


						<input type="checkbox" name="int_ativo" value="1" <?php echo $x;?>> Ativo

					</label>

					<br />

					<button type="submit" class="btn btn-primary">GRAVAR PARCEIRO</button>
				
				</fieldset>
			
			</form>	



		</div>
		<!-- FIM # DIV DIREITA -->

	</div>
	<!-- FIM # CONTEÚDO CENTRAL -->

	<script type="text/javascript">

		$(function(){

			$('.label').css('cursor', 'pointer');

			$('.nav_parceiros').addClass('active');

			$('.menu_parceiros').show();


			$('.fileupload0').fileupload({
				uploadtype : 'file',
				name       : 'imagem0'
			});

			setTimeout(function() {
				$('.alert').fadeOut('slow');
			}, 4000);
		});

	</script>