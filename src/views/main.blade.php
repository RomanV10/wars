<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{!! asset('css/wars.css') !!}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{!! asset('js/wars.js') !!}"></script>
    <title>Wars</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
               <div id="items-wrap" class="panel panel-default bg-grey">
                <div class="panel-heading bg-white">
                    <div class="left-side">
                        <h5 class="text-light-grey">Wars</h5>
                        <h4 class="text-grey">Highscore</h4>
                    </div>

                    <div class="right-side">
                        <div style="padding-bottom: 10px;">
                            <button type="button" id="show-apis" class="btn btn-info">Enable api</button>
                        </div>
                        <div>
                            <button type="button" id="show-random-apis-items" class="btn btn-info btn-pink">Start the game</button>
                        </div>
                    </div>

                </div>
                <div class="panel-body"></div>
            </div>

            <div class="modal fade" id="modal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
</body>

</html>
