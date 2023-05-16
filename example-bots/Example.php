<?php
error_reporting(0);
set_time_limit(0);
ob_start();
if(!file_exists("iTelegram.php")){
    copy('https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.php', 'iTelegram.php');
}
require_once('iTelegram.php');
use iTelegram\Bot;
define('API_KEY', "BOT_ACCESS_TOKEN");

$bot		= new Bot();
$bot->Authentification(API_KEY);
$text		= $bot->Text();
$chat_id	= $bot->getChatId();
$username	= $bot->getChatUsername();
$firstname	= $bot->getChatFirstname();
$message_id	= $bot->MessageId();

if($text == "/start"){
    $r = $bot->sendMessage($chat_id, "<b>Hello</b> <a href='tg://user?id=$chat_id'>$firstname</a> !\n\n<b>Special Thanks for using iNeoTeam Telegram Bot Class.</b>\n\n<b>GitHub:</b> https://github.com/iNeoTeam/iTelegram\n<b>Powered By</b> @iNeoTeam.", "HTML", true);
}elseif($text == "/update"){
	$r = $bot->sendMessage($chat_id, "*Please wait ...*", "MarkDown", true);
	unlink("iTelegram.php");
	copy("https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.php", "iTelegram.php");
	sleep(2); // for example
	$bot->deleteMessage($chat_id, $r->result->message_id);
	$bot->sendMessage($chat_id, "<b>New class loaded successfully.</b>", "HTML", true, $message_id);
}else{
    $bot->sendMessage($chat_id, "*Command not found.*", "MarkDown");
}
unlink("error_log");
?>
