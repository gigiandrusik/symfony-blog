$(document).ready(function() {

    let createForm = function (action) {
        return $('<form action="' + action + '" method="POST"></form>');
    };

    $(document).on('click', 'a.delete-item', function (e) {

        e.preventDefault();

        let confirm_delete = confirm($(this).data('confirm'));

        if (confirm_delete) {

            let form = createForm($(this).attr('href'), {
                _method: 'DELETE'
            }).hide();

            $('body').append(form);

            form.submit();
        }
    });
});