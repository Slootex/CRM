<?php 

/**
 * PHPMailer - PHP email creation and transport class.
 * PHP Version 1.0
 *
 * @see       https://www.gzamotors.de/DBBMailer The DBBMailer project
 *
 * @author    Dirk B. <overfutz@yahoo.com>
 * @copyright 2021 - 2061 Dirk B.
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note      This program is distributed by Gazi Ahmad - www.GZAMOTORS.de .
 *
 * @initialize object dbbMailer
 */
class dbbMailer {

	/* Constants  */
	const APPLICATION = "DBBMailer";
	const VERSION = "v1.0";
	const OWNER_INFO = "overfutz@yahoo.com";

	const CR = "\r";
	const LF = "\n";
	const TAB = "\t";
	const CRLF = self::CR . self::LF;
	const BRLF = "<br />" . self::LF;

	/* Variables - Public  */
	public $logging = "";

	public $host = "mail.example.net";
	public $username = "";
	public $password = "";
	public $secure = "tls";
	public $port = 587;
	public $charset = "UTF-8";
	public $timeout = 3000;

	public $subject = "";

	public $body = "";

	/* Variables - Protected  */
	protected $socket;

	protected $from_address = "";

	protected $to_addresses = [];
	protected $cc_addresses = [];
	protected $bcc_addresses = [];
	protected $replay_to_addresses = [];

	protected $file_attachments = [];
	protected $data_attachments = [];

    /**
     * Constructor.
     *
     * @addlog(parameter) string
     * @return void
     */
	public function __construct(){
		$this->addlog($this->html_tag("h1", "+++++ " . $this->html_tag("u", self::APPLICATION . " " . self::VERSION . " &copy; " . date("Y", time())) . " +++++"));
	}

	/**
	 * Set From.
	 *
	 * @param string $email The address from an E-mail-Account
	 * @param string $name The name from an E-mail-Account
	 *
	 * @from_address string
	 * @return void
	 */
	public function setFrom($email, $name = ""){
		$this->from_address = $this->format_address($email, $name);
	}

	/**
	 * Add Address.
	 *
	 * @param string $email The address from an E-mail-Account
	 * @param string $name The name from an E-mail-Account
	 *
	 * @to_addresses[] string
	 * @return void
	 */
	public function addAddress($email, $name = ""){
		$this->to_addresses[] = $this->format_address($email, $name);
	}

	/**
	 * Add CC.
	 *
	 * @param string $email The address from an E-mail-Account
	 * @param string $name The name from an E-mail-Account
	 *
	 * @$this->cc_addresses[] string
	 * @return void
	 */
	public function addCC($email, $name = ""){
		$this->cc_addresses[] = $this->format_address($email, $name);
	}

	/**
	 * Add BCC.
	 *
	 * @param string $email The address from an E-mail-Account
	 * @param string $name The name from an E-mail-Account
	 *
	 * @bcc_addresses[] string
	 * @return void
	 */
	public function addBCC($email, $name = ""){
		$this->bcc_addresses[] = $this->format_address($email, $name);
	}

	/**
	 * Add Replay To.
	 *
	 * @param string $email The address from an E-mail-Account
	 * @param string $name The name from an E-mail-Account
	 *
	 * @replay_to_addresses[] string
	 * @return void
	 */
	public function addReplyTo($email, $name = ""){
		$this->replay_to_addresses[] = $this->format_address($email, $name);
	}

	/**
	 * Add Attachment.
	 *
	 * @param string $path The attachment path
	 * @param string $filename The attachment filename
	 *
	 * @file_attachment[] array
	 * @return void
	 */
	public function addAttachment($path, $filename = '', $encoding = "base64", $filetype = ""){
		if(file_exists($path) && is_file($path)){
			$fileinfo = pathinfo($path);
			$filedata = file_get_contents($path);
			$filename = (!empty($filename) ? $filename : $fileinfo['basename']);
			$this->file_attachments[] = [
				"filedata" => $filedata, 
				"filename" => $filename, 
				"encoding" => $encoding, 
				"filetype" => (!empty($filetype) ? $filetype : mime_content_type($path))
			];
		}
	}

	/**
	 * Add String Attachment.
	 *
	 * @param string $filedata The file attachment data
	 * @param string $filename The file attachment name
	 * @param string $encoding The file data encoding
	 * @param string $filetype The file attachment filetype
	 *
	 * @data_attachment[] array
	 * @return void
	 */
	public function addStringAttachment($filedata, $filename, $encoding = "base64", $filetype = "application/pdf"){
		$this->data_attachments[] = array(
			"filedata" => $filedata, 
			"filename" => $filename, 
			"encoding" => $encoding, 
			"filetype" => $filetype
		);
	}

	/**
	 * Get Logs.
	 *
	 * @return string
	 */
	public function getLogs(){
		return $this->logging;
	}

	/**
	 * Add Log.
	 *
	 * @param string $str The logging command
	 *
	 * @logging string
	 * @return void
	 */
	public function addlog($str){
		$this->logging .= $str . self::BRLF;
	}

	/**
	 * Add Angle Brackets.
	 *
	 * @param string $str The string that is being bracketed
	 *
	 * @return string
	 */
	public function add_angle_brackets($str){
		return "<" . $str . ">";
	}

	/**
	 * Format Address.
	 *
	 * @param string $email The address from an E-mail-Account
	 * @param string $name The name from an E-mail-Account
	 *
	 * @return string
	 */
	public function format_address($email, $name){
		return (!empty($name) ? "=?" . $this->charset . "?Q?" . str_replace("%", "=", str_replace("%20", "_", rawurlencode($this->strip_crlf($name)))) . "?=" : "") . $this->add_angle_brackets($this->strip_8bit($email));
	}

	/**
	 * Get Domainname.
	 *
	 * @return string
	 */
	public function getDomainname(){
        if(!empty($_SERVER['HTTP_HOST'])){
            return $_SERVER['HTTP_HOST'];
        }elseif(!empty($_SERVER['SERVER_NAME'])){
            return $_SERVER['SERVER_NAME'];
        }else{
            return $_SERVER['SERVER_ADDR'];
		}
	}

	/**
	 * Strip 8bit.
	 *
	 * @param string $str The string that is freed from 8-bit characters
	 *
	 * @return string
	 */
	public function strip_8bit($str){
		return trim(preg_replace('/[\x80-\xFF]/', '', $str));
	}

	/**
	 * Strip CRLF.
	 *
	 * @param string $str The string that is freed from carrier-return and linefeed characters
	 *
	 * @return string
	 */
	public function strip_crlf($str){
		return trim(preg_replace('/[\r\n]+/', '', $str));
	}

	/**
	 * Array To UL LI.
	 *
	 * @param array $array A multidimensional array with key value pairs
	 * @param string $tab The tab is incremented in each recursion
	 *
	 * @return string
	 */
	public function array_to_ul_li($array, $tab = ""){
		$str = $tab . $this->html_tag("ul") . self::LF;
		foreach ($array as $key => $val){
			$str .= $tab . self::TAB . $this->html_tag("li", $key . ": " . (is_array($val) ? self::LF . $this->array_to_ul_li($val, $tab . self::TAB . self::TAB) . $tab . self::TAB : $val)) . self::LF;
		}
		$str .= $tab . $this->html_tag("/ul") . self::LF;
		return $str;
	}

	/**
	 * HTML Tag.
	 *
	 * @param string $tag The label of a html-tag
	 * @param string $text The content text for br and single tags it can be empty 
	 *
	 * @return string
	 */
	public function html_tag($tag, $text = ""){
		return empty($text) ? $this->add_angle_brackets(($tag == "br" ? $tag . "/" : $tag)) : $this->add_angle_brackets($tag) . $text . $this->add_angle_brackets("/" . $tag);
	}

	/**
	 * Generate Random String.
	 *
	 * @param integer $length The length for the returnes string, it is empty it will auto length set to 43
	 *
	 * @return string
	 */
	protected function generate_ramdom_string($length = 43){
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$string = "";
		for($i = 0; $i < $length; $i++){
			$string .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $string;
	}

	/**
	 * Get.
	 *
	 * @param string $label The logging label
	 *
	 * @addlog(parameter) string
	 * @return void
	 */
	protected function get($label){
		$data = '';
		$result = fgets($this->socket, 1024);
		while($result){
			$data .= $result;
			if($result[3] != '-'){
				break;
			}
			$result = fgets($this->socket, 1024);
		}
		$this->addlog($label . ": " . htmlentities($data));
	}

	/**
	 * Put.
	 *
	 * @param string $string The command string
	 *
	 * @return void
	 */
	protected function put($string){
		fputs($this->socket, $string . self::CRLF, 1024);
	}

	/**
	 * Create Attachment.
	 *
	 * @param array $attachments The attachments data
	 * @param string $boundary To seperate data areas
	 *
	 * @return string
	 */
	protected function create_attachment($attachments, $boundary){
		if(count($attachments) > 0){
			$data = "";
			for($i = 0;$i < count($attachments);$i++){
				$data .= self::CRLF . "--" . $boundary . self::CRLF;
				$data .= "Content-Type: " . $attachments[$i]['filetype'] . "; name=\"" . $attachments[$i]['filename'] . "\"" . self::CRLF;
				$data .= "Content-Transfer-Encoding: " . $attachments[$i]['encoding'] . self::CRLF;
				$data .= "Content-Disposition: attachment; " . $attachments[$i]['filename'] . self::CRLF;
				$data .= self::CRLF;
				if($attachments[$i]['encoding'] == "base64"){
					$data .= chunk_split(base64_encode($attachments[$i]['filedata']), 76, PHP_EOL);
					$data .= self::CRLF;
				}
			}
			return $data;
		}
		return "";
	}

	/**
	 * Send.
	 *
	 * @return bool
	 */
	public function send() {

		$boundary = "b0_" . $this->generate_ramdom_string();

		$this->socket = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
		$this->get("SOCKET OPEN");

		//stream_set_timeout($this->socket, $this->timeout);

		$this->put('EHLO ' . $this->getDomainname());
		$this->get("EHLO");

		$this->put('STARTTLS');
		$this->get("STARTTLS");

		if($this->secure == 'tls'){
			$crypto_method = STREAM_CRYPTO_METHOD_TLS_CLIENT;
			if(defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')){
				$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
				$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT;
			}
			stream_socket_enable_crypto($this->socket, true, $crypto_method);

			$this->put('EHLO ' . $this->getDomainname());
			$this->get("EHLO");

		}

		$this->put("AUTH LOGIN");
		$this->get("AUTH LOGIN");

		$this->put(base64_encode($this->username));
		$this->get("USERNAME");

		$this->put(base64_encode($this->password));
//		$this->get("PASSWORD");

		$this->put("MAIL FROM: " . $this->from_address);
		$this->get("MAIL FROM");

		for($i = 0;$i < count($this->to_addresses);$i++){
			$this->put("RCPT TO: " . $this->to_addresses[$i]);
			$this->get("RCPT TO");
			//$this->addlog("RCPT " . $i . ": " . htmlentities($this->to_addresses[$i]));
		}

		$this->put("DATA");
		$this->get("DATA");

		$this->body = str_replace("\n.", "\n..", $this->body);
		$this->body = preg_replace('/[^\r\n]{73}[^=\r\n]{2}/', "$0=\r\n", str_replace("%", "=", str_replace("%20", " ", rawurlencode($this->body))));
		//$this->addlog("BODY: OK");

		$headers = "MIME-Version: 1.0" . self::CRLF;
		$headers .= "Date: " . date("D, j M Y H:i:s O", time()) . self::CRLF;
		$headers .= "To: " . (implode(', ', $this->to_addresses)) . self::CRLF;
		$headers .= "From: " . $this->from_address . self::CRLF;
		$headers .= "Subject: " . strip_tags($this->subject) . self::CRLF;

		if(count($this->replay_to_addresses) > 0){
			$headers .= "Reply-To: " . implode(', ', $this->replay_to_addresses) . self::CRLF;
		}

		$headers .= "X-Mailer: " . self::APPLICATION . " " . self::VERSION . (!empty(self::OWNER_INFO) ? " (" . self::OWNER_INFO . ")" : "") . self::CRLF;

		if(count($this->file_attachments) > 0 || count($this->data_attachments) > 0){
			$headers .= "Content-Type: multipart/mixed;" . self::CRLF . "	boundary=\"" . $boundary . "\"" . self::CRLF;
			$headers .= "Content-Transfer-Encoding: 8bit" . self::CRLF;
			$headers .= self::CRLF;
			$headers .= "This is a multi-part message in MIME format." . self::CRLF;
			$headers .= "--" . $boundary . self::CRLF;
			$headers .= "Content-Type: text/html; charset=" . $this->charset . self::CRLF;
			$headers .= "Content-Transfer-Encoding: quoted-printable" . self::CRLF;
		}else{
			$headers .= "Content-type: text/html; charset=" . $this->charset . self::CRLF;
			$headers .= "Content-Transfer-Encoding: quoted-printable" . self::CRLF;
		}

		$file_attachments = $this->create_attachment($this->file_attachments, $boundary);

		$data_attachments = $this->create_attachment($this->data_attachments, $boundary);

		fputs($this->socket, $headers . "\r\n" . $this->body . $file_attachments . $data_attachments . "\n.\n");
		$this->get("HEADERS+BODY+FILE_ATTACHMENTS+DATA_ATTACHMENTS");

		$this->put("QUIT");
		$this->get("QUIT");

		$socket_info = $this->array_to_ul_li(stream_get_meta_data($this->socket));

		fclose($this->socket);
		$this->addlog("SOCKET CLOSE: OK" . self::BRLF);

		$this->addlog("<strong><u>META-DATA</u></strong>");
		$this->addlog($socket_info);

		return true;

	}

	/**
	 * Get.
	 *
	 * @param string $label The logging label
	 *
	 * @return void
	 */
	public function __destruct(){

	}

}

?>