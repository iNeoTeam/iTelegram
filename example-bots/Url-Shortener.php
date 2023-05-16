<?php
error_reporting(0);
set_time_limit(0);
ob_start();
define('TOKEN', "TELEGRAM_BOT_ACCESS_TOKEN");
if(!file_exists("iTelegram.php")){
	copy("https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.php", "iTelegram.php");
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
	$text = "🖐Hi <a href='tg://user?id=$chat_id'>$firstname</a> !\n\n😗Please send me a long url.";
	$bot->sendMessage($chat_id, $text, "HTML", true, $message_id, null);
}elseif($text == "/creator"){
	$message = "💥This Bot Coded By <a href='https://t.me/iNeoTeam'>iNeoTeam</a>.\n\n🖥<b>Based on:</b> <a href='https://github.com/iNeoTeam/iTelegram'>iTelegram</a>.";
	$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, null);
}else{
	$payload = array('http' => array('header' => "content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query(['longUrl' => $text])));
	$result = file_get_contents("https://ineo-team.ir/url-shortener/", false, stream_context_create($payload));
	preg_match("#<a href='./'>Short New URL</a><br><br><b>Short URL:</b><br><code>(.*?)</code>#su", $result, $out);
	if($out[1] == null){
		$message = "❌<b>Ooops, can't short this url :(</b>";
	}else{		
		$message = "✅<b>Link Shorted.</b>\n\n🔗 <a href='".$out[1]."'>".str_replace("https://", null, $out[1])."</a>";
	}
	$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, null);
}
unlink("error_log");
?>
