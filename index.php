<?php

$title = 'Dinner Randomizer 9000';

?>

<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<title><?php echo $title; ?></title>
</head>
<body>
<div class='container'>
<?php

$jsonRand = file_get_contents('dinner.json');
$jsonArray = json_decode($jsonRand, true);
$dinner = $jsonArray[rand(0, count($jsonArray) -1)];
$dinnerString = json_encode($dinner);

if (($pos = strpos($dinnerString, ":")) !== FALSE) {
    $dinner2 = substr($dinnerString, $pos+1);
}

$result = preg_replace('/[^a-zA-Z0-9_ -]/s','', $dinner2);

?> 

<div class="alert alert-info" role="alert">Dinner is <strong><?php echo $result; ?></strong>

<br />
<div class="alert alert-danger" role="alert">
That doesn't sound good, <a class="alert-link" href="<?php $_SERVER['PHP_SELF']; ?>">try again.</a>
</div>
</div>
<div>
    <?php
    $message = '';
    $error = '';

    if(isset($_POST["submit"]))
    {
        if(empty($_POST["title"]))
        {
            $error = "<label class='text-danger'>Enter dinner item</label>";
        }
        else{
            if(file_exists('dinner.json'))
            {
                $current_data = file_get_contents('dinner.json');
                $array_data = json_decode($current_data, true);
                $extra = array(
                    'title' =>  $_POST['title']
                );
                $array_data[] = $extra;
                $final_data = json_encode($array_data);
                if(file_put_contents('dinner.json', $final_data))
                {
                    $message = "<label class='text-success'>Dinner idea added.</p>";
                }
                else{
                    $error = "JSON file does not exist";
                }
            }
        }
    }
    ?>
    <h3 align=""> Add a dinner idea</h3><br />
    <form method="post">
        <?php
        if(isset($error))
        {
            echo $error;

        }
        ?>
        <br />
        <label>Dinner idea</label>
        <input type="text" name="title" class="form-control" /><br />

        <input type="submit" name="submit" value="Submit" class="btn btn-info" /><br />
        <?php
        if(isset($message))
        {
            echo $message;
        }
        ?>
    </form>
</div>
</body>

</html>