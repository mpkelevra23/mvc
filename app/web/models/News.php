<?php

class News
{
    /**
     * Returns single news item with specified id
     * @param $id
     * @return mixed
     */
    public static function getNewsItemById($id)
    {
        $id = intval($id);

        $db = Db::getConnection();
        $result = $db->prepare('SELECT * FROM `news` WHERE `id` = :id');
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch();
    }

    /**
     * Returns an array of news items
     * @return array
     */
    public static function getNewsList()
    {
        $db = Db::getConnection();

        $result = $db->query("SELECT `id`, `title`, `date`, `short_content`, `user_id` 
                    FROM `news`
                    ORDER BY `date` DESC 
                    LIMIT 10")->fetchAll();

        return $result;
    }

}