<fieldset>
    <legend>Publicaciones</legend>
    <div class="mb-3">
        <label for="titulo" class="form-label">Titulo</label>
        <input type="text" id="titulo" name="entrada[titulo]" class="form-control" placeholder="Titulo entrada" value="<?php echo s($entrada->titulo); ?>">
        <small class="form-text text-danger" id="errorTitulo">El titulo es obligatorio</small>
    </div>

    <div class="mb-3">
        <label for="entrada" class="form-label">Contenido</label>
        <textarea class="form-control" id="entrada" name="entrada[entrada]" rows="3"><?php echo s($entrada->entrada); ?></textarea>
        <small class="form-text text-danger" id="errorEntrada">El contenido es obligatorio</small>
    </div>

    <div class="mb-3">
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="entrada[imagen]">

    <?php if($entrada->imagen) { ?>
        <img src="/imagenes/<?php echo $entrada->imagen ?>" class="imagen-small">
    <?php } ?>
    </div>
</fieldset>