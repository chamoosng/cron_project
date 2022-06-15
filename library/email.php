<?php

require_once './src/PHPmailer.php';
require_once './src/SMTP.php';

function sendMail(string $body): void
{
  $mail = new PHPMailer(true);

  try {
    //Gmail 認証情報
    $host = 'smtp.gmail.com';
    $username = 'chamoosong@gmail.com'; // example@gmail.com
    $password = '';
  
    //差出人
    $from = 'chamoosong@gmail.com';
    $fromname = 'chamoosong@gmail.com';
  
    //宛先
    $to = 'zpunsss@gmail.com';
    $toname = 'zpunsss@gmail.com';
  
    //メール設定
    $mail->SMTPDebug = 2; //デバッグ用
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = $host;
    $mail->Username = $username;
    $mail->Password = $password;

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet = "utf-8";
    $mail->Encoding = "base64";

    $mail->setFrom($from, $fromname);
    $mail->addAddress($to, $toname);

    $mail->Subject = '疑われるサイトを発見';
    $mail->Body    = $body;

    $mail->IsHTML(true);  

    //メール送信
    $mail->send();
    echo '成功';
  
  } catch (Exception $e) {
    echo '失敗: ', $mail->ErrorInfo;
  }
}

/**
 * @param $warning_urls 状態がおかしなurls
 * @param $log おかしいだっと判断した理由
 * 
 * @return string emailの内容
 */
function email_template(array $warning_urls, string $log): string
{
  if (empty($warning_urls)) {

    return '';
  }

  return "<b>$log<b/> <br/>" . implode('<br/>', $warning_urls);
}
