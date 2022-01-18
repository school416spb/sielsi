<?php
	/*проверка сессии пользователя*/
	session_start();
	
	$user = $_SESSION['username'];

    if (empty($_SESSION['username'])){
        header("Location:/");
        exit();
    }
    
    /*закрытие сессии*/
    if (isset($_POST['exit'])){
        unset($_SESSION['username']);
        session_destroy();
        header("Location:/");
        exit();
    }
?>
<?php /*обновление данных организации*/

    if (isset($_POST['save'])){
        
        $director = htmlspecialchars($_POST['director']);
        $address = htmlspecialchars($_POST['address']);
        
        include('../php/cfg.php');
                
        // Create connection
        $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = 'UPDATE data SET name="'.$director.'", site="'.$address.'" WHERE `inn`="'.$user.'"';
        $result = $conn->query($sql);
        
        $conn->close();
        
        echo '<script>alert("Данные об организации успешно изменены!");</script>';
        echo '<meta http-equiv="refresh" content="0;url=main.php">';
        
    }

?>
<!DOCTYPE html><!--Давыдов Д.Э. (с) 2021-->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Простая электронная подпись</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="shortcut icon" href="../img/favicon.ico">
    <script src="https://use.fontawesome.com/dde0e1be1e.js"></script>
</head>
<body>
    
    <div class="container">

        <div class="row">
            
            <div class="col-12">
                <h1 class="text-primary">П<span class="text-secondary">ростая</span> Э<span class="text-secondary">лектронная</span> П<span class="text-secondary">одпись</span></h1>
            </div>
            
<div class="col-12">
                
<div class="accordion" id="accordionExample">
    
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <i class="fa fa-pencil" aria-hidden="true"></i> Подпись PDF документа
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        
        <form action="../script/sign.php" method="POST" enctype="multipart/form-data">

            <p><input type="file" name="filename" class="form-control-file" accept="application/pdf" required=""></p>
            
            <hr>
            
            <?php include("../templates/position.php"); ?>
            
            <hr>
            
            <!--Дата в момент подписи-->
            <p class="text-secondary">Дата и время подписи:</p>
            <p>
                <input type="date" name="date" required="" class="form-control" value="<?php echo date('Y-m-d'); ?>" style="margin-bottom: 3px;">
                <input type="time" name="time" required="" class="form-control" value="<?php echo date('H:i'); ?>">
            </p>
            
            <hr>
            
            <p>
		<button type="submit" name="upload" class="btn btn-outline-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Подписать</button> 
		<button type="reset" name="clear" class="btn btn-outline-primary btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cброс</button>
		<a href="main.php" class="btn btn-outline-secondary btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> Обновить</a>
	    </p>

        </form>
        
        <form method="POST">
            <button type="submit" class="btn btn-outline-danger" name="exit">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Выход
            </button>
        </form>
        
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <i class="fa fa-info-circle" aria-hidden="true"></i> Сведения
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
          
        <?php
        include('../php/cfg.php');
        
        // Create connection
        $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT `school1`, `school2`, `school3`, `name`, `site`, `inn` FROM data WHERE `inn`=$user";
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
        
        
        echo '<p><strong><i class="fa fa-home" aria-hidden="true"></i> ОУ:</strong> ' , "".$row['school1']."", " ".$row['school2']."", " ".$row['school3']."", "<br>";
        echo '<strong><i class="fa fa-user" aria-hidden="true"></i> Директор:</strong> ', "".$row['name']."", "<br>";
        echo '<strong><i class="fa fa-globe" aria-hidden="true"></i> Сайт:</strong> <a href="'.$row['site'].'" target="_blank">', "".$row['site']."", "</a><br>";
        echo '<strong><i class="fa fa-id-card-o" aria-hidden="true"></i> ИНН: </strong>', "".$row['inn']."", '</p>';
        
        echo '<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#Modal"><i class="fa fa-database" aria-hidden="true"></i> Изменить сведения</button>';
        
          }
        } else {
          echo "нет данных";
        }
        $conn->close();
        ?>
        
        <?php include("../templates/about.php"); ?>

      </div>
    </div>
  </div>
  
  
    <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          <i class="fa fa-cogs" aria-hidden="true"></i> Настройки
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        
        <strong><i class="fa fa-paint-brush" aria-hidden="true"></i> Цвет печати: </strong> 
        
        <?php
        include('../php/cfg.php');
        
        // Create connection
        $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        
        $sql = "SELECT `red`, `green`, `blue` FROM data WHERE `inn`=$user";
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
        
        
        echo "".$row['red']."", ", ".$row['green']."",  ", ".$row['blue']."";
        
        echo '<div class="stamp" style="background: rgba('.$row['red'].','.$row['green'].','.$row['blue'].',1);"></div>';
        
          }
        } else {
          echo "нет данных";
        }
        $conn->close();
        
        ?>
        
        <?php /*обновление цвета печати*/
        
        if(isset($_POST['new_color'])){
        
            include('../php/cfg.php');
            
            // Create connection
            $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            
            $red = $_POST['red'];
            $green = $_POST['green'];
            $blue = $_POST['blue'];
            
            $sql = "UPDATE data SET red=$red, green=$green, blue=$blue WHERE `inn`=$user";
            
            if ($conn->query($sql) === TRUE) {
                echo '<script>alert("Цвет печати успешно обновлен!");</script>';
            } else {
                echo "Ошибка: " . $conn->error;
            }
            
            $conn->close();
            
            echo '<meta http-equiv="refresh" content="0; url=main.php">';
            
        }
        ?>
        
        <hr>
        <form action="" method="POST">
            <input type="number" name="red" required="" placeholder="Red" min="0" max="255">
            <input type="number" name="green" required="" placeholder="Green" min="0" max="255">
            <input type="number" name="blue" required="" placeholder="Blue" min="0" max="255">
            <button type="submit" name="new_color" class="btn btn-outline-success btn-sm" style="margin-top: -5px;"><i class="fa fa-refresh" aria-hidden="true"></i> Обновить</button>
        </form>
        
      </div>
    </div>
  </div>


</div>

</div>

    <div class="col-12 text-center text-secondary">
        <p class="footer"><small>2021 &copy; Давыдов Д.Э.
        <a href="mailto:davydov@school416spb.ru">davydov@school416spb.ru</a><br>
        создано на базе свободных библиотек <a href="http://www.fpdf.org/" target="_blank">FPDF</a> и <a href="https://www.setasign.com/products/fpdi/about/" target="_blank">FPDI</a></small>
        </p>
    </div>

</div>
</div>

    <?php include("../templates/modal.php"); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
