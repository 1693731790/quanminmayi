<?php
return [
    'adminEmail' => 'admin@example.com',
    'imgurl' => '',//http://adminmall.chelunzhan.top
    'webLink' => 'https://shop.qmmayi.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    // token 有效期默认1000天
    'user.accessTokenExpire' => 1000*24*3600,
	'WECHAT'=>require(__DIR__.'/weixin.php'),
    'alipay'=>require(__DIR__.'/alipay.php'),
    'duanxin'=>require(__DIR__.'/duanxin.php'),
    'yunpian'=>require(__DIR__.'/yunpian.php'),
    'setting'=>require(__DIR__.'/site.php'),
  
    //话费金额记录
    'user_callfee_log'=>[
         1=>'充值',
         2=>'支出',
         3=>'退货返还',
         4=>'打电话',
      	 5=>"签到",
    ],
  
  	//充值金额记录
    'user_card_log'=>[
         1=>'充值',
         2=>'支出',
         3=>'退货返还',
      
        
        
    ],
  	//商品来源
    'goods_source'=>[
        //-1=>"已删除",
        "jindong"=>'云中鹤-京东',
        "wangyi"=>'云中鹤-网易严选',
        "system"=>'云中鹤-系统',
        "provider"=>'云中鹤-供应商',
        "qmmy"=>'全民蚂蚁',
        
        
    ],
  	//商品来源
    'wait_wallet_type'=>[
         1=>'下级用户购买商品',
        
        
    ],
    //商品状态
    'goods_status'=>[
        //-1=>"已删除",
        -2=>'审核拒绝',
        0=>'待审核',
        200=>'审核通过',
        
    ],
    //店铺状态
    'shops_status'=>[
        //-1=>"已删除",
        -1=>'审核拒绝',
        0=>'待审核',
        200=>'审核通过',
        
    ],
   //电话卡订单状态
    'mobile_card_order_status'=>[
        //-1=>"已删除",
        0=>'待处理',
        1=>'同意',
        -1=>'拒绝'
        
    ],
  //电话卡订单分类
    'mobile_card_order_type'=>[
        //-1=>"已删除",
        1=>'合伙人',
        2=>'代理商',
        
    ],
  	
	 // 免费拿订单状态
    'order_free_take_status'=>[
        //-1=>"已关闭",
        0=>'进行中',
        1=>'待发货',//商品订单
        2=>'已发货',//商品订单
        3=>'已完成',
        
    ],

    // 订单状态
    'order_status'=>[
        -1=>"已取消",
        0=>'待付款',
        1=>'已付款',//商品订单
        2=>'已发货',//商品订单
        3=>'已完成',
        4=>"退款中",
        5=>"已退款",
        6=>"退款拒绝",
        7=>"已兑换",
    ],
	
    // 支付方式
    'pay_method'=>[
        0=>'未支付',
        1=>'支付宝',
        2=>'微信h5支付',
        3=>'微信公众号支付',
        4=>'微信app支付',
        5=>'微信小程序',
        6=>'充值余额',
       
    ],

    //钱包记录类型
    'wallet_type'=>[
      	-1=>'消费',
        1=>'卖出商品',
        2=>'用户升级购买大礼包',
      	3=>'订单分成'
    ],
    
    
    // 提现申请状态
    'withdraw_cash_status'=>[
        -1=>'审核拒绝',
        0=>'待审核',
        10=>'已打款',
    ],

    
    // 提现事件
    'withdraw_cash_event'=>[
        -1=>'拒绝提现',
        1=>'审核通过',
        2=>'打款未成功',
        10=>'已打款',
        100=>'添加备注',
    ],
   

    

    // 实名认证审核状态
    'check_status'=>[
        0=>'未认证',
        1=>'审核中',
        -1=>'审核拒绝',
        10=>'已认证',
    ],

    
    

    


    // 管理员操作事件
    'admin_event'=>[
        1=>'使用账号密码登录',
    ],
   
    //订单类型
    'order_type'=>[
        1=>'商品订单',
        //2=>'充值',
        // 3=>'预约订单',
        4=>'积分兑换',
        5=>'零担',
        7=>'整车',
        9=>'绿色通道',

    ],
	
    
   
    

   

    


];
