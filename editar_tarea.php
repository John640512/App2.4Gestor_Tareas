<?php
include "conexion.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_tarea = intval($_GET['id']);
    
    // Obtener los datos actuales de la tarea
    $sql = "SELECT * FROM tareas WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_tarea);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $tarea = mysqli_fetch_assoc($resultado);
    
    if (!$tarea) {
        die("Tarea no encontrada");
    }
    
    mysqli_stmt_close($stmt);
} else {
    die("ID de tarea no válido");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $completada = isset($_POST['completada']) ? 1 : 0;
    
    $sql = "UPDATE tareas SET titulo = ?, descripcion = ?, completada = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $titulo, $descripcion, $completada, $id_tarea);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error al actualizar la tarea: " . mysqli_error($conexion);
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="estilosedt.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <h2><i class="fas fa-edit"></i> Editar Tarea</h2>
        
        <?php if (isset($error)): ?>
            <div class="error-message" style="color: #f72585; margin-bottom: 20px; text-align: center;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="titulo"><i class="fas fa-heading"></i> Título:</label>
                <input type="text" id="titulo" name="titulo" required 
                       value="<?php echo htmlspecialchars($tarea['titulo']); ?>">
            </div>
            
            <div class="form-group">
                <label for="descripcion"><i class="fas fa-align-left"></i> Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php 
                    echo htmlspecialchars($tarea['descripcion']); 
                ?></textarea>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-check-circle"></i> Estado:</label>
                <div class="status-option">
                    <label class="status-label">
                        <input type="checkbox" name="completada" value="1" 
                            <?php echo $tarea['completada'] ? 'checked' : ''; ?>>
                        <span class="status-icon <?php echo $tarea['completada'] ? 'completed-icon' : 'pending-icon'; ?>">
                            <i class="fas <?php echo $tarea['completada'] ? 'fa-check-circle' : 'fa-clock'; ?>"></i>
                        </span>
                        <?php echo $tarea['completada'] ? 'Completada' : 'Pendiente'; ?>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Guardar Cambios</button>
            <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Volver al listado</a>
        </form>
    </div>
</body>
</html>