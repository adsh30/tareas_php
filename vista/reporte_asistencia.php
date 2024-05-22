<!-- inicio del contenido principal -->
<div class="page-content">

   <h4 class="text-center text-secondary">ASISTENCIA DE EMPLEADOS</h4>

   <?php
   include 'db_connect.php';
   $sql = $conn->query(" SELECT * FROM employee_list ");
   ?>

   <form action="fpdf/ReporteAsistenciaFecha.php">
      <input required type="date" name="txtfechainicio" class="input input__text mb-2">
      <input required type="date" name="txtfechafinal" class="input input__text mb-2">
      <select required name="txtempleado" class="input input__select mb-2">
         <option value="todos">Todos los empleados</option>
         <?php
         while ($datos = $sql->fetch_object()) { ?>
            <option value="<?= $datos->employee_id ?>"><?= $datos->firstname . " " . $datos->lastname ?></option>
         <?php }
         ?>
      </select>
      <button type="submit" name="btngenerar" class="btn btn-primary w-100 p-3">Generar Reporte</button>
   </form>



</div>
</div>