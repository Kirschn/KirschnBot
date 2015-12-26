<?php
require_once './api/whatsprot.class.php';
include 'waconf.php';
$w = new WhatsProt($username, $nick, $debug);
require 'api/events/MyEvents.php';
$events = new MyEvents($w);
$events->setEventsToListenFor($events->activeEvents);
$w->eventManager()->bind("onGetMessage", "onMessage");
$w->eventManager()->bind("onGetGroupMessage", "grpmsghandle");
$w->connect();
$w->loginWithPassword($pass);

function onMessage($mynumber, $from, $id, $type, $time, $name, $body)
{
    global $w;
    echo json_encode(["from"=>$from, "id"=>$id, $type="type", "time"=>$time, "user"=>$name, "message"=>$body, "grpmsg" => false]);
    $w->sendMessage($from, "Mein Name ist Hase, ich weiß von nichts! (KirschnBot V2.0.1.8)");
}
function grpmsghandle($mynumber, $from_group_jid, $from_user_jid, $id, $type, $time, $name, $body) {
    global $w;
    global $sqlconnection;
    mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, text, channel, name) VALUES (\"kirschnbot\", \"WABOTPROCESS\", \"" . mysqli_real_escape_string($sqlconnection, $body) . "\", \"" . $from_group_jid . "\", \"" . mysqli_real_escape_string($sqlconnection, $name) . "\");");
}
while(true) {
    echo "Crawling..:";
    $w->pollMessage();
    $todos = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT id, text, channel FROM bottodo WHERE type=\"WABOTSEND\";"));
    if ($todos !== NULL) {
        $w->sendMessage($todos["channel"], $todos["text"]);
        mysqli_query($sqlconnection, "DELETE FROM bottodo WHERE id=\"".$todos["id"]."\";");
 }
    
}
