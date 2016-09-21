<?php
namespace Component;

class Video extends \DigitalUnited\Components\VcComponent
{
    const YT_API_KEY = 'AIzaSyDG2xiol3Ng2LxucQHIXuSTLmwNVVYr5_o';

    protected $id;
    protected $source;

    protected function getDefaultParams()
    {
        $params = parent::getDefaultParams();

        return $params;
    }

    protected function getComponentConfig()
    {
        return [
            'name' => 'Video (YouTube)',
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/video.png',
            'params' => [
                [
                    'type' => 'textfield',
                    'heading' => __('component.Video.heading.videourl', 'components'),
                    'param_name' => 'videourl',
                    'value' => '',
                ],
                [
                    'type' => 'attach_image',
                    'heading' => __('component.Video.image', 'components'),
                    'param_name' => 'image',
                    'value' => '',
                ]
            ],
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $this->source = $this->getSource();
        $this->id = $this->parseVideoId();
        $data['id'] = $this->parseVideoId();

        return $data;
    }

    protected function getSource()
    {
        $url = $this->param('videourl');
        if (preg_match('/youtu\.{0,1}be/', $url)) {
            return 'youtube';
        }
        else {
            return false;
        }
    }

    protected function parseVideoId()
    {
        $parsedUrl = parse_url($this->param('videourl'));
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryArgs);

            return isset($queryArgs['v']) ? $queryArgs['v'] : false;
        }
        else {
            preg_match('/\/([^\/]+)$/', $parsedUrl['path'], $matches);

            return $matches[1];
        }

        return false;
    }

    public function getStaticImage()
    {
        if (!$this->id) {
            return false;
        }

        if ($this->param('image')) {
            return wp_get_attachment_url($this->param('image'));
        }

        $cache = wp_cache_get($this->id, $this->source);

        if ($cache) {
            return $cache;
        }

        $return = false;

        if ($this->source == 'youtube') {
            $return = $this->getStaticYouTubeImage();
        }

        wp_cache_set($this->id, $return, $this->source);

        return $return;
    }

    private function getStaticYouTubeImage()
    {
        $url = 'https://www.googleapis.com/youtube/v3/videos?id=' . $this->id . '&key=' . self::YT_API_KEY . '&part=snippet';
        $res = json_decode(file_get_contents($url));
        if (is_object($res)) {
            $thumbs = (array) $res->items[0]->snippet->thumbnails;
            $highestAvailable = array_pop($thumbs);

            return $highestAvailable->url;
        }
    }
}
