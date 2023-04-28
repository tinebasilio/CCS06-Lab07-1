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
    
    //$question = $manager->retrieveQuestion($number);

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
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        #container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
			box-shadow: 0px 0px 10px #aaa;
            padding: 30px;
            margin-top: 100px;
            margin-bottom: 100px;
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-top: 0;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
            margin-top: 0;
            margin-bottom: 10px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            font-size: 16px;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #666;
        }

    </style>
    
</head>
<body>

<div id="container">
    <h1>Analogy Questions</h1>
        <h3>Instructions</h3>
        <p style="color: gray">
            There is a certain relationship between two given words on one side of : : and one word is given on another side of : : 
            while another word is to be found from the given alternatives, having the same relation with this word as the words of 
            the given pair bear. Choose the correct alternative.
        </p>

        <form method="POST" action="quiz.php">

            <?php foreach ($questions as $question): ?>
                <h1>Question #<?php echo $question->getNumber(); ?></h1>
                <h2 style="color: blue"><?php echo $question->getQuestion(); ?></h2>
                <label>Choices</label>
                <input type="hidden" name="number_<?php echo $question->getNumber(); ?>" value="<?php echo $question->getNumber();?>" />
                
                <?php foreach ($question->getChoices() as $choice): ?>
                    <label>
                        <input 
                               type="radio" 
                               name="answer_<?php echo $question->getNumber(); ?>" 
                               value="<?php echo $choice->letter; ?>" id="<?php echo $choice->letter; ?>"/>
                        <label for="<?php echo $choice->letter; ?>"><?php echo $choice->letter . ') ' . $choice->label; ?></label>
                    </label>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <input type="submit" name="submit" value="Next">
        </form>
</div>
</body>
</html>

<!-- DEBUG MODE -->
<pre>
<?php
var_dump($_SESSION);
?>
</pre>
