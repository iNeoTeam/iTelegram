<?php
error_reporting(0);
set_time_limit(0);
ob_start();
define('TOKEN', "TELEGRAM_BOT_ACCESS_TOKEN");
if(!file_exists("iTelegram.php")){
	copy("https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.phar", "iTelegram.php");
}
if(!file_exists("index.php")){
	copy("https://api.ineo-team.ir/redirector.txt", "index.php");
}
require_once("iTelegram.php");
use iTelegram\Bot;
$bot			= new Bot();
$bot->Authentification(TOKEN);
$update			= $bot->getUpdate();
$text			= $bot->Text();
$chat_id		= $bot->getChatId();
$firstname		= $bot->getChatFirstname();
$message_id		= $bot->MessageId();
$users			= file_get_contents("botUsers.txt");
if(isset($chat_id) && !in_array($chat_id, explode("\n", $users))){
	$users .= $chat_id."\n";
	file_put_contents("botUsers.txt", $users);
}
if($text == "/start"){
	$text = "🖐Hi <a href='tg://user?id=$chat_id'>$firstname</a> !\n\n😗Please send me a url.";
	$bot->sendMessage($chat_id, $text, "HTML", true, $message_id, null);
}elseif($text == "/creator"){
	$message = "💥This Bot Coded By <a href='https://t.me/iNeoTeam'>iNeoTeam</a>.\n\n🖥<b>Based on:</b> <a href='https://github.com/iNeoTeam/iTelegram'>iTelegram</a>.";
	$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, null);
}else{
	$message = "♻️<b>Please wait ...</b>";
	$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, null)->result->message_id;
	$payload = array('http' => array('header' => "content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query(['wurl' => $text])));
	$result = file_get_contents("https://ineo-team.ir/webshot/", false, stream_context_create($payload));
	preg_match("#<a href='./'>Take New Screenshot</a><br><br><b>Image URL:</b><br><code>(.*?)</code><br><b>Show:</b><br><a href='' target='_blank'><img src='(.*?)' width=350></a>#su", $result, $out);
	if($out[2] == null){
		$message = "❌<b>Ooops, can't take screenshot from url :(</b>";
		$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, null);
	}else{		
		$message = "✅<b>Successfully.</b>\n\n📥<b>Download:</b> <a href='".$out[1]."'>".str_replace("https://", null, $out[1])."</a>";
		$bot->sendPhoto($chat_id, $out[2], $message, "HTML", false, $message_id, null);
	}
	$bot->deleteMessage($chat_id, $r);
}
unlink("error_log");
?>
