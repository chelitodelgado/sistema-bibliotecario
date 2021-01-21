<?php 

if( $ajaxP ) {
    require_once("../core/main.php");
}else {
    require_once("./core/main.php");
}

class loginModel extends Main {

    protected function startSessionModel ($datos) {

        $sql = Main::connect()->prepare(
            "SELECT * FROM cuenta 
                WHERE CuentaUsuario  = :Usuario 
                    AND CuentaClave  = :Clave 
                    AND CuentaEstado = 'Activo'"
        );
        $sql->bindParam(':Usuario', $datos['Usuario']);
        $sql->bindParam(':Clave',   $datos['Clave']);

        $sql->execute();

        return $sql;

    }

    protected function sessionCloseModel( $datos ) {

        if( $datos['Usuario'] != "" && $datos['Token_S'] == $datos['Token'] ) {

           $bitacora = Main::updateBitacora( $datos['Codigo'], $datos['Hora'] ); 

           if($bitacora->rowCount() == 1) {
                session_unset();
                session_destroy();
                $response = "true";
           }else {
                $response = "false";
           }
        }else{
            $response = "false";
        }

        return $response;
    }


}
