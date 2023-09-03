<div class="container">
    <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success'): ?>
            <div class="alert-band">
                <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
                <a href="bandas.php" class="btn">Aceptar</a>
            </div>
    <?php elseif(isset($_REQUEST["message_error"])): ?>
            <div class="alert-band">
                <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
                <?php echo $_REQUEST["message_error"]; ?>
                <a href="bandas.php" class="btn">Aceptar</a>
            </div>
    <?php endif; ?>

    <h3><strong>Editar banda</strong></h3>

    <form action="bandas_controller.php?action=actualizar" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="nombre_banda" class="form-label">Nombre<i class="required">*</i></label>
                <input type="hidden" name="id_banda" value="<?= $id?>">
                <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" required autocomplete="off" value="<?= $datos->nombre?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="ubicacion" class="form-label">Ubicación<i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="ubicacion" name="ubicacion" required autocomplete="off" value="<?= $datos->ubicacion?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="id_categoria" class="form-label">Categoría</label>
                <select class="form-control form-control-lg" name="id_categoria" id="id_categoria" value="<?= $datos->id_categoria?>">
                    <option value="">Selecciona una opción</option>
                    <?php 
                    $query = $db->query("SELECT * FROM categorias_concurso");
                    $fetch_categorias_concurso = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($fetch_categorias_concurso as $categorias_concurso) { ?>
                        <option value="<?= $categorias_concurso->id_categoria ?>" <?= $datos->id_categoria==$categorias_concurso->id_categoria?'selected':''?>><?= $categorias_concurso->nombre_categoria?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="correo" class="form-label">Nombre de Instructor<i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" name="nombre_instructor" id="nombre_instructor" required autocomplete="off" value="<?= $datos->nombre_instructor?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="correo_instructor" class="form-label">Correo de Instructor<i class="required">*</i></label>
                <input type="email" class="form-control form-control-lg" name="correo_instructor" id="correo_instructor" required autocomplete="off" value="<?= $datos->correo_instructor?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="clave" class="form-label">Clave<i class="required">*</i></label>
                <input type="password" class="form-control form-control-lg" name="clave" id="clave" required autocomplete="off" value="<?= $datos->clave?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="correo" class="form-label">Concurso <i class="required">*</i></label>
                <select class="form-control form-control-lg" name="id_concurso" id="id_concurso">
                    <option value="">Selecciona una opción</option>
                    <?php 
                    $query = $db->query("SELECT * FROM concurso");
                    $fetch_concurso = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($fetch_concurso as $concurso) { ?>
                        <option value="<?= $concurso->id_concurso ?>" <?= $datos->id_concurso==$concurso->id_concurso?'selected':''?>><?= $concurso->nombre_concurso?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn-bandrank">Registrar</button>
        <a href="../../../pages/administrador/inicio.php" class="btn btn-secondary" >Volver</a>
    </form>

</div>