<?php

/**
 * Модель статей, отвечает за работу с БД MySQl, используется обертка PDO
 */
class Articles
{
    private $connection;

    public function __construct()
    {
        $port = 3306;
        $dsn = 'mysql:host=localhost:' . $port . ';dbname=deadlyalliance;charset=utf8';
        $username = 'root';
        $password = 'root';
        $this->connection = new PDO($dsn, $username, $password);
    }

    /**
     * Выборка всех новостей
     */
    public function select_news()
    {
        $query = $this->connection->prepare(
            "SELECT articles.id,`id_user`, `title`, `picture`, `text`, `date`, `username`
                      FROM articles INNER JOIN users ON articles.id_user = users.id
                      ORDER BY `date` DESC;");
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * Выборка ограниченного количества новостей из БД
     */
    public function select_limited_news($offset = 0, $limit)
    {
        $query = $this->connection->prepare(
            "SELECT articles.id,`id_user`, `title`, `picture`, `text`, `date`, `username` FROM articles INNER JOIN users ON articles.id_user = users.id ORDER BY `date` DESC LIMIT :offset,:limit;");
        $params = array(":offset" => $offset, ":limit" => $limit);
        $query->execute($params);
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * Добавление новости в БД
     */
    public function insert_article($id_user, $data, $file)
    {
        // Валидация поле ввода, и изображения
        if (empty($data["header"]) || empty($data["text"])) {
            $status = "Необходимо заполнить поля заголовка и текста статьи!";
            $error_code = false;
            return array($status, $error_code);
        }
        if ($file["error"] == 4) {
            $image_name = "1.jpg";
            $status = "Изображение не выбрано, будет загружена картинка по умолчанию";
        } else {
            // проверка типа файла
            if (($file["type"] != "image/jpeg") && ($file["type"] != "image/png") && ($file["type"] != "image/gif")) {
                $image_name = "1.jpg";
                $status = "Допустимы изображения только форматов jpeg, png и gif";
                $error_code = false;
                return array($status, $error_code);
            } else {
                $image_name = str_replace(" ", "_", $file["name"]);
                $image_temp_name = $file["tmp_name"];
                move_uploaded_file($image_temp_name, "../postpic/$image_name");
                $status = "";
            }
        }
        $query = $this->connection->prepare("INSERT INTO articles (id_user, title, picture, text) VALUES (:id_u, :title, :img, :txt)");
        $parameters = array(":id_u" => $id_user, ":title" => $data["header"], ":img" => $image_name, ":txt" => $data["text"]);
        $query->execute($parameters);
        $error_code = true;
        return array($status, $error_code);
    }

    /**
     * Удаление новости из БД
     */
    public function delete_article($id)
    {
        $query = $this->connection->prepare("DELETE FROM articles WHERE id = :idnew");
        $data = array(":idnew" => $id);
        return $query->execute($data);
    }

    /**
     * Выборка новости для последующего редактирования
     */
    public function select_edit($id)
    {
        $query = $this->connection->prepare("SELECT * FROM articles WHERE id = :idnew");
        $data = array(":idnew" => $id);
        $query->execute($data);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Редактирование новости
     */
    public function edit_new($id, $data, $file)
    {
        if (empty($data["header"]) || empty($data["text"])) {
            $status = "Необходимо заполнить поля заголовка и текста статьи!";
            $error_code = false;
            return array($status, $error_code);
        }
        if ($file["error"] == 4) {
            $query = $this->connection->prepare("UPDATE articles SET title = :title, text = :txt WHERE id = :idn");
            $parameters = array(":title" => $data["header"], ":txt" => $data["text"], ":idn" => $id);
        } else {
            if (($file["type"] != "image/jpeg") && ($file["type"] != "image/png") && ($file["type"] != "image/gif")) {
                $status = "Допустимы изображения только форматов jpeg, png и gif";
                $error_code = false;
                return array($status, $error_code);
            } else {
                $image_name = str_replace(" ", "_", $file["name"]);
                $image_temp_name = $file["tmp_name"];
                move_uploaded_file($image_temp_name, "../postpic/$image_name");
                $query = $this->connection->prepare("UPDATE articles SET title = :title, picture = :img, text = :txt WHERE id = :idn");
                $parameters = array(":title" => $data["header"], ":img" => $image_name, ":txt" => $data["text"], ":idn" => $id);
            }
        }
        $status = "";

        $query->execute($parameters);
        $error_code = true;
        return array($status, $error_code);
    }
}

?>