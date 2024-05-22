<?php

if (!empty($_POST["btnentrada"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conn->query(" SELECT count(*) as 'total' from employee_list where cedula='$dni' ");
        $id = $conn->query(" SELECT id from employee_list where cedula='$dni' ");
        $id_empleado = $id->fetch_object()->id_empleado;

        //verificar si existe un registro de entrada con la asistencia vacia
        $verificar = $conn->query(" SELECT max(id_asistencia), count(*) as 'total' from asistencia where employee_id=$id_empleado and salida is null ");
        if ($verificar->fetch_object()->total > 0) { ?>
            <script>
                window.location.href = "index.php?error=entrada-duplicado";
            </script>
            <?php exit();
        }


        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");


            $consultaFecha = $conn->query(" SELECT entrada from asistencia where employee_id=$id_empleado order by id_asistencia desc limit 1 ");
            $fechaBD = $consultaFecha->fetch_object()->entrada;

            $sql = $conn->query(" INSERT into asistencia(employee_id,entrada)values($id_empleado,'$fecha') ");
            if ($sql == true) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "CORRECTO",
                            type: "success",
                            text: "Hola, BIENVENIDO",
                            styling: "bootstrap3"
                        })
                    })
                </script>
            <?php } else { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Error al registrar ENTRADA",
                            styling: "bootstrap3"
                        })
                    })
                </script>
            <?php  }
        } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "INCORRECTO",
                        type: "error",
                        text: "La Cedula Registrada NO existe",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php }
    } else { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "INCORRECTO",
                    type: "error",
                    text: "Ingrese la CEDULA",
                    styling: "bootstrap3"
                })
            })
        </script>
    <?php } ?>

    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>

<?php }

?>


<!-- REGISTRO DE SALIDA -->

<?php

if (!empty($_POST["btnsalida"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conn->query(" SELECT count(*) as 'total' from employee_list where cedula='$dni' ");
        $id = $conn->query(" SELECT id from employee_list where cedula='$dni' ");
        if ($consulta->fetch_object()->total > 0) {

            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;
            $busqueda = $conn->query(" SELECT id_asistencia,entrada from asistencia where employee_id=$id_empleado order by id_asistencia desc limit 1 ");

            while ($datos = $busqueda->fetch_object()) {
                $id_asistencia = $datos->id_asistencia;
                $entradaBD = $datos->entrada;
            }

            if (substr($fecha, 0, 10) != substr($entradaBD, 0, 10)) {
?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "PRIMERO DEBES REGISTRAR TU ENTRADA",
                            styling: "bootstrap3"
                        })
                    })
                </script>
                <?php
            } else {
                $consultaFecha = $conn->query(" SELECT salida from asistencia where employee_id=$id_empleado order by id_asistencia desc limit 1 ");
                $fechaBD = $consultaFecha->fetch_object()->salida;

                if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) {
                ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "INCORRECTO",
                                type: "error",
                                text: "YA REGISTRASTE TU SALIDA",
                                styling: "bootstrap3"
                            })
                        })
                    </script>
                    <?php
                } else {
                    $sql = $conn->query(" UPDATE asistencia set salida='$fecha' where id_asistencia=$id_asistencia ");
                    if ($sql == true) { ?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "CORRECTO",
                                    type: "success",
                                    text: "ADIOS, Vuelve Pronto",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                    <?php } else { ?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "INCORRECTO",
                                    type: "error",
                                    text: "Error al registrar SALIDA",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
            <?php  }
                }
            }
        } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "INCORRECTO",
                        type: "error",
                        text: "La Cedula Ingresa NO existe",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php }
    } else { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "INCORRECTO",
                    type: "error",
                    text: "Ingrese la CEDULA",
                    styling: "bootstrap3"
                })
            })
        </script>
    <?php } ?>

    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>

<?php }

?>