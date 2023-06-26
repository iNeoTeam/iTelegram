# iTelegram
PHP Telegram Bot based on the official Telegram Bot API
<h2><a id="user-content-bots-an-introduction-for-developers" class="anchor" aria-hidden="true" href="#bots-an-introduction-for-developers"><svg class="octicon octicon-link" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"></svg></a>Bots: An introduction for developers</h2>
<blockquote>
<p>Bots are special Telegram accounts designed to handle messages automatically. Users can interact with bots by sending them command messages in private or group chats.</p>
</blockquote>
<blockquote>
<p>You control your bots using HTTPS requests to <a href="https://core.telegram.org/bots/api" rel="nofollow">bot API</a>.</p>
</blockquote>
<blockquote>
<p>The Bot API is an HTTP-based interface created for developers keen on building bots for Telegram.
To learn how to create and set up a bot, please consult <a href="https://core.telegram.org/bots" rel="nofollow">Introduction to Bots</a> and <a href="https://core.telegram.org/bots/faq" rel="nofollow">Bot FAQ</a>.</p>
</blockquote>
<h2>Installation & Usage:</h2>

```php
use iTelegram\Bot;
if (!file_exists('iTelegram.php')) {
    copy('https://raw.githubusercontent.com/iNeoTeam/iTelegram/main/iTelegram.php', 'iTelegram.php');
}
require_once('iTelegram.php');
$bot		= new Bot();
$bot->Authentification("BOT_ACCESS_TOKEN");
```

<h2>Example PHP Bot:</h2>

[Other Example Bots](https://github.com/iNeoTeam/TelegramBots)

```php
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
```
