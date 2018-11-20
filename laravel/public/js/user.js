/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {

    $(document).on('click', '#get_prize', function (e) {
        e.preventDefault();

        $.get('/prize/get')
                .done(function (data) {
                    $('.card-prize>.card-body').html('');
                    var typePrize = data.type === 'product' ? data.prize.name : data.type + ': ' + data.prize.amount + data.prize.name;
                    $('.card-prize>.card-body').append('<h2 class="type">You won a ' + capitalizeFirstLetter(typePrize) + '!</h2>');

                    if (data.type !== 'point') {                        
                        if (data.type === 'cash') {
                            $('.card-prize>.card-body').append('<p class="description">Your prize will be credited to the your account within 24 hours!</p>');
                            $('.card-body').append('<p class="description">You may convert your prize to points.</p>');
                        } else {
                            $('.card-prize>.card-body').append('<p class="description">Your prize will be shipped within 24 hours!</p>');
                        }
                        $('.card-prize>.card-body').append('<p class="description">You may refuse the prize.</p>');
                    } else {
                        updateUserAmount();
                    }

                    if (data.prize.action.length > 0) {
                        $('.card-prize>.card-body').append('<div class="actions"></div>');
                        data.prize.action.map(function (action) {
                            var actionClass = action === 'confirm' ? 'success' : (action === 'discard' ? 'danger' : 'primary');                            
                            $('.card-prize>.card-body>.actions').append('<button name="'+action+'" value="' + data.prize.id + '" class="action_prize btn btn-'+actionClass+' btn-right">'+capitalizeFirstLetter(action)+'</button>');
                        });
                    }

                    $('.card-prize').addClass('show_prize');
                })
                .fail(function (data) {
                    $('.card-prize').removeClass('show_prize');
                    $('.card-prize>.card-body').html('');
                    alert(data.responseText);
                });
    });

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $(document).on('click', '.action_prize', function (e) {
        e.preventDefault();
        var action = $(this).attr('name');
        $.get('/prize/'+action,{id: $(this).val() })
                .done(function (data) {
                    if(data.success == 'ok'){
                        $('.card-prize>.card-body>.actions').html('<h2>'+capitalizeFirstLetter(action)+' success!</h2>');
                        if(action === 'change' ){
                             updateUserAmount();
                        }
                    }else{
                        $('.card-prize').removeClass('show_prize');
                        $('.card-prize>.card-body').html('');
                    }
                })
                .fail(function (data) {
                    $('.card-prize').removeClass('show_prize');
                    $('.card-prize>.card-body').html('');
                    alert(data.responseText);
                });
        
    });

    function updateUserAmount() {
        $.get('/user/amount')
                .done(function (data) {
                    $('#userAmount>.amount').text(data.amount);
                })
                .fail(function (data) {
                    $('#userAmount>.amount').text(0);
                });
    }

});