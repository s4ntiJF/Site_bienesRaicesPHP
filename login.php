<?php 

    $errores = [];

    require 'includes/config/database.php';
    $baseDatos = conectarBD();
    // Autentificar el usuario

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        $email = mysqli_real_escape_string($baseDatos, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string($baseDatos, $_POST['password']);

        if(!$email){
            $errores[] = "El email es obligatorio o no es válido";
        }

        if(!$password){
            $errores[] = "El Passoword es obligatorio";
        }

        if(empty($errores)){

            // Revisar si el usuario existe.
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            $resultado = mysqli_query($baseDatos, $query);

            var_dump($resultado);

            if($resultado -> num_rows){
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // var_dump($usuario['password']);

                // Verificar si el password es correcto o no

                $auth = password_verify($password, $usuario['password']);

                if($auth){
                    // El usuario esta autentificado
                    session_start();

                    // Llenar el arreglo de la sesión
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');



                } else {
                    $errores[] = "El password es incorrecta";
                }

            } else {
                $errores[] = "El Usuario no existe";
            }
        }
    }

    // Incluye el header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Inciar Sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

       <form class="formulario" method="POST" novalidate>
            <fieldset>
                <legend>Email y Password</legend>

                    <label for="email">E-mail</label>
                    <input type="email" placeholder="Tu Email" id="email" name="email">

                    <label for="password">Password</label>
                    <input type="password" placeholder="Tu Password" id="password" name="password">
            </fieldset>
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
       </form>
    </main>

<?php 
    incluirTemplate('footer');
?>