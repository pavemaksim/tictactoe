<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tic Tac Toe</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Tic Tac Toe
                </div>
                <div class="hints">
                </div>
                <div class="board m-b-md">
                    <input type="hidden" id="game-id" value="">
                    <div class="board-row">
                        <div class="square">
                            <div class="square-item" data-row="1" data-column="1"></div>
                        </div>
                        <div class="square">
                            <div class="square-item" data-row="1" data-column="2"></div>
                        </div>
                        <div class="square">
                            <div class="square-item" data-row="1" data-column="3"></div>
                        </div>
                    </div>
                    <div class="board-row">
                        <div class="square">
                            <div class="square-item" data-row="2" data-column="1"></div>
                        </div>
                        <div class="square">
                            <div class="square-item" data-row="2" data-column="2"></div>
                        </div>
                        <div class="square">
                            <div class="square-item" data-row="2" data-column="3"></div>
                        </div>
                    </div>
                    <div class="board-row">
                        <div class="square">
                            <div class="square-item" data-row="3" data-column="1"></div>
                        </div>
                        <div class="square">
                            <div class="square-item" data-row="3" data-column="2"> </div>
                        </div>
                        <div class="square">
                            <div class="square-item" data-row="3" data-column="3"></div>
                        </div>
                    </div>
                </div>
                <div class="result">
                    
                </div>

                <div class="links start-block">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <a id="start-link" href="javascript:void(0);">Start</a>
                </div>
            </div>
        </div>
        <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="/js/main.js"></script>
    </body>
</html>
