<?php

include 'header.php';

$survey = $pdo->query('SELECT * FROM survey WHERE id = ' . $_GET['id'])->fetch();
$questions = $pdo->query('SELECT * FROM question WHERE survey_id = ' . $_GET['id'])->fetchAll();

?>
<div id="survey-show">
    <h3><?php echo $survey['name'] ?></h3>
    <div class="meta">
        Added by
        <span class="author"><?php echo $survey['author_first_name'] ?> <?php echo $survey['author_last_name'] ?></span>
        on
        <span class="date"><?php echo date_create($survey['created_at'])->format('l, j F Y @ H:i') ?></span>
    </div>
    <div class="questions">

        <?php foreach ($questions as $question): ?>
        <div class="question">
            <h4><?php echo $question['sentence'] ?></h4>
            <ul class="choices">
                <li class="choice"><?php echo $question['first_choice'] ?></li>
                <li class="choice"><?php echo $question['second_choice'] ?></li>
                <li class="choice"><?php echo $question['third_choice'] ?></li>
            </ul>
        </div>
        <?php endforeach ?>
    </div>
    <a class="button fleft" href="index.php">&larr; Back to list</a>
    <a class="button fright" href="answer.php?id=<?php echo $_GET['id'] ?>">Answer this survey &rarr;</a>
</div>
<?php

include 'footer.php';

?>
