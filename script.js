document.getElementById('generateInputs').addEventListener('click', function () {
    const formulaBOPD = document.getElementById('formulaBOPD').value;
    const formulaGOR = document.getElementById('formulaGOR').value;

    if (!formulaBOPD || !formulaGOR) {
        alert('Por favor, ingresa ambas fórmulas.');
        return;
    }

    // Extraer las variables únicas de las fórmulas
    const variablesBOPD = extractVariables(formulaBOPD);
    const variablesGOR = extractVariables(formulaGOR);

    // Generar los inputs dinámicamente
    const dynamicInputsDiv = document.getElementById('dynamicInputs');
    dynamicInputsDiv.innerHTML = '';
    const allVariables = new Set([...variablesBOPD, ...variablesGOR]);

    allVariables.forEach(variable => {
        dynamicInputsDiv.innerHTML += `
            <div class="mb-3">
                <label for="${variable}" class="form-label">Valor para ${variable}:</label>
                <input type="number" class="form-control" id="${variable}" name="${variable}" step="any" required>
            </div>
        `;
    });

    document.getElementById('calculateBtn').classList.remove('d-none');
});

document.getElementById('formulaForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formulaBOPD = document.getElementById('formulaBOPD').value;
    const formulaGOR = document.getElementById('formulaGOR').value;

    // Obtener los valores de los inputs dinámicos
    const inputs = document.querySelectorAll('#dynamicInputs input');
    const variableValues = {};
    inputs.forEach(input => {
        variableValues[input.id] = parseFloat(input.value);
    });

    // Enviar datos al servidor
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ formulaBOPD, formulaGOR, variableValues })
    })
    .then(response => response.json())
    .then(data => {
        // Mostrar los resultados
        const resultsDiv = document.getElementById('results');
        resultsDiv.innerHTML = `
            <h4>Resultados:</h4>
            <p><strong>Fórmula BOPD:</strong> ${formulaBOPD} = ${data.BOPD.toFixed(2)}</p>
            <p><strong>Fórmula GOR:</strong> ${formulaGOR} = ${data.GOR.toFixed(2)}</p>
            <p><strong>BOPD:</strong> ${data.BOPD.toFixed(2)}</p>
            <p><strong>GOR:</strong> ${data.GOR.toFixed(2)}</p>
        `;
    })
    .catch(error => {
        alert('Error al evaluar las fórmulas. Por favor, verifica los valores y las fórmulas.');
    });
});

// Función para extraer las variables de una fórmula
function extractVariables(formula) {
    const matches = formula.match(/\b[a-zA-Z]\w*\b/g);
    return matches ? Array.from(new Set(matches)) : [];
}
