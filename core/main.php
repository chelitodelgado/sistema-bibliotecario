<?php 

if( $ajaxP ) {
    // require_once "../core/dbConfig.php";
    require_once "../core/dbConfig.php";
}else {
    // require_once "../core/dbConfig.php";
    require_once "./core/dbConfig.php";
}

class Main {

    // Establecer la coneción 
    protected function connect(){
        
        try{
            $conn = new PDO(SGBD, USER, PASSWORD);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return $conn;

    }

    // Metodo que inyecta querys
    protected function query( $query ) {

        $resp = self::connect()->prepare($query);
        $resp->execute();
        return $resp;
        
    }

    // Agregar cuenta
    protected function addCuenta( $datos ) {

        $sql = self::connect()->prepare(
            "INSERT INTO cuenta(CuentaCodigo, CuentaPrivilegio, CuentaUsuario, CuentaClave, CuentaEmail, CuentaEstado, CuentaTipo, CuentaGenero, CuentaFoto ) 
            VALUES(:Codigo, :Privilegio, :Usuario, :Clave, :Email, :Estado, :Tipo, :Genero, :Foto);"
        );
        $sql->bindParam(":Codigo"    ,$datos['Codigo']);
        $sql->bindParam(":Privilegio",$datos['Privilegio']);
        $sql->bindParam(":Usuario"   ,$datos['Usuario']);
        $sql->bindParam(":Clave"     ,$datos['Clave']);
        $sql->bindParam(":Email"     ,$datos['Email']);
        $sql->bindParam(":Estado"    ,$datos['Estado']);
        $sql->bindParam(":Tipo"      ,$datos['Tipo']);
        $sql->bindParam(":Genero"    ,$datos['Genero']);
        $sql->bindParam(":Foto"      ,$datos['Foto']);
        $sql->execute();

        return $sql;
    }

    // Eliminar cuenta
    protected function deleteCuenta( $codigo ) {

        $sql = self::connect()->prepare("DELET FROM cuenta WHERE CuentaCodigo = :Codigo");
        $sql->bindParam(":Codigo", $codigo);
        $sql->execute();

        return $sql;

    }

    // Registrar entradas y salidas de los usuarios
    protected function saveBitacora( $datos ) {

        $sql = self::connect()->prepare(
            "INSERT INTO bitacora(BitacoraCodigo, BitacoraFecha, BitacoraHoraInicio, BitacoraHoraFinal, BitacoraTipo, BitacoraYear, CuentaCodigo) 
            VALUES(:Codigo, :Fecha, :HoraInicio, :HoraFinal, :Tipo, :Year, :Cuenta);"
        );

            $sql->bindParam(":Codigo"     ,$datos['Codigo']);
            $sql->bindParam(":Fecha"      ,$datos['Fecha']);
            $sql->bindParam(":HoraInicio" ,$datos['HoraInicio']);
            $sql->bindParam(":HoraFinal"  ,$datos['HoraFinal']);
            $sql->bindParam(":Tipo"       ,$datos['Tipo']);
            $sql->bindParam(":Year"       ,$datos['Year']);
            $sql->bindParam(":Cuenta"     ,$datos['Cuenta']);
            $sql->execute();

            return $sql;

    }

    // Actualizar datos de la bitacora
    protected function updateBitacora( $codigo, $hora ) {

        $sql = self::connect()->prepare("UPDATE bitacora SET BitacoraHoraFinal = :Hora WHERE BitacoraCodigo = :Codigo ");
        $sql->bindParam(":Hora", $hora );
        $sql->bindParam(":Codigo", $codigo );
        $sql->execute();

        return $sql;

    }

    // Eliminar datos de la bitacora
    protected function deleteBitacora( $codigo ) {

        $sql = self::connect()->prepare("DELETE FROM bitacora WHERE CuentaCodigo = :Codigo; ");
        $sql->bindParam(":Codigo", $codigo );
        $sql->execute();

        return $sql;

    }


    // Metodo para encriptar contraseñas en hash
    public function encryption( $string ) {
        
        $output = false;
        $key    = hash('sha256', SECRET_KEY);
        $iv     = substr( hash('sha256', SECRET_IV), 0, 16 );
        $output = openssl_encrypt( $string, METHOD, $key, 0, $iv );
        $output = base64_encode( $output );
        return $output;

    }

    // Metodo para desencriptar contraseñas en hash
    public function dencryption( $string ) {
        
        $key    = hash('sha256', SECRET_KEY);
        $iv     = substr( hash('sha256', SECRET_IV), 0, 16 );  
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv );
        return $output;

    }

    // Generar un codigo
    protected function generateCodeRamdom( $param, $long, $number ) {

        for($i = 1; $i>= $long; $i++) {
            $num = rand(0,9);
            $param.= $num; 
        }

        return $param.$number;

    }

    // Limpia error en la entrada del texto
    protected function clearString( $string ){

        $string = trim($string);
        $string = stripslashes($string);
        $string = str_ireplace("<script>", "", $string);
        $string = str_ireplace("</script>", "", $string);
        $string = str_ireplace("<script src >", "", $string);
        $string = str_ireplace("<script type= >", "", $string);
        $string = str_ireplace("SELECT * FROM", "", $string);
        $string = str_ireplace("DELETE FROM", "", $string);
        $string = str_ireplace("INSERT INTO", "", $string);
        $string = str_ireplace("--", "", $string);
        $string = str_ireplace("^", "", $string);
        $string = str_ireplace("[", "", $string);
        $string = str_ireplace("*", "", $string);
        $string = str_ireplace("==", "", $string);
        $string = str_ireplace(";", "", $string);

        return $string;
        
    }

    // Sistema de alertas perzonalizadas
    protected function sweetAlert( $data ) {

        if( $data['Alerta'] == "simple" ) {

            $alert = "
                <script>
                swal(
                    '".$data['Title']."',
                    '".$data['Text']."',
                    '".$data['Type']."'
                )
                </script>
            ";

        } elseif( $data['Alerta'] == "reload" ) {

            $alert = "
                <script>
                swal({
                    title: '".$data['Title']."',
                    text: '".$data['Text']."',
                    icon: '".$data['Type']."',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                  }).then((result) => {
                    location.reload();
                  })
                </script>
            ";

        } elseif( $data['Alerta'] == "clear" ) {

            $alert = "
                <script>
                swal(
                    '".$data['Title']."',
                    '".$data['Text']."',
                    '".$data['Type']."'
                );
                $('.FormularioAjax')[0].reset();
                </script>
            ";

        }

        return $alert;

    }


}



























