<?php 

require_once('control.php'); //Подключаем файл

    requestSQL($queryArticle);
    getDataFromArr(article);
    buildPageFooter();
    mysqli_free_result($result);             /* удаление выборки */


?>