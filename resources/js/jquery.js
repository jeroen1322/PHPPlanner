$(document).ready(function(){
    $(".new_reminder_field").hide(); 
    $("#new_reminder").click(function(){
        $(".new_reminder_field").toggle("fast", function(){});
    });
    
    $(".description").hide();
    $(".list-group-item").click(function(){
        $(".description").toggle("fast", function(){});
    });
});