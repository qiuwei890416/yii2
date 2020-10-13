<?php
namespace backend\models;
use yii\base\Model;
use Yii;
class Login extends Model{
    public $username;//用户名
    public $password;//密码
    public $verify;//验证码
    public $rember;//是否记住登录状态

    private $user=array();//用户数据
    public function rules()
    {
        return [
            ['username','required','message'=>'用户名不能为空'],
            ['verify','captcha','captchaAction'=>'login/captcha','message'=>'验证码错误'],
            ['password','checkpwd','skipOnEmpty'=>false],
            ['rember','safe']
        ];
    }
    //验证密码
    public function checkpwd($attribute,$params){
        if(empty($this->$attribute)){
            $this->addError($attribute,'密码不能为空');
        }else if(empty($this->getErrors())){
            $map['username']=array('=',$this->username);
            $map['password']=array('=',md5($this->$attribute));
            $db=(new \yii\db\Query());
            $data=$db
            ->from('qw_user')            //表全名
            ->where($map)
            ->one();
            if(!$data){
                $this->addError($attribute,'账号或密码错误');
            }else{
                $this->user=$data;
            }
        }

    }
    //存session
    public static function cunsession($id,$uname){
        $session=\Yii::$app->session;
        $auth=\Yii::$app->authManager;
        $list=$auth->getPermissionsByUser($id);
        $quan=array();
        if(count($list)!=0){
            foreach ($list as $key=>$val){
                $quan[]=$key;
            }
        }
        $session->set('quan',$quan);
        $session->set('uid',$id);
        $session->set('username',$uname);

    }
    //验证cookie是否存在
    public static function yancookie(){
        $cookie= \Yii::$app->request->cookies;
        if($cookie->has('rember')){
            $remcookie=Yii::$app->request->cookies->get('rember');
        }else{
            $remcookie=false;
        }

       if($remcookie){
        list($id,$usname,$time)=explode('#',base64_decode($remcookie));
        if($time>time()){
            self::cunsession($id,$usname);
            return $usname;
        }
       }else{
           return false;
       }

    }
    //验证是否登录成功 成功存Session和cookie
    public function yanzheng(){
        if(!$this->validate()){
            return false;
        }else{
           self::cunsession($this->user['id'],$this->user['username']);
            if($this->rember){
                $time=time()+60*60*24*7;
                $cookie= new \yii\web\Cookie();
                $cookie->name='rember';
                $cookie->expire=$time;
                $cookie->httpOnly=true;
                $cookie->value=base64_encode($this->user['id'].'#'.$this->user['username'].'#'.$time);
                Yii::$app->response->getCookies()->add($cookie);
            }

            return true;
        }

    }

}