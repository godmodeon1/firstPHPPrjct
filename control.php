<?php 

function connectSQL() {
    global $host, $user, $password, $db_name, $link;
        	//Устанавливаем доступы к базе данных:
    $host = 'localhost'; //имя хоста, на локальном компьютере это localhost
    $user = 'root'; //имя пользователя, по умолчанию это root
    $password = 'root'; //пароль, по умолчанию пустой or root
    $db_name = 'news'; //имя базы данных

//Соединяемся с базой данных используя наши доступы:
    $link = mysqli_connect($host, $user, $password, $db_name);

//Соединение записывается в переменную $link, которая используется дальше для работы mysqi_query.

//Устанавливаем кодировку (не обязательно, но поможет избежать проблем):
    mysqli_query($link, "SET NAMES 'utf8'");
}
connectSQL();        

function getParams() {
    global $page, $id;
    $page = $_GET["page"]; //Получаем номер страницы по клику
    $id = $_GET["id"]; //Получаем ID
}
getParams();

//Формируем запрос:
$query = "SELECT * FROM `news` ORDER BY `idate`";
$queryArticle = "SELECT * FROM `news` WHERE id = $id";

function requestSQL($request) {
    global $result, $link, $data, $row, $query, $queryArticle;
    //Делаем запрос к БД, результат запроса пишем в $result:
    $result = mysqli_query($link, $request) or die(mysqli_error($link));

    //Проверяем что же нам отдала база данных, если null – то какие-то проблемы:
    //var_dump($result);

    //Преобразуем то, что отдала нам база в нормальный массив PHP $data:
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);           

}

function viewFirstPage() {
    global $page, $id;
    if (!$page and !$id) {
        $page = 1;
    }
}
viewFirstPage();

function getArticleRange() {
    global $articleRangeEnd, $articleRangeStart, $page;
    //Получаем диапазон статей для вывода
    $articleRangeEnd = $page * 5;
    $articleRangeStart = $articleRangeEnd - 4;
}

function countRowsSQL() {
    global $new, $result, $num_rows, $numOfPages;
    $new = $result->num_rows; // Получем число записей в БД
    $numOfPages = ceil($new/5); // считаем количество страниц
}

function makeBtns() {
    echo "<hr><p><strong>Страницы:</strong></p>";
    global $numOfPages, $page;
    for ( $i = 1; $i <= $numOfPages; $i++ ) {
        // Для окраски нажатой кнопки
        if ($page == $i) {
            $div = "<div class='pageBtn pageBtnPshd'>";
        } else {
            $div = "<div class='pageBtn'>";
        }
        // выводим кнопки
    echo $div . "<a href='index.php?page=". $i . "'>". $i . "</a></div>";
    }
}

function getDataFromArr($type) {
    global $result, $link, $row, $query, $queryArticle, $articleRangeStart, $articleRangeEnd;                
    
    if ($type == "article") {$query = $queryArticle;}

    // извлечение ассоциативного массива
    if ($result = mysqli_query($link, $query)) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $i++;
            if ($type == "all") {
                
                if ($i >= $articleRangeStart and $i <= $articleRangeEnd) {
                    echo "<span class='date'>" . date("d.m.Y", $row["idate"]) . "</span>" . "\n <h3><a href='?id=" . $row["id"] . "'>" . $row["title"] . "</a></h3><br>" . $row["announce"] . "<br><br>";
                }       
            }
            if ($type == "article") {
                buildPageHead();
                echo "<span class='content'>" . $row['content'] . "</span>";
            }

        }
    }

}


function buildPageHead() {
    global $page, $row;
    $title = 0;
    if ($page) {$title = "Новости";} else {$title = $row['title'];};
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='stylesheet' type='text/css' href='style.css' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>". $title ."</title>
    </head>
    <body>
        <div class='wrap'>
            <h1>" . $title . "</h1>
            <hr>";
}

function buildPageFooter() {
    global $page;
    if (!$page) {
    echo "<hr><a class='allnews' href='/firstPHPPrjct/index.php'>Все новости >></a>"; 
    }
    echo "</div></body></html>";

}

?>