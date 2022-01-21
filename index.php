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
	<title>SIELSI &mdash; Простая электронная подпись</title>
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

                    			<p><img src="img/sign-front.jpg" alt="" class="img-fluid"></p>

					<p>
						<small class="text-secondary"><strong>SIELSI</strong> &mdash; веб-сервис простой электронной подписи PDF документов для размещения на официальном сайте ОУ</small>
					</p>
					
					<!--на время работ (при необходимости) раскоментировать надвись и закоментировать форму. Потом вернуть обратно!-->
					<!--<p class="text-danger text-uppercase">Временно ведутся работы!!!</p>-->

					<form action="" method="POST">
  						<p><input type="number" name="login" class="form-control" placeholder="ИНН организации" required="" autocomplete="off" min="0"></p>
  						<p><input type="password" name="password" class="form-control" placeholder="Пароль" required="" autocomplete="off"></p>
						<p><button type="submit" name="enter" class="btn btn-outline-success btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i> Войти</button></p>
					</form>

					<?php echo $error; ?>

                <?php include("templates/version.php") ?>

				</div>
			</div>
			
			<div class="col-12 text-center" style="margin-top: 25px;">
			    
			    <p><a href="https://github.com/school416spb/sielsi.git" target="_blank"><i class="fa fa-github" aria-hidden="true"></i> Исходный код проекта</a></p>
			    
			</div>
			
		</div>

		
		<div class="row justify-content-sm-center" style="margin-top: 15px;">
		<div class="col-12 col-sm-9 col-md-7 col-lg-5">
			 
		    <div class="alert alert-info" role="alert">
              Для подключения новой организации к сервису необходимо написать письмо по адресу 
              <strong><?php include('templates/mail.php'); ?></strong>, 
              сообщив полное наименование ОУ по уставу, ФИО директора, адрес официального школьного сайта и ИНН организации
            </div>	 
			    
		</div>
		</div
		
		
	</div>
</body>
</html>
