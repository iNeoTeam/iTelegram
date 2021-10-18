<?php
error_reporting(0);
set_time_limit(0);
ob_start();
$token		= ""; // set bot access token
$admin		= [0000000000, 0000000000]; // set admin user id
$channel	= ""; // set your channel username
$password	= ""; // set your password
if(!file_exists("iTelegram.php")){
    copy("https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.phar", "iTelegram.php");
}
if(!file_exists("CryptMe.php")){
	copy("https://raw.githubusercontent.com/iNeoTeam/CryptMe/main/CryptMe.php", "CryptMe.php");
}
include "CryptMe.php";
require_once("iTelegram.php");
use iTelegram\Bot;
define("API_KEY", $token);
$bot		= new Bot();
$crypt		= new CryptMe();
$bot->Authentification(API_KEY);
$update		= $bot->Update();
$text		= $bot->Text();
$chat_id	= $bot->getChatId();
$chatID		= $bot->getInlineChatId();
$message_id	= $bot->MessageId();
$messageID	= $bot->InlineMessageId();
$first_name	= $bot->getChatFirstname();
$getMe		= $bot->TelegramAPI('getMe');
$inputType	= $bot->InputMessageType();
$data		= $update['callback_query']['data'];
$button		= $bot->SingleInlineUrlKeyboard("💥طراحی و توسعه توسط آی نئو تیم", "https://t.me/".$channel);
$users		= file_get_contents("users.txt");
$_users		= explode("\n", $users);
if(!is_dir("data")){ mkdir("data"); }
if(!is_dir("upload")){ mkdir("upload"); }
if(!is_dir("data/$chat_id")){ mkdir("data/$chat_id"); }
if(!in_array($chat_id, $_users)){
	$users .= $chat_id."\n";
	file_put_contents("users.txt", $users);
}
if($text == "/start" or $text == "/start 1"){
	$message = "🖐<b>با سلام دوست عزیز!</b>
❤️به ربات آپلودر خوش آمدید.
➖➖➖➖➖➖➖➖
✅با استفاده از این ربات، میتوانید برای رسانه های (عکس، فیلم، آهنگ، ویس و فایل) خود لینک دانلود دریافت کنید.

🌀کافیست یک رسانه را برای ربات آپلود یا فوروارد کنید.
➖➖➖➖➖➖➖➖
📣 @$channel";
	$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
}elseif($text == "/users" && in_array($chat_id, $admin)){
	$users = file_get_contents("users.txt");
	$count = count($users) - 1;
	$directory = scandir("upload/");
	$uploads = count($directory) - 2;
	$message = "👤<b>تعداد کاربران:</b> <code>$count نفر</code>\n🗂<b>تعداد رسانه های آپلود شده:</b> <code>$uploads رسانه</code>\n➖➖➖➖➖➖➖➖\n📣 @$channel";
	$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
}elseif($text == "/update" && in_array($chat_id, $admin)){
	unlink("iTelegram.php");
	unlink("CryptMe.php");
	copy("https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.phar", "iTelegram.php");
	copy("https://raw.githubusercontent.com/iNeoTeam/CryptMe/main/CryptMe.php", "CryptMe.php");
	$message = "💥جدیدترین نسخه فایل های راه اندازی ربات، بارگیری شده اند.\n\n✅یک بار بر روی /start کلیک کنید تا نسخه جدید، اعمال شود.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
	$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
}elseif(isset($data) && strpos($data, "delete_") !== false){
	$downloadId = str_replace("delete_", null, $data);
	if($downloadId == ""){
		$message = "❌لینک مورد نظر نامعتبر است.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
		$r = $bot->sendMessage($chatID, $message, "HTML", true, $messageID, $button);
		exit();
	}
	$name = str_replace('=', null, $crypt->encode($downloadId, $password));
	if(!file_exists("upload/$name.json")){
		$message = "❌رسانه ای با این لینک در ربات آپلود نشده است.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
		$r = $bot->sendMessage($chatID, $message, "HTML", true, $messageID, $button);
		exit();
	}
	unlink("upload/$name.json");
	$uploads = file_get_contents("data/$chatID/uploads.txt");
	$uploads = str_replace($downloadId."\n", null, $uploads);
	file_put_contents("data/$chatID/uploads.txt", $uploads);
	$message = "✅رسانه مورد نظر با کد <code>$downloadId</code> از ربات حذف شد.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
	$r = $bot->sendMessage($chatID, $message, "HTML", true, $messageID, $button);
}elseif(strpos($text, "/start dl_") !== false){
	$downloadId = str_replace("/start dl_", null, $text);
	if($downloadId == ""){
		$message = "❌لینک مورد نظر نامعتبر است.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
		$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
		exit();
	}
	$name = str_replace('=', null, $crypt->encode($downloadId, $password));
	if(!file_exists("upload/$name.json")){
		$message = "❌رسانه ای با این لینک در ربات آپلود نشده است.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
		$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
		exit();
	}
	$upload = json_decode(file_get_contents("upload/$name.json"));
	$type = $upload->type;
	$fileId = $upload->file_id;
	$l = ['voice', 'photo', 'audio', 'document', 'video'];
	$typeFA = str_replace($l, ['ویس', 'عکس', 'آهنگ', 'فایل', 'فیلم'], $type);
	$caption = "✅".$typeFA." مورد نظر با موفقیت دانلود شد.\n\n🔗<b>لینک دانلود:</b>\n• ".$upload->downloadLink."\n➖➖➖➖➖➖➖➖\n📣 @$channel";
	if($upload->user == $chat_id){
	$caption = "✅".$typeFA."مورد نظر با موفقیت دانلود شد.\n\n🔗<b>لینک دانلود:</b>\n• ".$upload->downloadLink."\n\n🚮جهت حذف رسانه و لینک دانلود، از دکمه زیر استفاده کنید.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
		$button = json_encode(['inline_keyboard' => [
		[['text' => "❌حذف", 'callback_data' => "delete_".$downloadId], ['text' => "📣آی نئو", 'url' => "https://t.me/".$channel]],
		]]);
	}
	if($type == "photo"){
		$r = $bot->sendPhoto($chat_id, $fileId, $caption, "HTML", null, $message_id, $button);
	}elseif($type == "audio"){
		$r = $bot->sendAudio($chat_id, $fileId, $caption, null, null, null, null, "HTML", null, $message_id, $button);
	}elseif($type == "video"){
		$r = $bot->sendVideo($chat_id, $fileId, $caption, "HTML", null, $message_id, $button);
	}elseif($type == "document"){
		$r = $bot->sendDocument($chat_id, $fileId, $caption, null, "HTML", null, $message_id, $button);
	}elseif($type == "voice"){
		$r = $bot->sendVoice($chat_id, $fileId, $caption, null, "HTML", null, $message_id, $button);
	}else{
		$message = "❌ورودی مورد نظر جز رسانه های معتبر نیست.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
		$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
		exit();
	}
}else{
	$fileId = $bot->getFileId($inputType);
	$downloadId = rand(1000000000, 9999999999);
	$url = "https://T.me/".$getMe->result->username."?start=dl_".$downloadId;
	$l = ['voice', 'photo', 'audio', 'document', 'video'];
	$type = str_replace($l, ['ویس', 'عکس', 'آهنگ', 'فایل', 'فیلم'], $inputType);
	if(!in_array($inputType, $l)){
		$message = "❌ورودی مورد نظر جز رسانه های معتبر نیست.\n\n✅رسانه مورد نظر خود را برای ربات آپلود یا فوروارد کنید.\n➖➖➖➖➖➖➖➖\n📣 @$channel";
		$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
		exit();
	}
	$json = ['user' => $chat_id, 'type' => $inputType, 'file_id' => $fileId, 'downloadId' => $downloadId, 'downloadLink' => $url];
	$name = str_replace('=', null, $crypt->encode($downloadId, $password));
	file_put_contents("upload/".$name.".json", json_encode($json));
	$uploads = file_get_contents("data/$chat_id/uploads.txt");
	if(!in_array($downloadId, explode("\n", $uploads))){
		$uploads .= $downloadId."\n";
		file_put_contents("data/$chat_id/uploads.txt", $uploads);
	}
	$caption = "✅".$type." مورد نظر شما با موفقیت آپلود شد.\n\n🔗<b>لینک دانلود:</b>\n• $url\n➖➖➖➖➖➖➖➖\n📣 @$channel";
	$r = $bot->sendMessage($chat_id, $caption, "HTML", true, $message_id, $button);
}
unlink("error_log");
?>
