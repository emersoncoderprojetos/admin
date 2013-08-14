<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

	<!-- INICIO # CONTEÚDO CENTRAL -->
	<div class="row-fluid">

		<!-- INICIO # MENU LATERAL ESQUERDO -->
		<?php $this->load->view('clicserver/elementos/menu', $dados_menu); ?>
		<!-- FIM # MENU LATERAL ESQUERDO -->

		<div class="span9">

			<h2 id="capas_home"><a href="#">Capas da Home</a></h2>

			<div class="capas_home">

				<form action="<?php echo base_url();?>clicserver/capas_home/gravar" method="post" enctype="multipart/form-data">
					
					<fieldset>

						<input type="hidden" value="<?php echo $capas[0]->id;?>" name="id" />
						
						<legend>Nova Capa</legend>

						<label for="str_url">URL (página de destino)</label>
						<input class="input-xlarge" type="text" name="str_url" value="<?php echo $capas[0]->str_url;?>" id="str_url"/>
						 
						 	<?php

						 		

						 		if($capas[0]->str_destino == '_blank')
						 			$x = 'checked="checked"';
						 		else 
						 			$x = '';

						 		if($capas[0]->str_destino == '_parent')
						 			$y = 'checked="checked"';
						 		else 
						 			$y = '';					 		

						 	?>

						 <label class="checkbox" id="str_target1">

							<input name="str_destino" type="radio" id="str_target1" value="_parent" <?php echo $y;?>> _parent (Abre link mesma página)

						</label>

						<label class="checkbox" id="str_target">

							<input name="str_destino" type="radio" id="str_target" value="_blank" <?php echo $x;?>> _blank (Abre nova página)

						</label>						

						<legend>Imagens</legend>

						<?php

							if ($capas[0]->str_imagem) {

									echo '<div style="float:left;margin:5px;text-align:center;">';
										echo '<img src="' . base_url() . 'capas_slider_home/thumb/' . $capas[0]->str_imagem . '" class="img-polaroid" style="width:150px;height:100px;">';
										echo '<p><a onclick="return confirm(\'Excluir imagem ?\');" href="' . base_url() . 'clicserver/capas_home/excluir_imagem/' . $capas[0]->id . '"><i class="icon-remove"></i></a></p>';
									echo '</div>';

							} else {

								echo '<label>Imagem</label>';
								echo '<input type="file" name="userfile" />';
								echo br(3);

							}

						?>

						<legend>Status</legend>

						<?php

							if($capas[0]->int_ativo == 1)
								$x = 'checked';
							else
								$x = '';

						?>

						<label class="checkbox" for="int_ativo">
							<input type="checkbox" value="1" name="int_ativo" <?php echo $x;?>> Ativo
						</label>						
						
						<br style="clear:both;" />

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

			$('.fileupload').fileupload({
				uploadtype : 'file',
				name       : 'str_imagem'
			});			

		});

		$('#capas_home').click(function(event){
			event.preventDefault();
			$('.capas_home').toggle('slow');
			$('.tabela').toggle('slow');


		})


	</script>