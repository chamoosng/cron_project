<?php
require_once './library/email.php';

$urls = [
  'https://plus.netreal.jp/',
  'http://www.netfax.jp/',
  'https://www.netlist.jp/',
  'https://www.nettel.jp/',
  'https://www.net-dm.jp/',
  'https://xn--sms-rm0et401a.com/',
  'https://xn--hetw09e0b157h.com/',
  'https://www.netfax.jp/smp/',
  // 'https://this.is.dummy.site.co.jp/'
];

/**
 * @param $url 
 * 
 * @return bool htmlのコードが１００以下ならtrue
 */
function check_html_body_length(string $url): bool
{
  $context = stream_context_create([
    'ssl' => [
      'verify_peer'      => false,
      'verify_peer_name' => false
    ]
  ]);

  $body = file_get_contents($url, false, $context);

  return strlen($body) < 100 ? true : false;
}

/**
 * @param array $urls site urls
 * 
 * @return array htmlのコードが非常に短いurls
 */
function get_urls_warining_html_body(array $urls): array
{
  return array_filter($urls, 'check_html_body_length');
}

/**
 * @param $urls 状態がおかしなurls
 */
function send_email_warning_urls(array $urls): void
{
  $body = "";
  $body .= email_template(get_urls_warining_html_body($urls), 'htmlのボリュームが非常に低いです。ご確認申し上げます。');

  if ( ! empty($body)) {

    error_log($body . PHP_EOL, 3, './test.log');
    sendMail($body);
  }
}

send_email_warning_urls($urls);

