<?php
include 'controlador.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $controlador = new Controlador();
    $resultados = $controlador->calcularYGuardar($data['formulaBOPD'], $data['formulaGOR'], $data['variableValues']);
    
    echo json_encode($resultados);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórmulas Dinámicas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Generador de Fórmulas Dinámicas</h1>
        <form id="formulaForm">
            <div class="mb-3">
                <label for="formulaBOPD" class="form-label">Fórmula BOPD:</label>
                <input type="text" class="form-control" id="formulaBOPD" placeholder="Ejemplo: U * X" required>
            </div>
            <div class="mb-3">
                <label for="formulaGOR" class="form-label">Fórmula GOR:</label>
                <input type="text" class="form-control" id="formulaGOR" placeholder="Ejemplo: U * 1000 / S" required>
            </div>
            <div id="dynamicInputs"></div>
            <button type="button" class="btn btn-primary mt-3" id="generateInputs">Generar Inputs</button>
            <button type="submit" class="btn btn-success mt-3 d-none" id="calculateBtn">Calcular</button>
        </form>
        <div id="results" class="mt-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
