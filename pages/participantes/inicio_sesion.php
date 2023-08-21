<!doctype html>
<html lang="es">
<?php require("../../head.php"); ?>

<style>
    <?php require("../../dist/css/login.css"); ?>
</style>

<body>

    <section>
        <div class="content animate__animated animate__backInDown">

            <div class="left">
                <img src="../../dist/images/bandrank_isotipo_blanco.png" alt="icon">
            </div>

            <div class="right">
                <div class="title">
                    <h2>Bienvenido a Bandrank</h2>
                </div>
                <div class="form">
                    <form>
                        <div class="inputbox">
                            <label>Correo electrónico</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>
                        <div class="inputbox">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="clave" required>
                        </div>
                        <div class="create">
                            <button type="submit">Iniciar sesión</button>
                        </div>
                        <div class="or">
                            <div class="sign">
                                <a href="../../inicio.php" class="button">
                                    <span>Regresar</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</body>
<?php require("../../footer.php"); ?>
</html>