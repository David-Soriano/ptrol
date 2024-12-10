<?php
class Modelo {
    private $conexion;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=formulas_db';
        $username = 'root';
        $password = '';
        $this->conexion = new PDO($dsn, $username, $password);
    }

    public function insertarResultados($formulaBOPD, $formulaGOR, $BOPD, $GOR) {
        $sql = 'INSERT INTO resultados (formulaBOPD, formulaGOR, BOPD, GOR) VALUES (?, ?, ?, ?)';
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$formulaBOPD, $formulaGOR, $BOPD, $GOR]);
    }
}
?>
