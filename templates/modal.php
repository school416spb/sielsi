<!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-database" aria-hidden="true"></i> Изменение данных организации</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
            <?php
                include('../php/cfg.php');
                
                // Create connection
                $conn = new mysqli($server_name, $db_user, $db_password, $db_name);
                // Check connection
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT `name`, `site` FROM data WHERE `inn`=$user";
                $result = $conn->query($sql);
                
                
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                
                    echo '
                    
                    <form method="POST">
                        <strong><i class="fa fa-user" aria-hidden="true"></i> ФИО директора:</strong>
                        <input value="'.$row['name'].'" type="text" name="director" required="" autocomplete="off" class="form-control" placeholder="ФИО директора"><br>
                        <strong><i class="fa fa-globe" aria-hidden="true"></i> Адрес сайта:</strong>
                        <input value="'.$row['site'].'" type="text" name="address" required="" autocomplete="off" class="form-control" placeholder="Адрес сайта">
                        
                        <br><div class="alert alert-warning" role="alert">
                          Для изменения наименования ОУ, ИНН и пароля обратитесь к Администратору системы!<br>
                          <strong><i class="fa fa-envelope-o" aria-hidden="true"></i> Почта: '; 
                        
                        include('../templates/mail.php');
                        
                        echo '</strong></div>
                        
                      </div>
                      
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> Закрыть</button>
                        <button type="submit" class="btn btn-outline-success btn-sm" name="save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить</button>
                    </form>
                    
                    ';
                
                
                  }
                } else {
                  echo "нет данных";
                }
                $conn->close();
                ?>
              
          </div>
        </div>
      </div>
    </div>