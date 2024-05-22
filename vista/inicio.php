<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
   header('location:login/login.php');
}

?>

<style>
   ul li:nth-child(1) .activo {
      background: rgb(11, 150, 214) !important;
   }
</style>



<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<link href="../public/estilos/adminlte.min.css" rel="stylesheet">


<!-- inicio del contenido principal -->
<div class="page-content">

   <h4 class="text-center text-secondary">ESTABLECIMIENTO COMERCIAL CHK</h4>
   <br>
   <br>

   <?php
   include "../modelo/conexion.php";
   ?>
   <!-- Info boxes -->
      <div class="row">
         <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
               <div class="inner">
                  <h3><?php echo $conexion->query("SELECT * FROM cargo")->num_rows; ?></h3>

                  <p>Total de Cargos</p>
               </div>
               <div class="icon">
                  <i class="fa fa-list-alt"></i>
               </div>
            </div>
         </div>
         <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
               <div class="inner">
                  <h3><?php echo $conexion->query("SELECT * FROM usuario")->num_rows; ?></h3>

                  <p>Total de Usuarios</p>
               </div>
               <div class="icon">
                  <i class="fa fa-users"></i>
               </div>
            </div>
         </div>
         <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
               <div class="inner">
                  <h3><?php echo $conexion->query("SELECT * FROM empleado")->num_rows; ?></h3>

                  <p>Total de Empleados</p>
               </div>
               <div class="icon">
                  <i class="fa fa-user-friends"></i>
               </div>
            </div>
         </div>
         <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
               <div class="inner">
                  <h3><?php echo $conexion->query("SELECT * FROM asistencia")->num_rows; ?></h3>

                  <p>Total de Asistencias</p>
               </div>
               <div class="icon">
                  <i class="fa fa-tasks"></i>
               </div>
            </div>
         </div>
         <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
               <div class="inner">
                  <h3><?php echo $conexion->query("SELECT * FROM asistencia")->num_rows; ?></h3>

                  <p>Total de Tareas</p>
               </div>
               <div class="icon">
                  <i class="fa fa-tasks"></i>
               </div>
            </div>
         </div>
      </div>

</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>