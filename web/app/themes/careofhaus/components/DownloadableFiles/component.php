<?php
namespace Component;

class DownloadableFiles extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.downloadable.files', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/dowloadable_files.png',
            'params' => [
                [
                    'type' => 'dropdown',
                    'admin_label' => true,
                    'heading' => __('admin.text.filename', 'components'),
                    'param_name' => 'fileid',
                    'value' => $this->getMediaLibraryContent(),
                    'description' => __('admin.text.choose.file', 'components'),
                ],
            ],
        ];
    }

    protected function getMediaLibraryContent()
    {
        $return = [];

        $query = new \WP_Query([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
        ]);
        $others = [];
        $imgs = [];
        foreach ($query->posts as $post) {
            $txt = $post->post_title;
            $type = $this->_shortCodeFileType($post->post_mime_type);
            $v = ['id' => $post->ID, 'txt' => $txt, 'type' => $type];
            if (in_array($type, ['png', 'jpg', 'gif', 'jpeg'])) {
                $imgs[$type][] = $v;
            }
            else {
                $others[$type][] = $v;
            }
        }
        ksort($others);
        ksort($imgs);

        foreach ($others as $files) {
            foreach ($files as $f) {
                $return[$f['txt'] . '.' . $f['type']] = $f['id'];
            }
        }
        foreach ($imgs as $files) {
            foreach ($files as $f) {
                $return[$f['txt'] . '.' . $f['type']] = $f['id'];
            }
        }

        return $return;
    }

    public function getFileSize($postId)
    {
        return $this->_humanReadableFileSize(filesize(get_attached_file($postId)));
    }

    private function _humanReadableFileSize($bytes, $decimals = 1)
    {
        $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf('%.{$decimals}f', $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }

    private function _shortCodeFileType($string)
    {
        preg_match('|.*/(.*)$|', $string, $hit);

        return $hit[1];
    }

    protected function sanetizeDataForRendering($data)
    {
        $link = get_permalink($this->param('fileid'));
        $attachment = get_post($this->param('fileid'));
        $filesize = $this->getFileSize($this->param('fileid'));

        $data['link'] = $link;
        $data['name'] = $attachment->post_name;
        $data['size'] = $filesize;
        $data['type'] = $this->_shortCodeFileType($attachment->post_mime_type);

        return $data;
    }
}
