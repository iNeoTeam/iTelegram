<?php
/**
	* @author:		iNeoTeam
	* @copyright:	2018-2021 Sir.4m1R
	* @version:		1.6.3
	* @contact:		T.me/CrossXss
	* @telegram:	T.me/iNeoTeam
	* @website:		iNeo-Team.ir
**/
namespace iTelegram;
error_reporting(0);
class Bot{
	const TEXT				= 'text';
	const PHOTO				= 'photo';
	const VIDEO				= 'video';
	const DOCUMENT			= 'document';
	const AUDIO				= 'audio';
	const VOICE				= 'voice';
	const CONTACT			= 'contact';
	const LOCATION			= 'location';
	const STICKER			= 'sticker';
	const CALLBACK_QUERY	= 'callback_query';
	const INLINE_QUERY		= 'inline_query';
	private $data			= [];
	private $array			= [];
	public function __construct(){ $this->data = $this->getUpdate(); }
	public function getUpdate(){
		if(empty($this->data)){
			return json_decode(file_get_contents("php://input"), true);
		}else{
			return $this->data;
		}
	}
	public function Authentification($token){
		define('ACCESS_TOKEN', $token);
		function iNeoTeamBot($method, $data = []){
			$api = "https://api.telegram.org/bot".ACCESS_TOKEN."/".$method;
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $api);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $data);
			curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($cURL);
			if(curl_error($cURL)){
				var_dump(curl_error($cURL));
			}else{
				return json_decode($result);
			}
		}
	}
	function editMessage($chatID, $messageID, $text, $mode = null, $webPage = null, $button = null){
		if($mode == "" or !in_array(strtolower($mode), ['markdown', 'html'])){
			$mode = "html";
		}
		$output = iNeoTeamBot('editMessageText', [
			'chat_id' => $chatID,
			'message_id' => $messageID,
			'text' => $text,
			'parse_mode' => $mode,
			'disable_web_page_preview' => $webPage,
			'reply_markup' => $button
		]);
		return $output;
	}
	function sendMessage($chat_id, $text, $mode = null, $webPage = null, $replyTo = null, $button = null){
		if($mode == "" or !in_array(strtolower($mode), ['markdown', 'html'])){
			$mode = "html";
		}
		$output = iNeoTeamBot('sendMessage', [
			'chat_id' => $chat_id,
			'text' => $text,
			'parse_mode' => $mode,
			'disable_web_page_preview' => $webPage,
			'reply_to_message_id' => $replyTo,
			'reply_markup' => $button
		]);
		return $output;
	}
	function sendPhoto($chat_id, $photo, $caption = null, $mode = null, $notification = null, $replyTo = null, $button = null){
		if($mode == "" or !in_array(strtolower($mode), ['markdown', 'html'])){
			$mode = "html";
		}
		$output = iNeoTeamBot('sendPhoto', [
			'chat_id' => $chat_id,
			'photo' => $photo,
			'caption' => $caption,
			'parse_mode' => $mode,
			'disable_notification' => $notification,
			'reply_to_message_id' => $replyTo,
			'reply_markup' => $button
		]);
		return $output;
	}
	function sendSticker($chat_id, $sticker, $notification = null, $replyTo = null, $button = null){
		$output = iNeoTeamBot('sendSticker', [
			'chat_id' => $chat_id,
			'sticker' => $sticker,
			'disable_notification' => $notification,
			'reply_to_message_id' => $replyTo,
			'reply_markup' => $button
		]);
		return $output;
	}
	function sendVideo($chat_id, $video, $caption = null, $mode = null, $notification = null, $replyTo = null, $button = null){
		if($mode == "" or !in_array(strtolower($mode), ['markdown', 'html'])){
			$mode = "html";
		}
		$output = iNeoTeamBot('sendVideo', [
			'chat_id' => $chat_id,
			'video' => $video,
			'caption' => $caption,
			'parse_mode' => $mode,
			'disable_notification' => $notification,
			'reply_to_message_id' => $replyTo,
			'reply_markup' => $button
		]);
		return $output;
	}
	function sendAudio($chat_id, $audio, $caption = null, $duration = null, $title = null, $performer = null, $thumb = null, $mode = null, $notification = null, $replyTo = null, $button = null){
		if($mode == "" or !in_array(strtolower($mode), ['markdown', 'html'])){
			$mode = "html";
		}
		$output = iNeoTeamBot('sendAudio', [
			'chat_id' => $chat_id,
			'audio' => $audio,
			'caption' => $caption,
			'duration' => $duration,
			'title' => $title,
			'performer' => $performer,
			'thumb' => $thumb,
			'parse_mode' => $mode,
			'disable_notification' => $notification,
			'reply_to_message_id' => $replyTo,
			'reply_markup' => $button
		]);
		return $output;
	}
	function sendVoice($chat_id, $voice, $caption = null, $duration = null, $mode = null, $notification = null, $replyTo = null, $button = null){
		if($mode == "" or !in_array(strtolower($mode), ['markdown', 'html'])){
			$mode = "html";
		}
		$output = iNeoTeamBot('sendVoice', [
			'chat_id' => $chat_id,
			'voice' => $voice,
			'caption' => $caption,
			'duration' => $duration,
			'parse_mode' => $mode,
			'disable_notification' => $notification,
			'reply_to_message_id' => $replyTo,
			'reply_markup' => $button
		]);
		return $output;
	}
	function sendDocument($chat_id, $document, $caption = null, $thumb = null, $mode = null, $notification = null, $replyTo = null, $button = null){
		if($mode == "" or !in_array(strtolower($mode), ['markdown', 'html'])){
			$mode = "html";
		}
		$output = iNeoTeamBot('sendDocument', [
			'chat_id' => $chat_id,
			'document' => $document,
			'caption' => $caption,
			'thumb' => $thumb,
			'parse_mode' => $mode,
			'disable_notification' => $notification,
			'reply_to_message_id' => $replyTo,
			'reply_markup' => $button
		]);
		return $output;
	}
	function forwardMessage($toChat_id, $fromChat_id, $message_id){
		$output = iNeoTeamBot('forwardMessage', [
			'chat_id' => $toChat_id,
			'from_chat_id' => $fromChat_id,
			'message_id' => $message_id
		]);
		return $output;
	}
	function TelegramAPI($method, $data = []){ return iNeoTeamBot($method, $data); }
	function getMe(){ return iNeoTeamBot('getMe'); }
	function deleteWebHook($sourceUrl){ return iNeoTeamBot('deleteWebHook', ['url' => $sourceUrl]); }
	function setWebHook($sourceUrl){ return iNeoTeamBot('setWebHook', ['url' => $sourceUrl]); }
	function deleteMessage($chat_id, $message_id){ return iNeoTeamBot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $message_id]); }
	function sendChatAction($chat_id, $actionType){ return iNeoTeamBot('sendChatAction', ['chat_id' => $chat_id, 'action' => $actionType]); }
	function getChatMember($chat_id, $user_id){ return iNeoTeamBot('getChatMember', ['chat_id' => $chat_id, 'user_id' => $user_id]); }
	function getChatMemberCount($chat_id){ return iNeoTeamBot('getChatMemberCount', ['chat_id' => $chat_id]); }
	function unPinMessage($chat_id, $message_id){ return iNeoTeamBot('unpinChatMessage', ['chat_id' => $chat_id, 'message_id' => $message_id]); }
	function unPinAllMessages($chat_id){ return iNeoTeamBot('unpinAllChatMessages', ['chat_id' => $chat_id]); }
	public function SingleInlineUrlKeyboard($text, $url){ return json_encode(['inline_keyboard' => [[['text' => $text, 'url' => $url]]]]); }
	public function MultiInlineKeyboard($keyboard){ return json_encode(['inline_keyboard' => $keyboard]); }
	public function SingleNormalKeyboard($text){ return json_encode(['keyboard' => [[['text' => $text]]], 'resize_keyboard' => true]); }
	public function MultiNormalKeyboard($keyboard){ return json_encode(['keyboard' => $keyboard, 'resize_keyboard' => true]); }
	public function RemoveKeyboard(){ return json_encode(['remove_keyboard' => true]); }
	public function getChatId(){ return $this->data['message']['chat']['id']; }
	public function getChatUsername(){ return $this->data['message']['chat']['username']; }
	public function getChatFirstname(){ return $this->data['message']['chat']['first_name']; }
	public function getChatTitle(){ return $this->data['message']['chat']['title']; }
	public function getChatType(){ return $this->data['message']['chat']['type']; }
	public function Text(){ return $this->data['message']['text']; }
	public function Update(){ return $this->data; }
	public function Caption(){ return $this->data['message']['caption']; }
	public function Username(){ return $this->data['message']['from']['username']; }
	public function Firstname(){ return $this->data['message']['from']['first_name']; }
	public function Lastname(){ return $this->data['message']['from']['last_name']; }
	public function UserId(){ return $this->data['message']['from']['id']; }
	public function MessageId(){ return $this->data['message']['message_id']; }
	public function getInlineChatId(){ return $this->data['callback_query']['message']['chat']['id']; }
	public function InlineMessageId(){ return $this->data['callback_query']['message']['message_id']; }
	public function InlineUsername(){ return $this->data['callback_query']['message']['chat']['username']; }
	public function InlineFirstname(){ return $this->data['callback_query']['message']['chat']['first_name']; }
	public function InlineLastname(){ return $this->data['callback_query']['message']['chat']['last_name']; }
	public function InlineUserId(){ return $this->data['callback_query']['message']['chat']['id']; }
	public function ForwarderId(){ return $this->data['message']['reply_to_message']['forward_from']['id']; }
	public function InputMessageType(){
		if(isset($this->data['message']['text'])){ return self::TEXT; }
		if(isset($this->data['message']['photo'])){ return self::PHOTO; }
		if(isset($this->data['message']['video'])){ return self::VIDEO; }
		if(isset($this->data['message']['audio'])){ return self::AUDIO; }
		if(isset($this->data['message']['voice'])){ return self::VOICE; }
		if(isset($this->data['message']['document'])){ return self::DOCUMENT; }
		if(isset($this->data['message']['contact'])){ return self::CONTACT; }
		if(isset($this->data['message']['location'])){ return self::LOCATION; }
		if(isset($this->data['message']['sticker'])){ return self::STICKER; }
	}
	public function getFileId($type){
		switch($type){
			case 'photo';
				$count = count($this->data['message']['photo']) - 1;
				$fileId = $this->data['message'][$type][$count]['file_id'];
				break;
			case 'video';
				$fileId = $this->data['message'][$type]['file_id'];
				break;
			case 'audio';
				$fileId = $this->data['message'][$type]['file_id'];
				break;
			case 'voice';
				$fileId = $this->data['message'][$type]['file_id'];
				break;
			case 'document';
				$fileId = $this->data['message'][$type]['file_id'];
				break;
			case 'sticker';
				$fileId = $this->data['message'][$type]['file_id'];
				break;
		}
		return $fileId;
	}
	public function fileInfo($p){
		$fileId = $this->getFile($this->array["file_id"]);
		switch($p){
			case 'path';
				//$d = $fileId['result']['file_path'];
				$d = $fileId->result->file_path;
				break;
			case 'id';
				$d = $fileId->result->file_id;
				break;
			case 'unique';
				$d = $fileId->result->file_unique_id;
				break;
			case 'size';
				$d = $fileId->result->file_size;
				break;
		}
		return "https://api.telegram.org/file/bot".ACCESS_TOKEN."/".$d;
	}
	public function getFile($fileId){
		$this->array = get_defined_vars();
		return iNeoTeamBot('getFile', ['file_id' => $fileId]);
	}
	public function Audio($input){
		switch($input){
			case 'title';
				$output = $this->data['message']['audio']['title'];
				break;
			case 'artist';
				$output = $this->data['message']['audio']['performer'];
				break;
			case 'mime';
				$output = $this->data['message']['audio']['mime_type'];
				break;
			case 'thumb';
				$output = $this->data['message']['audio']['thumb'];
				break;
			case 'size';
				$output = $this->data['message']['audio']['file_size'];
				break;
		}
		return $output;
	}
	public function Document($input){
		switch($input){
			case 'name';
				$output = $this->data['message']['document']['file_name'];
				break;
			case 'id';
				$output = $this->data['message']['document']['file_id'];
				break;
			case 'mime';
				$output = $this->data['message']['document']['mime_type'];
				break;
			case 'thumb';
				$output = $this->data['message']['document']['thumb'];
				break;
			case 'size';
				$output = $this->data['message']['document']['file_size'];
				break;
			case 'unique';
				$output = $this->data['message']['document']['file_unique_id'];
				break;
		}
		return $output;
	}
	public function Contact($input){
		switch($input){
			case 'phone';
				$output = $this->data['message']['contact']['phone_number'];
				break;
			case 'firstname';
				$output = $this->data['message']['contact']['first_name'];
				break;
			case 'lastname';
				$output = $this->data['message']['contact']['last_name'];
				break;
			case 'id';
				$output = $this->data['message']['contact']['user_id'];
				break;
			case 'vcard';
				$output = $this->data['message']['contact']['vcard'];
				break;
		}
		return $output;
	}
	public function CallBackQuery($input){
		switch($input){
			case 'callback_id';
				$output = $this->data['callback_query']['id'];
				break;
			case 'fromID';
				$output = $this->data['callback_query']['from']['id'];
				break;
			case 'data';
				$output = $this->data['callback_query']['data'];
				break;
			case 'chatID';
				$output = $this->data['callback_query']['message']['chat']['id'];
				break;
			case 'messageID';
				$output = $this->data['callback_query']['message']['message_id'];
				break;
		}
		return $output;
	}
	public function InlineQuery($input){
		switch($input){
			case 'id';
				$output = $this->data['inline_query']['id'];
				break;
			case 'query';
				$output = $this->data['inline_query']['query'];
				break;
		}
		return $output;
	}
	public function UpdateType(){
		if(isset($this->data['callback_query'])){ return self::CALLBACK_QUERY; }
		if(isset($this->data['inline_query'])){ return self::INLINE_QUERY; }
	}
	function AnswerCallBack($callback_id, $text, $alert = null){
		if($alert == 1 or $alert == true){
			$_alert = true;
		}else{
			$_alert = false;
		}
		$output = iNeoTeamBot('answerCallbackQuery', [
			'callback_query_id' => $callback_id,
			'text' => $text,
			'show_alert' => $_alert
		]);
		return $output;
	}
	function AnswerInlineQuery($inline_query_id, $data){
		$output = iNeoTeamBot('answerInlineQuery', [
			'cache_time' => 0,
			'inline_query_id' => $inline_query_id,
			'result' => json_encode($data)
		]);
	}
	function pinMessage($chat_id, $message_id, $notification = null){
		if($notification == 1 or $notification == true){
			$_notification = true;
		}else{
			$_notification = false;
		}
		$output = iNeoTeamBot('pinChatMessage', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'disable_notification' => $_notification
		]);
		return $output;
	}
}
unlink("error_log");
