<?php
//Llamada al modelo
require_once("models/usuarios_model.php");


class usuarios_controller {

/**
 * Muestra pantalla 'add'
 * @return No
 */
function add() {
  require_once("views/usuarios_add.phtml");
}



/**
 * Inserta a la taula
 * @return No
 */
function insert() {
    $usuarios=new usuarios_model();

    if (isset($_POST['insert'])) {
        $usuarios->setUsername( $_POST['username'] );
        $usuarios->setPassword( $_POST['password'] );
        $usuarios->setName( $_POST['name'] );
        $usuarios->setEmail( $_POST['email'] );
        $usuarios->setDireccion( $_POST['direccion'] );
        $usuarios->setCp( $_POST['cp'] );

        $error = $usuarios->insertar();

        if (!$error) {
          $usuario = $_POST['name'];
          $usuarios = new usuarios_model();
          $usuarios->setUsername( $usuario );

          $error = $usuarios->buscar_usuarios();
          if ($error) {
            $_SESSION['name'] = $usuario;
            echo "usuario existente"; exit;
          }else {
            header( "Location: index.php?controller=usuarios&action=add");

          }


        }
        else {
            echo $error;
        }
    }
}


function login(){
$usuario = $_POST['name'];
$password = $_POST['pswd'];

$usuarios = new usuarios_model();

$usuarios->setUsername( $usuario );
$usuarios->setPassword( $password );

$_SESSION["usuario"] = $usuario;


$error = $usuarios->buscar_usuarios();

if ($error) {
  $_SESSION['name'] = $usuario;
  header('location: index.php?controller=productos&action=view');

}
else {

echo "FALLO  al iniciar sesion";
  header('location: index.php?controller=usuarios&action=add');

}
}

function logout() {

session_start();
session_unset();
session_destroy();
header('location: index.php');
}

public function buscar_usuarios(){
  $user=new usuarios_model();

    $usuarioUtilizando=$user->buscar_usuarios();
}

}
?>
