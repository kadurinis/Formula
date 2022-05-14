'use strict';

function summaryFunc(source, data) {
    console.log(source, data);
}

$(document).ready(function() {
    let content = $('#recipe-edit');
    let pjax = '#recipe-pjax';
    let recipe_id = $('input[name=recipe_id]').val();

    let changeRow = (data, focus = false) => {
        $.ajax({
            method: 'POST',
            cache: false,
            url: '/index.php?r=recipe/change-row',
            data: data,
            success: function (data) {
                $.pjax.reload({
                    container: pjax,
                    timeout: 3000
                })
                    .done(() => {
                        if (focus) {
                            let f = content.find('input[data-id=' + focus + ']');
                            console.log(f);
                            if (f) {
                                f.focus();
                            }
                        }
                    });
            },
            error: function (data) {
                alert(data);
            }
        });
    }

    let buildParams = (target) => {
        let row = $(target).closest('tr');
        return {
            recipe_id: recipe_id,
            section_id: row[0].getAttribute('section_id'),
            nutrient_id: row[0].getAttribute('nutrient_id'),
        }
    }

    content
        .change('input[name=weight-value]', e => {
            if (e.target.getAttribute('name') === 'weight-value') {
                let params = buildParams(e.target);
                let focus = e.target.getAttribute('data-id');
                params.weight = $(e.target).val();
                changeRow(params, focus);
            }
        })
        .change('input[name=comment-value]', e => {
            if (e.target.getAttribute('name') === 'comment-value') {
                let params = buildParams(e.target);
                let focus = e.target.getAttribute('data-id');
                params.comment = $(e.target).val();
                changeRow(params, focus);
            }
        })
        .on('click', '.remove-row', e => {
            e.preventDefault();
            let params = buildParams(e.target);
            params.weight = 0;
            changeRow(params, false);
        });
});