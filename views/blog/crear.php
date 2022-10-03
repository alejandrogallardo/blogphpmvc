<div class="container">
    <?php foreach($errores as $error): ?>
        <div class="alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php'; ?>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>