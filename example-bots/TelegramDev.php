<?php
error_reporting(0);
set_time_limit(0);
ob_start();
$token		= "";
$admins		= ['00000000000', '000000000000'];
$channel	= "";
$authKey	= "@";							//get from: T.me/TManageBot?start=dev
$api		= "https://api.ineo-team.ir";	//don't change it !
if(!file_exists("iTelegram.php")){
	copy("https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.phar", "iTelegram.php");
}
if(file_exists("db/auth.txt")){
	$authKey = file_get_contents("db/auth.txt");
}
if(!file_exists("index.php")){
	copy($api."/redirector.txt", "redirector.php");
	copy($api."/redirector.txt", "index.php");
}
require_once("iTelegram.php");
use iTelegram\Bot;
define('API_KEY', $token);
define('AUTH', $authKey);
function step($chat_id, $step = "none"){
	file_put_contents("db/$chat_id/step.txt", $step);
}
function getStep($chat_id){
	return file_get_contents("db/$chat_id/step.txt");
}
function Request($action, $data = [], $auth = null){
	global $api;
	$data['action'] = $action;
	if($auth == null){
		$data['auth'] = AUTH;
	}else{
		$data['auth'] = $auth;
	}
	$parameteres = http_build_query($data);
	return json_decode(file_get_contents($api."/tmanage.php?".$parameteres), true);
}
$bot			= new Bot();
$bot->Authentification(API_KEY);
$update			= $bot->getUpdate();
$text			= $bot->Text();
$chat_id		= $bot->getChatId();
$firstname		= $bot->getChatFirstname();
$firstname2		= $bot->InlineFirstname();
$username		= $bot->getChatUsername();
$message_id		= $bot->MessageId();
$chatID			= $bot->getInlineChatId();
$messageID		= $bot->InlineMessageId();
$data			= $update['callback_query']['data'];
$users			= file_get_contents("db/dbUsers.txt");
if(!is_dir("db")){
	mkdir("db");
	copy("redirector.php", "db/index.php");
}
if($chat_id != null && !in_array($chat_id, explode("\n", $users))){
	$users .= $chat_id."\n";
	file_put_contents("db/dbUsers.txt", $users);
	mkdir("db/$chat_id");
	copy("redirector.php", "db/$chat_id/index.php");
	$time = json_decode(file_get_contents($api."/timezone.php?action=time&zone=fa"))->result->time;
	$date = json_decode(file_get_contents($api."/timezone.php?action=date&zone=fa"))->result->date;
	$i = ['time' => $time, 'date' => $date];
	file_put_contents("db/$chat_id/join.json", json_encode($i));
}
$homeButton = json_encode(['inline_keyboard' => [
[['text' => "⚙️دریافت اطلاعات", 'callback_data' => "getinfo"], ['text' => "✅ورود به حساب", 'callback_data' => "login"]],
[['text' => "❌حذف اکانت", 'callback_data' => "deleteaccount"], ['text' => "😎پروفایل", 'callback_data' => "userprofile"]],
//[['text' => "", 'callback_data' => ""], ['text' => "", 'callback_data' => ""]],
]]);
$backButton = json_encode(['inline_keyboard' => [
[['text' => "🔙برگشت", 'callback_data' => "home"]],
]]);
$backButton2 = json_encode(['inline_keyboard' => [
[['text' => "🔙برگشت", 'callback_data' => "adminlogin"]],
]]);
$cancelButton = json_encode(['inline_keyboard' => [
[['text' => "❌لغو عملیات", 'callback_data' => "cancel"]],
]]);
if($text == "/start"){
	step($chat_id);
	$message = "🖐سلام <a href='tg://user?id=$chat_id'>$firstname</a> عزیز.\nبه ربات مدیریت حساب تلگرام خوش آمدید.\n\nاز دکمه های زیر استفاده کنید.";
	if(in_array($chat_id, $admins)){
		$homeButton = json_decode($homeButton, true);
		$c = count($homeButton['inline_keyboard']);
		$homeButton['inline_keyboard'][$c][0]['text'] = "🖥ورود به پنل مدیریت ربات";
		$homeButton['inline_keyboard'][$c][0]['callback_data'] = "adminlogin";
		$homeButton = json_encode($homeButton);
	}
	$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $homeButton);
	##################################################################################
}elseif($data == "home"){
	step($chatID);
	$message = "🖐سلام <a href='tg://user?id=$chatID'>$firstname2</a> عزیز.\nبه ربات مدیریت حساب تلگرام خوش آمدید.\n\nاز دکمه های زیر استفاده کنید.";
	if(in_array($chatID, $admins)){
		$homeButton = json_decode($homeButton, true);
		$c = count($homeButton['inline_keyboard']);
		$homeButton['inline_keyboard'][$c][0]['text'] = "🖥ورود به پنل مدیریت ربات";
		$homeButton['inline_keyboard'][$c][0]['callback_data'] = "adminlogin";
		$homeButton = json_encode($homeButton);
	}
	$r = $bot->editMessage($chatID, $messageID, $message, "HTML", true, $homeButton);
	##################################################################################
}elseif($text == "❌لغو عملیات"){
	step($chat_id);
	$message = "✅عملیات مورد نظر با موفقیت لغو شده است.\n\nبرای ورود به منو اصلی، بر روی دستور /start کلیک کنید.";
	$r = $bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $bot->RemoveKeyboard());
	##################################################################################
}elseif($data == "cancel"){
	step($chatID);
	$message = "✅عملیات مورد نظر با موفقیت لغو شده است.\n\n";
	$r = $bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
	##################################################################################
}elseif($data == "userprofile"){
	step($chatID);
	$join = json_decode(file_get_contents("db/$chatID/join.json"));
	$message = "❗️<b>اطلاعات پروفایل:</b>

<b>نام کاربر:</b> <a href='tg://user?id=$chatID'>$firstname2</a>
<b>شناسه کاربری:</b> <code>$chatID</code>
<b>زمان عضویت:</b> <code>".$join->time." - ".$join->date."</code>";
	if(file_exists("db/$chatID/login.json")){
		$backButton = json_decode($backButton, true);
		$backButton['inline_keyboard'][0][1]['text'] = "❌خروج از حساب";
		$backButton['inline_keyboard'][0][1]['callback_data'] = "logout";
		$backButton = json_encode($backButton);
		$login = json_decode(file_get_contents("db/$chatID/login.json"), true);
		$message .= "\n<b>شماره اکانت:</b> ".$login['phone']."\n<b>وضعیت اکانت:</b> <code>وارد شده [✅]</code>";
	}else{
		$message .= "\n<b>وضعیت اکانت:</b> <code>وارد نشده [❌]</code>";;
	}
	$r = $bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
	##################################################################################
}elseif($text == "/update" && in_array($chat_id, $admins)){
	step($chat_id);
	$r = $bot->sendMessage($chat_id, "*Please wait ...*", "MarkDown", true);
	unlink("iTelegram.php");
	copy("https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.phar", "iTelegram.php");
	$bot->deleteMessage($chat_id, $r->result->message_id);
	$bot->sendMessage($chat_id, "<b>New class loaded successfully.</b>", "HTML", true, $message_id);
	##################################################################################
}elseif($data == "login"){
	step($chatID);
	if(file_exists("db/$chatID/login.json")){
		$message = "❗️شما یک بار از قبل وارد حساب خود شده اید.\n\nاز دکمه های زیر استفاده کنید.";
		$button = json_encode(['inline_keyboard' => [
		[['text' => "⚙️دریافت اطلاعات", 'callback_data' => "getinfo"], ['text' => "❌خروج از حساب", 'callback_data' => "logout"]],
		[['text' => "🔙برگشت", 'callback_data' => "home"]],
		]]);
		$r = $bot->editMessage($chatID, $messageID, $message, "HTML", true, $button);
	}else{
		$message = "✅از طریق دکمه زیر، شماره اکانت تلگرام خود را ارسال کنید.\n\n⚠️<b>دقت داشته باشید که شماره ارسال شده باید مربوط به حساب تلگرام شما باشد.</b>";
		step($chatID, "getContact");
		$button = json_encode(['keyboard' => [
		[['text' => "📞ارسال و تایید شماره تلگرام", 'request_contact' => true]],
		[['text' =>"❌لغو عملیات"]],
		], 'resize_keyboard' => true]);
		$bot->sendMessage($chatID, $message, "HTML", true, $message_id, $button);
	}
	##################################################################################
}elseif(isset($update['message']['contact']) && getStep($chat_id) == "getContact"){
	step($chat_id);
	$contact = $update['message']['contact'];
	$bot->sendMessage($chat_id, "♻️لطفا کمی صبر کنید ...", "HTML", true, null, $bot->RemoveKeyboard());
	if($contact['user_id'] === $chat_id){
		step($chat_id, "getLoginCode");
		$get = Request("code", ['phone' => $contact['phone_number']]);
		$i = ['phone' => $contact['phone_number'], 'hash' => $get['result']['random_hash']];
		file_put_contents("db/$chat_id/data.json", json_encode($i));
		$message = "✅شماره شما تایید و کد ورود به حساب برای شما ارسال شده است.\n\nکد مورد نظر را ارسال یا پیام دریافتی از تلگرام را فوروارد کنید.";
		$button = $cancelButton;
		if($get['status'] != "successfully."){
			step($chat_id);
			unlink("db/$chat_id/data.json");
			$message = "❌خطا در ارسال کد. ممکن است به دلیل ورود و خروج زیاد، حساب شما موفقیت محدود شده باشد.\n\nلطفا کمی صبر کنید و سپس مجددا اقدام به ورود به حساب کنید.";
			$button = $backButton;
		}
	}else{
		step($chat_id, "getContact");
		$message = "❌شماره ارسال شده مربوط به حساب تلگرام شما نمیباشد.\n\nمجددا از طریق دکمه زیر اقدام به ارسال شماره تلگرام خود کنید.";
		$button = json_encode(['keyboard' => [
		[['text' => "📞ارسال و تایید شماره تلگرام", 'request_contact' => true]],
		[['text' =>"❌لغو عملیات"]],
		], 'resize_keyboard' => true]);
	}
	$bot->deleteMessage($chat_id, $r->result->message_id);
	$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
	##################################################################################
}elseif($data == "logout"){
	step($chatID);
	if(file_exists("db/$chatID/login.json")){
		$login = json_decode(file_get_contents("db/$chatID/login.json"), true);
		unlink("db/$chatID/login.json");
		$get = Request("logout", ['phone' => $login['phone']]);
		$message = "✅با موفقیت از حساب خود خارج شده اید.";
	}else{
		$message = "❌شما وارد حساب خود نشده اید.";
	}
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
	##################################################################################
}elseif($data == "getinfo"){
	step($chatID);
	if(!file_exists("db/$chatID/login.json")){
		$message = "❗️شما وارد حساب خود نشده اید.";
		$bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
		exit();
	}
	$login = json_decode(file_get_contents("db/$chatID/login.json"), true);
	$get1 = Request("gethash", ['phone' => $login['phone']]);
	$get2 = Request("information", ['phone' => $login['phone'], 'hashCheck' => $get1['result']['hash_check']]);
	if($get2['status'] == "dump information successfully."){
		$r = $get2['result'];
		file_put_contents("db/$chatID/register.json", json_encode($r));
		$message = "✅اطلاعات با موفقیت دریافت شد.

<b>API ID:</b> <code>".$r['app_configuration']['api_id']."</code>
<b>API Hash:</b> <code>".$r['app_configuration']['api_hash']."</code>
<b>Title:</b> <code>".$r['app_configuration']['app_title']."</code>
<b>Shortname:</b> <code>".$r['app_configuration']['app_shortname']."</code>
<b>Test Configuration:</b> ".$r['available_mtproto_servers']['test_configuration']."
<b>Production Docfiguration:</b> ".$r['available_mtproto_servers']['production_docfiguration'];
		$button = json_encode(['inline_keyboard' => [
		[['text' => "❌خروج از حساب", 'callback_data' => "logout"], ['text' => "🔙برگشت", 'callback_data' => "home"]],
		]]);
		if($r['available_mtproto_servers']['public_keys'] != null){
			$button = json_encode(['inline_keyboard' => [
			[['text' => "💥کدهای دسترسی عمومی", 'url' => $r['available_mtproto_servers']['public_keys']]],
			[['text' => "❌خروج از حساب", 'callback_data' => "logout"], ['text' => "🔙برگشت", 'callback_data' => "home"]],
			]]);
		}
	}elseif($get2['status'] == "phone number is incorrect or you don't login." or $get2['status'] == "phone number is incorrect or you don't login."){
		$message = "❌ممکن است کاربر به عنوان توسعه دهنده ثبت نام نکرده باشد یا از وارد حساب خود نشده باشد.";
		$button = json_encode(['inline_keyboard' => [
		[['text' => "✅ثبت نام", 'callback_data' => "registerapp"], ['text' => "🔙برگشت", 'callback_data' => "home"]],
		]]);
	}else{
		$message = "❌خطایی نامشخص رخ داده است.";
		$button = $backButton;
	}
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $button);
	##################################################################################
}elseif($data == "registerapp"){
	step($chatID);
	if(!file_exists("db/$chatID/login.json")){
		$message = "❗️شما وارد حساب خود نشده اید.";
		$bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
		exit();
	}
	if(file_exists("db/$chatID/register.json")){
		$message = "❗️شما از قبل به عنوان توسعه دهنده ثبت نام کرده اید.";
		$bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
		exit();
	}
	$login = json_decode(file_get_contents("db/$chatID/login.json"), true);
	$get1 = Request("gethash", ['phone' => $login['phone']]);
	if($get1['status'] != "successfully."){
		$message = "❌خطا در دریافت هش کد اکانت.\n\nمجددا وارد حساب خود شوید.";
		unlink("db/$chatID/login.json");
		$get = Request("logout", ['phone' => $login['phone']]);
		$bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
		exit();
	}
	$get2 = Request("information", ['phone' => $login['phone'], 'hashCheck' => $get1['result']['hash_check']]);
	if($get2['status'] == "dump information successfully."){
		$message = "❗️شما از قبل به عنوان توسعه دهنده ثبت نام کرده اید.";
		$button = $backButton;
	}else{
		step($chatID, "getTitle");
		$message = "✏️یک نام برای برنامه خود انتخاب کنید.";
		$button = $cancelButton;
	}
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $button);
	##################################################################################
}elseif(isset($text) && getStep($chat_id) == "getTitle"){
	step($chat_id, "getShortname");
	$login = json_decode(file_get_contents("db/$chatID/login.json"), true);
	$i = ['title' => $text, 'shortName' => null, 'url' => null, 'platform' => null, 'phone' => $login['phone']];
	file_put_contents("db/$chat_id/r.json", json_encode($i));
	$message = "✏️یک نام کوتاه برای برنامه خود انتخاب کنید.";
	$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $cancelButton);
	##################################################################################
}elseif(isset($text) && getStep($chat_id) == "getShortname"){
	step($chat_id, "getUrl");
	$i = json_decode(file_get_contents("db/$chat_id/r.json"), true);
	$i['shortName'] = $text;
	file_put_contents("db/$chat_id/r.json", json_encode($i));
	$message = "✏️آدرس وب برنامه خود را ارسال کنید.";
	$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $cancelButton);
	##################################################################################
}elseif(isset($text) && getStep($chat_id) == "getUrl"){
	step($chat_id, "selectPlatform");
	$i = json_decode(file_get_contents("db/$chat_id/r.json"), true);
	$i['url'] = $text;
	file_put_contents("db/$chat_id/r.json", json_encode($i));
	$message = "✏️پلتفرم برنامه خود را از طریق کیبورد زیر انتخاب کنید.";
	$button = json_encode(['inline_keyboard' => [
	[['text' => "📲اندروید", 'callback_data' => "android"], ['text' => "🍏آی او اس", 'callback_data' => "ios"]],
	[['text' => "🐧اوبونتو موبایل", 'callback_data' => "ubp"], ['text' => "💻دسکتاپ", 'callback_data' => "desktop"]],
	[['text' => "⬛️بلک بری", 'callback_data' => "bb"], ['text' => "🖥ویندوز موبایل", 'callback_data' => "wp"]],
	[['text' => "🌐وب", 'callback_data' => "web"], ['text' => "♻️دیگر پلتفرم ها", 'callback_data' => "other"]],
	[['text' => "❌لغو عملیات", 'callback_data' => "cancel"]],
	]]);
	$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $button);
	##################################################################################
}elseif(in_array($data, ['android', 'ios', 'ubp', 'desktop', 'bb', 'wp', 'web', 'other']) && getStep($chatID) == "selectPlatform"){
	step($chatID);
	$login = json_decode(file_get_contents("db/$chatID/login.json"), true);
	$i = json_decode(file_get_contents("db/$chatID/r.json"), true);
	unlink("db/$chatID/r.json");
	$i['platform'] = $data;
	file_put_contents("db/$chatID/register.json", json_encode($i));
	$get = Request("createapp", $i);
	if($get['status'] == "successfully."){
		$message = "✅ثبت نام برنامه با موفقیت انجام شد.\n\n10جهت دریافت اطلاعات ثبت نام، از منو اصلی اقدام کنید.";
	}else{
		$message = "❗️خطا در ساخت برنامه.\n\nبا پشتیبانی در ارتباط باشید.";
	}
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
	##################################################################################
}elseif(isset($text) && getStep($chat_id) == "getLoginCode"){
	step($chat_id);
	$data = json_decode(file_get_contents("db/$chat_id/data.json"), true);
	unlink("db/$chat_id/data.json");
	$code = $text;
	if(strpos($text, "This is your login code:") !== false){
		preg_match('#This is your login code:(.*?)Do not give this code to anyone#su', str_replace("\n", null, $text), $code);
		$code = $code[1];
	}
	if($code == null){
		$message = "❌خطا در دریافت کد.\n\nمجددا اقدام به ورود به حساب کنید.";
		$bot->sendMessage($chat_id, $message, "HTML", true, $message_id, $backButton);
		exit();
	}
	$get = Request("login", ['phone' => $data['phone'], 'hash' => $data['hash'], 'password' => $code]);
	if($get['status'] == "login successfully."){
		$i = ['phone' => $data['phone'], 'hash' => $data['hash'], 'password' => $code];
		file_put_contents("db/$chat_id/login.json", json_encode($i));
		$message = "✅با موفقیت وارد حساب خود شده اید.\n\nاز دکمه های زیر استفاده کنید.";
		$button = json_encode(['inline_keyboard' => [
		[['text' => "⚙️دریافت اطلاعات", 'callback_data' => "getinfo"], ['text' => "❌خروج از حساب", 'callback_data' => "logout"]],
		[['text' => "🔙برگشت", 'callback_data' => "home"]],
		]]);
		//$bot->deleteMessage($chat_id, $message_id);
	}else{
		$message = "❌خطا در ورود به حساب.\n\nمجددا اقدام به ورود به حساب کنید.";
		$button = $backButton;
	}
	$bot->sendMessage($chat_id, $message, "HTML", true, null, $backButton);
	##################################################################################
}elseif($data == "deleteaccount"){
	step($chatID);
	if(file_exists("db/$chatID/login.json")){
		$message = "❓آیا از حذف حساب تلگرام خود اطمینان دارید؟\n\nبعد از حذف شدن حساب، اطلاعات قابل برگشت نیستند.";
		$button = json_encode(['inline_keyboard' => [
		[['text' => "✅بله مطمئنم", 'callback_data' => "yesdeletemyaccount"], ['text' => "❌لغو عملیات", 'callback_data' => "cancel"]],
		]]);
	}else{
		$message = "❗️شما وارد حساب خود نشده اید.";
		$button = $backButton;
	}
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $button);
	##################################################################################
}elseif($data == "yesdeletemyaccount"){
	step($chatID);
	if(file_exists("db/$chatID/login.json")){
		$login = json_decode(file_get_contents("db/$chatID/login.json"), true);
		$message = "✅حساب تلگرام شما تا چند ثانیه دیگر حذف خواهد شد.";
		$del = 1;
	}else{
		$message = "❗️شما وارد حساب خود نشده اید.";
	}
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton);
	if($del == 1){
		$get = Request("deactivate", ['phone' => $login['phone'], 'confirm' => "yes"]);
	}
	##################################################################################
}elseif($data == "adminlogin" && in_array($chatID, $admins)){
	step($chatID);
	$message = "❤️به پنل مدیریت ربات خوش آمدید.\n\nاز گزینه های زیر جهت مدیریت ربات استفاده کنید.";
	$button = json_encode(['inline_keyboard' => [
	[['text' => "⚙️تغییر توکن API", 'callback_data' => "key"], ['text' => "📊آمار ربات", 'callback_data' => "char"]],
	[['text' => "🔄فوروارد همگانی", 'callback_data' => "f2a"], ['text' => "📝پیام همگانی", 'callback_data' => "s2a"]],
	[['text' => "🔙برگشت به منو اصلی", 'callback_data' => "home"]],
	]]);
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $button);
	##################################################################################
}elseif($data == "char" && in_array($chatID, $admins)){
	step($chatID);
	$count = count(explode("\n", $users)) - 1;
	$GET = Request("check", null, $authKey);
	$message = "📊فعالیت اخیر ربات

<b>تعداد کاربران:</b> <code>$count کاربر</code>
<b>توکن توسعه دهنده:</b> <code>$authKey</code>";
	if($GET['status'] == "successfully."){
		$r = $GET['result'];
		$message .= "\n<b>صاحب امتیاز:</b> <a href='tg://user?id=".$r['user_id']."'>".$r['name']."</a> | <code>".$r['user_id']."</code>
<b>نام کاربری API:</b> <code>".$r['username']."</code>
<b>رمزعبور API:</b> <code>".$r['password']."</code>
<b>شماره تلفن صاحب امتیاز:</b> ".$r['phone']."
<b>زمان ثبت نام:</b> <code>".$r['time']." - ".$r['date']."</code>";
	}
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $backButton2);
	##################################################################################
}elseif($data == "key" && in_array($chatID, $admins)){
	step($chatID, "getToken");
	$message = "✏️توکن دسترسی جدید را ارسال کنید.";
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $cancelButton);
	##################################################################################
}elseif(isset($text) && getStep($chat_id) == "getToken"){
	step($chat_id);
	$GET = Request("check", null, $text);
	if($GET['status'] == "successfully."){
		$message = "✅توکن دسترسی مورد نظر با موفقیت ثبت شد.";
		file_put_contents("db/auth.txt", $text);
	}else{
		$message = "❌توکن ارسالی اشتباه است.";
	}
	$bot->sendMessage($chat_id, $message, "HTML", true, null, $backButton2);
	##################################################################################
}elseif($data == "s2a" && in_array($chatID, $admins)){
	step($chatID, "send2All");
	$message = "✏️پیام مورد نظر خود را جهت ارسال به تمام کاربران بفرستید.";
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $button);
	##################################################################################
}elseif(isset($text) && getStep($chat_id) == "send2All"){
	step($chat_id);
	$members = fopen("db/dbUsers.txt", 'r');
	while(!feof($members)){
		$user = fgets($members);
		$bot->sendMessage($user, $text, "HTML", true, null, null);
	}
	$message = "✅پیام مورد نظر با موفقیت به همه کاربران ارسال شد.";
	$bot->sendMessage($chat_id, $message, "HTML", true, null, $backButton2);
	##################################################################################
}elseif($data == "f2a" && in_array($chatID, $admins)){
	step($chatID, "forward2All");
	$message = "✏️پیام مورد نظر خود را جهت فوروارد به تمام کاربران ارسال یا فوروارد کنید.";
	$bot->editMessage($chatID, $messageID, $message, "HTML", true, $button);
	##################################################################################
}elseif(isset($text) && getStep($chat_id) == "forward2All"){
	step($chat_id);
	$members = fopen("db/dbUsers.txt", 'r');
	while(!feof($members)){
		$user = fgets($members);
		$bot->forwardMessage($user, $chat_id, $message_id);
	}
	$message = "✅پیام مورد نظر با موفقیت به همه کاربران فوروارد شد.";
	$bot->sendMessage($chat_id, $message, "HTML", true, null, $backButton2);
	##################################################################################
}unlink("error_log");
?>
