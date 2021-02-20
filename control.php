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

?>