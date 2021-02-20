<?php 

require_once('control.php'); //Подключаем файл

        if ($page) {
            buildPageHead();
            getArticleRange();
            requestSQL($query);
            getDataFromArr(all);
            countRowsSQL();
            makeBtns();
            buildPageFooter();
            mysqli_free_result($result);             /* удаление выборки */
        }
        if ($id) {
            requestSQL($queryArticle);
            getDataFromArr(article);
            buildPageFooter();
            mysqli_free_result($result);             /* удаление выборки */
        }   

?>
</div>