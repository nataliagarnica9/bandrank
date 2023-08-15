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
                    <label for="categoria" class="form-label">Categoría <i class="required">*</i></label>
                    
                    <select name="categoria" id="categoria" class="form-control">
                        <option value="">Selecciona una opción</option>
                        <?php 
                        $query = $db->query("SELECT * FROM categorias_concurso");
                        $fetch_categoria = $query->fetchAll(PDO::FETCH_OBJ);

                        foreach($fetch_categoria as $categoria) { ?>
                            <option value="<?= $categoria->id_categoria ?>"><?= $categoria->nombre_categoria?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="fecha_evento" class="form-label">Fecha del evento</label>
                    <input type="date" class="form-control form-control-lg" id="fecha_evento" name="fecha_evento"  maxlength="10" autocomplete="off">
                </div>
            </div>

            <button type="button" class="btn-bandrank" onclick="registrarConcurso()">Registrar</button>
        </form>
    </div>
</div>