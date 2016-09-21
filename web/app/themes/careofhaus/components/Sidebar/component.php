<?php
namespace Component;

class Sidebar extends \DigitalUnited\Components\Component
{
    protected function getDefaultParams()
    {
        return [
            'theme' => 'archive',
        ];
    }

    public function main()
    {
        $this->addCPTSupportToWpGetArchives();
    }

    /**
     * This functionality will be messed up if there are multiple wp_get_archives calls
     * with diffrent post_types on the same page.
     *
     * @link http://stackoverflow.com/questions/23386709/date-archives-for-custom-post-type
     **/
    protected function addCPTSupportToWpGetArchives()
    {
        add_filter('getarchives_where', function ($where, $args) {
            if (isset($args['post_type']) && $args['post_type']) {
                $where = 'WHERE post_type = "' . $args['post_type'] . 'AND post_status = "publish"';

                add_filter('get_archives_link', function ($link) use ($args) {
                    $link = str_replace(home_url(), home_url() . '/' . $args['post_type'], $link);

                    return $link;
                }, 10, 2);
            }

            return $where;
        }, 10, 2);

        // Needed due to WPMU´s join-clause
        add_filter('getarchives_join', function ($join, $args) {
            if (isset($args['post_type']) && $args['post_type']) {
                $join = str_replace('post_post', 'post_' . $args['post_type'], $join);
            }

            return $join;
        }, 100, 2);
    }

    protected function getWrapperElementType()
    {
        return 'aside';
    }

    protected function getExtraWrapperClasses()
    {
        return ['col-xs-12 col-sm-12 col-md-3 col-md-push-9 sidebar'];
    }

    protected function getWrapperAttributes()
    {
        return ['role' => 'complementary'];
    }

}

