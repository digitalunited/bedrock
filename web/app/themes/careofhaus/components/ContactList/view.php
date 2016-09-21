<div id="filters">
    <a href="#" id="reset" class="btn btn-sm pull-right" style="display:none;">Reset Filter</a>
    <div class="department-filter">
        <a class="btn btn--transparent filter" data-filter="all"><?= __('component.contact-list.all', 'components') ?></a>
        <?php foreach ($departments as $department) { ?>
            <a class="btn btn--transparent filter" data-filter=".category-<?= $department->term_id ?>"><?= $department->name ?></a>
        <?php } ?>
    </div>
</div>

<div id="contact-list" class="contact-list" data-first-category="">
    <?php for ($i = 0; $i < count($contacts); $i++) :
        $contact = $contacts[$i];
        $singleContact = new \Component\ContactSingle(['contact_id' => $contact->ID]);
        $c = $singleContact->render();

        ?>
        <div class="mix<?= $singleContact->classes ?>">
            <?= $c ?>
        </div>
    <?php endfor; ?>
</div>
