<?php

require_once (__DIR__.'/alipay-sdk-PHP-3.3.1/AopSdk.php');

class Alipay
{
    /**
     * 应用ID
     */
    const APPID = '2019010962799772';
    /**
     *请填写开发者私钥去头去尾去回车，一行字符串
     */
    const RSA_PRIVATE_KEY = 'MIIEowIBAAKCAQEAsjN+PnqxEFHWyZubDBTpYVIp0kIU37MkgLpTg71rErWdvDDI4MOwL14VDNPAfZGASSmNtxIAf6tzs9mrS4P7FmdAmk4NvvZgeYfWGD2cpWON/f9zq6Et26PzEPz0RV/r8q1n9iZmTr1bv52qZRJ/BudRGphtL7sTrxF3FiLd51x668dJLjaqViWWAkGmG2EG9SMDULVMs0FuqmG6KiNOa+CwSt/Y5XS6YPgzPuGUhqObPzJMv6N25i0x2HHw5n1UmYOy1KKNyeEgcfulop85wlJoTgUvu+gvHA4WrDZYaKPN0PKgRXmRshWxw1czCTi/nSQ1cWNz7EvOqHbVK/Gq0wIDAQABAoIBADejWDFNwWblBnjf+qLlDJD0RFZ/h2Do3+bJRjYFuB6ZUexmFvIGZ0YCy/O7UYhjG3i8XqDgIAO8ll17Ar6LMKQoDMWgxS3wYuLPBIuBAR2qXbUGQyk9I8JGCCgvslzOvC6C8ciq6JqBCNpk8cSo57xSEMKLANw8PsMUYugobrxDYEFixIisEWHpkaoQLpjQoQUEJBZSy2wE4kiHKR/VqE4BDvb3dEvFL69oj5W+NtgyQ12H+/OoYr891ouUehSYCF2qAHjXBfalKqEUFSzFDdKjMtKIwNFIqvIJqQEsfKF1nsngs8NqSYbXoAFUEGWNFIoQJe0NOBNxKPAanOceHKECgYEA2QcTyzNFcN55Sn3PFESB/XAWHknaBr11RuTyIOpXf+6YJ9uabJoCtyHnJ7Yexk7cBHefD7dJO8pSVNPQkS9lewzLTtIL/0qyKAaLfmYyJdIfqRzUYzupXX2rrghf72azP92TPdXbTn83oJWg75H8JMVlMBTAFDdL+lIdSAblqLkCgYEA0jOIWu5y40RXTPK/FCQy6bihlibS2BQR/Op5tjy70Nh/GAKyDX7/RMWBtOd/KesZMPFR6Za5Ly2QLOVD2I7bPApAQiUTIY4h6wE8YS0igUNiMf8TrmyPPJQxYKwtHSQ93o2DsieUSr3AB7VUjlyFEUHuUAmZ04zy3QEOMpGHkesCgYEAgvzNipBIciYkqLwkNwRePJvhDajfScAhv4dBSHKIGzPja/MUUkXmK6fvvz0hd+lyy9NzEmY6cjbb2Ez7jhVAN7NyJgGKsivgOV4x5TlDPSaEa2p2GeqRf1bxPpnZZUHkIEDYtLKVqdwItAh7WP0QZRUqzIlJoSn61nunJqjbBikCgYBSbRjEJ4rvqaXeK7ZYDJXWZqseeRzm1H/1QHD30DsJ+0tjO/NcLXemHRjuunR4GJOpSIgJZCw73s8Re9mt+t7nXVGzXlxxJQ4R3Es0BAHq1GSWHGM4W6OTar0uHnYWXlbQhYel/bU91ciOfUGqDYe0q7jqs8kZVsUJetd5Zu3VfwKBgCyHaMJJEsher+K6cd+lyaSmP/YLjermBdknQPhMd435jCGXLm7GjI+Gd9aFthsMjj0l3RPk09W8xPzE3QGQ4omdc+Aj8BWY2X+w9kUwHuPmBDhtr91kXeHwmgi5M1uhoQI/5JNRusQ0BU22H8lXufxJyOybALBKETZvMkUGws8c';
    /**
     *请填写支付宝公钥，一行字符串
     */
    const ALIPAY_RSA_PUBLIC_KEY = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkQK+NfiKExOvQ6Y2AGGuS5iqXWSHBOtQrO+H/1wJOMCKveDshJA5KU+1Cnb/MntZrt1NdWIWKnTcSDGUtN4wA/qrKf94kGQp6uq6tRql2LSIpg/N7781DkwFofrp9c4b+TMyPyy6iVFwxHDQspVhR5bZAFhNwxjLiT2isr/vDivDghDCOd13AuxQwqugHSSqr+H1L95FGKze/+NWbjzVl8h3n1Xo2BuggDWnTG4WyCTTk9QNBMX61xZ8YeI9tL8kEVUYJNU2LoozpIU9Yy9FNDRRLcQCSCeUszqToqsNMHrP7xkEy+0Ixd7h+Tf6Xc8sxnQCI85syMiUIsYvJi9pbwIDAQAB';
    /**
     * 支付宝服务器主动通知商户服务器里指定的页面
     * @var string
     */
    private $callback = "http://www.test.com/notify/alipay_notify.php";

    /**
     *生成APP支付订单信息
     * @param string $orderId   商品订单ID
     * @param string $subject   支付商品的标题
     * @param string $body      支付商品描述
     * @param float $pre_price  商品总支付金额
     * @param int $expire       支付交易时间
     * @return bool|string  返回支付宝签名后订单信息，否则返回false
     */
    public function unifiedorder($orderId, $subject,$body,$pre_price,$expire){
        try{
            $aop = new AopClient();
            $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
            $aop->appId = self::APPID;
            $aop->rsaPrivateKey = self::RSA_PRIVATE_KEY;
            $aop->format = "json";
            $aop->charset = "UTF-8";
            $aop->signType = "RSA2";
            $aop->alipayrsaPublicKey = self::ALIPAY_RSA_PUBLIC_KEY;
            //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
            $request = new \AlipayTradeAppPayRequest();
            //SDK已经封装掉了公共参数，这里只需要传入业务参数
            $bizcontent = "{\"body\":\"{$body}\","      //支付商品描述
                . "\"subject\":\"{$subject}\","        //支付商品的标题
                . "\"out_trade_no\":\"{$orderId}\","   //商户网站唯一订单号
                . "\"timeout_express\":\"{$expire}m\","       //该笔订单允许的最晚付款时间，逾期将关闭交易
                . "\"total_amount\":\"{$pre_price}\"," //订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]
                . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                . "}";
            $request->setNotifyUrl($this->callback);
            $request->setBizContent($bizcontent);
            //这里和普通的接口调用不同，使用的是sdkExecute
            $response = $aop->sdkExecute($request);
            //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
            return htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
        }catch (\Exception $e){
            return false;
        }

    }
}
