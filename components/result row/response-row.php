<div class="response-row">
    <div><?= $result["student_name"] ?>
        <?php if ($result["leader"]) { ?> <span class="label-info">Староста</span><?php } ?></div>
    <div><?= $result["group_name"] ?></div>
</div>