<div class="response-row">
    <div><?= $result["student_name"] ?></div>
    <div>
        <?php
        $timestamp = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result["record_time"])->getTimestamp();
        echo date("d.m.Y", $timestamp);
        ?>
    </div>
</div>