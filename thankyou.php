<?php

/*******w******** 
    
    Name:
    Date:
    Description:

****************/
//Email validation
    function filterinputemail(){
        return filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    };
        
    if (isset($_POST['email']) && !filterinputemail()) {
           $errors[] = "Invalid email address";
       };  


//Postal code validation
    $postal_regex = '/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/';
    $postal = $_POST['postal'];


    if (isset($postal) && !preg_match($postal_regex, $postal)) {
        $errors[] = "Invalid postal code";
    };




//Credit card number validation
    $credit_regex = '/^[0-9]{10}$/';
    $credit = $_POST['cardnumber'];


    if (isset($credit) && !preg_match($credit_regex, $credit)) {
        $errors[] = "Invalid card number";
    };


//card month validation
    $credit_month = $_POST['month'];

    if (isset($credit_month) && trim($credit_month) > 12 ) {
        $errors[] = "Invalid card month";
    };


//credit card year validation
    $year = $_POST['year'];

    $current_year = date_create("2024");
    $interval = date_interval_create_from_date_string('5 years');
    $limit = date_add($current_year, $interval) ;

    if ($year > $limit ) {
           $errors[] = "Invalid expiry year";
       }; 


//credit card type validation
    $radio = $_POST['cardtype'];

    if(!isset($radio) && strlen(trim($radio)) == 0){
            $errors[] = "No card type selected.";
    } 




//personal identity validation(fullname, cardname, address, city)
    if(empty($_POST['fullname']) || strlen(trim($_POST['fullname'])) == 0){
        $errors[] = "No full name entered";
    }

    if(empty($_POST['cardname']) || strlen(trim($_POST['cardname'])) == 0){
        $errors[] = "No card name entered";
    }

    if(empty($_POST['address']) || strlen(trim($_POST['address'])) == 0){
        $errors[] = "No address entered";
    }

    if(empty($_POST['city']) || strlen(trim($_POST['city'])) == 0){
        $errors[] = "No city entered";
    }


    //province validation
    $province = $_POST['province'];

    if (isset($province) && trim($province) == " ") {
            $errors[] = "No province selected";
        }
    


//Quantities validation
    $qty_1 = $_POST['qty1'];

    if (isset($qty_1) && filter_input(INPUT_POST, 'qty1', FILTER_VALIDATE_INT) && $qty_1 > 0) {
        
             $cart_items[] = 
                            ['item' => 'iMac',
                             'quantity' => $qty_1,
                             'cost' => doubleval($qty_1) * 1899.99];
                            
        }

    $qty_2 = $_POST['qty2'];

    if (isset($qty_2) && filter_input(INPUT_POST, 'qty2', FILTER_VALIDATE_INT) && $qty_2 > 0) {
        
             $cart_items[] = 
                            ['item' => 'Razer Mouse',
                             'quantity' => $qty_2,
                             'cost' => doubleval($qty_2) * 79.99];
                            
        }


    $qty_3 = $_POST['qty3'];

    if (isset($qty_3) && filter_input(INPUT_POST, 'qty3', FILTER_VALIDATE_INT) && $qty_3 > 0) {
        
             $cart_items[] =  
                            ['item' => 'WD HDD',
                             'quantity' => $qty_3,
                             'cost' => doubleval($qty_3) * 179.99];
        }


    $qty_4 = $_POST['qty4'];

    if (isset($qty_4) && filter_input(INPUT_POST, 'qty4', FILTER_VALIDATE_INT) && $qty_4 > 0) {
        
             $cart_items[] = 
                            ['item' => 'Google Nexus',
                             'quantity' => $qty_4,
                             'cost' => doubleval($qty_4) * 249.99];
                         
        }



    $qty_5 = $_POST['qty5'];

    if (isset($qty_5) && filter_input(INPUT_POST, 'qty5', FILTER_VALIDATE_INT) && $qty_5 > 0) {
        
             $cart_items[] = 
                            ['item' => 'DD-45',
                             'quantity' => $qty_5,
                             'cost' => doubleval($qty_5) * 119.99];
                        
        }
//total calculation of all costs
    foreach ($cart_items as $item ) {
             $total += $item['cost'];
        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Thanks for your order!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php if (empty($errors)) : ?>
    <h2>Thank you for your order <?= $_POST['fullname']?></h2>
    <h3> Here's a summary of your order: </h3>

        <table id="tableOne">
            <caption>Address Information</caption>
            <tr>
                <td>Adress:</td>
                 <td><?=$_POST['address']?> </td>
                 <td>City:</td>
                 <td><?= $_POST['city']?></td>
            </tr>

            <tr>
                <td>Province:</td>
                <td><?= $province ?></td>
                <td>Postal code:</td>
                <td><?= $postal ?></td>
            </tr>

            <tr id="thirdRow">
                <td colspan="2">Email:</td>
                <td colspan="2"><?= $_POST['email'] ?></td>
            </tr>
        </table>

         <table id="tableTwo">
            <caption>Order Information</caption>
            <tr>
                <td>Quantity</td>
                <td>Description</td>
                <td>Cost</td>
            </tr>


            <?php foreach ($cart_items as $item ) :?>

            <tr>
                <td> <?= $item['quantity'] ?> </td>
                <td><?= $item['item']?></td>
                <td><?= $item['cost']?></td>
            </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="2">Totals:</td>
                <td><?= $total ?></td>
            </tr>
        </table>

    <?php else:?>
        <?php foreach ($errors as $error):?> 
            <p> <?= $error ?> </p>
        <?php endforeach ?>

        <h5>Sorry this page can only be loaded when submitting an order</h5>

    <?php endif?>
    
</body>
</html>