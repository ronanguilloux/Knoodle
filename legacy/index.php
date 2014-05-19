<?php

include 'header.php';

$surveys = $pdo->query('SELECT * FROM survey ORDER BY created_at DESC')->fetchAll();

?>
<div id="survey-list">
    <h3>Surveys List</h3>
    <?php foreach ($surveys as $survey): ?>
    <div class="survey">
        <a href="survey.php?id=<?php echo $survey['id'] ?>" class="name"><?php echo $survey['name'] ?></a>
        <div class="meta">
            Added by
            <span class="author"><?php echo $survey['author_first_name'] ?> <?php echo $survey['author_last_name'] ?></span>
            on
            <span class="date"><?php echo date_create($survey['created_at'])->format('l, j F Y @ H:i') ?></span>
        </div>
    </div>
    <?php endforeach ?>
</div>
<?php

include 'footer.php';

?>
