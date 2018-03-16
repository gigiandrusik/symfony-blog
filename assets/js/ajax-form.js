$(document).ready(function () {

    $('form.ajax-form').on('submit', function(e) {

        e.preventDefault();

        let form = $(this);

        $.post(form.attr('action'), form.serialize(), function (response) {

            let comment = '<li class="list-group-item">' + response.author +' at ' + response.created + ' : ' + response.content + '</li>';

            form.parent('.panel-body').find('ul.list-group').append(comment);

            form[0].reset();
        });
    });
});