<?php
include 'modelo.php';

class Controlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new Modelo();
    }

    public function calcularYGuardar($formulaBOPD, $formulaGOR, $variableValues) {
        // Evaluar las fórmulas con los valores ingresados
        $BOPD = $this->evaluateFormula($formulaBOPD, $variableValues);
        $GOR = $this->evaluateFormula($formulaGOR, array_merge($variableValues, ['BOPD' => $BOPD]));

        // Guardar resultados en la base de datos
        $this->modelo->insertarResultados($formulaBOPD, $formulaGOR, $BOPD, $GOR);

        return ['BOPD' => $BOPD, 'GOR' => $GOR];
    }

    private function evaluateFormula($formula, $values) {
        // Ajustar el porcentaje si el valor es mayor a 1
        if (isset($values['X']) && $values['X'] > 1) {
            $values['X'] = $values['X'] / 100; // Convertir porcentaje a decimal
        }

        // Reemplazar variables por sus valores
        $formulaParsed = preg_replace_callback('/\b[a-zA-Z]\w*\b/', function ($matches) use ($values) {
            return $values[$matches[0]] ?? 0;
        }, $formula);

        // Evaluar la fórmula
        return eval('return ' . $formulaParsed . ';');
    }
}
?>
