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

   <h4 class="text-center text-secondary">REGISTRO DE USUARIOS</h4>

   <?php
   include '../modelo/conexion.php';
   include "../controlador/controlador_registrar_usuario.php"
   ?>

   <div class="row">
      <form action="" method="POST">
         <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
            <input type="text" placeholder="Nombre" class="input input__text" name="txtnombre" onkeypress="return SoloLetras(event);">
         </div>
         <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
            <input type="text" placeholder="Apellido" class="input input__text" name="txtapellido" onkeypress="return SoloLetras(event);">
         </div>
         <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
            <input type="text" placeholder="Usuario" class="input input__text" name="txtusuario">
         </div>
         <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
            <input type="password" placeholder="Contraseña" class="input input__text" name="txtpassword">
         </div>
         <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
            <select class="form-select" id="rol" name="rol">
               <option value="" selected>Seleccionar Rol de Usuario</option>
               <option value="1">ADMINISTRADOR</option>
               <option value="2">VENDEDOR</option>
            </select>
         </div>
         <div class="text-right p-2">
            <a href="usuario.php" class="btn btn-secondary btn-rounded">Atras</a>
            <button type="submit" value="ok" name="btnregistrar" class="btn btn-primary btn-rounded">Registrar</button>
         </div>
      </form>
   </div>


</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>