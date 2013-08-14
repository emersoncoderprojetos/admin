<!-- INICIO # CONTEÚDO -->
<div class="container-fluid">

	<!-- INICIO # CONTEÚDO CENTRAL -->
	<div class="row-fluid">

		<!-- INICIO # MENU LATERAL ESQUERDO -->
		<?php $this->load->view('admin/elementos/menu_inicio', $dados_menu); ?>
		<!-- FIM # MENU LATERAL ESQUERDO -->

		<div class="span9">

			<?php

				# MENSAGENS DE ALERTA #

				$display        = 'display:none;';
				$display_tabela = 'display:block;';

				if($msg == 'ok'){

					echo '<div class="alert alert-success sumir">';
						echo '<p>Usuario salvo com sucesso !</p>';
					echo '</div>';
				}
				
				else if ($msg == 'erro'){
					echo '<div class="alert alert-error sumir">';
						echo '<p>ERRO ao gravar usuário - Contate o Suporte Técnico admin - AGENCIA10CLIC !</p>';
					echo '</div>';					
				}

				else if ($msg == 'excluido'){
					echo '<div class="alert alert-error sumir">';
						echo '<p>Usuário excluido com sucesso !</p>';
					echo '</div>';					
				}

				else if ($msg == 'existe_usuario'){
					echo '<div class="alert alert-error sumir">';
						echo '<p>Já existe esse usuário, digite outro !</p>';
					echo '</div>';					
					$display        = 'display:block;';
					$display_tabela = 'display:none;';					
				}

				else if ($msg == 'existe_email'){
					echo '<div class="alert alert-error sumir">';
						echo '<p>Já existe esse e-mail, digite outro !</p>';
					echo '</div>';
					$display        = 'display:block;';
					$display_tabela = 'display:none;';									
				} 

				else if ($msg == 'nao_validou') {

					$display        = 'display:block;';
					$display_tabela = 'display:none;';					

				}


			?>

			<h3 class="usuarios"><a href="#">Novo Usuário</a></h3>

			<div id="usuarios" style="<?php echo $display;?>">

				<form action="<?php echo base_url();?>admin/usuarios/inserir" method="post" enctype="multipart/form-data">

  					<fieldset>

  						<legend class="">Adicionar Novo Usuário</legend>

  						<?php echo validation_errors(); ?>

						<div class="control-group">
							<label class="control-label" for="str_nome">Nome</label>
							<div class="controls">
								<input type="text" id="str_nome" name="str_nome" placeholder="nome" class="input-xlarge" value="<?php echo set_value('str_nome'); ?>">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="str_usuario">Usuário</label>
							<div class="controls">
								<input type="text" id="str_usuario" name="str_usuario" placeholder="usuário" class="input-xlarge"  value="<?php echo set_value('str_usuario'); ?>">
							</div>
						</div>						

						<div class="control-group">
							<!-- E-mail -->
							<label class="control-label" for="str_email">E-mail</label>

							<div class="controls">
								<input type="text" id="str_email" name="str_email" placeholder="e-mail" class="input-xlarge"  value="<?php echo set_value('str_email'); ?>">
							</div>

						</div>

						<div class="control-group">
							<!-- Password-->
							<label class="control-label" for="password">Senha</label>
							<div class="controls">
								<input type="password" id="str_password" name="str_password" placeholder="senha" class="input-xlarge">
							</div>
						</div>

						<div class="control-group">
							<!-- Password -->
							<label class="control-label" for="str_password_confirma">Confirme a Senha</label>
							<div class="controls">
								<input type="password" id="str_password_confirma" name="str_password_confirma" placeholder="repita a senha" class="input-xlarge">
							</div>
						</div>

						<legend>Status do Usuário</legend>

						<label class="checkbox" for="int_ativo">

	      					<input type="checkbox" value="1" name="int_ativo" checked> Ativo

	    				</label>						

	    				<hr />

						<div class="control-group">
							<!-- Button -->
							<div class="controls">

								<button class="btn btn-info btn-small" type="button" onclick="javascript:history.go(-1);"><i class="icon-arrow-left"></i> VOLTAR</button>
								<button class="btn btn-primary" type="submit"><i class="icon-save"></i> ADICIONAR</button>
								<button class="btn btn-small" type="reset"><i class="icon-refresh"></i> LIMPAR</button> 

							</div>

						</div>

					</fieldset>

				</form>

			</div>

			<div id="tabela" style="<?php echo $display_tabela;?>">

				<!-- INICIO # TABELA DE DADOS -->
				<table id="tabela_linha" class="table table-hover table-striped table-bordered table-condensed">
					<caption>Usuários</caption>
					<thead>
						<tr>
							<th>ID</th>
							<th>Usuário</th>
							<th>Nome</th>
							<th>E-mail</th>
							<th>Ativo</th>
							<th>Ação</th>
						</tr>
					</thead>
					<tbody>
						<?php

							foreach($usuarios as $us):

								echo '<tr>';

									echo '<td><span class="badge">' . $us->id . '</span></td>';

									echo '<td>' . $us->str_usuario . '</td>';

									echo '<td>' . $us->str_nome . '</td>';

									echo '<td>' . $us->str_email . '</td>';

									# ATIVO
									if ($us->int_ativo == 1) {
										$status = '<span onclick="muda_status(' . $us->id . ');" class="prod_sit_' . $us->id . ' label label-important" id="ativ_' . $us->id . '"><i class="icone_' . $us->id . ' icon-stop link"> </i></span>';
									}
									elseif ($us->int_ativo == 0) {
										$status = '<span onclick="muda_status(' . $us->id . ');" class="prod_sit_' . $us->id . ' label label-success" id="ativ_' . $us->id . '"><i class="icone_' . $us->id . ' icon-play link"></i></span>';
									}
									echo '<td>' . $status . '</td>';

									echo '<td><a style="cursor:pointer;" onclick="return confirm(\'Editar usuário: ' . $us->str_usuario . ' ?\')";" href="' . base_url() . 'admin/usuarios/editar/' . $us->id . '"><i class="icon-edit"></i></a> / <a style="cursor:pointer;" onclick="return confirm(\'Excluir usuário: ' . $us->str_usuario . ' ?\')";" href="' . base_url() . 'admin/usuarios/excluir/' . $us->id . '"><i class="icon-trash"></i></a></td>';

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

		$('.usuarios').click(function(){
			$('#usuarios').toggle('slow');
			$('#tabela').toggle('slow');
		});

		$(function(){

			$('.nav_usuarios').addClass('active');
			$('.menu_usuarios').show();

			$('#tabela_linha').dataTable({
				"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ produtos por página"
				}
			});

			$('.label').css('cursor', 'pointer');
			$('.usuarios').css('cursor', 'pointer');

		});

		function muda_status (id) {
			
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url();?>admin/usuarios/status",
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

		setTimeout(function() {
			$('.sumir').fadeOut('slow');
		}, 4000);		

	</script>