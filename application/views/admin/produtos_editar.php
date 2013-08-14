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

				$display_produto         = 'display:block;';
				$display_arquivos        = 'display:none;';
				$display_tabela          = 'display:none;';
				$display_inserir_arquivo = 'display:none;';

				if ($msg == 'nao_validou_slug') {

					echo '<div class="alert alert-error sumir">';
						echo '<p>Digite um SLUG válido !</p>';
					echo '</div>';

				}				

			?>

			<h3><a href="#" class="editar_produto">Edição de Produto</a></h3>

			<div id="produtos" style="<?php echo $display_produto;?>">

				<h4><?php echo $produtos[0]->str_nome;?></h4>

				<form action="<?php echo base_url();?>clicserver/produtos/gravar" method="post" enctype="multipart/form-data">

					<fieldset>

						<legend>DADOS DO PRODUTO</legend>

						<input type="hidden" value="<?php echo $produtos[0]->id;?>" name="id" />

						<input type="hidden" value="" name="confirma_slug" id="confirma_slug"/>

						<?php echo validation_errors(); ?>

						<label>Escolha a Categoria</label>
						<select name="id_categoria">

							<option value="">Selecione uma Categoria</option>

							<?php

								foreach($categorias as $cat):

									if ($cat->id == $produtos[0]->id_categoria)
										echo '<option value="' . $cat->id . '" selected="selected">' . $cat->str_nome . '</option>';		
									else
										echo '<option value="' . $cat->id . '">' . $cat->str_nome . '</option>';

								endforeach;

							?>

						</select>

						<label>Escolha a Sub-Categoria</label>
						<select name="id_sub_categoria">
							<option value="">Escolha uma categoria</option>
						</select>

						<label for="str_nome">Nome</label>
						<input id="str_nome" type="text" placeholder="nome" class="input-xxlarge" name="str_nome" value="<?php echo $produtos[0]->str_nome; ?>" />

						<label for="str_slug">Slug (nome que vai aparecer na url ex: www.seusite.com.br/slug)</label>
						<input type="text" placeholder="slug" class="input-xxlarge" id="str_slug" name="str_slug" value="<?php echo $produtos[0]->str_slug;?>">						

						<label for="txt_descricao">Descrição</label>
						<textarea class="textarea" style="width:500px;height:100px;" name="txt_descricao"><?php echo $produtos[0]->txt_descricao; ?></textarea>

						<br style="clear:both;" />

						<legend>Imagens do Produto</legend>

							<?php

								foreach($imagem as $img):

									echo '<div style="float:left;margin:5px;text-align:center;">';

										echo '<img src="'.base_url().'produtos_imagem/thumb/'.$img->str_imagem.'" class="img-polaroid" style="width:150px;height:100px;">';
										echo '<p><a onclick="return confirm(\'Excluir a imagem do produto ?\');" href="' . base_url() . 'clicserver/produtos/excluir_imagem/' . $img->id . '"><i class="icon-remove"></i></a></p>';

									echo '</div>';


							  	endforeach;

							  	$sobra = $total_imagem;

							  	if($total_imagem < 1 ){

							  		for($i = 0; $i <= $sobra; $i++): ?>

										<div style="float:left;" class="fileupload<?php echo $i;?> fileupload-new" data-provides="fileupload">
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
							<?php
							  		endfor;

							  	}
							
							?>

						<legend>SEO</legend>

						<label for="str_title">title</label>
						<input type="text" id="str_title" class="input-xxlarge" placeholder="title" value="<?php echo $produtos[0]->str_title;?>" name="str_title" >
					
						<label for="str_keywords">keywords</label>
						<input type="text" id="str_keywords" class="input-xxlarge" placeholder="keywords" value="<?php echo $produtos[0]->str_keywords;?>" name="str_keywords">

						<label for="str_description">description</label>
						<textarea id="str_description"  placeholder="description" style="width:500px;" name="str_description"><?php echo $produtos[0]->str_description;?></textarea>

						<legend>Status do Produto</legend>

						<label class="checkbox">

							<?php 

								if($produtos[0]->int_ativo == 1)
									$x = 'checked';
								else
									$x = '';

								if ($produtos[0]->int_destaque == 1)
									$y = 'checked';
								else
									$y = '';

							?>

							<input type="checkbox" name="int_ativo" value="1" <?php echo $x;?>> Ativo

						</label>

						<label class="checkbox">
							<input type="checkbox" name="int_destaque" value="1" <?php echo $y;?>> Destaque
						</label>

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
		<!-- FIM # DIV DIREITA -->

	</div>
	<!-- FIM # CONTEÚDO CENTRAL -->

	<script type="text/javascript">

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

			id_categoria     =  '<?php echo $produtos[0]->id_categoria;?>';
			id_sub_categoria =  '<?php echo $produtos[0]->id_sub_categoria;?>';

		    $.getJSON( site_url + 'clicserver/produtos/get_sub_cat/' + id_categoria, function (data){

		        var option = new Array();

		        $.each(data, function(i, obj){

		            option[i] = document.createElement('option');
		            $( option[i] ).attr( {value : obj.id} );
		            $( option[i] ).append( obj.str_nome );

		            if (obj.id == id_sub_categoria) {
		        		$( option[i] ).attr( {value : obj.id, selected:'selected'} ); 
		        	}

		            $("select[name='id_sub_categoria']").append( option[i] );
		     
		        });
		 
		    });

			$("select[name=id_categoria]").change(function(){

			    id_categoria = $(this).val();

			    if (id_categoria === '')
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
				$('.sumir').fadeOut('slow');
			}, 4000);

			valor_slug = $('#str_slug').val();			

			$('#tabela_produtos').dataTable( {
				"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ produtos por página"
				}
			});			

		});

		$('#str_codigo').blur(function(){

			slug_nome   = $('#str_nome').val();
			slug_codigo = $('#str_codigo').val();

			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>clicserver/produtos/slug",
				data : { slug : slug_nome + ' ' + slug_codigo }
			}).done(function( msg1 ) {

				if (msg1 == valor_slug) {

					
				} else {

					$('#str_slug').attr('value', msg1);
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

			}

		});		

	</script>