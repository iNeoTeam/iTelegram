<?php
error_reporting(0);
set_time_limit(0);
ob_start();
if(!file_exists("iTelegram.php")){
    copy('https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.phar', 'iTelegram.php');
}
require_once('iTelegram.php');
use iTelegram\Bot;
define('API_KEY', "BOT_HTTP_ACCESS_TOKEN");
$bot		= new Bot();
$bot->Authentification(API_KEY);
$text		= strtolower($bot->Text());
$chat_id	= $bot->getChatId();
$username	= $bot->getChatUsername();
$firstname	= $bot->getChatFirstname();
$message_id	= $bot->MessageId();
$list		= array(
	"سلام",
	"خوبی؟",
	"آی نئو تیم",
	"Powered By iNeoTeam",
	"Telegram: @iNeoTeam",
	"Name: $firstname",
);
if(in_array($text, ["/start", "استارت کردن ربات"])){
	$message = "<b>سلام دوست من.\n\nمتن هولدر با هر بار استارت کردن ربات تغییر میکند.\n\nاگر با تلگرام نسخه موبایل وارد ربات شده اید، بعد از هر بار کلیک بر روی دکمه زیر، از چت خارج و مجددا وارد شوید تا متن تغییر کند.\n\nگروه ربات سازی و خدمات مجازی آی نئو\n</b>@iNeoTeam";
	$button = json_encode(['keyboard' => [
	[['text' => "استارت کردن ربات"]],
	],
	'resize_keyboard' => true,
	'input_field_placeholder' => $list[array_rand($list)]]);
    $r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
}else{
    $bot->sendMessage($chat_id, "*دستور پیدا نشد.*", "MarkDown");
}
unlink("error_log");
?>
