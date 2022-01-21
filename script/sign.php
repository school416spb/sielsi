<?php

/*Давыдов Д.Э. (с) 2021*/

header('Content-Type: text/html; charset=utf-8');

/*проверка сессии пользователя*/
	session_start();
	
	$user = $_SESSION['username'];

    if (empty($_SESSION['username'])){
        header("Location:/");
        exit();
    }

    if(is_uploaded_file($_FILES["filename"]["tmp_name"])){
    
        //загрузка и перемещение файла для подписи
        move_uploaded_file($_FILES["filename"]["tmp_name"], "../tmp/".$_FILES["filename"]["name"]);
        
        $ext = pathinfo("../tmp/".$_FILES["filename"]["name"], PATHINFO_EXTENSION);
        
        if ($ext != "pdf"){
            if ($ext != "PDF"){
                unlink ("../tmp/".$_FILES["filename"]["name"]);
                echo '<script>alert("Не верный формат файла! Используйте PDF!");</script>';
                echo '<meta http-equiv="refresh" content="0;url=../resources/main.php">';
            }
        }
    }

//подключение шрифтов
define('FPDF_FONTPATH',"../library/fpdf/font/");

require_once('../library/fpdf/fpdf.php');
require_once('../library/fpdi/src/autoload.php');

use \setasign\Fpdi\Fpdi;

$firstPage=1;

/*чтение данных из БД*/
include('../php/cfg.php');

// Create connection
$conn = new mysqli($server_name, $db_user, $db_password, $db_name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `id`, `school1`, `school2`, `school3`, `position`, `name`, `site`, `inn`, `red`, `green`, `blue` FROM data WHERE `inn`=$user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

$id=$row['id'];
$school1=$row['school1'];
$school2=$row['school2'];
$school3=$row['school3'];
$position=$row['position'];
$name=$row['name'];
$site=$row['site'];
$inn=$row['inn'];
$red=$row['red'];
$green=$row['green'];
$blue=$row['blue'];

  }
}
$conn->close();

//позиция отрисовки
$select = $_POST['select'];

//ориентация листа документа
$orient = $_POST['orient'];

//количество штампов
$whereIS = $_POST['whereIS'];

//получение даты и времени подписания
$date = date('d.m.Y', strtotime($_POST["date"]));
$time = $_POST["time"];

$IsDateTime = $date." ".$time;

//генерация уникального ключа ОУ-время unix-ГодМесяцДень-НомерДнявГоду-НомерНедели-ЧасыМинуты-Секунды
$key=$inn."-".$id."-".time().date("-Ymd-z-w-Hi-s");

$pdf = new FPDI();

//импорт исходного файла pdf
try{
    //Попытка открыть PDF-файл
    $pageCount = $pdf->setSourceFile("../tmp/".$_FILES["filename"]["name"]);
    if($pageCount === false){
        throw new Exception('Невозможно импортировать PDF-файл!');
    } else $pageCount = $pdf->setSourceFile("../tmp/".$_FILES["filename"]["name"]);
}

//Перехватываем ошибку и выводим пользователю
catch (Exception $ex) {
    unlink("../tmp/".$_FILES["filename"]["name"]);
    echo '<p style="text-align: center;"><img src="../img/error.gif" alt="" width="128"></p>
          <p style="text-align: center; font-size: 24px; color: #f00;"><strong>Подписываются документы исключительно формата PDF/A (PDF версии 1.4)</strong></p>
          <p style="text-align: center; font-size: 24px; color: #f00;">Рекомендуем для экспорта в PDF использовать редакторы 
          <a href="https://www.libreoffice.org/download/download/?lang=ru" target="_blank">LibreOffice</a> или 
          <a href="https://www.onlyoffice.com/ru/download-desktop.aspx?affChecked=1" target="_blank">OnlyOffice</a></p>
          <hr>
          <p style="text-align: center; font-size: 24px;"><a href="../resources/main.php">Вернуться назад</a></p>
          <hr>
          <p style="text-align: center;"><small>2021 &copy; Давыдов Д.Э.</small></p>';
}

for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {

    $templateId = $pdf->importPage($pageNo);
    $size = $pdf->getTemplateSize($templateId);

    if ($size[0] > $size[1]) {
        $pdf->AddPage('L', array($size[0], $size[1]));
    } else {
        $pdf->AddPage('P', array($size[0], $size[1]));
    }

    $pdf->useTemplate($templateId);

    /*отрисовка только на первом листе*/
    if (($firstPage==1)&&($whereIS==1)){
        
        //отрисовка полей штампа и его размеры
        $pdf->SetDrawColor($red,$green,$blue);
        
        /*отрисовка книжная*/
        if ($orient==1){
        
            if ($select == "left-1"){
                $pdf->Rect(10, 10, 87, 39);
                $x = 12; 
            } elseif ($select == "center-1"){
                $pdf->Rect(60, 10, 87, 39);
                $x = 62;
            } elseif (($select == "right-1")) {
                $pdf->Rect(112, 10, 87, 39);
                $x = 114;
            } elseif (($select == "left-2")) {
                $pdf->Rect(10, 85, 87, 39);
                $x = 12;
                $pdf->SetY(85);
            } elseif (($select == "center-2")) {
                $pdf->Rect(60, 85, 87, 39);
                $x = 62;
                $pdf->SetY(85);
            } elseif (($select == "right-2")) {
                $pdf->Rect(112, 85, 87, 39);
                $x = 114;
                $pdf->SetY(85);
            } elseif (($select == "left-3")) {
                $pdf->Rect(10, 150, 87, 38);
                $x = 12;
                $pdf->SetY(150);
            } elseif (($select == "center-3")) {
                $pdf->Rect(60, 150, 87, 38);
                $x = 62;
                $pdf->SetY(150);
            } elseif (($select == "right-3")) {
                $pdf->Rect(112, 150, 87, 39);
                $x = 114;
                $pdf->SetY(150);
            } elseif (($select == "left-4")) {
                $pdf->Rect(10, 205, 87, 39);
                $x = 12;
                $pdf->SetY(205);
            } elseif (($select == "center-4")) {
                $pdf->Rect(60, 205, 87, 39);
                $x = 62;
                $pdf->SetY(205);
            } elseif (($select == "right-4")) {
                $pdf->Rect(112, 205, 87, 39);
                $x = 114;
                $pdf->SetY(205);
            }
            
            //подключение шрифтов
            $pdf->AddFont('Liberation Bold','','liberation-serif.bold.php'); 
            $pdf->SetFont('Liberation Bold','',10);
            
            //цвет текста на штампе
            $pdf->SetTextColor($red,$green,$blue);
        
            //вывод информации на штамп = название, подписано, дата и время, должность, ФИО, ключ
            $pdf->SetX($x);
            $pdf->Write(7,iconv('utf-8', 'windows-1251', $school1));
        
            $pdf->SetX($x);
            $pdf->Write(14, iconv('utf-8', 'windows-1251', $school2));
            
            $pdf->SetX($x);
            $pdf->Write(21, iconv('utf-8', 'windows-1251', $school3));
        
            $pdf->SetX($x);
            $pdf->Write(32, iconv('utf-8', 'windows-1251',"Подписано электронной подписью"));
            
            //дата и время подписания
            $pdf->SetX($x);
            $pdf->Write(41, $IsDateTime);
        
            $pdf->SetX($x);
            $pdf->Write(51, iconv('utf-8', 'windows-1251',$position));
        
            //отрисовка линии под подпись
            /*$pdf->SetX($x);
            $pdf->Line($x,38,$x+23,38);*/
        
            $pdf->SetX($x);
            $pdf->Write(61, iconv('utf-8', 'windows-1251',$name));
        
            //вывод изображения факсимилье
            /*$pdf->Image('../img/sign.png',$x,30,-600);*/
        
            //установка ссылки для ключа
            $pdf->SetX($x);
            $pdf->Write(70, $key, $site);
        
        } elseif($orient==2) { /*отрисовка альбомная*/
            
            if ($select == "left-1"){
                $pdf->Rect(10, 10, 87, 39);
                $x = 12; 
            } elseif ($select == "center-1"){
                $pdf->Rect(110, 10, 87, 39);
                $x = 112;
            } elseif (($select == "right-1")) {
                $pdf->Rect(190, 10, 87, 39);
                $x = 192;
            } elseif (($select == "left-2")) {
                $pdf->Rect(10, 55, 87, 39);
                $x = 12;
                $pdf->SetY(55);
            } elseif (($select == "center-2")) {
                $pdf->Rect(110, 55, 87, 39);
                $x = 112;
                $pdf->SetY(55);
            } elseif (($select == "right-2")) {
                $pdf->Rect(190, 55, 87, 39);
                $x = 192;
                $pdf->SetY(55);
            } elseif (($select == "left-3")) {
                $pdf->Rect(10, 100, 87, 38);
                $x = 12;
                $pdf->SetY(100);
            } elseif (($select == "center-3")) {
                $pdf->Rect(110, 100, 87, 38);
                $x = 112;
                $pdf->SetY(100);
            } elseif (($select == "right-3")) {
                $pdf->Rect(190, 100, 87, 39);
                $x = 192;
                $pdf->SetY(100);
            } elseif (($select == "left-4")) {
                $pdf->Rect(10, 120, 87, 39);
                $x = 12;
                $pdf->SetY(120);
            } elseif (($select == "center-4")) {
                $pdf->Rect(110, 120, 87, 39);
                $x = 112;
                $pdf->SetY(120);
            } elseif (($select == "right-4")) {
                $pdf->Rect(190, 120, 87, 39);
                $x = 192;
                $pdf->SetY(120);
            }
            
            //подключение шрифтов
            $pdf->AddFont('Liberation Bold','','liberation-serif.bold.php'); 
            $pdf->SetFont('Liberation Bold','',10);
            
            //цвет текста на штампе
            $pdf->SetTextColor($red,$green,$blue);
        
            //вывод информации на штамп = название, подписано, дата и время, должность, ФИО, ключ
            $pdf->SetX($x);
            $pdf->Write(7,iconv('utf-8', 'windows-1251', $school1));
        
            $pdf->SetX($x);
            $pdf->Write(14, iconv('utf-8', 'windows-1251', $school2));
            
            $pdf->SetX($x);
            $pdf->Write(21, iconv('utf-8', 'windows-1251', $school3));
        
            $pdf->SetX($x);
            $pdf->Write(32, iconv('utf-8', 'windows-1251',"Подписано электронной подписью"));
            
            //дата и время подписания
            $pdf->SetX($x);
            $pdf->Write(41, $IsDateTime);
        
            $pdf->SetX($x);
            $pdf->Write(51, iconv('utf-8', 'windows-1251',$position));
        
            //отрисовка линии под подпись
            /*$pdf->SetX($x);
            $pdf->Line($x,38,$x+23,38);*/
        
            $pdf->SetX($x);
            $pdf->Write(61, iconv('utf-8', 'windows-1251',$name));
        
            //вывод изображения факсимилье
            /*$pdf->Image('../img/sign.png',$x,30,-600);*/
        
            //установка ссылки для ключа
            $pdf->SetX($x);
            $pdf->Write(70, $key, $site);
            
        }

    } elseif ($whereIS==2) { /*отрисовка на всех страницах документа*/
        
        //отрисовка полей штампа и его размеры
        $pdf->SetDrawColor($red,$green,$blue);
        
        /*отрисовка книжная*/
        if ($orient==1){
        
            if ($select == "left-1"){
                $pdf->Rect(10, 10, 87, 39);
                $x = 12; 
            } elseif ($select == "center-1"){
                $pdf->Rect(60, 10, 87, 39);
                $x = 62;
            } elseif (($select == "right-1")) {
                $pdf->Rect(112, 10, 87, 39);
                $x = 114;
            } elseif (($select == "left-2")) {
                $pdf->Rect(10, 85, 87, 39);
                $x = 12;
                $pdf->SetY(85);
            } elseif (($select == "center-2")) {
                $pdf->Rect(60, 85, 87, 39);
                $x = 62;
                $pdf->SetY(85);
            } elseif (($select == "right-2")) {
                $pdf->Rect(112, 85, 87, 39);
                $x = 114;
                $pdf->SetY(85);
            } elseif (($select == "left-3")) {
                $pdf->Rect(10, 150, 87, 38);
                $x = 12;
                $pdf->SetY(150);
            } elseif (($select == "center-3")) {
                $pdf->Rect(60, 150, 87, 38);
                $x = 62;
                $pdf->SetY(150);
            } elseif (($select == "right-3")) {
                $pdf->Rect(112, 150, 87, 39);
                $x = 114;
                $pdf->SetY(150);
            } elseif (($select == "left-4")) {
                $pdf->Rect(10, 205, 87, 39);
                $x = 12;
                $pdf->SetY(205);
            } elseif (($select == "center-4")) {
                $pdf->Rect(60, 205, 87, 39);
                $x = 62;
                $pdf->SetY(205);
            } elseif (($select == "right-4")) {
                $pdf->Rect(112, 205, 87, 39);
                $x = 114;
                $pdf->SetY(205);
            }
            
            //подключение шрифтов
            $pdf->AddFont('Liberation Bold','','liberation-serif.bold.php'); 
            $pdf->SetFont('Liberation Bold','',10);
            
            //цвет текста на штампе
            $pdf->SetTextColor($red,$green,$blue);
        
            //вывод информации на штамп = название, подписано, дата и время, должность, ФИО, ключ
            $pdf->SetX($x);
            $pdf->Write(7,iconv('utf-8', 'windows-1251', $school1));
        
            $pdf->SetX($x);
            $pdf->Write(14, iconv('utf-8', 'windows-1251', $school2));
            
            $pdf->SetX($x);
            $pdf->Write(21, iconv('utf-8', 'windows-1251', $school3));
        
            $pdf->SetX($x);
            $pdf->Write(32, iconv('utf-8', 'windows-1251',"Подписано электронной подписью"));
            
            //дата и время подписания
            $pdf->SetX($x);
            $pdf->Write(41, $IsDateTime);
        
            $pdf->SetX($x);
            $pdf->Write(51, iconv('utf-8', 'windows-1251',$position));
        
            //отрисовка линии под подпись
            /*$pdf->SetX($x);
            $pdf->Line($x,38,$x+23,38);*/
        
            $pdf->SetX($x);
            $pdf->Write(61, iconv('utf-8', 'windows-1251',$name));
        
            //вывод изображения факсимилье
            /*$pdf->Image('../img/sign.png',$x,30,-600);*/
        
            //установка ссылки для ключа
            $pdf->SetX($x);
            $pdf->Write(70, $key, $site);
        
        } elseif($orient==2) { /*отрисовка альбомная*/
            
            if ($select == "left-1"){
                $pdf->Rect(10, 10, 87, 39);
                $x = 12; 
            } elseif ($select == "center-1"){
                $pdf->Rect(110, 10, 87, 39);
                $x = 112;
            } elseif (($select == "right-1")) {
                $pdf->Rect(190, 10, 87, 39);
                $x = 192;
            } elseif (($select == "left-2")) {
                $pdf->Rect(10, 55, 87, 39);
                $x = 12;
                $pdf->SetY(55);
            } elseif (($select == "center-2")) {
                $pdf->Rect(110, 55, 87, 39);
                $x = 112;
                $pdf->SetY(55);
            } elseif (($select == "right-2")) {
                $pdf->Rect(190, 55, 87, 39);
                $x = 192;
                $pdf->SetY(55);
            } elseif (($select == "left-3")) {
                $pdf->Rect(10, 100, 87, 38);
                $x = 12;
                $pdf->SetY(100);
            } elseif (($select == "center-3")) {
                $pdf->Rect(110, 100, 87, 38);
                $x = 112;
                $pdf->SetY(100);
            } elseif (($select == "right-3")) {
                $pdf->Rect(190, 100, 87, 39);
                $x = 192;
                $pdf->SetY(100);
            } elseif (($select == "left-4")) {
                $pdf->Rect(10, 120, 87, 39);
                $x = 12;
                $pdf->SetY(120);
            } elseif (($select == "center-4")) {
                $pdf->Rect(110, 120, 87, 39);
                $x = 112;
                $pdf->SetY(120);
            } elseif (($select == "right-4")) {
                $pdf->Rect(190, 120, 87, 39);
                $x = 192;
                $pdf->SetY(120);
            }
            
            //подключение шрифтов
            $pdf->AddFont('Liberation Bold','','liberation-serif.bold.php'); 
            $pdf->SetFont('Liberation Bold','',10);
            
            //цвет текста на штампе
            $pdf->SetTextColor($red,$green,$blue);
        
            //вывод информации на штамп = название, подписано, дата и время, должность, ФИО, ключ
            $pdf->SetX($x);
            $pdf->Write(7,iconv('utf-8', 'windows-1251', $school1));
        
            $pdf->SetX($x);
            $pdf->Write(14, iconv('utf-8', 'windows-1251', $school2));
            
            $pdf->SetX($x);
            $pdf->Write(21, iconv('utf-8', 'windows-1251', $school3));
        
            $pdf->SetX($x);
            $pdf->Write(32, iconv('utf-8', 'windows-1251',"Подписано электронной подписью"));
            
            //дата и время подписания
            $pdf->SetX($x);
            $pdf->Write(41, $IsDateTime);
        
            $pdf->SetX($x);
            $pdf->Write(51, iconv('utf-8', 'windows-1251',$position));
        
            //отрисовка линии под подпись
            /*$pdf->SetX($x);
            $pdf->Line($x,38,$x+23,38);*/
        
            $pdf->SetX($x);
            $pdf->Write(61, iconv('utf-8', 'windows-1251',$name));
        
            //вывод изображения факсимилье
            /*$pdf->Image('../img/sign.png',$x,30,-600);*/
        
            //установка ссылки для ключа
            $pdf->SetX($x);
            $pdf->Write(70, $key, $site);
            
        }
        
    }

    $firstPage++;
}


//вывод результирующего файла
$pdf->Output();

//удаление импортируемого исходного файла
unlink("../tmp/".$_FILES["filename"]["name"]);

?>
