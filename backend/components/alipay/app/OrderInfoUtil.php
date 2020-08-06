<?php

class OrderInfoUtil
{

    /**
     * 构造授权参数列表
     *
     * @param
     *            pid
     * @param
     *            app_id
     * @param
     *            target_id
     * @return
     *
     */
    public static function buildAuthInfoMap($pid, $app_id, $target_id)
    {
        $keyValues = [];
        // 商户签约拿到的app_id，如：2013081700024223
        $keyValues['app_id'] = $app_id;
        
        // 商户签约拿到的pid，如：2088102123816631
        
        $keyValues['pid'] = $pid;
        
        // 服务接口名称， 固定值
        
        $keyValues['apiname'] = "com.alipay.account.auth";
        
        // 商户类型标识， 固定值
        
        $keyValues['app_name'] = "mc";
        
        // 业务类型， 固定值
        
        $keyValues['biz_type'] = "openservice";
        
        // 产品码， 固定值
        
        $keyValues['product_id'] = "APP_FAST_LOGIN";
        
        // 授权范围， 固定值
        
        $keyValues['scope'] = "kuaijie";
        
        // 商户唯一标识，如：kkkkk091125
        
        $keyValues['target_id'] = $target_id;
        
        // 授权类型， 固定值
        
        $keyValues['auth_type'] = "AUTHACCOUNT";
        
        // 签名类型
        // keyValues.put("sign_type", "RSA");
        $keyValues['sign_type'] = "RSA";
        
        return $keyValues;
    }

    /**
     * 构造支付订单参数列表
     * 
     * @param
     *            pid
     * @param
     *            app_id
     * @param
     *            target_id
     * @return
     *
     */
    public static function buildOrderParamMap($app_id)
    {
        $keyValues = [];
        $keyValues['app_id'] = $app_id;
        
        // keyValues . put("biz_content", "{\"timeout_express\":\"30m\",\"product_code\":\"QUICK_MSECURITY_PAY\",\"total_amount\":\"0.01\",\"subject\":\"1\",\"body\":\"我是测试数据\",\"out_trade_no\":\"" + getOutTradeNo() + "\"}");
        $keyValues['biz_content'] = "{\"timeout_express\":\"30m\",\"product_code\":\"QUICK_MSECURITY_PAY\",\"total_amount\":\"0.01\",\"subject\":\"1\",\"body\":\"我是测试数据\",\"out_trade_no\":\"" + getOutTradeNo() + "\"}";
        
        $keyValues['charset'] = "utf-8";
        $keyValues['method'] = "alipay.trade.app.pay";
        
        $keyValues['sign_type'] = "RSA";
        $keyValues["timestamp"] = date("Y-m-d H:i:s");
        // keyValues . put("timestamp", "2016-07-29 16:55:53");
        $keyValues["version"] = "1.0";
        
        // keyValues . put("version", "1.0");
        
        return keyValues;
    }

    /**
     * 构造支付订单参数信息
     *
     * @param
     *            map
     *            支付订单参数
     * @return
     *
     */
    public static function buildOrderParam($map)
    {
        $m = [];
        foreach ($map as $key => $val) {
            $m = $key . "=" . $val;
        }
        
        return join("&", $m);
    }

    /**
     * 对支付参数信息进行签名
     *
     * @param
     *            map
     *            待签名授权信息
     *            
     * @return
     *
     */
    public static function getSign($map, $rsaKey)
    {
        ksort($map);
        $string = "";
        $m = [];
        foreach ($map as $key => $val) {
            $m = $key . "=" . $val;
        }
        $string = join("&", $m);
        
        $aop = new AopClient();
        $oriSign = $aop->generateSign($map);
        
        /*
         * $oriSign = SignUtils.sign($string, rsaKey);
         * String encodedSign = "";
         *
         * try {
         * encodedSign = URLEncoder.encode(oriSign, "UTF-8");
         * } catch (UnsupportedEncodingException e) {
         * e.printStackTrace();
         * }
         */
        $encodedSign = urlencode($oriSign);
        return "sign=" + $encodedSign;
    }

/**
 * 要求外部订单号必须唯一。
 * 
 * @return
 *
 */
}
