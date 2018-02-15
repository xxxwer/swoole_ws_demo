<!DOCTYPE html>
<meta charset="utf-8" />
<title>
<?php echo $data['d']; ?>
</title>
<style type="text/css">
#output {
    height: 100px;
    border: solid lightgray 1px;
    overflow: auto;
    padding: 20px;
}
</style>
<script language="javascript"type="text/javascript">
    var wsUri ="ws://172.16.98.163:9501";
    var websocket;
    function init() {
        var output = document.getElementById("output");
        var sendMsg = document.getElementById("send-text");
        var sendBtn = document.getElementById("send-btn");

        var myws = new myWS(output);
        initWebSocket(myws);

        var doSendMsg = function(){
            var msg = {};
            msg.route = 'ws_test1';
            msg.data = sendMsg.value;
            myws.doSend(JSON.stringify(msg));
        }

        sendBtn.addEventListener('click', doSendMsg, false)
    }

    function myWS(output)
    {
        this.output = output;
        this.config = {};
        this.config.type = 'debug';
    }

    myWS.prototype.debug = function(evt){
        if (this.config.type === 'debug') {
            console.log(evt);
        }
    }

    myWS.prototype.onOpen = function(evt) {
        this.debug(evt);
        this.writeToScreen("CONNECTED");
        this.doSend("WebSocket rocks");
    }
    myWS.prototype.onClose = function(evt) {
        this.debug(evt);
        this.writeToScreen("DISCONNECTED");
    }
    myWS.prototype.onMessage = function(evt) {
        this.debug(evt);
        this.writeToScreen('<span style="color: blue;">RESPONSE: '+ evt.data+'</span>');
        // websocket.close();
    }
    myWS.prototype.onError = function(evt) {
        this.debug(evt);
        this.writeToScreen('<span style="color: red;">ERROR:</span> '+ evt.data);
    }
    myWS.prototype.doSend = function(message) {
        this.writeToScreen("SENT: " + message);
        websocket.send(message);
    }
    myWS.prototype.writeToScreen = function(message) {
        var pre = document.createElement("p");
        pre.style.wordWrap = "break-word";
        pre.innerHTML = message;
        this.output.appendChild(pre);
    }

    function initWebSocket(myws) {
        websocket = new WebSocket(wsUri);

        websocket.onopen = function(evt) {
            myws.onOpen(evt)
        };
        websocket.onclose = function(evt) {
            myws.onClose(evt)
        };
        websocket.onmessage = function(evt) {
            myws.onMessage(evt)
        };
        websocket.onerror = function(evt) {
            myws.onError(evt)
        };
    }

    window.addEventListener("load", init, false);


    console.log(JSON.parse('<?php echo json_encode($data["request"]); ?>'));
</script>
<h2><?php echo $data['d']; ?></h2>
<div id="output"></div>
<input type="text" id="send-text">
<button id="send-btn">发送</button>
</html>