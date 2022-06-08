'use strict';

$(document).ready(function() {
    let refresh = () => {
        $.ajax({
            method: 'POST',
            cache: false,
            url: '/index.php?r=recipe/get-active',
            data: {},
            success: function (data) {
                if (recipe_id !== data.id) {
                    document.location.reload();
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    setInterval(() => refresh(), 2000);
});