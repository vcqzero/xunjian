<?php
/**
* @类简述: 
* 判断token是否在有效期内，如果不在有效期内，则需要重新获取token，并存入文件中
* 以后获取token需要从文件中读取，不能再从本类获取
* 
* @debug:
*/
namespace Api\Service\Server;

use Zend\Cache\Storage\Adapter\Filesystem;
use Api\Tool\MyCurl;

class Weixiner
{
    const CACHE_KEY_WEIXIN_TOKEN = 'weixin-token';
    const CACHE_KEY_WEIXIN_JSAPI_TICKET = 'weixin-jsapi-ticket';
    
    const EXPIRES_IN = 7200;
    
    private $Cache;
    private $appid;
    private $secret;

    public function __construct(
        Filesystem $Cache,
        $weixinConfig
        )
    {
        $this->Cache = $Cache;
        $this->appid = $weixinConfig['appid'];
        $this->secret= $weixinConfig['secret'];
    }
    
    /**
     * fetch the access_token array 
     *
     * @param            
     * @return string $access_token
     */
    public function getAccessToken()
    {
        $Cache = $this->Cache;
        $Cache->getOptions()->setTtl(self::EXPIRES_IN - 20);
        
        $access_token = $Cache->getItem(self::CACHE_KEY_WEIXIN_TOKEN);
        if (empty($access_token))
        {
            //需要重新获取token
            $url = 'https://api.weixin.qq.com/cgi-bin/token';
            
            $data = [
                'appid'     => $this->appid,
                'secret'    => $this->secret,
                'grant_type'=> 'client_credential',
            ];
            
            $res = MyCurl::get($url, $data);
            if (!empty($res['errcode']))
            {
                $errcode = $res['errcode'];
                $errmsg  = $res['errmsg'];
                throw new \Exception("获取微信access_token 发生错误，错误代码为:$errcode, 错误信息：$errmsg");
            }
            $access_token = $res['access_token'];
            $Cache->setItem(self::CACHE_KEY_WEIXIN_TOKEN, $access_token);
        }
        return $access_token;
    }
    
    public function getWxConfig($url)
    {
        $str="abcdrrlljokoptldiektldlyuiopasdfghjklzxcvbnm";
        str_shuffle($str);
        $noncestr       =substr(str_shuffle($str),5,10);
        $jsapi_ticket   =$this->getJsapiTicket();
        $timestamp      =time();
        
        $data=[
            'jsapi_ticket'  =>$jsapi_ticket,
            'noncestr'      =>$noncestr,
            'timestamp'     =>$timestamp,
            'url'           =>$url,
        ];
        $data_string=[];
        foreach ($data as $key=>$val)
        {
            $data_string[]=$key . '=' . $val;
        }
        
        $signature          =sha1(implode('&', $data_string));
        $config = [
            'appId' => $this->appid,
            'timestamp' => $timestamp,
            'nonceStr' => $noncestr,
            'signature' => $signature,
        ];
        return $config;
    }
    
    /**
    * jsapi_ticket是公众号用于调用微信JS接口的临时票据。
    * 正常情况下，jsapi_ticket的有效期为7200秒，
    * 通过access_token来获取。
    * 
    * @param  
    * @return        
    */
    public function getJsapiTicket()
    {
        $Cache = $this->Cache;
        $Cache->getOptions()->setTtl(self::EXPIRES_IN - 20);
        $jsapi_ticket = $Cache->getItem(self::CACHE_KEY_WEIXIN_JSAPI_TICKET);
        //先确保access_token存在
        //防止access_token更新之后jsapi使用时出错
        $has_access_token_cached = $Cache->hasItem(self::CACHE_KEY_WEIXIN_TOKEN);
        if (empty($has_access_token_cached) || empty($jsapi_ticket))
        {
            $access_token = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$access_token&type=jsapi";
            $res = MyCurl::get($url);
            
            if (!empty($res['errcode']))
            {
                $errcode = $res['errcode'];
                $errmsg  = $res['errmsg'];
                throw new \Exception("获取微信jspai_ticket 发生错误，错误代码为:$errcode, 错误信息：$errmsg");
            }
            
            $jsapi_ticket= $res['ticket'];
            $Cache->setItem(self::CACHE_KEY_WEIXIN_JSAPI_TICKET, $jsapi_ticket);
        }
        return $jsapi_ticket;
    }
    
    /**
    * 获取用户openid
    * 静默方式
    * 
    * @param string $code 
    * @return string $openid       
    */
    public function getOpenid($code)
    {
        $appid  = $this->appid;
        $secret = $this->secret;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $res = MyCurl::get($url);
        
        if (!empty($res['errcode']))
        {
            $errcode = $res['errcode'];
            $errmsg  = $res['errmsg'];
            throw new \Exception("获取微信openid 发生错误，错误代码为:$errcode, 错误信息：$errmsg");
        }
        
        $openid= $res['openid'];
        return $openid;
    }
}

