<?php
/**
 * Created by PhpStorm.
 * User: xyin
 * Date: 15/3/27
 * Time: 下午1:09
 */

class Mailer{
    private $_host = '';
    private $_smtp_auth = true;
    private $_username = '';
    private $_password = '';
    private $_smtp_secure = 'ssl';
    private $_port = 0;
    private $_from = '';
    private $_from_name = '';
    private $_isHTML = true;
    private $_address_list = array();
    private $_attachment = array();

    private $_subject = '';
    private $_body = '';
    private $_alt_body = '';

    /**
     * @param array $addressList
     * @param string $subject
     * @param string $message
     * @param array $mailConf
     */
    public function __construct($addressList = array(),$subject = '',$message = '',$mailConf =array()){
        $this->_host = $mailConf['Host'];
        $this->_smtp_auth = $mailConf['SMTPAuth'];
        $this->_username = $mailConf['Username'];
        $this->_password = $mailConf['Password'];
        $this->_smtp_secure = isset($mailConf['SMTPSecure']) ?  $mailConf['SMTPSecure'] : 'ssl';
        $this->_port = $mailConf['Port'];
        $this->_from = $mailConf['From'];
        $this->_from_name = $mailConf['FromName'];
        $this->_isHTML = $mailConf['isHTML'];
        $this->_address_list = $addressList;
        $this->_subject = $subject;
        $this->_body = $message;
    }

    public function send(){
        require_once ROOT . '/../Mailer/PHPMailerAutoload.php';

        $mail = new PHPMailer();
        $mail->CharSet = "utf-8"; //设置字符集编码
        $mail->isSMTP();
        $mail->Host = $this->_host;
        $mail->SMTPAuth = $this->_smtp_auth;
        $mail->Username = $this->_username;
        $mail->Password = $this->_password;
        $mail->SMTPSecure = $this->_smtp_secure;
        $mail->Port = $this->_port;
        $mail->From = $this->_from;
        $mail->FromName = $this->_from_name;
        $mail->SMTPKeepAlive = true;
        $mail->IsHTML(true);
        foreach($this->_address_list as $address){
            $mail->addAddress($address);
        }
        $mail->Subject = $this->_subject;
        $mail->Body = $this->_body;
        $mail->AltBody = $this->_alt_body;

        if(!$mail->send()){
            return array(-1,$mail->ErrorInfo);
        }else{
            return array(0,'success');
        }
    }
}
