<?php
namespace Component;

class Post extends \DigitalUnited\Components\Component
{
    private $meta;

    protected function getDefaultParams() {
        return [
            'post' => false,
            'view' => 'list',
            'image' => '',
            'seen' => false,
        ];
    }

    protected function sanetizeDataForRendering($data) {
        $data['image'] = $this->getImage();
        $data['srcset'] = $this->getImageSrcset();
        $data['id'] = $this->param('post')->ID;

        return $data;
    }

    public function getHeadline() {
        return $this->param('post')->post_title;
    }

    public function getPostDate($format = null) {
        if (!$format) {
            $format = get_option('date_format');
        }

        return get_the_date($format, $this->param('post')->ID);
    }

    public function getPostCategories() {
        $post = $this->param('post');
        $terms = $post->post_type == 'post'
            ? get_the_category($post->ID)
            : get_the_terms($post->ID, $post->post_type . '-category');

        return $terms && !isset($terms->errors) ? $terms : [];
    }

    public function getExcerpt($maxWords = 25) {
        $post = $this->param('post');
        if ($post->post_excerpt) {
            $excerpt = trim($post->post_excerpt);
        } else {
            //Strip shortcodes and markup
            $excerpt = preg_replace('/\[.*?\]/s', '', $post->post_content);
            $excerpt = strip_tags($excerpt);

            // Truncate excessive words
            $words = explode(' ', $excerpt);
            if (count($words) > $maxWords) {
                $words = array_slice($words, 0, $maxWords);
                $words[] = '...';
            }
            $excerpt = implode(' ', $words);
        }

        return $excerpt;
    }

    public function getPostTypeArchiveLink() {
        $post_type = $this->param('post')->post_type;
        $url = $post_type == 'post'
            ? get_permalink(get_option('page_for_posts'))
            : get_post_type_archive_link($post_type);

        return new \DigitalUnited\Components\Link([
            'url' => $url,
            'title' => $this->getHeadline(),
        ]);
    }

    public function getLink() {
        $post = $this->param('post');

        return new \DigitalUnited\Components\Link([
            'url' => get_permalink($post->ID),
            'title' => $this->getHeadline(),
        ]);
    }

    public function getPermalink() {
        $post = $this->param('post');

        return get_permalink($post->ID);
    }

    public function getImage() {
        $attachment_id = $this->getMeta('_thumbnail_id');

        if (is_array($attachment_id)) {
            $attachment_id = $attachment_id[0];
        } else {
            $attachment_id;
        }

        return $attachment_id ? new Image(['image_id' => $attachment_id]) : '';
    }

    public function getImageSrcset() {
        $image_id = $this->getMeta('_thumbnail_id');

        if (is_array($image_id)) {
            $image_id = $image_id[0];
        } else {
            $image_id;
        }

        $srcset = $image_id ? \CoH\ResponsiveImage::render([
            'imgId' => $image_id,
            'output' => 'srcset',
            'ratio' => 'none'
        ]) : '';

        return $srcset;
    }

    public function getNextPostLink() {
        global $wpdb;
        $post = $this->param('post');
        $id = $wpdb->get_var('
            select ID from {$wpdb->posts}
            where post_date > "{$post->post_date}" and post_type = "{$post->post_type}"
                and post_status="publish"
            order by post_date asc limit 1');

        return $id ? get_permalink($id) : false;
    }

    public function getPrevPostLink() {
        global $wpdb;
        $post = $this->param('post');
        $id = $wpdb->get_var('
            select ID from {$wpdb->posts}
            where post_date < "{$post->post_date}" and post_type = "{$post->post_type}"
                and post_status="publish"
            order by post_date desc limit 1');

        return $id ? get_permalink($id) : false;
    }

    protected function getExtraWrapperClasses() {
        return [$this->param('view')];
    }

    public function getMeta($metaField, $fallback = '') {
        $this->populateMetaIfNotPoulated();

        return isset($this->meta[$metaField]) ? $this->meta[$metaField] : $fallback;
    }

    private function populateMetaIfNotPoulated() {
        if ($this->meta) {
            return true;
        }

        $cacheKey = $this->param('post')->ID;
        $cacheGroup = 'component.post.meta';
        $cache = wp_cache_get($cacheKey, $cacheGroup);
        if ($cache) {
            $this->meta = $cache;

            return true;
        }

        global $wpdb;
        $query = $wpdb->prepare('
            select meta_key, meta_value
            from $wpdb->postmeta
            where post_id = %d', $this->param('post')->ID);

        $rows = $wpdb->get_results($query);
        foreach ($rows as $row) {
            $this->addMetaField($row);
        }

        wp_cache_set($cacheKey, $this->meta, $cacheGroup);
    }

    private function addMetaField($field) {
        // If the meta key is already set, we need to make an array or append existing array
        // since we do not want to overrwrite
        if (isset($this->meta[$field->meta_key])) {
            $this->meta[$field->meta_key] = is_array($this->meta[$field->meta_key])
                ? array_merge($this->meta[$field->meta_key], [$field->meta_value])
                : [$this->meta[$field->meta_key], $field->meta_value];
        } else {
            $this->meta[$field->meta_key] = $field->meta_value;
        }
    }
}
