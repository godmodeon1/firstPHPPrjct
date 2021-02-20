<link rel='stylesheet' type='text/css' href='style.css' />

<div class="wrap">
<h1>Новости</h1>
<hr>
<?php 
require_once('control.php');




        if ($page) {
            getArticleRange();

            //Делаем запрос к БД, результат запроса пишем в $result:
            $result = mysqli_query($link, $query) or die(mysqli_error($link));
        
            //Проверяем что же нам отдала база данных, если null – то какие-то проблемы:
            //var_dump($result2);
    
            //Преобразуем то, что отдала нам база в нормальный массив PHP $data:
            for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);           
                        
            // извлечение ассоциативного массива
            if ($result = mysqli_query($link, $query)) {
                $i = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $i++;
                    if ($i >= $articleRangeStart and $i <= $articleRangeEnd) {
                        echo "<span class='date'>" . date("d.m.Y", $row["idate"]) . "</span>" . "\n <h3><a href='?id=" . $row["id"] . "'>" . $row["title"] . "</a></h3><br>" . $row["announce"] . "<br><br>";
                    }
                }
            }

            $new = $result->num_rows; // Получем число записей в БД
            $numOfPages = ceil($new/5); // считаем количество страниц

            echo "<hr><p><strong>Страницы:</strong></p>";


            for ( $i = 1; $i <= $numOfPages; $i++ )
            {
                // Для окраски нажатой кнопки
                if ($page == $i) {
                    $div = "<div class='pageBtn pageBtnPshd'>";
                } else {
                    $div = "<div class='pageBtn'>";
                }
                // выводим кнопки
            echo $div . "<a href='index.php?page=". $i . "'>". $i . "</a></div>";
            }
            /* удаление выборки */
            mysqli_free_result($result);
        }
        if ($id) {
            //Делаем запрос к БД, результат запроса пишем в $result:
            $result = mysqli_query($link, $queryArticle) or die(mysqli_error($link));

            //Проверяем что же нам отдала база данных, если null – то какие-то проблемы:
            //var_dump($result);
    
            //Преобразуем то, что отдала нам база в нормальный массив PHP $data:
            for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);           

            // извлечение ассоциативного массива
            if ($result = mysqli_query($link, $queryArticle)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<h1>" . $row['title'] . "</h1><hr>";
                    echo "<span class='content'>" . $row['content'] . "</span>";
                }
            }
            echo "<hr><a class='allnews' href='/firstPHPPrjct/index.php'>Все новости >></a>";
        }   

?>
</div>