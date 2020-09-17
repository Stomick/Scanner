<?php
?>
<script src="/js/socket.io.js"></script>

<div class="hidden" id="token" data-id="ap1IT41gal3Im54zCytp"></div>
<div class="hidden" id="page_id" data-id="<?= $page_id ?>"></div>
<div class="hidden" id="user_id" data-id="1"></div>
<div class="widget-chat full-chat">
    <header>
        <h4 class="online"> Chatting  with  Mayane</h4>
    </header>
    <div class="chat-body">
        <dl class="chat" id="chat_inner_text">

        </dl>
    </div>
    <footer>
        <form class="message-input">
            <input name="message" type="text" id="mtext" placeholder="Enter your message">
            <button type="button"  class="btn btn-theme send_message">Отправить</button>
        </form>
    </footer>
</div>
<script src="/js/chat.js"></script>
