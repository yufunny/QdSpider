<?php
/**
 * Created by PhpStorm.
 * User: xyin
 * Date: 15/9/20
 * Time: 下午3:13
 */

define('ROOT',realpath(dirname(__FILE__)));
require ROOT . "/conf.php";
require ROOT . "/functions.php";
mb_internal_encoding("UTF-8");

$bookIds = Conf::$bookIds;
$indexUrl = Conf::$indexUrl;
$readUrlTemplate = Conf::$readUrl;

foreach($bookIds as $id){
    $url = str_replace("{1}",$id,$indexUrl);
    $str = file_get_contents($url);
    if(preg_match_all("/<div class=\"tit02\".*?>.*?<\/div>/ism",$str,$match)){
        $bookInfo = $match[0][0];
        preg_match_all("/<h4.*?<\/h4>/ism",$bookInfo,$match);
        $bookName = preg_replace("/[<h4>\/\s]+/","",$match[0][0]);
    }
    else{
        spiderLog("preg",Conf::$logLevel["error"],$id . "未匹配到小说信息");
        continue;
    }

    if(preg_match_all("/最新章节.*?<\/a>/ism",$str,$match)){
        $articleInfo = $match[0][0];
        preg_match_all("/>.*?</ism",$articleInfo,$match);
        $title = preg_replace("/^[<>\s]+|[<>\s]+$/","",$match[0][0]);
        preg_match_all("/\d+/ism",$articleInfo,$match);
        $chapterId = $match[0][1];
    }
    else{
        spiderLog("preg",Conf::$logLevel["error"],$id . "未匹配到最新章节信息");
        continue;
    }

    if(compare($id,$chapterId)){
        spiderLog("update",Conf::$logLevel["success"],$id . "($bookName)" . "已更新");
        $readUrl = str_replace("{1}",$id,$readUrlTemplate);
        $readUrl = str_replace("{2}",$chapterId,$readUrl);
        list($code,$msg) = sendMail($bookName,$title,$readUrl);
        if($code == 0){
            spiderLog("mail",Conf::$logLevel["success"],$id . "($bookName)" . "发送邮件通知成功");
        }
        else{
            spiderLog("mail",Conf::$logLevel["error"],$id . "($bookName)" . $msg);
        }
    }
    else{
        spiderLog("update",Conf::$logLevel["warning"],$id . "($bookName)" . "未更新");
    }
    $fp = fopen("foo.txt","a");
    fwrite($fp,$bookName . $title .$chapterId ."\n");
    fclose($fp);
}
