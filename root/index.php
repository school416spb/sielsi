<?php /*логинизация пользователя*/
    if (isset($_POST['enter'])) {

        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        
        if (($login=='root')&&($password=='12345678')){
            session_start();
            $_SESSION['username'] = 'root';
            header('Location:root.php');
            exit();
        }else {
              $error='<div class="alert alert-danger" role="alert">Неверный логин или пароль!</div>';
            }
        

    }
?>
<!DOCTYPE html><!--Давыдов Д.Э. (с) 2021-->
<html lang="ru">
<head>
	<title>Вход администратора</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
	<link rel="shortcut icon" href="../img/favicon.ico">
	<script src="https://use.fontawesome.com/dde0e1be1e.js"></script>
</head>

<body>
    

   <div class="container">
		<div class="row justify-content-sm-center">
			<div class="col-12 col-sm-9 col-md-7 col-lg-5 text-center">
				<div class="login">

                    <p><img src="../img/flash.jpg" alt="" width="64"></p>

					<h3 class="text-primary text-uppercase">Электронная подпись</h3>

					<p>
						<small class="text-secondary">вход для администратора</small>
					</p>

					<form action="" method="POST">
  						<p><input type="text" name="login" class="form-control" placeholder="Логин" required="" autocomplete="off"></p>
  						<p><input type="password" name="password" class="form-control" placeholder="Пароль" required="" autocomplete="off"></p>
						<p><button type="submit" name="enter" class="btn btn-outline-success btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i> Войти</button></p>
					</form>

					<?php echo $error; ?>

                    <?php include("../templates/version.php"); ?>

			</div>
			</div>
		</div>
	</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
	
</body>
</html>
