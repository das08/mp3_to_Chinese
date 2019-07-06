function sendFileToServer(formData, status) {
    $('#error').hide();
    $('#message').hide();
    $('#card').hide();
    $('#loading').show();
    var uploadURL = "up2.php"; //Upload URL
    var jqXHR = $.ajax({
        url: uploadURL,
        type: "POST",
        contentType: false,
        processData: false,
        cache: false,
        dataType: "text",
        data: formData,

        success: function (data) {
            
            $('#result').empty();
            $("#status").remove();
            var obj = $.parseJSON(data);
            console.log(data);
            var add_contents = '';
            if (obj.data !== undefined) {
                $.each(obj.data,
                    function (index, val) {
                        add_contents += '<p>' + val.trans + '</p>';
                    }
                );
                $("#result").prepend("<h5>" + obj.filename + "</h5>");
                $('#result').append(add_contents);
                $('#card').show();
            } 
            if (obj.message !== undefined) {
                $("#message").html(obj.message);
                $('#message').show();
            }
            if (obj.error !== undefined) {
                $("#error").html(obj.error);
                $('#error').show();
            }
            $('#loading').hide();
        }
    });
}
function handleFileUpload(files, obj) {
        var fd = new FormData();
        fd.append('file', files[0]);
        sendFileToServer(fd, status);
}
$(document).ready(function () {
    var obj = $("#dragandrophandler");
    obj.on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', '2px solid #0B85A1');
    });
    obj.on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    obj.on('drop', function (e) {

        $(this).css('border', '2px dotted #0B85A1');
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        handleFileUpload(files, obj);
    });
    $(document).on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $(document).on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        obj.css('border', '2px dotted #0B85A1');
    });
    $(document).on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

});

function file_upload() {
    $('#error').hide();
    $('#message').hide();
    $('#card').hide();
    $('#loading').show();
    // フォームデータを取得
    var formdata = new FormData($('#file_select').get(0));

    // POSTでアップロード
    $.ajax({
        url: "up2.php",
        type: "POST",
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "text"
    })
        .done(function (data, textStatus, jqXHR) {

            $('#result').empty();
            $("#status").remove();
            var obj = $.parseJSON(data);
            console.log(data);
            var add_contents = '';
            if (obj.data !== undefined) {
                $.each(obj.data,
                    function (index, val) {
                        add_contents += '<p>' + val.trans + '</p>';
                    }
                );
                $("#result").prepend("<h5>" + obj.filename + "</h5>");
                $('#result').append(add_contents);
                $('#card').show();
            } 
            if (obj.message !== undefined) {
                $("#message").html(obj.message);
                $('#message').show();
            }
            if (obj.error !== undefined) {
                $("#error").html(obj.error);
                $('#error').show();
            }
            $('#loading').hide();
            
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert("fail");
        });
}