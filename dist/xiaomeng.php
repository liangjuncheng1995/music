<?php
/**
 * ��������ô�����������������
 * ���ߣ���������
 * ԭ�ĵ�ַ��https://mkblog.cn/1523/
 * ������ת������ر���������Ϣ������
 */
 
$web_id = '15095';      // ��վID
$sso_key = 'wSJf8g0TmnnGpbVMqJqYGd5XplHPlVK7';  // SSO_KEY
 
/***************************************************************/
 
// �����վID�Լ�SSO_KEY�Ƿ�����
if(!$web_id || !$sso_key) die('��������վID�Լ�SSO_KEY��');
 
// ��ȡģ���û���Ϣ
if(isset($_COOKIE['xlm_uid'])) {    // �� COOKIE �ж�ȡ�����û���Ϣ
    $uid = $_COOKIE['xlm_uid'];
    $uname = isset($_COOKIE['xlm_uname'])? $_COOKIE['xlm_uname']: '����_'.$uid;
    $upic = isset($_COOKIE['xlm_upic'])? $_COOKIE['xlm_upic']: 'https://unsplash.it/100/100?random';
} else {
    // ��ȡ������û������Ա�ͷ�����Ϣ�����õ����� API��
    $uinfo = file_get_contents('https://uinames.com/api/?region=england&ext');
    $uinfo = json_decode($uinfo, true);
    $uname = $uinfo['name'];
    $upic = $uinfo['photo'];
    $uid = rand(1, 999999999);  // ��������û�ID
    
    // �洢��ȡ���û���Ϣ�� COOKIE ��
    setcookie('xlm_uid', $uid, 0, '/');
    setcookie('xlm_uname', $uname, 0, '/');
    setcookie('xlm_upic', $upic, 0, '/');
} 
 
// ���������ַ�
$uid = urlencode(htmlspecialchars($uid));
$uname = urlencode(htmlspecialchars($uname));
$upic = urlencode(htmlspecialchars($upic));
 
// ��ȡʱ���
$time = time(); 
 
// �ϳ� Token
$token = $web_id.'_'.$uid.'_'.$time.'_'.$sso_key;
 
// ���� Token����� xlm_hash
$xlm_hash = hash('sha512', $token);
 
// �ϳ������ַ
$chat_url = 'https://xianliao.me/s/'.$web_id.'?mobile=1&uid='.$uid.'&username='.$uname.'&avatar='.$upic.'&ts='.$time.'&token='.$xlm_hash;
 
// �ض���������ҳ���ַ
header('Location: '.$chat_url); 
die();
 
?>