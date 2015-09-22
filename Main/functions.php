<?php
/**
 * Created by PhpStorm.
 * User: xyin
 * Date: 15/9/21
 * Time: 下午2:58
 */

/**
 * @param $bookName 书名
 * @param $title    章节标题
 * @param $url  章节阅读链接
 * @return array
 */
function sendMail($bookName,$title,$url){
    $conf = Conf::$mailOptions;
    require_once(ROOT . '/Mail.php');
    ignore_user_abort(TRUE); //如果客户端断开连接，不会引起脚本abort
    set_time_limit(0);
    $mailOptions = Conf::$mailOptions;
    $addressList = Conf::$addressList;
    $subjectTemplate = Conf::$subjectTemplate;
    $contentTemplate = Conf::$contentTemplate;
    $subject = str_replace("{1}",$bookName,$subjectTemplate);
    $content = str_replace("{1}",$title,$contentTemplate);
    $content = str_replace("{2}",$url,$content);

    $mailer = new Mailer($addressList,$subject,$content,$mailOptions);

    return $mailer->send();
}

function compare($bookId,$chapterId){
    $path = ROOT . Conf::$dataPath;
    $data = json_decode(file_get_contents($path),true);
    if(isset($data[$bookId])&&is_numeric($data[$bookId])){
        if($data[$bookId] == $chapterId){
            return false;
        }
        else{
            $data[$bookId] = $chapterId;
            $fp = fopen($path,"w+");
            fwrite($fp,json_encode($data));
            fclose($fp);
            return true;
        }
    }
    else{
        $data[$bookId] = $chapterId;
        $fp = fopen($path,"w+");
        fwrite($fp,json_encode($data));
        fclose($fp);
        return false;
    }

}

function spiderLog($type,$flag,$message){
    $logPath = ROOT . Conf::$logPath;
    if(!is_readable($logPath))
    {
        is_file($logPath) or mkdir($logPath,0777);
    }
    $fileName = date("Y_m_d",time()) . ".log";
    $path = rtrim($logPath,"/") . "/" . $fileName;

    $str = sprintf("%s\t%s\t%s\t%s\t\n",
        date("Y-m-d H:i:s"),
        $type,
        $flag,
        $message
    );

    $fp = fopen($path,"a+");
    fwrite($fp,$str);
    fclose($fp);
}