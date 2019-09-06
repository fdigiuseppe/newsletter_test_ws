<?php

header('HTTP/1.1 200 OK');
header("access-control-allow-credentials:true");
header("AMP-Same-Origin: true");
header("Access-Control-Allow-Origin:". $_SERVER['HTTP_ORIGIN']);
header("amp-access-control-allow-source-origin: https://".$_SERVER['HTTP_HOST']);
header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
header("access-control-allow-headers:Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token");
//header("Access-Control-Allow-Origin: ". str_replace('.', '-','http://testnl.websolute.it/') .".cdn.ampproject.org");
header("access-control-allow-methods:POST, GET, OPTIONS");
header("Content-Type: application/json");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

class Form {
	var $destinatario;
	var $oggetto;
	var $messaggio;
	var $result;

	function __construct()
   {
			 $this->destinatario = "";
			 $this->oggetto = "";
			 $this->messaggio = "";
	 }

	 function setForm($destinatario,$oggetto,$messaggio)
   {
			 $this->destinatario = $destinatario;
			 $this->oggetto = $oggetto;
			 $this->messaggio = $messaggio;
	 }
	 
	 function getDestinatario() {
		 return $this->destinatario;
	 }

	 function getOggetto() {
		 return $this->oggetto;
	 }

	 function getMessaggio() {
		 return $this->messaggio;
	 }

	 function setDestinatario($destinatario) {
		 $this->destinatario = $destinatario;
	 }

	 function setOggetto($oggetto) {
		 $this->oggetto = $oggetto;
	 }

	 function setMessaggio($messaggio) {
		 $this->messaggio = $messaggio;
	 }

	 function sendMail(Form $f) {

			$mail = new PHPMailer;
			//$mail->SMTPDebug = 3;        
			$mail->isSMTP();                            
			$mail->Host = "mailhosting.websolute.it";
			$mail->Port = 25;                    
			$mail->From = "newsletterTest@websolute.it";
			$mail->FromName = utf8_decode("Newsletter Test");
			$mail->CharSet = 'UTF-8';
			//$mail->addBCC('fdigiuseppe@websolute.it', 'Test');
			//$mail->addCustomHeader("BCC: fdigiuseppe@websolute.it"); 
			//$mail-> AddCC ("");
			//$mail-> AddBCC ("fdigiuseppe@websolute.it");
			$mail->isHTML(true);
			$mail->ClearAllRecipients();
			$mail->addAddress($f->getDestinatario());
			$mail->Subject = $f->getOggetto();
			$mail->Body = $f->getMessaggio();

			//RECAP MAIL DEBUG
			$recap_mail = new PHPMailer;
			//$mail->SMTPDebug = 3;        
			$recap_mail->isSMTP();                            
			$recap_mail->Host = "mailhosting.websolute.it";
			$recap_mail->Port = 25;                    
			$recap_mail->From = "newsletterTest@websolute.it";
			$recap_mail->FromName = utf8_decode("Newsletter Test");
			$recap_mail->isHTML(true);
			$recap_mail->ClearAllRecipients();
			$recap_mail->addAddress("fdigiuseppe@websolute.it");

			if(!$mail->send())
			{
					//echo "Mailer Error: " . $mail->ErrorInfo;
					$recap_mail->Subject = "CHECK MAIL NL KO CONTROLLARE".$f->getOggetto();
					$recap_mail->Body = "MAIL INVIO KO". "<br/>"."Mailer Error: " . $mail->ErrorInfo. "<br/><br/><br/>". $f->getMessaggio();
					$recap_mail->send();
					$result = 0;
			}
			else
			{
					//echo "Message has been sent successfully";
					$recap_mail->Subject = "CHECK MAIL NL OK ".$f->getOggetto();
					$recap_mail->Body = "Inviata a: ".$f->getDestinatario(). "<br/>"."MAIL INVIO OK". "<br/>". $f->getMessaggio();
					$recap_mail->send();
					$result = 1;
			}

			return $result;
		}

}


?>