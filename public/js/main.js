/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

var game = {
    started: false,

    sendStartRequest: function sendStartRequest() {
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
            success: function success(res) {
                $('.square').css('cursor', 'pointer');
                $('#game-id').val(res.id);
            }
        });
    },

    displayResult: function displayResult(winner) {
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

    updateBoard: function updateBoard(res) {
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

$(document).ready(function () {
    $('.square').click(function () {
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
                    "row": row - 1,
                    "column": column - 1
                },
                dataType: "JSON",
                success: game.updateBoard
            });
        }
    });

    $('#start-link').click(function () {
        game.sendStartRequest();
        $(this).hide();
        game.started = true;
    });
});

/***/ }),
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(0);


/***/ })
/******/ ]);