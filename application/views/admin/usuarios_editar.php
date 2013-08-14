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


			?>

			<h3 class="usuarios"><a href="#">Edição de usuário</a></h3>

			<div id="usuarios">

				<form action="<?php echo base_url();?>admin/usuarios/gravar" method="post">

  					<fieldset>

  						<input type="hidden" name="id" value="<?php echo $usuarios[0]->id;?>">

  						<input type="hidden" name="usuario_atual" value="<?php echo $usuarios[0]->str_usuario;?>">

  						<input type="hidden" name="email_atual" value="<?php echo $usuarios[0]->str_email;?>">

  						<legend class="">Editar usuário: <?php echo $usuarios[0]->str_usuario;?></legend>

  						<?php echo validation_errors(); ?>

						<div class="control-group">
							<label class="control-label" for="str_nome">Nome</label>
							<div class="controls">
								<input type="text" id="str_nome" name="str_nome" placeholder="nome" class="input-xlarge" value="<?php echo $usuarios[0]->str_nome;?>">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="str_usuario">Usuário</label>
							<div class="controls">
								<input type="text" id="str_usuario" name="str_usuario" placeholder="usuário" class="input-xlarge"  value="<?php echo $usuarios[0]->str_usuario;?>">
							</div>
						</div>						

						<div class="control-group">
							<!-- E-mail -->
							<label class="control-label" for="str_email">E-mail</label>

							<div class="controls">
								<input type="text" id="str_email" name="str_email" placeholder="e-mail" class="input-xlarge"  value="<?php echo $usuarios[0]->str_email;?>">
							</div>

						</div>

						<div class="control-group">
							<!-- Password-->
							<label class="control-label" for="password">Nova Senha</label>
							<div class="controls">
								<input type="password" id="str_password" name="str_password" placeholder="senha" class="input-xlarge">
							</div>
						</div>

						<div class="control-group">
							<!-- Password -->
							<label class="control-label" for="str_password_confirma">Confirme a Nova Senha</label>
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

			$('.nav_usuarios').addClass('active');
			$('.menu_usuarios').show();


		});


		setTimeout(function() {
			$('.sumir').fadeOut('slow');
		}, 4000);		

	</script>