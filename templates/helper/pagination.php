<?php
$paginationOffset = 3;

if($pages > 1) {
    ?>
    <nav>
        <ul class="pagination justify-content-end">
            <?php if($page - $paginationOffset > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $this->path(str_replace('%page%', 1, $path)); ?>">
                        1
                    </a>
                </li>
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-ellipsis-h"></i>
                    </span>
                </li>
            <?php } ?>
            <?php for($i = max($page - $paginationOffset, 1) ; $i <= min($page + $paginationOffset, $pages) ; $i++) { ?>
                <li class="page-item<?= $page === $i ? ' active' : '' ?>">
                    <a class="page-link" href="<?= $this->path(str_replace('%page%', $i, $path)); ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>
            <?php if($page + $paginationOffset < $pages) { ?>
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-ellipsis-h"></i>
                    </span>
                </li>
                <li class="page-item">
                    <a class="page-link" href="<?= $this->path(str_replace('%page%', $pages, $path)); ?>">
                        <?= $pages ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>
