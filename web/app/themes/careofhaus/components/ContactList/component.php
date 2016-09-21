<?php

namespace Component;

use JeroenDesloovere\VCard\VCard;

class ContactList extends \DigitalUnited\Components\VcComponent
{

    /*
         * Vc mapping array
         * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
         */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.contact_list', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/contact_list.png',
            'params' => []
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['contacts'] = $this->getContacts();
        $data['departments'] = $this->getDepartments();

        return $data;
    }

    public function main()
    {
        add_action('template_redirect', array(&$this, 'getVCard'));
    }

    public function getVCard()
    {

        if (!isset($_GET['vcard']) || !isset($_GET['contact_id'])) {
            return;
        }

        $contact_id = $_GET['contact_id'];
        $c = get_post($contact_id);
        $singleContact = new ContactSingle();
        $contact = $singleContact->formatContact($contact_id);
        if (!$contact) {
            return;
        }

        $parts = explode(' ', $contact['name']);
        $firstname = isset($parts[0]) ? $parts[0] : '';
        $lastname = isset($parts[1]) ? $parts[1] : '';
        $email = $contact['email'] ?: '';
        $phone = $contact['phone'] ?: '';
        $img_url = get_attached_file(get_field('contact_image', $contact_id));

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

    private function getContacts()
    {
        $args = [
            'post_type' => 'contact',
            'numberposts' => -1,
            'orderby' => 'ID',
            'order' => 'ASC',
        ];

        return $contacts = get_posts($args);
    }

    private function getDepartments()
    {
        // Get all departments
        $taxonomies = array(
            'contact_department',
        );

        $args = [
            'hide_empty' => true,
            'orderby' => 'term_order',
            'order' => 'ASC',
        ];

        return get_terms($taxonomies, $args);
    }

}
