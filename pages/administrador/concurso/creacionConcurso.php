<h2 class="mb-5">Crear nuevo concurso</h2>
<div class="row">
    <div class="col-12">
        <form id="form_concurso" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="nombre_concurso" class="form-label">Nombre del concurso <i class="required">*</i></label>
                    <input type="text" class="form-control form-control-lg" id="nombre_concurso" name="nombre_concurso" required autocomplete="off">
                </div>
                <div class="col-6 mb-3">
                    <label for="director" class="form-label">Director <i class="required">*</i></label>
                    <input type="text" class="form-control form-control-lg" id="director" name="director" required autocomplete="off">
                </div>
                <div class="col-6 mb-3">
                    <label for="ubicacion" class="form-label">Dirección / Ubicación <i class="required">*</i></label>
                    <input type="text" class="form-control form-control-lg" id="ubicacion" name="ubicacion" required autocomplete="off">
                </div>
            </div>
            
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="fecha_evento" class="form-label">Fecha del evento</label>
                    <input type="date" class="form-control form-control-lg" id="fecha_evento" name="fecha_evento"  maxlength="10" autocomplete="off">
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 mb-2">
                    <label for="categoria" class="form-label">Categorias <i class="required">*</i></label>
                    <select name="categorias[]" multiple="multiple" class="form-select select_categoria">
                    <?php
                        $query = $db->query("SELECT * FROM categorias_concurso WHERE eliminado = 0");
                        $fetch_cat = $query->fetchAll(PDO::FETCH_OBJ);

                        foreach ($fetch_cat as $categoria) { ?>
                            <option value="<?= $categoria->id_categoria ?>"><?= $categoria->nombre_categoria ?></option>
                        <?php
                        }
                    ?>
                    </select>
                </div>
            </div>

            <button type="button" class="btn-bandrank" onclick="registrarConcurso()">Registrar</button>
            <a href="<?=base_url?>pages/administrador/inicio.php" type="button" class="btn btn-light">Volver</a>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select_categoria').select2({
            width: 'resolve'
        });
    });
</script>