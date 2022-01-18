<?php /*логинизация пользователя*/
		    if (isset($_POST['enter'])) {

                $login = htmlspecialchars($_POST['login']);
                $password = htmlspecialchars($_POST['password']);
                


                include('php/cfg.php');
                
                $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
                
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT `inn` FROM data WHERE `inn`='$login' AND `password`='$password'";
                $result = $conn->query($sql);
                
                
                if ($result->num_rows > 0) {
                    
                session_start();
                    
                  while($row = $result->fetch_assoc()) {
                
                    $_SESSION['username'] = $row['inn'];
                    
                    }
                      
		            header("Location:resources/main.php");
		            exit();

                    } else {
                      $error='<div class="alert alert-danger" role="alert">Не верный логин или пароль!</div>';
                    }
                
                $conn->close();

		    }
		?>
<!DOCTYPE html><!--Давыдов Д.Э. (с) 2021-->
<html lang="ru">
<head>
	<title>Электронная подпись документа</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
	<link rel="shortcut icon" href="img/favicon.ico">
	<script src="https://use.fontawesome.com/dde0e1be1e.js"></script>
</head>

<body>
	<div class="container">
		<div class="row justify-content-sm-center">
			<div class="col-12 col-sm-9 col-md-7 col-lg-5 text-center">
				<div class="login">

                                       <!--<p><img src="img/flash.jpg" alt="" width="64"></p>
					<h3 class="text-primary text-uppercase">Электронная подпись</h3>-->

                                        <p><img src="img/sign-front.jpg" alt="" class="img-fluid"></p>

					<p>
					    <small class="text-secondary">SIELSI.RU &mdash; сервис простой электронной подписи PDF документов для размещения на официальном сайте ОУ</small>
					</p>

					<form action="" method="POST">
  						<p><input type="number" name="login" class="form-control" placeholder="ИНН организации" required="" autocomplete="off" min="0"></p>
  						<p><input type="password" name="password" class="form-control" placeholder="Пароль" required="" autocomplete="off"></p>
						<p><button type="submit" name="enter" class="btn btn-outline-success btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i> Войти</button></p>
					</form>

					<?php echo $error; ?>

                <?php include("templates/version.php") ?>

				</div>
			</div>
		</div>
	</div>
</body>
</html>
