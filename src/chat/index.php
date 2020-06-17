<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />

    <!-- JavaScript -->
    <script src="../../public/js/chat.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../../public/css/chat.css" />

    <title>
        Chat Demo
    </title>
</head>

<body>
    <!-- Chat component -->
    <div class="chat">
        <div class="messages col-12 my-2">
            <div id="message-box"></div>
        </div>

        <div class="input-group col-12 my-2">
            <div class="input-group-prepend">
                <input id="name" type="text" class="form-control" placeholder="Your Username" />
            </div>
            <input id="message" type="text" class="form-control" placeholder="Your Message" />
            <div class="input-group-append">
                <button id="send_btn" class="btn btn-outline-secondary" type="button">
                    Senden
                </button>
            </div>
        </div>
    </div>
    <!-- end of Chat -->
</body>

</html>