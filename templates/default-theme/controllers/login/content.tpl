<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-danger hide">{$alert|var_dump}</div>
		</div>
	</div>
</div>
<div id="login-panel">
	<div id="shop-img" style="margin: -106px auto;width:150px;">
		<img src="templates/default-theme/images/Odin_logo.png" alt="Odin Logo" width="150px" />
	</div>
	<div class="flip-container">
			<div class="flipper">
				<div class="front panel">
					<!--<h4 id="shop_name">v1.0.0</h4>-->
						<form id="login_form" action="index.php?controller=AdminLogin&token=eca4c9f66070f625f2d9915cd217fe49" name="login" method="post">
							<div class="form-group">
								<label class="control-label" for="email">Correo electrónico</label>
								<input name="email" type="email" id="email" class="form-control" value="" autofocus="autofocus" tabindex="1" placeholder=" test@example.com">
							</div>
							<div class="form-group">
								<label class="control-label" for="passwd">
									Contraseña
								</label>
								<input name="passwd" type="password" id="passwd" class="form-control" value="" tabindex="2" placeholder=" Contraseña">
							</div>
							<div class="form-group row-padding-top">
								<div class="button-login">
									<div class="button-login">
										<button type="submit" id="submitLogin" name="submitLogin" class="btn btn-primary btn-lg btn-block ladda-button" value="entrar">Iniciar sesión</button>
									</div>
								</div>
							</div>
					</form>
				</div>
			</div>
		</div>
</div>
