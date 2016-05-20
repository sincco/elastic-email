<?php
# NOTICE OF LICENSE
#
# This source file is subject to the Open Software License (OSL 3.0)
# that is available through the world-wide-web at this URL:
# http://opensource.org/licenses/osl-3.0.php
#
# -----------------------
# @author: Iván Miranda
# @version: 1.0.0
# -----------------------
# Send email using Elastic Email API
# -----------------------

namespace Sincco\Tools;

final class ElasticEmail extends \stdClass {
	public function send($para, $asunto, $contenidoTxt, $contenidoHtml, $de, $deNombre) {
		$respuesta = "";
		$_data = "username=".urlencode($username);
		$_data .= "&api_key=".urlencode($api_key);
		$_data .= "&from=".urlencode($de);
		$_data .= "&from_name=".urlencode($deNombre);
		$_data .= "&to=".urlencode($para);
		$_data .= "&subject=".urlencode($asunto);
		if($contenidoHtml)
		$_data .= "&body_html=".urlencode($contenidoHtml);
		if($contenidoTxt)
		$_data .= "&body_text=".urlencode($contenidoTxt);
		$_header = "POST /mailer/send HTTP/1.0\r\n";
		$_header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$_header .= "Content-Length: " . strlen($_data) . "\r\n\r\n";
		$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
		if(!$fp)
		return "ERROR. Could not open connection";
		else {
		fputs ($fp, $_header.$_data);
		while (!feof($fp)) {
		$respuesta .= fread ($fp, 1024);
		}
		fclose($fp);
		}
		return $respuesta;
	}
}