<!-- Chat component -->
<div class="chat">
    <div class="messages col-12 my-2">
        <div id="message-box"></div>
    </div>

    <div class="input-group col-12 my-2">
        <div class="input-group-prepend">
            <span class="input-group-text" id="name" value="<?php echo $_SESSION['nickname']; ?>"><?php echo $_SESSION['nickname']; ?></span>
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