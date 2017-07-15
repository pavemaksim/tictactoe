var game = {
    started : false,
    
    sendStartRequest: function() {
        $('.result').html("");
        $('.board').css('opacity', 1);
        $('.square-item').removeClass('xmark taken circle');
        
        $.ajax({
            url: "/api/game/start",
            method: "POST",
            data: {
                "_token": $('#token').val()
            },
            dataType: "JSON",
            success: function(res) {
                $('.square').css('cursor', 'pointer');
                $('#game-id').val(res.id);
            }
        });
    },
    
    displayResult: function(winner) {
        if (winner == 'X') {
            $('.result').html("You won");
            $('.result').css('color', 'green');
        } else if (winner == '') {
            $('.result').html("Draw");
            $('.result').css('color', 'black');
        } else {
            $('.result').html("You lost");
            $('.result').css('color', 'red');
        }
    },
    
    updateBoard: function(res) {
        var newRow = res.nextBotMove[0] + 1;
        var newColumn = res.nextBotMove[1] + 1;

        $('.square').find("div[data-row='" + newRow + "'][data-column='" + newColumn + "']").addClass('circle taken');

        if (res.gameFinished) {
            $('.board').css('opacity', '0.1');
            $('.square').css('cursor', 'auto');

            game.displayResult(res.winner);

            $('#start-link').show();
            game.started = false;
            $('#game-id').val("");
        }
    }
};

$( document ).ready(function() {
    $('.square').click(function() {
        if ($(this).find('.square-item').hasClass('taken')) {
            alert('This square is already taken');
        } else if (game.started) {
            var squareItem = $(this).find('.square-item');

            squareItem.addClass('xmark taken');
            var row = squareItem.attr('data-row');
            var column = squareItem.attr('data-column');

            $.ajax({
                url: "/api/game/" + $('#game-id').val() + "/move",
                method: "POST",
                data: {
                    "_token": $('#token').val(),
                    "row" : row - 1,
                    "column" : column - 1
                },
                dataType: "JSON",
                success: game.updateBoard
            });
        }
    });
    
    $('#start-link').click(function() {
        game.sendStartRequest();
        $(this).hide();
        game.started = true;
    });
});
