'use strict';

$(document).ready(function() {
    let content = $('#recipe-edit');
    let pjax = '#recipe-pjax';
    let recipe_id = $('input[name=recipe_id]').val();
    let total = $('#total-weight');

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
                        refreshTotal();
                        if (focus) {
                            let f = content.find('input[data-id=' + focus + ']');
                            if (f) {
                                f.focus();
                            }
                        }
                    });
            },
            error: function (err) {
                alert(err.responseText);
            }
        });
    }

    let refreshTotal = () => {
        let sum = 0;
        $('input[name="weight-value"]').each((i, el) => sum += Number(el.value));
        total.html(sum > 1000 ? (Math.floor(sum / 1000) + ' кг ' + sum % 1000) : sum);
    }

    let buildParams = (target) => {
        let row = $(target).closest('tr');
        return {
            recipe_id: recipe_id,
            section_id: row[0].getAttribute('section_id'),
            nutrient_id: row[0].getAttribute('nutrient_id'),
        }
    }

    refreshTotal();

    content
        .change('input[name=weight-value]', e => {
            if (e.target.getAttribute('name') === 'weight-value') {
                let params = buildParams(e.target);
                let focus = e.target.getAttribute('data-id');
                params.weight = $(e.target).val();
                pjax = '#' + $(e.target).closest('div[data-pjax-container=""]').prop('id');
                changeRow(params, focus);
            }
        })
        .change('input[name=comment-value]', e => {
            if (e.target.getAttribute('name') === 'comment-value') {
                let params = buildParams(e.target);
                let focus = e.target.getAttribute('data-id');
                params.comment = $(e.target).val();
                pjax = '#' + $(e.target).closest('div[data-pjax-container=""]').prop('id');
                changeRow(params, focus);
            }
        })
        .on('click', '.remove-row', e => {
            e.preventDefault();
            let params = buildParams(e.target);
            params.weight = 0;
            pjax = '#' + $(e.target).closest('div[data-pjax-container=""]').prop('id');
            changeRow(params, false);
        });
});