<?php
namespace Component;

class ContactSingle extends \DigitalUnited\Components\VcComponent
{
    public $classes;

    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.contact.single', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/contact_single.png',
            'params' => [
                [
                    'type' => 'dropdown',
                    'heading' => 'Kontaktperson',
                    'param_name' => 'contact_id',
                    'admin_label' => true,
                    'value' => $this->fetch_posts()
                ]
            ],
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $contact_id = $this->param('contact_id');
        $post = get_post($contact_id);

        $data['contact'] = $this->formatContact($contact_id);

        $data['categories'] = $this->getCategories($post);

        return $data;
    }

    public function formatContact($contact_id)
    {
        $contact = get_post($contact_id);
        $fields = get_fields($contact_id);
        $categories = wp_get_post_terms($contact->ID, ['contact_department']);
        $classes = '';
        $contact_departments = [];
        foreach ($categories as $category) {
            if ($category->taxonomy === 'contact_department') {
                $contact_departments[] = $category;

                $classes .= ' category-' . $category->term_id;
                if ($category->parent) {
                    $contact_sub_department = isset($contact_sub_department) ? $contact_sub_department . ', ' . $category->name : $category->name;
                }
                else {
                    $contact_department = isset($contact_department) ? $contact_department . ', ' . $category->name : $category->name;
                }
            }
        }
        $this->classes = $classes;

        return [
            'id' => $contact->ID,
            'name' => $contact->post_title,
            'phone' => $fields['contact_phone'],
            'email' => $fields['contact_email'],
            'departments' => $contact_departments,
            'department_name' => isset($contact_department) ? $contact_department : '',
            'sub_department_name' => isset($contact_sub_department) ? $contact_sub_department : '',
            'classes' => $classes,
            'srcset' => $this->getImageSrcset($fields['contact_image'])
        ];
    }

    public function getImageSrcset($image_id)
    {

        if (is_array($image_id)) {
            $image_id = $image_id[0];
        }
        else {
            $image_id;
        }

        $srcset = $image_id ? \DigitalUnited\ResponsiveImage::render([
            'imgId' => $image_id,
            'output' => 'srcset',
            'ratio' => 'none'
        ]) : '';

        return $srcset;
    }

    private function getCategories($post)
    {
        $categories = wp_get_post_terms($post->ID, ['contact_department']);

        foreach ($categories as $category) {
            if ($category->taxonomy === 'contact_department') {
                if ($category->parent) {
                    $contact_sub_department = isset($contact_sub_department) ? $contact_sub_department . ', ' . $category->name : $category->name;
                }
                else {
                    $contact_department = isset($contact_department) ? $contact_department . ', ' . $category->name : $category->name;
                }
            }
        }

        return [
            'department' => $contact_department,
            'sub_department' => isset($contact_sub_department) ? $contact_sub_department : null,
        ];
    }

    private function fetch_posts()
    {
        $result = [];
        $posts = get_posts(
            [
                'posts_per_page' => -1,
                'post_type' => 'contact',
                'orderby' => 'title',
                'order' => 'ASC'
            ]
        );

        foreach ($posts as $reference) {

            $label = $reference->post_title;
            $value = $reference->ID;
            $result[$label] = $value;
        }

        return $result;
    }

    public function getVCard()
    {

        if (!isset($_GET['vcard']) || !isset($_GET['contact_id'])) {
            return;
        }

        $contact_id = $_GET['contact_id'];
        $contact = get_post($contact_id);

        if (!$contact) {
            return;
        }

        $firstname = $contact->firstname ?: '';
        $lastname = $contact->lastname ?: '';
        $email = $contact->email ?: '';
        $phone = $contact->phone ?: '';
        $img_url = get_attached_file(get_post_thumbnail_id($contact_id));

        $titles = wp_get_post_terms($contact_id, 'contact_title', ['fields' => 'names']);
        $title = is_array($titles) && count($titles) ? reset($titles) : '';

        $vcard = new VCard();
        $vcard->addName($firstname, $lastname)
            ->addCompany('Digital Mechanics')
            ->addJobtitle($title)
            ->addEmail($email)
            ->addPhoneNumber($phone, 'PREF;WORK')
            ->addURL(site_url())
            ->addPhoto($img_url)
            ->download();
    }

    public function main()
    {
        add_action('template_redirect', array(&$this, 'getVCard'));
    }

    public function getClasses()
    {
    }
}
