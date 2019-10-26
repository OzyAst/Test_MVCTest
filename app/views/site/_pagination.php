<?php if ($pages['count_page'] > 1): ?>
<nav class="mt-5">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= $pages['prev_page'] == $pages['current_page'] ? "disabled" : ""?>">
            <a class="page-link"
               href="<?= str_replace("{{:page}}", $pages['prev_page'], $pages['url_template']) ?>">
                &#x261A; Туда
            </a>
        </li>

        <?php for ($i = 1; $i<=$pages['count_page']; $i++): ?>
            <li class="page-item <?= $pages['current_page'] == $i ? "active" : ""?>">
                <a class="page-link" href="<?= str_replace("{{:page}}", $i, $pages['url_template']) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?= $pages['next_page'] == $pages['current_page'] ? "disabled" : ""?>">
            <a class="page-link" href="<?= str_replace("{{:page}}", $pages['next_page'], $pages['url_template']) ?>">
                Сюда &#x261B;
            </a>
        </li>
    </ul>
</nav>
<?php endif; ?>