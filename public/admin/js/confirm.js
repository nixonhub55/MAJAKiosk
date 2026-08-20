 
var checker;
function fbconfirm(title, msg, $true, $false, $function) { /*change*/

var $content = "<div id='sucess_messages'" +
    "<div class='modal-backdrop2 confirmSubmit'></div>" +
    "<div class='container floating confirmSubmitFloating'>" +
    "<div class='dialog-ovelay'>" +
                "<div class='dialog'><header>" +
                 " <h3> " + title + " </h3> " +
             "</header>" +
             "<div class='dialog-msg'>" +
                 " <p> " + msg + " </p> " +
             "</div>" +
             "<footer>" +
                 "<div class='controls'style='float: right; padding-bottom: 10px;'>" +
                     " <button class='button button-danger doAction' onclick='"+$function+"'>" + $true + "</button> " +
                     ($false=="" ? "" : " <button class='button button-default cancelAction'>" + $false + "</button> ") +
                 "</div>" +
             "</footer>" +
          "</div>" +
        "</div>";
    "</div>" +
    "</div>" +
    "</div>";

 $('body').prepend($content);

$( ".doAction" ).on( "click", function() {
  $(".confirmSubmitFloating, .confirmSubmit").fadeOut();
}); 
$( ".cancelAction , .fa-close" ).on( "click", function() {
  $(".confirmSubmitFloating, .confirmSubmit").fadeOut();
}); 
} 