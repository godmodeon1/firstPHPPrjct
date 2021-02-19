<link rel='stylesheet' type='text/css' href='style.css' />

<div class="wrap">
<h1>Новости</h1>
<hr>
<?php
	//Устанавливаем доступы к базе данных:
		$host = 'localhost'; //имя хоста, на локальном компьютере это localhost
		$user = 'root'; //имя пользователя, по умолчанию это root
		$password = 'root'; //пароль, по умолчанию пустой or root
		$db_name = 'news'; //имя базы данных

	//Соединяемся с базой данных используя наши доступы:
		$link = mysqli_connect($host, $user, $password, $db_name);


	/*
		Соединение записывается в переменную $link,
		которая используется дальше для работы mysqi_query.
	*/
	//Устанавливаем кодировку (не обязательно, но поможет избежать проблем):
        mysqli_query($link, "SET NAMES 'utf8'");

        $page = $_GET["page"]; //Получаем номер страницы по клику
        $id = $_GET["id"]; //Получаем ID
        if ($page) {

            //Получаем диапазон статей для вывода
            $articleRangeEnd = $page * 5;
            $articleRangeStart = $articleRangeEnd - 4;

            //Формируем запрос:
            $query2 = "SELECT * FROM `news` ORDER BY `idate`";

            //Делаем запрос к БД, результат запроса пишем в $result:
            $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
        
            //Проверяем что же нам отдала база данных, если null – то какие-то проблемы:
            //var_dump($result2);
    
            //Преобразуем то, что отдала нам база в нормальный массив PHP $data:
            for ($data = []; $row = mysqli_fetch_assoc($result2); $data[] = $row);           
                        
                if ($result2 = mysqli_query($link, $query2)) {

                        /* извлечение ассоциативного массива */
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $i++;
                            if ($i >= $articleRangeStart and $i <= $articleRangeEnd) {
                                echo "<span class='date'>" . date("d.m.Y", $row["idate"]) . "</span>" . "\n <h3><a href='?id=" . $row["id"] . "'>" . $row["title"] . "</a></h3><br>" . $row["announce"] . "<br><br>";
                            }
                        }
                        /* удаление выборки */
                        mysqli_free_result($result2);
                    }

            //Формируем запрос всех статей из БД:
            $query = "SELECT * FROM `news`";

            //Делаем запрос к БД, результат запроса пишем в $result:
            $result = mysqli_query($link, $query) or die(mysqli_error($link));

            //Проверяем что же нам отдала база данных, если null – то какие-то проблемы:
            //var_dump($result);

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
        }
        if ($id) {
            echo "AAAAAA";
        }   
?>
</div>