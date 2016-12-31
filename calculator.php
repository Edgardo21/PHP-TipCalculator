<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content= "IE=edge">
        <meta name="viewport" content="width = device-width, initial-scale = 1"> <!--set the viewport-->
        <title>Tip Calculator</title>
        <link rel="stylesheet" type="text/css" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> <!--add bootstap-->
        
        <style>
            .lindo{
                background-color: #87CEEB;
                border: 5px solid black; /*border*/
                width: 350px;/*width of space*/
                height: auto; /*adjust the height of screen*/
                padding-left:1%; /*make the left padding big*/
                padding-bottom:1%; /*make the bottom padding part big*/
                margin: 0 auto; /*to make the calculator apear at center*/
            
            }
            .btn-info
            {
                background-color: #000000; /*submit button background color change*/
            }
        </style>
    </head>
    <body>
    
    <?php
        //help from w3school,stackoverflow.com,derek banas from youtube and special thanks to owen31302(Yu-Cheng Lin) 
        //setting variables
        $billSubtotal = $customBill = ""; //variables to input the bill
        $radiobtn = 10;//declaration of the button in 10%
        $split = 1; // $split is set to 1 person
        $billError = $splitError = $customError = ""; //error handler
        function check_if_int($variable)//check if  a number is a positive int
        {
		$temporal = (int) $variable;
		if($temporal == $variable)
			return true;
		else
			return false;
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (isset($_POST["billSubtotal"]))
                {
                    $billSubtotal = $_POST["billSubtotal"];
                    
                    if(!is_numeric($billSubtotal) && ($billSubtotal != "") || ($billSubtotal < 0) || ($billSubtotal == "")) //check for error in billSubtotal
                    {
                        $billError = "red";
                    }
                    
                }
                if(isset($_POST["radiobtn"])) //radiobutton check
            {
                $radiobtn = $_POST["radiobtn"];
            }
            
            
            if (isset($_POST['customBill'])) //custom bill check
                {
                    $customBill = $_POST["customBill"];
                    if($radiobtn == 0)
                    {
                        if(!is_numeric($customBill) && ($customBill != "") || ($customBill <= 0)) //conditions to check
                        {
                            $customError = "red";
                        }
                    }
                }
         
                
            if (isset($_POST['split'])) // split values check for errrors detected
            {
                $split = $_POST["split"];
                if(!is_numeric($split))
                {
                    $splitError = "red";
                }
                else{
                    if(!check_if_int($split) || ($split <1))
                    {
                        $splitError = "red";
                    }
                    
                }
            }
                
               
        }
                 
    ?>
    <!--This is the form of the calculator-->
    <div class="container">
        <div class="lindo">
    
    <center><h1>Tip Calculator</h1></center>
        <form  method = "post"> 
        <p style="color:<?php echo $billError;?>"> Bill Subtotal:$ <input type = "text" name="billSubtotal" size = "8px" value = "<?php echo $billSubtotal;?>" ></p>
        
        <p style="color:<?php echo $customError;?>" >Tip Percentage:</p>
            <?php
                for($i=2; $i<=4; $i++) //this is the for loop to print out the radiobutton
                {
                    if($radiobtn == $i*5)
                    {
                        echo '<input type="radio" name="radiobtn" checked="checked" value="'.($i*5).'"'.">\t".($i*5)."%\t"; //print radiobutton
                    }
                    else{
                        echo  '<input type="radio" name="radiobtn" value="'.($i*5).'"'.">\t".($i*5)."%\t";	//print radiobutton
                    }
                }
            
            
                if($radiobtn == 0) //check if custom radio button was selected
                {
                    echo '<input type = "radio" name = "radiobtn"  value = "0" checked = "checked">'; //print custom radiobutton
                }
                else{
                    echo '<input type="radio"name = "radiobtn" >';
                }
                
                    echo 'Custom: <input type = "text" size="8px" name = "customBill" value = " '.$customBill.'"> %'; //input the customBill
            ?>
            
            <p style="color:<?php echo $splitError;?>">Split:<input type="text" name ="split" size= "6px"value ="<?php echo $split;?>"> person(s)</p><br>
            
        <center><input type="submit" class= "btn btn-info" value="submit"><br></center>
            <?php
                    $printOut = "";
                    if(is_numeric($billSubtotal) && $billError != "red"){//check for errors before calculation of tip and total
                    $regularTip = (($billSubtotal/100)*$radiobtn); // calculations for tip and total
                    $regularTip = number_format((float)$regularTip,2,'.','');//format the values to 2 decimals after the point
                    $regularTotal = $billSubtotal + $regularTip;
                    $regularTotal = number_format((float)$regularTotal,2,'.','');//format the values to 2 decimals after the point
                    }
                    else
                    {
                        $regularTotal = "n/a";//exeption handling to prevent dangling values.
                        $regularTip = "n/a";
                      
                    }
            
                    if(is_numeric($split) && $splitError != "red" && $billError !="red"){//check for errors with split and then calculate total with split
                    $splitTip = (floor(($billSubtotal/100)*($radiobtn/$split)*100)/100);
                    $splitTip = number_format((float)$splitTip,2,'.','');//format the values to 2 decimals after the point
                    $splitTotal = (($regularTotal)/$split);
                    $splitTotal = number_format((float)$splitTotal,2,'.','');
                    }
                    else{
                        $splitTotal = "n/a";
                        $splitTip = "n/a";
                    }
                    if(is_numeric($billSubtotal) && ($billError != "red") && $billError != "red" && $customError != "red"){//check for errors and calculate custom tip
                    $customTip = ($billSubtotal/100)*$customBill;
                    $customTip = number_format((float)$customTip,2,'.','');
                    $customTotal = $billSubtotal + $customTip;
                    $customTotal = number_format((float)$customTotal,2,'.','');
                    }
                    else{
                        $customTip = "n/a";
                        $customTotal = "n/a";
                    }
                    if(is_numeric($split) && is_numeric($billSubtotal) && $splitError != "red" && $billError = "red" && $customError != "red")//check for errror and calculate custom tip with split
                    {
                        $custom_split_tip = (floor(($billSubtotal/100)*($customBill/$split)*100)/100);
                        $custom_split_tip = number_format((float)$custom_split_tip,2,'.','');
                        $custom_split_total = ($customTotal/$split);
                        $custom_split_total = number_format($custom_split_total,2,'.','');
                        
                    }
                    else{
                        $custom_split_tip = "n/a";
                        $custom_split_total = "n/a";
                    }
                
                if(isset($billSubtotal) && ($billSubtotal >0) && isset($radiobtn)){ //function to print out the results including: Tip,split tip, total, split total
                    
                    if($split >=1 && $radiobtn !=0 )
                    {
                    $printOut = "<td>Tip: $" .$regularTip. "<br> Total: $" .$regularTotal; //totals
                    
                        if ($split > 1 )
                        {
                            $printOut = $printOut."<br>Tip each person: " .$splitTip. "<br>Total each person: $" .$splitTotal;//totals with split
                        }
                    }
                    else
                    {
                        if($split >= 1 && $customBill > 0 )
                        {
                            $printOut = "<td>Tip: $" .$customTip. "<br>Total: $" .$customTotal;//custom totals
                            if($split > 1)
                            {
                               $printOut = $printOut. "<br>Tip each person: " .$custom_split_tip. "<br> Total each person: $" .$custom_split_total; //totals with split
                            }
                        }
                    }
                    $printOut = $printOut."</td>"; //print all the values needed
                    echo $printOut;//print to the screen
                }
                    
                
            ?>
           
            
        </form>
        </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>