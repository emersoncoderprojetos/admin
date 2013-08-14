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

				$display        = 'style="display:none;"';
				$display_tabela = 'style="display:block;"';

				if ($msg == 'excluido_sucesso') {

					echo '<div class="alert alert-success">';
						echo '<p>Produto excluido com sucesso !</p>';
					echo '</div>';

				}

				else if ($msg == 'ok') {

					echo '<div class="alert alert-success">';
						echo '<p>Produto salvo com sucesso !</p>';
					echo '</div>';

				}				
				
				else if ($msg == 'erro') {

					echo '<div class="alert alert-error">';
						echo '<p>ERRO ao excluir produto - Contate o Suporte Técnico CLICSERVER - AGENCIA10CLIC !</p>';
					echo '</div>';					

				}

				else if ($msg == 'nao_validou') { 

					$display        = 'style="display:block;"';
					$display_tabela = 'style="display:none;"';

				} 

				else if ($msg == 'nao_validou_slug') {

					$display        = 'style="display:block;"';
					$display_tabela = 'style="display:none;"';					

					echo '<div class="alert alert-error sumir">';
						echo '<p>Digite um SLUG válido !</p>';
					echo '</div>';

				}					



			?>			

			<h3><a href="#" class="inserir_novo_produto">Cadastrar novo produto</a></h3>

			<div id="inserir_produtos" <?php echo $display;?>>

				<form action="<?php echo base_url();?>clicserver/produtos/inserir" method="post" enctype="multipart/form-data">

					<fieldset>

						<legend>DADOS DO PRODUTO</legend>

						<?php echo validation_errors(); ?>

						<label>Escolha a Categoria</label>
						<select name="id_categoria">
							<option value="" selected="selected">Selecione uma Categoria</option>

							<?php

								foreach($categorias as $cat):

									echo '<option value="' . $cat->id . '">' . $cat->str_nome . '</option>';

								endforeach;

							?>

						</select>

						<label>Escolha a Sub-Categoria</label>
						<select name="id_sub_categoria">
							<option value="">Escolha uma categoria</option>
						</select>

						<label for="str_nome">Nome</label>
						<input id="str_nome" type="text" placeholder="nome" class="input-xxlarge" name="str_nome" value="<?php echo set_value('str_nome'); ?>" />						

						<label for="str_slug">Slug (nome que vai aparecer na url ex: www.seusite.com.br/slug)</label>
						<input type="text" id="str_slug" placeholder="slug" class="input-xxlarge" name="str_slug" value="<?php echo set_value('str_slug'); ?>">						

						<label for="txt_descricao">Descrição</label>
						<textarea class="textarea" style="width:500px;height:100px;" name="txt_descricao"><?php echo set_value('txt_descricao'); ?></textarea>

						<br style="clear:both;" />

						<legend>Imagens do Produto</legend>
						
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


						<legend>SEO</legend>

						<label for="str_title">title</label>
						<input type="text" id="str_title" class="input-xxlarge" placeholder="title" value="<?php echo set_value('str_title'); ?>" name="str_title" >
					
						<label for="str_keywords">keywords</label>
						<input type="text" id="str_keywords" class="input-xxlarge" placeholder="keywords" value="<?php echo set_value('str_keywords'); ?>" name="str_keywords">

						<label for="str_description">description</label>
						<textarea id="str_description"  placeholder="description" style="width:500px;" name="str_description"><?php echo set_value('str_description'); ?></textarea>

						<legend>Status do Produto</legend>

						<label class="checkbox">
							<input type="checkbox" checked name="int_ativo" value="1"> Ativo
						</label>

						<label class="checkbox">
							<input type="checkbox" name="int_destaque" value="0"> Destaque
						</label>

						<input type="hidden" name="confirma_slug" id="confirma_slug"/>

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
			<!-- FIM # DIV DIREITA -->


			<!-- INICIO # TABELA -->

			<div id="tabela" <?php echo $display_tabela;?>>

				<table id="tabela_produtos" class="table table-hover table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>Categoria</th>
							<th>Sub-Categoria</th>
							<th>Ativo</th>
							<th>Destaque</th>
							<th>Ação</th>
						</tr>
					</thead>
					<tbody>

					<?php

						foreach($produtos as $pd):

							echo '<tr>';

								echo '<td>' . $pd->id . '</td>';

								echo '<td>' . $pd->str_nome . '</td>';

								echo '<td>' . $pd->str_categoria . '</td>';

								echo '<td>' . $pd->str_sub_categoria . '</td>';
								
									# ATIVO

									if ($pd->int_ativo == 1) {

										$int_ativo = '<span onclick="muda_ativo(' . $pd->id . ');" class="prod_sit_' . $pd->id . ' label label-important" id="ativ_' . $pd->id . '"><i class="icone_' . $pd->id . ' icon-stop link"> </i></span>';

									}

									elseif ($pd->int_ativo == 0) {

										$int_ativo = '<span onclick="muda_ativo(' . $pd->id . ');" class="prod_sit_' . $pd->id . ' label label-success" id="ativ_' . $pd->id . '"><i class="icone_' . $pd->id . ' icon-play link"></i></span>';

									}

								echo '<td>' . $int_ativo . '</td>';

									# DESTAQUE

									if ($pd->int_destaque == 1) {

										$int_destaque = '<span onclick="muda_destaque(' . $pd->id . ');" class="prod_dest_' . $pd->id . ' label label-warning" id="dest_' . $pd->id . '"><i class="icone_dest_' . $pd->id . '  icon-star link"> </i></span>';

									}

									elseif ($pd->int_destaque == 0) {

										$int_destaque = '<span onclick="muda_destaque(' . $pd->id . ');" class="prod_dest_' . $pd->id . ' label label-inverse" id="dest_' . $pd->id . '"><i class="icone_dest_' . $pd->id . ' icon-star link"></i></span>';

									}

								echo '<td>' . $int_destaque . '</td>';							

						 		echo '<td><a style="cursor:pointer;" onclick="return confirm(\'Editar produto: ' . $pd->str_nome . ' ?\')";" href="' . base_url() . 'clicserver/produtos/editar/' . $pd->id . '"><i class="icon-edit"></i></a> / <a style="cursor:pointer;" onclick="return confirm(\'Excluir produto: ' . $pd->str_nome . ' ?\')";" href="' . base_url() . 'clicserver/produtos/excluir/' . $pd->id . '"><i class="icon-trash"></i></a></td>';

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

		$('.inserir_novo_produto').click(function(){
			$('#inserir_produtos').toggle('slow');
			$('#tabela').toggle();
		});

		function resetaCombo( el ) {

		   $("select[name='" + el + "']").empty();

		   var option = document.createElement('option');                                 
		   $( option ).attr( {value : ''} );
		   $( option ).append( 'Escolha uma categoria' );
		   $("select[name='" + el + "']").append( option );

		}

		$(function(){

			$('.textarea').wysihtml5({
				"font-styles" : true,
				"color"       : false,
				"image"       : false,
				"link"        : false,
				locale        : "pt-BR"
			});			

		   $("select[name=id_categoria]").change(function(){
		 
		        id_categoria = $(this).val();
		         
		        if ( id_categoria === '')
		            return false;
		         
		        resetaCombo('id_sub_categoria');
		             
		        $.getJSON( site_url + 'clicserver/produtos/get_sub_cat/' + id_categoria, function (data){
		 
		            var option = new Array();
		 
		            $.each(data, function(i, obj){
		 
		                option[i] = document.createElement('option');
		                $( option[i] ).attr( {value : obj.id} );
		                $( option[i] ).append( obj.str_nome );
		 
		                $("select[name='id_sub_categoria']").append( option[i] );
		         
		            });
		     
		        });
		     
		    });			

			$('.label').css('cursor', 'pointer');
			$('.nav_produtos').addClass('active');
			$('.menu_produtos').show();



			$('#tabela_produtos').dataTable( {
				"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ produtos por página"
				},
				"aaSorting": [[ 0, "desc" ]],
				"aoColumns": [
					null,
					null,
					null,
					null,
					null,
					null,
					null
				]
			});


			$('.fileupload0').fileupload({
				uploadtype : 'image',
				name       : 'imagem0'
			});

			setTimeout(function() {
				$('.alert').fadeOut('slow');
			}, 4000);
			
		});

		function muda_ativo (id) {

			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/produtos/status",
				data : { id : id }
			}).done(function(msg) {

				if (msg == 'ativo') {

					$('.icone_' + id).removeClass('icon-play');
					$('.icone_' + id).addClass('icon-stop');
					$('.prod_sit_' + id).removeClass('label-success');
					$('.prod_sit_' + id).addClass('label-important');

				}

				else if (msg == 'desativado') {

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
				url  : "<?php echo base_url();?>clicserver/produtos/destaque",
				data : { id : id }
			}).done(function(msg) {

				if (msg == 'ativo') {

					$('.prod_dest_' + id).addClass('label-warning');
					$('.prod_dest_' + id).removeClass('label-inverse');
				}

				else if (msg == 'desativado') {

					$('.prod_dest_' + id).addClass('label-inverse');
					$('.prod_dest_' + id).removeClass('label-warning');
				}

			});

		}

		/* CONSULTA SLUG */
		$('#str_nome').blur(function(){

			slug_nome   = $('#str_nome').val();

			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/produtos/existe_slug",
				data : { slug : slug_nome }
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
				url  : "<?php echo base_url();?>clicserver/produtos/existe_slug",
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

		});

	</script>