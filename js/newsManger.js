//появление формы добвления новости

$(document).ready(function(){
    $('#addnew').click(function(event){
        $('body').append('<div id="overlay2"></div>' +
            '<div id="addform"><form id = "formD" method="POST" action="controllers/addnew.php" enctype="multipart/form-data">' +
            '<h2>Добавить новость</h2>"<p id="mes" class="message"></p>"<input type="text" name="header" placeholder = "Введите заголовок статьи:">'+
            '<p>Добавить картинку</p><input type="file" name="image"><textarea cols="40" rows="20" placeholder = "Введите текст статьи:" name="text"></textarea>'+
            '<button type="submit" id="add" value="Сохранить">Сохранить</button><button id="closeform">Закрыть окно</button></form></div>');
        $('#addform').css({
            left: ($(window).innerWidth() - $('#addform').outerWidth())/2,
            top:  (window.innerHeight - $('#addform').outerHeight())/1.7
        });
        $('#addform').fadeIn('fast');
        $('body').on('click', '#closeform', function close(event){
            //$('#closeform').click(function(event) {
            event.preventDefault();
            $('#addform').fadeOut('fast', function(){
                $('#overlay2').remove();
                $('#addform').remove();
            });
        });
        $('#formD').submit(function(event){
            //$('body').on('click', '#add', function(event){
            event.preventDefault();
            //var form = $('#formD')[0];
            //var date = new FormData(form);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: new FormData(this),
                enctype: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                //contentType: "json",
                dataType: "json",
                success: function(result)
                {
                    function secondStep(){
                        $('#addform').fadeOut('fast', function(){
                            $('#overlay2').remove();
                            $('#addform').remove();
                        });
                        window.location.reload();
                        $(window).scrollTop(0);
                    }
                    $('#mes').html(result[0]);
                    if(result[1] == false) {
                        return;
                    }
                    $('#add').attr('disabled', true);
                    let idtime = setTimeout(secondStep, 2000);

                }
            });

        });
    });
});
//удаление записи
$(document).ready(function()
{
    $('body').on('click', '.delnew', function(event) {
        let btn = event.target;
        let id = $(btn).attr('value');
        $.ajax({
            type: 'POST',
            url: 'controllers/delnew.php',
            //contentType: false,
            //cache: false,
            dataType: "json",
            data: ({idnew: id}),
            //processData: false,
            success: function(result) {
                window.location.reload();
            }
        });
    });

});
//редактирование записи
$(document).ready(function()
{
    let id;
    $('body').on('click', '.editnew', function(event) {
        $('body').append('<div id="overlay2"></div>' +
            '<div id="addform"><form id = "formD" method="POST" action="controllers/editnew.php" enctype="multipart/form-data">' +
            '<h2>Изменить новость</h2>"<p id="mes" class="message"></p>"<input id="titleinp" type="text" name="header" placeholder = "Введите заголовок статьи:">'+
            '<p>Изменить картинку</p><input type="file" name="image"><textarea id="textarea" cols="40" rows="20" placeholder = "Введите текст статьи:" name="text"></textarea>'+
            '<button type="submit" id="savenew" value="Сохранить">Сохранить</button><button id="closeform">Закрыть окно</button></form></div>');
        $('#addform').css({
            left: ($(window).innerWidth() - $('#addform').outerWidth())/2,
            top:  (window.innerHeight - $('#addform').outerHeight())/1.7
        });
        $('#addform').fadeIn('fast');
        $('body').on('click', '#closeform', function close(event){
            //$('#closeform').click(function(event) {
            event.preventDefault();
            $('#addform').fadeOut('fast', function(){
                $('#overlay2').remove();
                $('#addform').remove();
            });

        });
        let btn = event.target;
        id = $(btn).attr('value');
        $.ajax({
            type: 'POST',
            url: 'controllers/selectedit.php',
            //contentType: false,
            //cache: false,
            dataType: "json",
            data: ({idnew: id}),
            //processData: false,
            success: function(result) {
                //alert(result["title"]);
                $('#titleinp').val(result["title"]);
                $('#textarea').html(result["text"]);
            }
        });


        $('#formD').submit(function(event){
            //$('body').on('click', '#add', function(event){
            event.preventDefault();
            //var form = $('#formD')[0];
            //var date = new FormData(form);
            let dataQ = new FormData(this);
            dataQ.append("idnew", id);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: dataQ,
                enctype: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData: false,
                //contentType: "json",
                dataType: "json",
                success: function(result)
                {
                    function secondStep(){
                        $('#addform').fadeOut('fast', function(){
                            $('#overlay2').remove();
                            $('#addform').remove();
                        });
                        window.location.reload();
                    }
                    $('#mes').html(result[0]);
                    if(result[1] == false) {
                        return;
                    }
                    $('#savenew').attr('disabled', true);
                    let idtime = setTimeout(secondStep, 2000);

                }
            });

        });
    });
});