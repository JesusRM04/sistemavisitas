<?php
/*include ('../app/config.php');
include ('../layout/sesion.php');*/

include ('../layout/parte1.php');

//include ('../app/controllers/roles/listado_de_roles.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registrar Nuevo Usuario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">INGRESE LOS DATOS DEL NUEVO USUARIO</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/usuarios/create.php" method="post">
                                        <!-- Input Nombres -->
                                        <div class="form-group">
                                            <label for="">Nombre Completo</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-keyboard"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="nombres" class="form-control" placeholder="Escriba aquí el nombre del Nuevo Usuario..." required>
                                            </div>                    
                                        </div>
                                        <!-- Input Email -->
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </div>
                                                <input type="email" name="email" class="form-control" placeholder="Escriba aquí el correo del Nuevo Usuario..." required>
                                            </div>
                                        </div>
                                        <!-- Input Telefono -->
                                        <div class="form-group">
                                            <label for="">Extensión de Tel.</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                </div>
                                                <input type="number" name="telusuario" class="form-control" placeholder="Escriba aquí el teléfono del Nuevo Usuario..." required>
                                            </div>
                                        </div>
                                        <!-- Input Rol de Usuario -->
                                        <div class="form-group">
                                            <label for="">Rol del Usuario</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                </div>
                                                <select name="rol" id="" class="form-control">
                                                    <option value="" disabled selected>Seleccione el Rol del Nuevo Usuario...</option>
                                                    <?php
                                                    foreach ($roles_datos as $roles_dato){?>
                                                        <option value="<?php echo $roles_dato['id_rol'];?>"><?php echo $roles_dato['rol'];?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Input Contraseña -->
                                        <div class="form-group">
                                            <label for="">Contraseña</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-key"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="password_user" class="form-control" placeholder="Escriba aquí la contraseña del Nuevo Usuario..." required>
                                            </div>
                                        </div>
                                        <!-- Input Repetir Contraseña -->
                                        <div class="form-group">
                                            <label for="">Repita la Contraseña</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-key"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="password_repeat" class="form-control" placeholder="Repita la contraseña del Nuevo Usuario..." required>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-danger">Cancelar</a>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include ('../layout/parte2.php'); ?>