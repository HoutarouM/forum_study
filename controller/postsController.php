<?php

namespace App\Controller;

class PostsController implements BasicController
{
    protected $model;
    protected $data;

    public function index($url, $data = null)
    {
        if ($data != null) {
            $this->data = $data;
        }

        $m = $this->getModel($url);

        if (!$m) {
            return false;
        }

        $this->render($url);
    }

    private function render($url)
    {
        if (file_exists('./view/' . $url . '.php')) {
            include_once './view/' . $url . '.php';
        } else {
            $data['error_mes'] = 'Nie znałeziono strony :(';

            include_once './view/error.php';
        }
    }

    public function getModel($url = 'posts')
    {
        if (file_exists('./model/' . $url . 'Model.php')) {
            include './model/' . $url . 'Model.php';

            $this->model = trim('App\Model\ ', ' ') . ucfirst($url) . 'Model';

            $this->model = new $this->model();

            return true;
        } else {
            $data['error_mes'] = 'Nie znałeziono strony :(';

            include './view/error.php';

            return false;
        }
    }

    private function getPostsData()
    {
        $data = null;

        if (!empty($this->data)) {
            $data = $this->data;
        }

        $posts_data = $this->model->getPostsData($data);

        if (empty($posts_data)) {
            return false;
        }

        return $posts_data;
    }

    private function getAuthorData($post_id)
    {
        $author_data = $this->model->getAuthorData($post_id);

        if (empty($author_data)) {
            return false;
        }

        return $author_data[0][0];
    }

    private function getLikesData($post_id)
    {
        $likes_data = $this->model->getLikesData($post_id);

        if (empty($likes_data)) {
            return false;
        }

        return $likes_data[0][0];
    }

    private function getCategories()
    {
        return $this->model->getCategories();
    }
};
