<?php
namespace Component;

class LatestPost extends \DigitalUnited\Components\Component
{

    protected function getDefaultParams()
    {
        return [];
    }

    protected function sanetizeDataForRendering($data)
    {
        $args = array(
            'numberposts' => 5,
            'offset' => 0,
            'category' => 7,
            'post__not_in' => array(1)
        );

        $data['posts'] = wp_get_recent_posts($args);

        return $data;
    }

    public function main()
    {
        $this->registerAjax();
        $this->registerCookie();
    }

    private function registerAjax()
    {
        // Returns latest posts
        add_action('wp_ajax_latest_post', array(&$this, 'ajaxLatestPost'));
        add_action('wp_ajax_nopriv_latest_post', array(&$this, 'ajaxLatestPost'));

        // Mark post as seen
        add_action('wp_ajax_mark_as_seen', array(&$this, 'ajaxMarkAsSeen'));
        add_action('wp_ajax_nopriv_mark_as_seen', array(&$this, 'ajaxMarkAsSeen'));
    }

    private function registerCookie()
    {
        add_action('init', [&$this, 'setCookieIfUnset']);
        add_action('template_redirect', [&$this, 'setSeenPostCookie']);
        add_action('init', [&$this, 'setLastVisitCookie']);
    }

    public function ajaxLatestPost()
    {
        if (isset($_GET['archive']) && $_GET['archive']) {
            $this->setAllSeenPostCookie();
            echo json_encode([]);
            exit;
        }

        echo json_encode($this->getPostList());
        exit;
    }

    public function ajaxMarkAsSeen()
    {
        $return = '';
        if (isset($_POST['id'])) {
            $seenposts = json_decode($_COOKIE['seenposts']);
            if (!in_array((int) $_POST['id'], $seenposts)) {
                $seenposts[] = (int) $_POST['id'];
                $return = 'success';
            }
            $_COOKIE['seenposts'] = json_encode($seenposts);
            setcookie('seenposts', json_decode($seenposts), strtotime('+1 year'), '/');
        }

        echo $return;
        exit;
    }

    public function setCookieIfUnset()
    {
        // If lastvisit-cookie isn't set, set it
        if (!isset($_COOKIE['lastvisit'])) {
            $_COOKIE['lastvisit'] = date('Y-m-d 00:00:00', strtotime('-2 weeks'));
            setcookie('lastvisit', date('Y-m-d 00:00:00', strtotime('-2 weeks')), strtotime('+1 year'), '/');
        }
        // Also set posts seen (to exist but without values)
        if (!isset($_COOKIE['seenposts'])) {
            $_COOKIE['seenposts'] = json_encode(array());
            setcookie('seenposts', json_encode(array()), strtotime('+1 year'), '/');
        }
    }

    public function setSeenPostCookie()
    {
        if (is_single()) {
            $seenposts = json_decode($_COOKIE['seenposts']);
            $post_id = get_the_ID();
            if (!in_array($post_id, $seenposts)) {
                $seenposts[] = $post_id;
            }
            $_COOKIE['seenposts'] = json_encode($seenposts, JSON_NUMERIC_CHECK);
            setcookie('seenposts', json_encode($seenposts, JSON_NUMERIC_CHECK), strtotime('+1 year'), '/');
        }

        if (is_home()) {
            $this->setAllSeenPostCookie();
        }
    }

    public function setAllSeenPostCookie()
    {
        $seenposts = json_decode($_COOKIE['seenposts']);

        $blog_posts = wp_get_recent_posts([
            'post_status' => 'publish'
        ], OBJECT);

        $seen_posts_ids = array_map(function ($post) {
            return $post->ID;
        }, $blog_posts);

        $seenposts = array_merge($seenposts, $seen_posts_ids);

        $_COOKIE['seenposts'] = json_encode($seenposts, JSON_NUMERIC_CHECK);
        setcookie('seenposts', json_encode($seenposts, JSON_NUMERIC_CHECK), strtotime('+1 year'), '/');
    }

    public function setLastVisitCookie()
    {
        // If lastvisit-cookie is set and it's the next day from previous visit, set lastvisit-cookie to today
        if (isset($_COOKIE['lastvisit'])) {
            if ((date('Y-m-d 00:00:00', strtotime('-2 weeks')) > $_COOKIE['lastvisit'])
                || (date('Y-m-d 00:00:00', strtotime('-1 day')) == $_COOKIE['lastvisit'])
            ) {
                $_COOKIE['lastvisit'] = date('Y-m-d') . ' 00:00:00';
                setcookie('lastvisit', date('Y-m-d') . ' 00:00:00', strtotime('+1 year'), '/');
            }
        }
    }

    public function getPostList()
    {
        $seen_posts = [];
        $seen_posts_cookie = json_decode($_COOKIE['seenposts']);
        if (is_array($seen_posts_cookie) && count($seen_posts_cookie)) {
            $seen_posts = $seen_posts_cookie;
        }

        $blog_posts = wp_get_recent_posts([
            'post_status' => 'publish'
        ], OBJECT);

        $posts = [];
        foreach ($blog_posts as $post) {
            if (!in_array($post->ID, $seen_posts)) {
                $posts[] = [
                    'post_title' => $post->post_title,
                    'post_date' => date('j M Y', strtotime($post->post_date)),
                    'url' => get_permalink($post->ID),
                    'id' => $post->ID
                ];
            }
        }

        return $posts;
    }

}
