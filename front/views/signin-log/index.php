<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = '签到';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/newstatic/css/public.css" />
<link rel="stylesheet" href="/newstatic/css/signin.css" />
<script type="text/javascript" src="/newstatic/js/rili.js"></script>
<link rel="stylesheet" type="text/css" href="css/font/iconfont.css" />
<!--<script type="text/javascript" src="/newstatic/js/jquery1.72.min.js"></script>-->
<?php if(empty($_GET["token"])):?>
<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="hearder-img" src="/webstatic/images/back_jt_w.png"/></div></a>签到
</header> 
<?php endif;?>
      <div class="nxa">
    <div class="top flex flex-align-end flex-pack-center flex-warp"> 
      <div class="out-1 flex flex-align-center flex-pack-center" id="signIn">
        <div class="out-2 flex flex-align-center flex-pack-center">
          <div class="signBtn">
            <strong id="sign-txt"><?=$dayRes!=0?"已签到":"立即签到"?></strong>
             <span>已签<em id="sign-count">0</em>天</span> 


          </div>
        </div>
      </div>
     </div> 
    
     <div class="tips">已获得<em class="money" id="sign-counts"><?=round($countFee)?></em>元</div> 
    <div class="Calendar">
      <div id="toyear" class="flex flex-pack-center">
        <!--<div id="idCalendarPre">&lt;</div>-->
        <div class="year-month">
          <b><span id="idCalendarYear">2019</span>/<span id="idCalendarMonth">3</span>月</b>
        </div>
        <!--<div id="idCalendarNext">&gt;</div>-->
      </div>
      <table border="1px" cellpadding="0" cellspacing="0">
        <thead>
          <tr class="tou">
            <td>日</td>
            <td>一</td>
            <td>二</td>
            <td>三</td>
            <td>四</td>
            <td>五</td>
            <td>六</td>
          </tr>
        </thead>
        <tbody id="idCalendar">
        </tbody>
      </table>
    </div>
    <div class="model" id="model">
    <div class="modelo">
    <img  class="pico" src="/newstatic/images/pib.png">
     <img class="btn" id="btn" src="/newstatic/images/pie.png">
    </div>
    <div class="close" id="close">  <img  class="pict" src="/newstatic/images/pid.png">  </div>
    </div> 
    </div>



     <script>
  $(function (doc, win) {
          var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
              var clientWidth = docEl.clientWidth;
              if (!clientWidth) return;
              docEl.style.fontSize = 20 * (clientWidth / 320) + 'px';
            };


          if (!doc.addEventListener) return;
          win.addEventListener(resizeEvt, recalc, false);
          doc.addEventListener('DOMContentLoaded', recalc, false);
        });
  </script>
    <script language="JavaScript">
  $(function(){
      console.log(<?=$MRes?>);
  })
      
      var isSign ="<?=$dayRes!=0?1:0?>";
      var mydayjson=<?=$MRes?>;
      var myday = new Array(); //已签到的数组

      for(var i=0;i<mydayjson.length;i++)
      {
          myday[i]=mydayjson[i].create_time;

      }
      

      var cale = new Calendar("idCalendar", {
        qdDay: myday,
        onToday: function(o) {
          o.className = "onToday";
        },
       
        onFinish: function() {
          $$("sign-count").innerHTML = myday.length //已签到次数
          
          $$("idCalendarYear").innerHTML = this.Year;
          $$("idCalendarMonth").innerHTML = this.Month; //表头年份

        }
      });
    
      //添加今天签到
      $$("signIn").onclick = function() 
      {
          if(isSign == "0") {
              $.get("<?=Url::to(['signin-log/create'])?>","",function(res){
                  if(res.success)
                  {
                      isSign = "1";
                      var res = cale.SignIn();
                      $$("sign-txt").innerHTML = '已签到';
                      var num=$("#sign-count").text();
                      $("#sign-count").text(parseInt(num)+1);
                      $("#model").show();        
                  }else{
                      layer.msg('签到失败');        
                  }
                  
              },"json")
              
            
          } else {
              layer.msg('今天已经签到了');
           
          }

      }


    
  
$("#btn").click(function(){  
    $("#model").hide();   
});  
$("#close").click(function(){  
  $("#model").hide();   
});  

    </script>



