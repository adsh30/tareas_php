<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
   header('location:login/login.php');
}

?>

<style>
   ul li:nth-child(3) .activo {
      background: rgb(11, 150, 214) !important;
   }
</style>

<script>
   function SoloLetras(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toString();
      letras = "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚabcdefghijklmnopqrstuvwxyzáéíóú";

      especiales = [8, 13, 32];
      tecla_especial = false
      for (var i in especiales) {
         if (key == especiales[i]) {
            tecla_especial = true;
            break;
         }
      }

      if (letras.indexOf(tecla) == -1 && !tecla_especial) {
         alertaPersonalizada('error', 'INGRESE SOLO LETRAS');
         return false;
      }
   }
</script>


<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

   <h4 class="text-center text-secondary">LISTA DE USUARIOS</h4>

   <?php
   include "../modelo/conexion.php";
   include "../controlador/controlador_modificar_usuario.php";
   include "../controlador/controlador_eliminar_usuario.php";

   $sql = $conexion->query(" SELECT * from usuario ");

   ?>

   <a href="registro_usuario.php" class="btn btn-primary btn-rounded mb-2"><i class="fa-solid fa-plus"></i> &nbsp;Registrar</a>
   <div class="text-right mb-2">
      <a href="fpdf/ReporteUsuario.php" target="_blank" class="btn btn-success"><i class="fas fa-file-pdf"></i> Generar reportes</a>
   </div>
   <table class="table table-bordered table-hover w-100" id="example">
      <thead>
         <tr>
            <th scope="col">ID</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">APELLIDO</th>
            <th scope="col">USUARIO</th>
            <th scope="col">ROL</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php
         while ($datos = $sql->fetch_object()) { ?>
            <tr>
               <td><?= $datos->id_usuario ?></td>
               <td><?= $datos->nombre ?></td>
               <td><?= $datos->apellido ?></td>
               <td><?= $datos->usuario ?></td>
               <td><?= $datos->rol ?></td>
               <td>
                  <a href="" data-toggle="modal" data-target="#exampleModal<?= $datos->id_usuario ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                  <a href="usuario.php?id=<?= $datos->id_usuario ?>" onclick="advertencia(event)" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
               </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal<?= $datos->id_usuario ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title w-100" id="exampleModalLabel">Modificar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="" method="POST">
                           <div hidden class="fl-flex-label mb-4 px-2 col-12">
                              <input type="text" placeholder="ID" class="input input__text" name="txtid" onkeypress="return SoloLetras(event);" value="<?= $datos->id_usuario ?>">
                           </div>
                           <div class="fl-flex-label mb-4 px-2 col-12">
                              <input type="text" placeholder="Nombre" class="input input__text" name="txtnombre" onkeypress="return SoloLetras(event);" value="<?= $datos->nombre ?>">
                           </div>
                           <div class="fl-flex-label mb-4 px-2 col-12">
                              <input type="text" placeholder="Apellido" class="input input__text" name="txtapellido" onkeypress="return SoloLetras(event);" value="<?= $datos->apellido ?>">
                           </div>
                           <div class="fl-flex-label mb-4 px-2 col-12">
                              <input type="text" placeholder="Usuario" class="input input__text" name="txtusuario" onkeypress="return SoloLetras(event);" value="<?= $datos->usuario ?>">
                           </div>
                           <div class="fl-flex-label mb-4 px-2 col-12">
                              <select name="txtrol" class="input input__select">
                                 <?php
                                 $sql2 = $conexion->query(" select * from usuario ");
                                 while ($datos2 = $sql2->fetch_object()) { ?>
                                    <option <?= $datos->usuario == $datos2->rol ? 'selected' : '' ?> value="<?= $datos2->rol ?>"><?= $datos2->rol ?></option>
                                 <?php }
                                 ?>
                              </select>
                           </div>
                           <div class="text-right p-2">
                              <a href="usuario.php" class="btn btn-secondary btn-rounded">Atras</a>
                              <button type="submit" value="ok" name="btnmodificar" class="btn btn-primary btn-rounded">Modificar</button>
                           </div>
                        </form>
                     </div>

                  </div>
               </div>
            </div>
         <?php }
         ?>


      </tbody>
   </table>

</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>