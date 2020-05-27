<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous"
        />

        <link rel="stylesheet" href="../public/css/chat.css">
        <title>Chat Demo</title>
    </head>
    <body>
        <div class="chat">
            <div class="message-box">

            </div>
            <div class="chat-input input-group mb3">
                <div class="input-group-prepend">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Your Username"
                    />
                </div>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Your Message"
                />
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        Send
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
