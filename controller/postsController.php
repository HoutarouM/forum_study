<?php

namespace App\Controller;

class PostsController extends BasicController
{
    protected function getPostsData()
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

    protected function getAuthorData($post_id)
    {
        $author_data = $this->model->getAuthorData($post_id);

        if (empty($author_data)) {
            return false;
        }

        return $author_data[0][0];
    }

    protected function getLikesData($post_id)
    {
        $likes_data = $this->model->getLikesData($post_id);

        if (empty($likes_data)) {
            return false;
        }

        return $likes_data[0][0];
    }

    protected function getCategories()
    {
        return $this->model->getCategories();
    }
};
