<?php
include_once './DatabaseManager.php';

/**
 * Description of ServicioGenerico
 *
 * @author estef
 */
class ServicioGenerico {
    protected $tabla, $campos, $discr, $discrValor;
    
    protected function selectTodos(){
        $query = "SELECT * FROM $this->tabla";
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $resultado = $dbM->executeQuery($query);
        $dbM->closeConnection();
        return $resultado;
}
}
