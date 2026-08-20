@extends('layouts.admin')  
@section('content') 
 <style>
    l{  
        display: none;
        fon
    }
 
    
   /*  .content_p2{
        display: block;
    } */

 </style>

<!-- <?=$result?> -->

<div id="conts" class="divSearch" style="cursor:unset" onmouseover="this.style.backgroundColor='white'" ></div>

  <script>

            function LoadPage(php_page){
                var xhr = new XMLHttpRequest();
                xhr.open('GET', php_page, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {  
                   
                        var responseDoc = new DOMParser().parseFromString(xhr.responseText, "text/html");
                        var specificDiv = responseDoc.getElementById('<?=$result?>').innerHTML;
                        var contDiv = document.getElementById('conts'); 
                        contDiv.innerHTML=specificDiv;  
                        var elements = contDiv.querySelectorAll('.content_p');
                        var elements2 = contDiv.querySelectorAll('.content_p2');
                        
                        elements.forEach(function(element) { 
                        element.setAttribute('style', 'font-size:15px;display:block;font-style:normal;text-decoration:underline;font-weight:bold;margin-top:20px;color:#49a3b4');
                        });

                        elements2.forEach(function(element) { 
                        element.setAttribute('style', 'font-size:15px;display:block');
                        });
                    }
                };
                xhr.send();
            }
            
            LoadPage('{{url("/search/a")}}');
  </script>
@endsection