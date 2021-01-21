<div class="container-fluid">
	<div class="page-header">
		<h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios <small>ADMINISTRADORES</small></h1>
	</div>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
		<li>
			<a href="<?php ECHO SERVERURL; ?>admin/" class="btn btn-info">
				<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ADMINISTRADOR
			</a>
		</li>
		<li>
			<a href="<?php ECHO SERVERURL; ?>adminlist/" class="btn btn-success">
				<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ADMINISTRADORES
			</a>
		</li>
		<li>
			<a href="<?php ECHO SERVERURL; ?>adminsearch/" class="btn btn-primary">
				<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ADMINISTRADOR
			</a>
		</li>
	</ul>
</div>

<!-- Panel listado de administradores -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ADMINISTRADORES</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<!-- <table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">DNI</th>
							<th class="text-center">NOMBRES</th>
							<th class="text-center">APELLIDOS</th>
							<th class="text-center">TELÉFONO</th>
							<th class="text-center">A. CUENTA</th>
							<th class="text-center">A. DATOS</th>
							<th class="text-center">ELIMINAR</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>7890987651</td>
							<td>Nombres</td>
							<td>Apellidos</td>
							<td>Telefono</td>
							<td>
								<a href="#!" class="btn btn-success btn-raised btn-xs">
									<i class="zmdi zmdi-refresh"></i>
								</a>
							</td>
							<td>
								<a href="#!" class="btn btn-success btn-raised btn-xs">
									<i class="zmdi zmdi-refresh"></i>
								</a>
							</td>
							<td>
								<form>
									<button type="submit" class="btn btn-danger btn-raised btn-xs">
										<i class="zmdi zmdi-delete"></i>
									</button>
								</form>
							</td>
						</tr>
					</tbody>
				</table> -->

				<table id="example" class="display table table-hover text-center" style="width:100%">
					<thead>
						<tr>
							<th class="text-center">DNI</th>
							<th class="text-center">Nombre</th>
							<th class="text-center">Teléfono</th>
							<th class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>7890987651</td>
							<td>Angel Paredes Torres</td>
							<td>Telefono</td>
							<td>
								<button class="btn btn-sm btn-warning"><i class="zmdi zmdi-account-add"></i></button>
							</td>
						</tr>
					</tbody>
				</table>

			</div>

			<script>
			$(document).ready(function() {
				$('#example').DataTable();
			} );</script>
		</div>
	</div>
</div>