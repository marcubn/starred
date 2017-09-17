$("#send_btn").click(function(){
    var data = {request : $("#url").val()};
    $.ajax({
        url: "process/",
        type: "POST",
        data: data,
        success: function(data, dataType)
        {
            alert(data);
        },
    });
});
