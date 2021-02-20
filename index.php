<?php 

require_once('control.php'); //Подключаем файл

        if ($page) {
            buildPageHead();
            getArticleRange();
            requestSQL($query);
            getDataFromArr(all);
            countRowsSQL();

            echo "<hr><p><strong>Страницы:</strong></p>";

            makeBtns();
            buildPageFooter();
            mysqli_free_result($result);             /* удаление выборки */
        }
        if ($id) {
            requestSQL($queryArticle);
            getDataFromArr(article);

            echo "<hr><a class='allnews' href='/firstPHPPrjct/index.php'>Все новости >></a>";
            buildPageFooter();
            mysqli_free_result($result);             /* удаление выборки */
        }   

?>
</div>