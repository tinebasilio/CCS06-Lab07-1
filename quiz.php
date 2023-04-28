<?php

require "vendor/autoload.php";

session_start();

use App\QuestionManager;

$number = null;
$question = null;

try {
    $manager = new QuestionManager;
    $manager->initialize();

    $questions = [];

    for ($number = 1; $number <= $manager->getQuestionSize(); $number++) {
        $question = $manager->retrieveQuestion($number);
        array_push($questions, $question);
    }

    if (isset($_SESSION['is_quiz_started'])) {
        $number = 1;
        //$number = $_SESSION['current_question_number'];
    } else {
        // Marker for a started quiz
        $_SESSION['is_quiz_started'] = true;
        $_SESSION['answers'] = [];
        $number = 1;
    }

    if (isset($_POST['submit'])) {
        for ($number = 1; $number <= $manager->getQuestionSize(); $number++) {
            if (isset($_POST['answer_'.$number])) {
                $_SESSION['answers'][$number] = $_POST['answer_'.$number];
            }
        }

        // Has user answered all items
        $answeredQuestions = count($_SESSION['answers']);
        if ($answeredQuestions == $manager->getQuestionSize()) {
            header("Location: result.php");
            exit;
        } 
    } 
    
} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3, h4 {
            margin-top: 0;
        }
        
        p {
            line-height: 1.5;
            color: #555;
        }
        form {
            background-color: white;
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #aaa;

        }
        input[type="radio"], input[type="checkbox"] {
            margin-right: 10px;
        }
        label {
            font-size: 16px;
            color: #333;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Analogy Questions</h1>
    <h3>Instructions</h3>
    <p>
        There is a certain relationship between two given words on one side of : : and one word is given on another side of : : 
        while another word is to be found from the given alternatives, having the same relation with this word as the words of 
        the given pair bear. Choose the correct alternative.
    </p>

    <form method="POST" action="quiz.php">
        <?php foreach ($questions as $question): ?>
            <div style="margin-bottom: 20px;">
                <h2><?php echo $question->getNumber(); ?>. <?php echo $question->getQuestion(); ?></h2>

                <?php foreach ($question->getChoices() as $choice): ?>
                    <div>
                        <input type="radio" name="answer_<?php echo $question->getNumber(); ?>" value="<?php echo $choice->letter; ?>" id="<?php echo $choice->letter; ?>"/>
                        <label for="<?php echo $choice->letter; ?>"><?php echo $choice->letter . ') ' . $choice->label; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endforeach; ?>

        <input type="submit" name="submit" value="Submit">
    </form>
</div>
</body>
</html>


<!-- DEBUG MODE -->
<pre>
<?php
//var_dump($_SESSION);
?>
</pre>
