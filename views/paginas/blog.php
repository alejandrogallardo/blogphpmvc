<div class="container mt-5 mb-5">
    <h1 class="text-center">Blog</h1>
    <hr>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach($entradas as $entrada): ?>
            <div class="col">
                <div class="card">
                    <img src="imagenes/<?php  if($entrada->imagen) {echo $entrada->imagen;} else { echo 'default.png'; } ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <?php  echo '<h2 class="card-title">' . $entrada->titulo . '</h2>'; ?>
                        <p class="card-text"><?php echo $entrada->entrada; ?></p>
                    </div>
                    <a href="blog/actualizar?id=<?php echo $entrada->id; ?>" class="btn btn-warning">Leer mas...</a>
                    <a href="blog/actualizar?id=<?php echo $entrada->id; ?>" class="btn btn-warning">Actualizar</a>
                    <a href="blog/actualizar?id=<?php //echo $value["id"]; ?>" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>