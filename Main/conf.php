<?php
/**
 * Created by PhpStorm.
 * User: xyin
 * Date: 15/9/20
 * Time: 下午3:16
 */

class Conf{
    public static $bookIds = array(3106580,2952453,3513193);

    public static $mailOptions = array(
        'Host' => 'smtp-mail.outlook.com',
        'SMTPAuth'  => true,
        'Username'  => 'pirate_001@outlook.com',
        'Password'  => 'pirate15',
        'SMTPSecure'=> 'tls',
        'Port'      => 587,
        'From'      => 'pirate_001@outlook.com',
        'FromName'  => 'notice',
        'isHTML'	=> true,
    );

    public static $addressList = array("825627580@qq.com");

    public static $subjectTemplate = "你关注的小说《{1}》更新啦！";

    public static $contentTemplate = "最新章节:{1}，<a href='{2}'>点击进入</a>起点阅读";

    public static $logPath = '/Log';

    public static $indexUrl = "http://wap.m.qidian.com/book/showbook.aspx?bookid={1}&order=desc";

    public static $readUrl = "http://wap.m.qidian.com/book/BookReader.aspx?bookid={1}&chapterid={2}";

    public static $dataPath = '/data.json';   //小说数据保存路径

    public static $logLevel = array(
        "success"   => 0,
        "warning"   => 1,
        "error"     => 2,
        "fatal"     => 3,
    );
}