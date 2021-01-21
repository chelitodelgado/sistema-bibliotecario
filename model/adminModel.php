<?php 

if( $ajaxP ) {
    require_once("../core/main.php");
}else {
    require_once("./core/main.php");
}

class adminModel extends Main {

    protected function addAdminModel( $datos ) {

        $sql = Main::connect()->prepare(
            "INSERT INTO admin(AdminDNI, AdminNombre, AdminApellido, AdminTelefono, AdminDireccion, CuentaCodigo) 
             VALUES(:DNI, :Nombre, :Apellido, :Telefono, :Direccion, :Codigo)"
        );

        $sql->bindParam(":DNI",       $datos['DNI']);
        $sql->bindParam(":Nombre",    $datos['Nombre']);
        $sql->bindParam(":Apellido",  $datos['Apellido']);
        $sql->bindParam(":Telefono",  $datos['Telefono']);
        $sql->bindParam(":Direccion", $datos['Direccion']);
        $sql->bindParam(":Codigo",    $datos['Codigo']);
        $sql->execute();

        return $sql;

    }


}