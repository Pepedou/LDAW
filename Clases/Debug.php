<?php

/**
 * Description of Debug
 *
 * @author José Luis Valencia Herrera     A01015544
 */

class Debug {

    static private $instancia = NULL;

    public static function getInstance() {
        if (self::$instancia == NULL) {
            self::$instancia = new Debug();
        }
        return self::$instancia;
    }

    public function alert($texto) {
        echo " 
                <script type=\"text/javascript\"> 
                    alert(\"[Debug] $texto\"); 
                </script>";
    }

    public function log($texto) {
        //Agregar la fecha
        $nombreArchivo = 'logs/log.txt';

        if (is_writable($nombreArchivo)) {
            if (!$archivo = fopen($nombreArchivo, 'a')) {
                $this->alert("No se puede abrir el archivo ($nombreArchivo). Verifique que los permisos sean 766.");
                return false;
            }

            // Escribir $texto a nuestro archivo abierto.
            //Agregar hora
            if (fwrite($archivo, $texto) === FALSE) {
                $this->alert("No se puede escribir en el archivo ($nombreArchivo). Verifique que los permisos sean 766.");
                return false;
            }
            fclose($archivo);
            return true;
        } else {
            $this->alert("El nombreArchivo $nombreArchivo no se puede abrir para escritura!");
            return false;
        }
    }
    
    public function alertAndLog($texto){
        $this->alert($texto);
        $this->log($texto);
    }
}
