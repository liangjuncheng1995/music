<?php
/**
 * 将“闲聊么”改造成匿名聊天室
 * 作者：孟坤博客
 * 原文地址：https://mkblog.cn/1523/
 * ！！！转载请务必保留以上信息！！！
 */
 
$web_id = '15095';      // 网站ID
$sso_key = 'wSJf8g0TmnnGpbVMqJqYGd5XplHPlVK7';  // SSO_KEY
 
/***************************************************************/
 
// 检测网站ID以及SSO_KEY是否设置
if(!$web_id || !$sso_key) die('请设置网站ID以及SSO_KEY！');
 
// 获取模拟用户信息
if(isset($_COOKIE['xlm_uid'])) {    // 从 COOKIE 中读取到了用户信息
    $uid = $_COOKIE['xlm_uid'];
    $uname = isset($_COOKIE['xlm_uname'])? $_COOKIE['xlm_uname']: '匿名_'.$uid;
    $upic = isset($_COOKIE['xlm_upic'])? $_COOKIE['xlm_upic']: 'https://unsplash.it/100/100?random';
} else {
    // 获取随机的用户名、性别、头像等信息（利用第三方 API）
    $uinfo = file_get_contents('https://uinames.com/api/?region=england&ext');
    $uinfo = json_decode($uinfo, true);
    $uname = $uinfo['name'];
    $upic = $uinfo['photo'];
    $uid = rand(1, 999999999);  // 随机生成用户ID
    
    // 存储获取的用户信息到 COOKIE 中
    setcookie('xlm_uid', $uid, 0, '/');
    setcookie('xlm_uname', $uname, 0, '/');
    setcookie('xlm_upic', $upic, 0, '/');
} 
 
// 过滤特殊字符
$uid = urlencode(htmlspecialchars($uid));
$uname = urlencode(htmlspecialchars($uname));
$upic = urlencode(htmlspecialchars($upic));
 
// 获取时间戳
$time = time(); 
 
// 合成 Token
$token = $web_id.'_'.$uid.'_'.$time.'_'.$sso_key;
 
// 加密 Token，获得 xlm_hash
$xlm_hash = hash('sha512', $token);
 
// 合成聊天地址
$chat_url = 'https://xianliao.me/s/'.$web_id.'?mobile=1&uid='.$uid.'&username='.$uname.'&avatar='.$upic.'&ts='.$time.'&token='.$xlm_hash;
 
// 重定向至聊天页面地址
header('Location: '.$chat_url); 
die();
 
?>