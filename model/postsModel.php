<?php

namespace App\Model;

require './model/basicModel.php';

class PostsModel extends BasicModel
{
    public function getPostsData($data)
    {
        if ($data != null) {
            $get_post_data_query = "SELECT * FROM `posty` WHERE `id` = ? OR `id_postu_nadzendnego` = ?";

            $stmt = $this->read($get_post_data_query, [$data, $data]);
        } else {
            $get_post_data_query = "SELECT * FROM `posty` WHERE isNull(`id_postu_nadzendnego`);";

            $stmt = $this->read($get_post_data_query, []);
        }

        $data = $stmt->fetchAll();

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getAuthorData($post_id)
    {
        $get_post_data_query = "SELECT DISTINCT users.nick FROM `users` JOIN posty on posty.id_autora = users.id WHERE posty.id = ?;";
        $stmt = $this->read($get_post_data_query, [$post_id]);

        $data = $stmt->fetchAll();

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getAutourId($login)
    {
        $get_autour_id_query = "SELECT `id` FROM `users` WHERE `nick` = ?";

        $stmt = $this->read($get_autour_id_query, [$login]);

        $res = $stmt->fetchAll();

        if (empty($res)) {
            return false;
        }

        return $res;
    }

    public function getLikesData($post_id)
    {
        $get_likes_data_query = "SELECT COUNT(*) FROM `polubienia` JOIN posty ON posty.id = polubienia.id_posta WHERE posty.id = ?;";
        $stmt = $this->read($get_likes_data_query, [$post_id]);

        $data = $stmt->fetchAll();

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getCategories()
    {
        $get_categories_query = "SELECT * FROM `kategorie`";

        $stmt = $this->read($get_categories_query, []);

        $data = $stmt->fetchAll();

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function addComment($parent_post_id, $category_id, $author_id, $text)
    {
        $add_comment_query = "INSERT INTO `posty`(`id`, `id_postu_nadzendnego`, `id_kategorii`, `id_autora`, `tytul`, `text`) VALUES (NULL, ?, ?, ?, NULL, ?);";

        $this->write($add_comment_query, [$parent_post_id, $category_id, $author_id, $text]);

        return true;
    }
}
