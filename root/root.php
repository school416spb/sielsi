<?php
    session_start();/*старт сессии и проверка root*/
    
    if ($_SESSION['username']!='root'){
        header("Location:/root/");
        exit();
        }

    /*выход пользователя*/
    if (isset($_POST['exit'])) {
        unset($_SESSION['username']);
        session_destroy();
        header("Location:/root/");
        exit();
    }
?>
<!DOCTYPE html><!--Давыдов Д.Э. (с) 2021-->
<html lang="ru">
<head>
	<title>Электронная подпись документа</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
	<link rel="shortcut icon" href="../img/favicon.ico">
	<script src="https://use.fontawesome.com/dde0e1be1e.js"></script>
	
	<style>
	    .table td, .table th{
	        vertical-align: middle !important;
	    }
	</style>
	
</head>

<body>
    
<?php /*добавление новой организации*/

    if (isset($_POST['add_school'])){
        
        $school1 = htmlspecialchars($_POST['school1']);
        $school2 = htmlspecialchars($_POST['school2']);
        $school3 = htmlspecialchars($_POST['school3']);
        $director = htmlspecialchars($_POST['director']);
        $site = htmlspecialchars($_POST['site']);
        $inn = htmlspecialchars($_POST['inn']);
        $password = htmlspecialchars($_POST['password']);
        
        include('../php/cfg.php');
                
        // Create connection
        $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = 'INSERT INTO data (password, school1, school2, school3, position, name, site, inn, red, green, blue) VALUES ("'.$password.'", "'.$school1.'", "'.$school2.'", "'.$school3.'", "директор", "'.$director.'", "'.$site.'", "'.$inn.'", "0", "0", "255")';
        $result = $conn->query($sql);
        
        $conn->close();
        
        echo '<script>alert("Данные об организации успешно добавлены!");</script>';
        echo '<meta http-equiv="refresh" content="0;url=root.php">';
        
    }

?>

<?php /*обновление данных организации*/

    if (isset($_POST['update'])){
        
        $school1 = htmlspecialchars($_POST['school1']);
        $school2 = htmlspecialchars($_POST['school2']);
        $school3 = htmlspecialchars($_POST['school3']);
        $director = htmlspecialchars($_POST['director']);
        $site = htmlspecialchars($_POST['site']);
        $inn = htmlspecialchars($_POST['inn']);
        $password = htmlspecialchars($_POST['password']);
        
        $IDupdate = $_POST['update'];
        
        include('../php/cfg.php');
                
        // Create connection
        $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = 'UPDATE data SET school1="'.$school1.'", school2="'.$school2.'", school3="'.$school3.'", name="'.$director.'", site="'.$site.'", inn="'.$inn.'", password="'.$password.'" WHERE `id`="'.$IDupdate.'"';
        $result = $conn->query($sql);
        
        $conn->close();
        
        echo '<script>alert("Данные об организации успешно изменены!");</script>';
        echo '<meta http-equiv="refresh" content="0;url=root.php">';
        
    }

?>

<?php /*удаление организации*/

    if (isset($_POST['delete'])){
        
        $IDupdate = $_POST['delete'];
        
        include('../php/cfg.php');
                
        // Create connection
        $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = 'DELETE FROM data WHERE `id`="'.$IDupdate.'"';
        $result = $conn->query($sql);
        
        $conn->close();
        
        echo '<script>alert("Данные об организации успешно удалены!");</script>';
        echo '<meta http-equiv="refresh" content="0;url=root.php">';
        
    }

?>

    
        <div class="container-fluid">
        
            <div class="row">
            
                <div class="col-12"><hr></div>
            
                <div class="col-12 col-sm-6 col-md-2">
                
                    <button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#Modal">
                      <i class="fa fa-plus-circle" aria-hidden="true"></i> Добавить организацию
                    </button>
                    
                </div>
                
                <div class="col-12 col-sm-6 col-md-2">
                    <form method="POST">
                      <button type="submit" class="btn btn-outline-danger btn-block" name="exit"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</button>
                    </form>
                </div>
                
                <div class="col-12"><hr>
                
                    <?php
                    
                    if (isset($_POST['search'])) {
                        
                    $isINN = $_POST['isINN'];    
                    
                    echo '<div class="table-responsive"><h3 class="text-warning"><i class="fa fa-search" aria-hidden="true"></i> Результат поиска</h3><table class="table table-bordered table-hover table-sm" style="background: #fff;">';
                    
                    include('../php/cfg.php');
                    
                    // Create connection
                    $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
                    // Check connection
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }
                    
                    $sql = 'SELECT `id`, `school1`, `school2`, `school3`, `name`, `site`, `inn`, `password` FROM data WHERE `inn`="'.$isINN.'"';
                    $result = $conn->query($sql);
                    
                    
                    if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                    
                        echo '
                        
                        <form method="POST">
                        
                            <tr>
                            
                            <td><input value="'.htmlspecialchars($row['school1']).'" type="text" name="school1" required="" autocomplete="off" class="form-control" placeholder="Первая часть"></td>
                            <td><input value="'.htmlspecialchars($row['school2']).'" type="text" name="school2" autocomplete="off" class="form-control" placeholder="Вторая часть"></td>
                            <td><input value="'.htmlspecialchars($row['school3']).'" type="text" name="school3" autocomplete="off" class="form-control" placeholder="Третья часть"></td>
                            <td><input value="'.$row['name'].'" type="text" name="director" required="" autocomplete="off" class="form-control" placeholder="ФИО директора"></td>
                            <td><input value="'.$row['site'].'" type="text" name="site" required="" autocomplete="off" class="form-control" placeholder="Адрес сайта"></td>
                            <td><input value="'.$row['inn'].'" type="text" name="inn" required="" autocomplete="off" class="form-control" placeholder="ИНН организации"></td>
                            <td><input value="'.$row['password'].'" type="text" name="password" required="" autocomplete="off" class="form-control" placeholder="Пароль"></td>
                         
                            <td><button type="submit" value="'.$row['id'].'" class="btn btn-outline-success btn-sm btn-block" name="update"><i class="fa fa-refresh" aria-hidden="true"></i> Обновить</button></td>
                            <td><button type="submit" value="'.$row['id'].'" class="btn btn-outline-danger btn-sm btn-block" name="delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button></td>
                            
                            </tr>
                            
                        </form>
                        
                        ';
                    
                    
                      }
                    } else {
                      echo "<p class='text-danger'>нет данных...</p>";
                    }
                    $conn->close();
                    
                
                echo '</table></div>';
                
                }
                
                ?>
                
                </div>
                
                <div class="col-12 col-sm-6 col-md-8">
                    
                    <form method="POST"><input type="number" name="isINN" required="" autocomplete="off" class="form-control" placeholder="Поиск организации по ИНН" min="0">
                </div>
                
                <div class="col-12 col-sm-6 col-md-2">
                    <button type="submit" name="search" class="btn btn-outline-primary btn-block"><i class="fa fa-search" aria-hidden="true"></i> Поиск</button></form>
                </div>
                
                <div class="col-12 col-sm-6 col-md-2">
                    <a href="root.php" class="btn btn-outline-secondary btn-block"><i class="fa fa-refresh" aria-hidden="true"></i> Сброс</a>
                </div>
                
                
                <div class="col-12">
                    
                    <hr>
                
                    <h3 class="text-primary"><i class="fa fa-database" aria-hidden="true"></i> Подключенные организации</h3>
                    
                    <?php
                    
                    echo '<div class="table-responsive"><table class="table table-bordered table-hover table-sm" style="background: #fff;">
                        <tr class="text-center table-secondary">
                        <th colspan="3"><i class="fa fa-building" aria-hidden="true"></i> Наименование организации</th>
                        <th><i class="fa fa-user-circle-o" aria-hidden="true"></i> ФИО директора</th>
                        <th><i class="fa fa-globe" aria-hidden="true"></i> Адрес сайта</th>
                        <th><i class="fa fa-id-card" aria-hidden="true"></i> ИНН организации</th>
                        <th><i class="fa fa-lock" aria-hidden="true"></i> Пароль</th>
                        <th colspan="2"><i class="fa fa-cogs" aria-hidden="true"></i> Действия</th></tr>';
                    
                    include('../php/cfg.php');
                    
                    // Create connection
                    $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
                    // Check connection
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }
                    
                    $sql = "SELECT `id`, `school1`, `school2`, `school3`, `name`, `site`, `inn`, `password` FROM data";
                    $result = $conn->query($sql);
                    
                    
                    if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                    
                        echo '
                        
                        <form method="POST">
                        
                            <tr>
                            
                            <td><input value="'.htmlspecialchars($row['school1']).'" type="text" name="school1" required="" autocomplete="off" class="form-control" placeholder="Первая часть"></td>
                            <td><input value="'.htmlspecialchars($row['school2']).'" type="text" name="school2" autocomplete="off" class="form-control" placeholder="Вторая часть"></td>
                            <td><input value="'.htmlspecialchars($row['school3']).'" type="text" name="school3" autocomplete="off" class="form-control" placeholder="Третья часть"></td>
                            <td><input value="'.$row['name'].'" type="text" name="director" required="" autocomplete="off" class="form-control" placeholder="ФИО директора"></td>
                            <td><input value="'.$row['site'].'" type="text" name="site" required="" autocomplete="off" class="form-control" placeholder="Адрес сайта"></td>
                            <td><input value="'.$row['inn'].'" type="text" name="inn" required="" autocomplete="off" class="form-control" placeholder="ИНН организации"></td>
                            <td><input value="'.$row['password'].'" type="text" name="password" required="" autocomplete="off" class="form-control" placeholder="Пароль"></td>
                         
                            <td><button type="submit" value="'.$row['id'].'" class="btn btn-outline-success btn-sm btn-block" name="update"><i class="fa fa-refresh" aria-hidden="true"></i> Обновить</button></td>
                            <td><button type="submit" value="'.$row['id'].'" class="btn btn-outline-danger btn-sm btn-block" name="delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button></td>
                            
                            </tr>
                            
                        </form>
                        
                        ';
                    
                    
                      }
                    } else {
                      echo "нет данных";
                    }
                    $conn->close();
                    
                
                echo '</table></div></div>';
                
                ?>
                
            
            </div>
        
        </div>
    

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-home" aria-hidden="true"></i> Добавление организации</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form method="POST">
        
        <strong><i class="fa fa-building" aria-hidden="true"></i> Наименование:</strong>
        <input type="text" name="school1" required="" class="form-control" autocomplete="off" placeholder="Первая часть наименования" style="margin-bottom: 3px;">
        <input type="text" name="school2" class="form-control" autocomplete="off" placeholder="Вторая часть наименования" style="margin-bottom: 3px;">
        <input type="text" name="school3" class="form-control" autocomplete="off" placeholder="Третья часть наименования">
        
        <br><strong><i class="fa fa-user-circle-o" aria-hidden="true"></i> ФИО директора:</strong>
        <input type="text" name="director" required="" class="form-control" autocomplete="off" placeholder="Фамилия Имя Отчество">
        
        <br><i class="fa fa-globe" aria-hidden="true"></i> Адрес сайта:</strong>
        <input type="text" name="site" required="" class="form-control" autocomplete="off" placeholder="Адрес сайта в сети">
        
        <br><i class="fa fa-id-card" aria-hidden="true"></i> ИНН:</strong>
        <input type="text" name="inn" required="" class="form-control" autocomplete="off" placeholder="ИНН организации">
        
        <br><strong><i class="fa fa-lock" aria-hidden="true"></i> Пароль:</strong>
        <input type="text" name="password" required="" class="form-control" autocomplete="off" placeholder="Пароль для входа">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> Закрыть</button>
        <button type="submit" name="add_school" class="btn btn-outline-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
	
</body>
</html>