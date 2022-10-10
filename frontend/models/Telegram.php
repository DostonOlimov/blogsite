<?php

namespace app\models;


use CurlFile;
use Exception;

class Telegram
{
	// declare const
	const BASE_URL = 'https://api.telegram.org';
	const BOT_URL = '/bot';
	const FILE_URL = '/file';
	// base url 
	public $baseUrl;
	public $baseFileURL;
	//bot token now for doston_bot
	protected $token ='5333966748:AAHWW2W38o6p1M7nFSIxmRXcd-Y_IyULr34';
	//chat id 
	protected $chat_id;
	//constructor must get chat id
	public function __construct($chat_id)
	{
		$this->chat_id = $chat_id;
		if (is_null($this->token)) {
			throw new Exception('chat id must not be null');
		}
		$this->baseURL = self::BASE_URL . self::BOT_URL . $this->token . '/';
		$this->baseFileURL = self::BASE_URL . self::FILE_URL . self::BOT_URL . $this->token . '/';
	}
	/**
	 * send request 
	 */
	private function sendRequest($method, $params)
	{
		
		return json_decode(file_get_contents($this->baseURL . 
		$method . '?' . http_build_query($params)), true);
 	}
	 /**
	 * A simple method for testing your bot's auth token.
	 * Returns basic information about the bot in form of a User object.
	 *return true if the bot is authenticated
	 * @link https://core.telegram.org/bots/api#getme
	 *
	 * @return Array
	 */
	public function getMe()
	{
		if ($this->sendRequest('getMe', array()))
		{
			return true;
		}
		else
		{
			return false;
		}	
	
	}
	/**
	 * Use this method to get up to date information about the chat.
	 * Returns a Chat object on success.
	 *
	 * @link https://core.telegram.org/bots/api#getchat
	 *
	 * @param int|string id or username of the supergroup or channel
	 *
	 * @return Chat object
	 */
	public function getChat()
	{
		$chat_id=$this->chat_id;
		$params = compact('chat_id');
		if ($this->sendRequest('getChat', $params))
			return true; 
		else return false;
	}	
	/**
	 * Use this method to get a list of administrators in a chat.
	 * Returns an Array of ChatMember objects on success
	 *
	 * @link https://core.telegram.org/bots/api#getchatadministrators
	 *
	 * @param int|string id or username of the supergroup or channel
	 *
	 * @return Array of ChatMember objects
	 */
	public function getChatAdministrators()
	{
		$chat_id = $this->chat_id;
		$params = compact('chat_id');
		 if (!$this->sendRequest('getChatAdministrators', $params))
		 throw new Exception('not Administrators');
		  else return true;
	}
	/**
	 * Send text messages.
	 *
	 * @link https://core.telegram.org/bots/api#sendmessage
	 *
	 * @param string         $text
	 * @param string         $parse_mode
	 * @param int            $reply_to_message_id
	 * @param KeyboardMarkup $reply_markup
	 *
	 * @return Array
	 */
	public function sendMessage( $text, $parse_mode = null, $reply_to_message_id = null, $reply_markup = null)
	{
		$chat_id=$this->chat_id;
		$params = compact('chat_id', 'text', 'parse_mode', 'reply_to_message_id', 'reply_markup');
		return $this->sendRequest('sendMessage', $params);
	}
	/**
	 * Send Photos.
	 *
	 * @link https://core.telegram.org/bots/api#sendphoto
	 *
	 * @param string         $photo
	 * @param string         $caption
	 * @param int            $reply_to_message_id
	 * @param KeyboardMarkup $reply_markup
	 *
	 * @return Array
	 */
	public function sendPhoto( $photo, $caption = null,  $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$data = compact('chat_id', 'photo', 'caption',  'reply_markup');
		// send from local file
		if( file_exists($photo)){
			return $this->uploadFile('sendPhoto', $data);
		}
		// send from url
		return $this->sendRequest('sendPhoto', $data);
	}
	/**
	 * Use this method to receive incoming updates using long polling.
	 *
	 * @link https://core.telegram.org/bots/api#getupdates
	 *
	 * @param int $offset
	 * @param int $limit
	 * @param int $timeout
	 * @return Array
	 */
	public function pollUpdates($offset = null, $timeout = null, $limit = null)
	{
		$params = compact('offset', 'limit', 'timeout');
		return $this->sendRequest('getUpdates', $params);
	}
	

	/**
	 * Forward messages of any kind.
	 *
	 * @link https://core.telegram.org/bots/api#forwardmessage
	 *
	 * @param int $from_chat_id
	 * @param int $message_id
	 *
	 * @return Array
	 */
	public function forwardMessage( $from_chat_id, $message_id)
	{
		$chat_id = $this->chat_id;
		$params = compact('chat_id', 'from_chat_id', 'message_id');
		return $this->sendRequest('forwardMessage', $params);
	}

	
	/**
	 * Send Audio.
	 *
	 * @link https://core.telegram.org/bots/api#sendaudio
	 *
	 * @param string          $audio
	 * @param int             $duration
	 * @param string          $performer
	 * @param string          $title
	 * @param int             $reply_to_message_id
	 * @param KeyboardMarkup  $reply_markup
	 *
	 * @return Array
	 */
	public function sendAudio( $audio, $duration = null, $performer = null, $title = null, $reply_to_message_id = null, $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$data = compact('chat_id', 'audio', 'duration', 'performer', 'title', 'reply_to_message_id', 'reply_markup');
		// send from local file
		if( file_exists($audio)){
			return $this->uploadFile('sendAudio', $data);
		}
		// send from url
		return $this->sendRequest('sendAudio', $data);
	}

	/**
	 * Send Document.
	 *
	 * @link https://core.telegram.org/bots/api#senddocument
	 *
	 * @param string         $document
	 * @param int            $reply_to_message_id
	 * @param KeyboardMarkup $reply_markup
	 *
	 * @return Array
	 */
	public function sendDocument( $document,$caption = null, $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$data = compact('chat_id', 'document',  'caption','reply_markup');
		if( file_exists($document)){
			return $this->uploadFile('sendDocument', $data);
		}
		// send from url
		return $this->sendRequest('sendDocument', $data);
	}

	/**
	 * Send Sticker.
	 *
	 * @link https://core.telegram.org/bots/api#sendsticker
	 *
	 * @param string         $sticker
	 * @param int            $reply_to_message_id
	 * @param KeyboardMarkup $reply_markup
	 *
	 * @return Array
	 */
	public function sendSticker( $sticker, $reply_to_message_id = null, $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$data = compact('chat_id', 'sticker', 'reply_to_message_id', 'reply_markup');
		if( file_exists($sticker)){
			return $this->uploadFile('sendSticker', $data);
		}
		// send from url
		return $this->sendRequest('sendSticker', $data);
	}

	/**
	 * Send Video.
	 *
	 * @link https://core.telegram.org/bots/api#sendvideo
	 *
	 * @param string          $video
	 * @param int             $duration
	 * @param string          $caption
	 * @param int             $reply_to_message_id
	 * @param KeyboardMarkup  $reply_markup
	 *
	 * @return Array
	 */
	public function sendVideo( $video,$caption = null, $duration = null, $reply_to_message_id = null, $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$data = compact('chat_id', 'video', 'duration', 'caption', 'reply_to_message_id', 'reply_markup');

		if( file_exists($video)){
			return $this->uploadFile('sendVideo', $data);
		}
		// send from url
		return $this->sendRequest('sendVideo', $data);
	}

	/**
	 * Send Voice.
	 *
	 * @link https://core.telegram.org/bots/api#sendvoice
	 *
	 * @param string          $audio
	 * @param int             $duration
	 * @param int             $reply_to_message_id
	 * @param KeyboardMarkup  $reply_markup
	 *
	 * @return Array
	 */
	public function sendVoice( $audio, $duration = null, $reply_to_message_id = null, $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$data = compact('chat_id', 'audio', 'duration', 'reply_to_message_id', 'reply_markup');
		if( file_exists($audio)){
			return $this->uploadFile('sendVoice', $data);
		}
		// send from url
		return $this->sendRequest('sendVoice', $data);
	}

	/**
	 * Send Location.
	 *
	 * @link https://core.telegram.org/bots/api#sendlocation
	 *
	 * @param float          $latitude
	 * @param float          $longitude
	 * @param int            $reply_to_message_id
	 * @param KeyboardMarkup $reply_markup
	 *
	 * @return Array
	 */
	public function sendLocation( $latitude, $longitude, $reply_to_message_id = null, $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$params = compact('chat_id', 'latitude', 'longitude', 'reply_to_message_id', 'reply_markup');
		return $this->sendRequest('sendLocation', $params);
	}

	/**
	 * Send Venue.
	 *
	 * @link https://core.telegram.org/bots/api#sendvenue
	 * @param float          $latitude
	 * @param float          $longitude
	 * @param string         $title
	 * @param string         $address
	 * @param string         $foursquare_id
	 * @param int            $reply_to_message_id
	 * @param KeyboardMarkup $reply_markup
	 *
	 * @return Array
	 */
	public function sendVenue( $latitude, $longitude, $title, $address, $foursquare_id = null, $reply_to_message_id = null, $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$params = compact('chat_id', 'latitude', 'longitude', 'title', 'address', 'foursquare_id', 'reply_to_message_id', 'reply_markup');
		return $this->sendRequest('sendVenue', $params);
	}
	/**
	 * Send Contact.
	 *
	 * @link https://core.telegram.org/bots/api#sendcontact
	 *
	 * @param string         $phonenumber
	 * @param string         $first_name
	 * @param string         $last_name
	 * @param bool           $disable_notification
	 * @param int            $reply_to_message_id
	 * @param KeyboardMarkup $reply_markup
	 *
	 * @return Array
	 */
	public function sendContact( $phone_number, $first_name, $last_name = null, $reply_to_message_id = null, $reply_markup = null)
	{
		$chat_id = $this->chat_id;
		$params = compact('chat_id', 'phone_number', 'first_name', 'last_name', 'reply_to_message_id', 'reply_markup');
		return $this->sendRequest('sendContact', $params);
	}

	
	/**
	 * Send Chat Action.
	 *
	 * @link https://core.telegram.org/bots/api#sendchataction
	 *
	 * @param int            $chat_id
	 * @param string         $action
	 *
	 * @return Array
	 */
	public function sendChatAction( $action)
	{
		$chat_id = $this->chat_id;
		$actions = array(
			'typing',
			'upload_photo',
			'record_video',
			'upload_video',
			'record_audio',
			'upload_audio',
			'upload_document',
			'find_location',
		);
		if (isset($action) && in_array($action, $actions)) {
			$params = compact('chat_id', 'action');
			return $this->sendRequest('sendChatAction', $params);
		}
		throw new Exception('Invalid Action! Accepted value: '.implode(', ', $actions));
	}

	/**
	 * Use this method to get basic info about a file and prepare it for downloading.
	 *
	 * @link https://core.telegram.org/bots/api#getfile
	 *
	 * @param String            $file_id
	 *
	 * @return On success, a File object is returned
	 */
	public function getFile($file_id)
	{
		return $this->sendRequest('getFile', compact('file_id'));
	}

	/**
	 * Use this method for your bot to leave a group, supergroup or channel.
	 * Returns True on success.
	 *
	 * @link https://core.telegram.org/bots/api#leavechat
	 *
	 * @param int|string id or username of the supergroup or channel
	 *
	 * @return True on success
	 */
	public function leaveChat()
	{
		$chat_id = $this->chat_id;
		$params = compact('chat_id');
		return $this->sendRequest('leaveChat', $params);
	}


	/**
	 * Use this method to get file Data.
	 *
	 * @link https://core.telegram.org/bots/api#getfile
	 *
	 * @see getFile
	 *
	 * @param string		$file_id
	 * @param string		$file_path		Is taken from the getFile response
	 *
	 * @return On success, a File Data is returned
	 */
	public function getFileData($file_id, $file_path)
	{
		return file_get_contents($this->baseFileURL . $file_path . '?' . http_build_query(compact('file_id')));
	}

	/**
	 * Set a Webhook to receive incoming updates via an outgoing webhook.
	 *
	 * @param string     $url            HTTPS url to send updates to. Use an empty string to remove webhook integration
	 * @param InputFile  $cerificate     Upload your public key certificate so that the root certificate in use can be checked
	 *
	 * @return Array
	 *
	 */
	public function setWebhook($url, $certificate = null)
	{
		if (filter_var($url, FILTER_VALIDATE_URL) === false) {
			throw new Exception('Invalid URL provided');
		}
		if (parse_url($url, PHP_URL_SCHEME) !== 'https') {
			throw new Exception('Invalid URL, it should be a HTTPS url.');
		}
		if (is_null($certificate)) {
			return $this->sendRequest('setWebhook', compact('url', 'certificate'));
		} else {
			return $this->uploadFile('setWebhook', compact('url', 'certificate'));
		}
	}

	/**
	 * Returns webhook updates sent by Telegram.
	 * Works only if you set a webhook.
	 *
	 * @see setWebhook
	 *
	 * @return Array
	 */
	public function getWebhookUpdates()
	{
		$body = json_decode(file_get_contents('php://input'), true);
		return $body;
	}

	/**
	 * Builds a custom keyboard markup.
	 *
	 * @link https://core.telegram.org/bots/api#replykeyboardmarkup
	 *
	 * @param array $keyboard
	 * @param bool  $resize_keyboard
	 * @param bool  $one_time_keyboard
	 * @param bool  $selective
	 *
	 * @return string
	 */
	public function replyKeyboardMarkup($keyboard, $resize_keyboard = false, $one_time_keyboard = false, $selective = false)
	{
		return json_encode(compact('keyboard', 'resize_keyboard', 'one_time_keyboard', 'selective'));
	}

	/**
	 * Hide the current custom keyboard and display the default letter-keyboard.
	 *
	 * @link https://core.telegram.org/bots/api#replykeyboardhide
	 *
	 * @param bool $selective
	 *
	 * @return string
	 */
	public static function replyKeyboardHide($selective = false)
	{
		$hide_keyboard = true;
		return json_encode(compact('hide_keyboard', 'selective'));
	}

	/**
	 * Display a reply interface to the user (act as if the user has selected the bots message and tapped 'Reply').
	 *
	 * @link https://core.telegram.org/bots/api#forcereply
	 *
	 * @param bool $selective
	 *
	 * @return string
	 */
	public static function forceReply($selective = false)
	{
		$force_reply = true;
		return json_encode(compact('force_reply', 'selective'));
	}

	

	private function uploadFile($method, $data)
	{
		$key = array(
			'sendPhoto'    => 'photo',
			'sendAudio'    => 'audio',
			'sendDocument' => 'document',
			'sendSticker'  => 'sticker',
			'sendVideo'    => 'video',
			'setWebhook'   => 'certificate'
		);
		if (filter_var($data[$key[$method]], FILTER_VALIDATE_URL)) {
			$file = __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . mt_rand(0, 9999);
			$url = true;
			file_put_contents($file,
			 file_get_contents($data[$key[$method]]));
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime_type = finfo_file($finfo, $file);
			$extensions = array(
				'image/jpeg'  => '.jpg',
				'image/png'   =>  '.png',
				'image/gif'   =>  '.gif',
				'image/bmp'   =>  '.bmp',
				'image/tiff'  =>  '.tif',
				'audio/ogg'   =>  '.ogg',
				'audio/mpeg'  =>  '.mp3',
				'video/mp4'   =>  '.mp4',
				'image/webp'  =>  '.webp'
			);
			if ($method != 'sendDocument') {
				if (!array_key_exists($mime_type, $extensions)) {
					unlink($file);
					throw new Exception('Bad file type/extension');
				}
			}
			$newFile = $file . $extensions[$mime_type];
			rename($file, $newFile);
			$data[$key[$method]] = new CurlFile($newFile, $mime_type, $newFile);
		} else {
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime_type = finfo_file($finfo, $data[$key[$method]]);
			$data[$key[$method]] = new CurlFile($data[$key[$method]], $mime_type, $data[$key[$method]]);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->baseURL . $method);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = json_decode(curl_exec($ch), true);
	/*	if ($url) {
			unlink($newFile);
		}*/
		return $response;
	}

}