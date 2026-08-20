<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Wizard Template</title>
  <style>
 

    .wizard-container {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 20vh;  
      width: 100%;
    }

    .step {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 130px;
      height: 50px;
      border-radius: 50%;
      background-color: #ddd;
      color: white;
      font-weight: bold;
      font-size: 18px;
      z-index: 2;
      border:3px solid #4CAF50;
    }
  
    .step.completed {
      background-color:#B6E292;
    }

    .step.rejected {
      background-color:#f89aa9;
      border:3px solid #c86474;
    }

    .step.current {
      background-color: #2196F3;
    }


    .step.incompleted {
      background-color: #ddd;
      border:3px solid #ddd;
    }

    /* Line styling */
    .line {
      width: 100%;
      height: 4px;
      background-color: #ddd;
      z-index: 1;
    } 

    .line.completed {
      background-color: #4CAF50;
    }

    /* Check mark styling */
    .step.completed:after {
      content: "✔";
      position: absolute;
      top: -30px;  /* Position the check mark above the circle */
      font-size: 18px;
      color: green;
    }

    .step.rejected:after {
       /*  content:"\26A0"; */
      content: "✖";
      position: absolute;
      top: -30px;  
      font-size: 18px;
      color: #c86474;
    }

    h5{
        font-weight: bold;
        color:#7499b5
    }

    .cust{
      /* display:none */
    }

    #divF{
        font-size:45px;
        color:#61aebf
    }

  </style>
</head>
<body>
<?php 
    $num = count($wizard['rows']); 
?>
  @if( $num>1)
   <div class="form-control">
        <center><h5>Application Wizard</h5></center>
        <hr>
        <div class="wizard-container">
           @foreach($wizard['rows'] as $rows)
           <?php 
                $setpID = "w_step".$rows->templateLineId;
                $lblID = "w_lbl".$rows->templateLineId;  
           ?> 
            <label for="<?=$setpID?>" id="<?=$lblID?>"></label> 
             <div class="step {{$rows->class}}" id="<?=$setpID?>" onmouseover="hover_success_message('<?=$lblID?>','{{$rows->hoverMesaage}}')">{{$rows->templateLineId}}</div>
            @if($rows->templateLineId<$num)
            <div class="line {{$rows->class}}"></div> 
            @else
            <div class="line {{$rows->class}}"></div> 
            <div id="divF"><i class="fa-solid fa-flag-checkered"></i></div>
            @endif 

           @endforeach
            

        </div>
   </div>
   @endif

</body>
</html>
