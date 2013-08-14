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

				if ($msg == 'nao_validou_slug') {

					echo '<div class="alert alert-error sumir">';

						echo '<p>Digite um SLUG válido !</p>';

					echo '</div>';

				}				

			?>			

			<h3><a href="#">Editar Menu</a></h3>

			<!-- INICIO # FORMULÁRIO -->
			<form action="<?php echo base_url();?>admin/menus/gravar_menu" method="post">

				<fieldset>

					<legend>Edição de Menu</legend>

					<?php echo validation_errors(); ?>

					<input type="hidden" value="<?php echo $menu[0]->id;?>" name="id"/>

					<label for="str_nome">Menu</label>
					<input type="text" id="str_nome" placeholder="menu" class="input-xxlarge" name="str_nome" value="<?php echo $menu[0]->str_nome;?>">

					<label for="str_slug">Slug (nome que vai aparecer na url ex: www.seusite.com.br/slug)</label>
					<input type="text" placeholder="slug" class="input-xxlarge" id="str_slug" name="str_slug" value="<?php echo $menu[0]->str_slug;?>">						

					<legend>Status</legend>		

				    <label class="checkbox" for="int_ativo">

				    	<?php

				    		if ($menu[0]->int_ativo == 1)
				    			$x = 'checked';
				    		else if ($menu[0]->int_ativo == 0)
				    			$x = '';

				    	?>

				    	<input type="checkbox" name="int_ativo" value="1" <?php echo $x;?>> Ativo

				    </label>

				    <input type="hidden" value="" id="slug_atual" name="slug_atual" />
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

			$('.nav_menus').addClass('active');
			$('.menu_menus').show();
			$('.label').css('cursor', 'pointer');
			$('.topo_site').addClass('active');
			$('.menus_1').css('background-color', '#DBDBDB');	

			valor_slug = $('#str_slug').val();

		});

		
		setTimeout(function() {

			$('.sumir').fadeOut('slow');

		}, 4000);


		/* CONSULTA SLUG */
		$('#str_nome').blur(function(){

			slug = $('#str_nome').val();

			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>admin/menus/dados_slug",
				data : { slug : slug }
			}).done(function( msg ) {

				if (msg == valor_slug) {

					//alert('mesmo slug');

					/*

						1 = são os mesmos, esta ok

					*/
					$('#confirma_slug').attr('value', 0);

				} else if (msg != valor_slug) {

					/*

						msg = e-mail 

					*/
					alert('já existe esse slug');

					//$('#str_slug').attr('value', msg);

					/*

						2 = não pode cadastrar porque já existe

					*/					
					$('#confirma_slug').attr('value', 1);

				} else {

					$('#str_slug').attr('value', msg);

					$('#confirma_slug').attr('value', 0);					

				}
				
			});

		});

		

		// $('#str_slug').blur(function(){

		// 	valor = $('#str_slug').val();

		// 	$.ajax({

		// 		type : "POST",
		// 		url  : "<?php echo base_url();?>admin/menus/existe_slug",
		// 		data : { slug : valor }

		// 	}).done(function( msg1 ) {

		// 		if (msg1 == 'sim') {

		// 			alert('já existe SLUG com esse nome, digite um diferente !');

		// 			/*

		// 				1 = existe slug, não pode cadastar

		// 			*/

		// 			$('#confirma_slug').attr('value', 1);

		// 		} else {

		// 			/*

		// 				msg1 = e-mail 

		// 			*/
		// 			$('#str_slug').attr('value', msg1);

		// 			/*

		// 				2 = ok, pode cadastar

		// 			*/					
		// 			$('#confirma_slug').attr('value', 0);

		// 		}

		// 	});

		//});

	</script>