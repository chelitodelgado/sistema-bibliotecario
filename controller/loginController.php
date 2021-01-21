<?php

if( $ajaxP ) {
    require_once("../model/loginModel.php");
}else {
    require_once("./model/loginModel.php");
}

class loginController extends loginModel {

    public function startSessionController () {

        $user = Main::clearString( $_POST['usuario'] );
        $pass = Main::clearString( $_POST['password'] );

        $pass = Main::encryption( $pass );

        $datosLogin = [
            "Usuario" => $user,
            "Clave"   => $pass
        ];

        $datosCuenta = loginModel::startSessionModel( $datosLogin );

        if( $datosCuenta->rowCount() >= 1  ) {
            $row = $datosCuenta->fetch();

            $fechaActual = date("Y-m-d");
            $yearActual  = date("Y");
            $horaActual  = date("h:i:s a");
            
            $consulta1 = Main::query("SELECT id FROM bitacora;");
            $num       = ($consulta1->rowCount())+1;
            $codeB     = Main::generateCodeRamdom( "CB", 7, $num );

            $datosBitacora = [
                "Codigo"     => $codeB,
                "Fecha"      => $fechaActual,
                "HoraInicio" => $horaActual,
                "HoraFinal"  => "Sin registro",
                "Tipo"       => $row['CuentaTipo'], 
                "Year"       => $yearActual,  
                "Cuenta"     => $row['CuentaCodigo']      
            ];

            $insertBitacora = Main::saveBitacora( $datosBitacora );
            

            if( $insertBitacora->rowCount() >= 1 ) {
                session_start(['name'=>'SBP']);

                $_SESSION['usuario_SBP']    = $row['CuentaUsuario'];
                $_SESSION['tipo_SBP']       = $row['CuentaTipo'];
                $_SESSION['privilegio_SBP'] = $row['CuentaPrivilegio'];
                $_SESSION['foto_SBP']       = $row['CuentaFoto'];
                $_SESSION['token_SBP']      = md5( uniqid(mt_rand(),true) ); //Obtener un numero unico random
                $_SESSION['codigo_SBP']     = $row['Cuentacodigo'];
                $_SESSION['codigoB_SBP']    = $codeB;

                if( $row['CuentaTipo'] == "Administrador" ){
                    $url = SERVERURL."home/";
                }else{
                    $url = SERVERURL."catalog/";
                }
                $urlLocation =  '
                    <script>    
                        window.location="'.$url.'"
                    </script>
                ';

                return $urlLocation;

            }else {
                $alert = [
                    "Alerta" => "simple",
                    "Title"  => "Ocurrio un error inesperado.",
                    "Text"   => "La session no se pudo iniciar intente nuevamente.",
                    "Type"   => "error"   
                ];
                return Main::sweetAlert($alert);
            }


        }else {
            $alert = [
                "Alerta" => "simple",
                "Title"  => "Error al iniciar sesion.",
                "Text"   => "La contraseña o usuario es incorrecta o desavilitada.",
                "Type"   => "error"   
            ];
            return Main::sweetAlert($alert);
        }

    }

    public function sessionCloseController() {

        session_start(['name'=>'SBP']);
        $token = Main::dencryption($_GET['Token']);
        $hora = date("h:i:s a");
        
        $datos  = [
            "Usuario" => $_SESSION['usuario_SBP'],
            "Token_S" => $_SESSION['token_SBP'],
            "Token"   => $token,
            "Codigo"  => $_SESSION['codigoB_SBP'],
            "Hora"    => $hora
        ];

        return loginModel::sessionCloseModel( $datos );

    }

    public function destroySessionController() {

        session_destroy();

        return header("Location:".SERVERURL."login/");
    }

}