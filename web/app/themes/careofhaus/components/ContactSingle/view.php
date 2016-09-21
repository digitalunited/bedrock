<?php if (!empty($contact['srcset'])) { ?>
    <div class="image du-resp-div-bg lazyload contain" data-bgset="<?= $contact['srcset'] ?>"></div>
<?php } ?>

<div class="text-content<?= empty($contact['srcset']) ? ' full' : '' ?>">
    <strong><?= $contact['department_name'] ?></strong><br>
    <?php if ($contact['sub_department_name']) { ?>

        <span class="label label-title"><?= $contact['sub_department_name'] ?></span><br>
    <?php } ?>

    <hr>

    <h2><?= $contact['name'] ?></h2>

    <ul class="list-unstyled">
        <li>
            <a class="tel" href="tel:<?= $contact['phone'] ?>"><span class="icon-phone"></span> <?= $contact['phone'] ?>
            </a>
        </li>
        <li>
            <a href="mailto:<?= $contact['email'] ?>"><span class="icon-email"></span> <?= $contact['email'] ?></a>
        </li
        <li>
            <a href="?vcard&contact_id=<?= $contact['id'] ?>" class="download-vcard" data-contact-id="<?= $contact['id'] ?>"><span class="icon icon-address-book"></span> <?= __('contact.download.vcard', 'components') ?>
            </a>
        </li>
    </ul>
</div>

