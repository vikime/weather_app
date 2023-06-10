<?php
include('dbconnection.php');

$status="";
$message="";
$city=" ";
if(isset($_POST['submit'])){
    $city=$_POST['city'];
    $url="http://api.openweathermap.org/data/2.5/weather?q=$city&appid=49c0bad2c7458f1c76bec9654081a661";
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $result=curl_exec($ch);
    curl_close($ch);
    $result=json_decode($result,true);
    
    if($result['cod']==200){
        $status="yes";
    }else{
        $message=$result['message'];
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <div class="weather-form">
         <form  method="post">
            <div>
            <input type="text" class="text" placeholder="Enter City Name..." name="city" />
            </div>
            <div>
            <input type="submit" value="Submit" class="submit" name="submit"/>
            </div>
         </form>
        
   </div>
   <div class="message">
    <h2> <?php echo $message?> </h2>
   </div>
     

    <?php if($status=="yes"){?>
      <article class="weather-container">
                    <div class="temperature">
                        <span><?php echo round($result['main']['temp']-273.15)?>°</span>
                    </div>
                    <div class="condition">
                        <span><?php echo $result['weather'][0]['main']?></span>
                    </div>
                    <div class="speed">
                        <span><?php echo "Wind Speed : " .$result['wind']['speed']?> M/H</span>
                    </div>

      </article>              
        <div class="place">
            <span><?php echo $result['name']?></span>
        </div>
            
        <div class="date">
                <?php echo date("D  j M Y G:i:s",$result['dt'])?> 
        </div>


        
    <?php } ?>


</body>
</html>