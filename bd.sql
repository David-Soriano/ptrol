CREATE DATABASE formulas_db;
USE formulas_db;

CREATE TABLE resultados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    formulaBOPD VARCHAR(255),
    formulaGOR VARCHAR(255),
    BOPD DECIMAL(10, 2),
    GOR DECIMAL(10, 2)
);
