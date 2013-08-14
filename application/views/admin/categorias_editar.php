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

				if ($msg == 'nao_validou_slug'){
					echo '<div class="alert alert-error sumir">';
						echo '<p>Digite um SLUG válido !</p>';
					echo '</div>';
				}				

			?>			

			<h3><a href="#">Editar Categorias</a></h3>

			<!-- INICIO # FORMULÁRIO -->
			<form action="<?php echo base_url();?>clicserver/categorias/gravar" method="post" enctype="multipart/form-data">

				<fieldset>

					<legend>Edição de Categorias</legend>

					<?php echo validation_errors(); ?>

					<input type="hidden" value="<?php echo $categorias[0]->id;?>" name="id"/>

					<label for="str_nome">Categorias</label>
					<input type="text" id="str_nome" placeholder="categorias" class="input-xxlarge" name="str_nome" value="<?php echo $categorias[0]->str_nome;?>">

					<label for="str_slug">Slug (nome que vai aparecer na url ex: www.seusite.com.br/slug)</label>
					<input type="text" placeholder="slug" class="input-xxlarge" id="str_slug" name="str_slug" value="<?php echo $categorias[0]->str_slug;?>">						

					<legend>SEO</legend>

					<label for="str_title">title</label>
					<input type="text" id="str_title" class="input-xxlarge" placeholder="title" value="<?php echo $categorias[0]->str_title; ?>" name="str_title" >
				
					<label for="str_keywords">keywords</label>
					<input type="text" id="str_keywords" class="input-xxlarge" placeholder="keywords" value="<?php echo $categorias[0]->str_keywords; ?>" name="str_keywords">

					<label for="str_description">description</label>
					<textarea id="str_description"  placeholder="description" style="width:500px;" name="str_description"><?php echo $categorias[0]->str_description; ?></textarea>

					<legend>Status da Categoria</legend>		

				    <label class="checkbox" for="int_ativo">

				    	<?php

				    		if ($categorias[0]->int_ativo == 1)
				    			$x = 'checked';
				    		else if ($categorias[0]->int_ativo == 0)
				    			$x = '';

				    	?>

				    	<input type="checkbox" name="int_ativo" value="1" <?php echo $x;?>> Ativo

				    </label>

				    <label class="checkbox" for="int_destaque">

				    	<?php

				    		if ($categorias[0]->int_destaque == 1)
				    			$x = 'checked';
				    		else if ($categorias[0]->int_destaque == 0)
				    			$x = '';

				    	?>

				    	<input type="checkbox" name="int_destaque" value="1" <?php echo $x;?>> Destaque

				    </label>

    				<input type="hidden" value="" id="confirma_slug" name="confirma_slug" />					    					    				

					<br />

					<button class="btn btn-info btn-small" onclick="javascript:history.back();"><i class="icon-arrow-left"></i> VOLTAR</button>
					<button class="btn btn-primary" type="submit"><i class="icon-save"></i> GRAVAR</button>
					<button class="btn btn-small" type="reset"><i class="icon-refresh"></i> LIMPAR</button> 

				</fieldset>

			</form>
			<!-- FIM # FORMULÁRIO -->

		</div>

	</div>
	<!-- FIM # CONTEÚDO CENTRAL -->

	<script type="text/javascript">

		$(function(){

			$('.nav_categorias').addClass('active');

			$('.menu_categorias').show();

			$('.fileupload').fileupload({
				uploadtype : 'file',
				name       : 'imagem'
			});				

			valor_slug = $('#str_slug').val();

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

			if (valor == valor_slug) {

			} else {

				$.ajax({
					type : "POST",
					url  : "<?php echo base_url();?>clicserver/categorias/existe_slug",
					data : { slug : valor }
				}).done(function( msg1 ) {

					if (msg1 == ' sim') {

						alert('já existe SLUG com esse nome, digite um diferente !');
						$('#confirma_slug').attr('value', 1);

					} else {

						$('#str_slug').attr('value', msg1);
						$('#confirma_slug').attr('value', 0);

					}

				});

			}

		});

	</script>