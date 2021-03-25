<?php 

/**
* Выполняет подключение к базе данных, возвращает объект подключения к серверу MySQL, в случае ошибки подключения, выводит на экран код ошибки.
* Принимает следующие параметры:
* @param  string $host имя хоста или IP-адрес, 
* @param  string $user Имя пользователя MySQL, 
* @param  string $password Пароль пользователя MySQL, 
* @param  string $db Имя базы данных.
*/
function db_connect(string $host, string $user, string $password, string $db): mysqli 
{
    $con = mysqli_connect($host, $user, $password, $db);

    if ($con == false) {
       print("Ошибка подключения: " . mysqli_connect_error());
       exit();
    } 
    else {
        return $con;
    }
};

/**
* Возвращает массив с данными из базы данных, к которой уже произведено подключение на основании строки запроса. В случае ошибки, выводит на экран код ошибки.
* Принимает следующие параметры:
* @param  mysqli $connect обьект подключения к базе данных, 
* @param  string $request Строка запроса к базе данных.
*/
function get_array_db(mysqli $connect, string $request): array
{
  $query =  mysqli_query($connect, $request); 
  
  if($query == false) {
    print("Ошибка запроса в БД: " .  mysqli_error($connect));
    exit();
  }
  else {
    $array = mysqli_fetch_all($query, MYSQLI_ASSOC);

    return $array;
  }  
};

/**
 * Функция получает типы контента из БД
 * @param mysqli $connection объект соединения с БД
 * @return array массив с типами контента
 */
function get_content_types(mysqli $connection): array
{
    $sql = "SELECT type, class_name FROM types";
    return get_array_db($connection, $sql);
}

/**
 * Функция получает список постов из БД
 * @param mysqli $connection объект соединения с БД
 * @return array массив с списком постов
 */
function get_posts(mysqli $connection): array
{
    $sql = "SELECT 
              posts.content,
              posts.title, 
              posts.publictation_date,
              posts.author_quote, 
              posts.img_path, 
              posts.video_path,
              site_path,
              users.first_name, 
              users.last_name, 
              users.avatar_path, 
              types.class_name

            FROM `posts` 

            LEFT JOIN 
              `users` 
            ON 
              posts.user_id = users.id

            LEFT JOIN 
              `types` 
            ON 
              posts.type_id = types.id 

            order by `count_view` DESC";
    return get_array_db($connection, $sql);
}


