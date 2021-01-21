<?php 

if( $ajaxP ) {
    require_once "../model/adminModel.php";
}else {
    require_once "./model/adminModel.php";
}

class adminController extends adminModel {

    // Controlador para agregar administradores
    public function addAdminController() {

        $dni         = Main::clearString($_POST['dni-reg']);
        $nombre      = Main::clearString($_POST['nombre-reg']);
        $apellido    = Main::clearString($_POST['apellido-reg']);
        $telefono    = Main::clearString($_POST['telefono-reg']);
        $direccion   = Main::clearString($_POST['direccion-reg']);

        $usuario     = Main::clearString($_POST['usuario-reg']);
        $password1   = Main::clearString($_POST['password1-reg']);
        $password2   = Main::clearString($_POST['password2-reg']);
        $email       = Main::clearString($_POST['email-reg']);
        $genero      = Main::clearString($_POST['optionsGenero']);
        $privilegio  = Main::clearString($_POST['optionsPrivilegio']);

        if($genero == "Maculino") {
            $foto = "AdminMale.png";
        }else{
            $foto = "AdminFamele.png";
        }

        if( $password1 != $password2 ) {
            
            $alert = [
                "Alerta" => "simple",
                "Title"  => "La contraseña es igcorrecta.",
                "Text"   => "Las contraseñas no coinsiden.",
                "Type"   => "error"   
            ];
        }else{
            $consult1 = Main::query("SELECT AdminDNI  FROM admin WHERE AdminDNI = '$dni';");
            if( $consult1->rowCount() >= 1 ) {
                $alert = [
                    "Alerta" => "simple",
                    "Title"  => "Ocurrio un error inesperado.",
                    "Text"   => "El DNI ingresado ya exites en el sistema.",
                    "Type"   => "error"   
                ];
            }else {
                if( $email != "" ) {
                    $consult2 = Main::query("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail = '$email';");
                    $ec = $consult2->rowCount();
                }else {
                    $ec = 0;
                }

                if( $ec>=1 ) {
                    $alert = [
                        "Alerta" => "simple",
                        "Title"  => "Ocurrio un error inesperado",
                        "Text"   => "El Email ingresado ya exites en el sistema.",
                        "Type"   => "error"   
                    ];
                }else {
                    $consult3 = Main::query("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario = '$usuario';");
                    if( $consult3->rowCount() >= 1) {
                        $alert = [
                            "Alerta" => "simple",
                            "Title"  => "Ocurrio un error inesperado",
                            "Text"   => "El Usuario ingresado ya exites en el sistema.",
                            "Type"   => "error"   
                        ];
                    }else {
                        $consult4 = Main::query("SELECT id FROM cuenta;");
                        $num = ( $consult4->rowCount() ) + 1;

                        $codigo = Main::generateCodeRamdom("AC", 7, $num);
                        $clave  = Main::encryption($password1 );
                        $dataAC = [
                            "Codigo"     => $codigo,
                            "Privilegio" => $privilegio,
                            "Usuario"    => $usuario,
                            "Clave"      => $clave,
                            "Email"      => $email,
                            "Estado"     => "Activo",
                            "Tipo"       => "Administrador",
                            "Genero"     => $genero,
                            "Foto"       => $foto,
                        ];

                        $saveCuenta = Main::addCuenta( $dataAC );
                        if( $saveCuenta->rowCount() >= 1 ) {
                            $dataAD = [
                                "DNI"       => $dni,
                                "Nombre"    => $nombre,
                                "Apellido"  => $apellido,
                                "Telefono"  => $telefono,
                                "Direccion" => $direccion,
                                "Codigo"    => $codigo,
                            ];

                            $saveAdmin = adminModel::addAdminModel( $dataAD );

                            if( $saveAdmin->rowCount() >= 1 ) {
                                $alert = [
                                    "Alerta" => "clear",
                                    "Title"  => "Registro correcto",
                                    "Text"   => "La cuenta se agrego correctamente.",
                                    "Type"   => "success"   
                                ];
                            }else {
                                Main::deleteCuenta( $codigo );
                                $alert = [
                                    "Alerta" => "simple",
                                    "Title"  => "Ocurrio un error inesperado",
                                    "Text"   => "La cuenta de administrador ingresado ya exites en el sistema.",
                                    "Type"   => "error"   
                                ];
                            }

                        }else {
                            $alert = [
                                "Alerta" => "simple",
                                "Title"  => "Ocurrio un error inesperado",
                                "Text"   => "La cuenta no se pudo registrar.",
                                "Type"   => "error"   
                            ];
                        }   

                    }
                }

            }
        }

        return Main::sweetAlert( $alert );

    }

    // Sistema de paginación
    public function paginadorAdminController( $pag, $reg, $role, $code ) {
        
        $pag   = Main::clearString($pag);
        $reg   = Main::clearString($reg);
        $role  = Main::clearString($role);
        $code  = Main::clearString($code);
        $tabla = "";

        $pag   = ( isset($pag) && $pag > 0 ) ? (int) $pag : 1 ;
        $index = ( $pag > 0) ? ( ($pag * $reg) - $reg ) : 0 ;

        $conn  = Main::connect();
        $query = $conn->query("
            SELECT SQL_CALC_FOUND_ROWS * FROM admin 
                WHERE CuentaCodigo != '$code' 
                    AND id != 1 ORDER BY AdminNombre ASC LIMIT $index,$reg 
        ");

        $query = $query->fetchAll();

        $total = $conn->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $nPag = ceil( ($total/$reg) );

        return $tabla;
    }




}

