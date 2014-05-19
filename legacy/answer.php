<?php

include 'header.php';

$survey = $pdo->query('SELECT * FROM survey WHERE id = ' . $_GET['id'])->fetch();
$questions = $pdo->query('SELECT * FROM question WHERE survey_id = ' . $_GET['id'])->fetchAll();

if (isset($_POST['author_first_name'])) {
    foreach ($questions as $question) {
        $authorFirstname = $_POST['author_first_name'];
        $authorLastname = $_POST['author_last_name'];
        $authorEmail = $_POST['author_email'];
        $choice = $_POST['question_' . $question['id']];

        $pdo->query(<<<SQL
INSERT INTO answer(question_id, author_first_name, author_last_name, author_email, choice)
VALUES({$question['id']}, "{$authorFirstname}", "{$authorLastname}", "{$authorEmail}", {$choice})
SQL
        );
    }

    header('Location: survey.php?id=' . $_GET['id']);
}

?>
<div id="answer-new">
    <h3>New Answer</h3>
    <h4><?php echo $survey['name'] ?></h4>
    <form action="" method="post">
        <fieldset class="author">
            <legend><h4>Author</h4></legend>
            <div class="question">
                <input type="text" name="author_first_name" />
                <label for="author_first_name">First name</label>
            </div>
            <div class="question">
                <input type="text" name="author_last_name" />
                <label for="author_last_name">Last name</label>
            </div>
            <div class="question">
                <input type="text" name="author_email" />
                <label for="author_email">Email</label>
            </div>
        </fieldset>
        <?php foreach ($questions as $question): ?>
        <fieldset>
            <legend><h4><?php echo $question['sentence'] ?></h4></legend>
            <div class="question">
                <input type="radio" id="question_<?php echo $question['id'] ?>_first_choice" name="question_<?php echo $question['id'] ?>" value="1">
                <label for="question_<?php echo $question['id'] ?>_first_choice"><?php echo $question['first_choice'] ?></label>
            </div>
            <div class="question">
                <input type="radio" id="question_<?php echo $question['id'] ?>_second_choice" name="question_<?php echo $question['id'] ?>" value="2">
                <label for="question_<?php echo $question['id'] ?>_second_choice"><?php echo $question['second_choice'] ?></label>
            </div>
            <div class="question">
                <input type="radio" id="question_<?php echo $question['id'] ?>_third_choice" name="question_<?php echo $question['id'] ?>" value="3">
                <label for="question_<?php echo $question['id'] ?>_third_choice"><?php echo $question['third_choice'] ?></label>
            </div>
        </fieldset>
        <?php endforeach ?>
        <button type="submit" class="button">Validate</button>
        or
        <a href="survey.php?id=<?php echo $_GET['id'] ?>">Cancel</a>
    </form>
</div>
<?php

include 'footer.php';

?>
