<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\User;

class UserForm extends Model
{

    public $user;
    public $name;
    public $surname;
    public $password;
    public $email;
    public $user_type;
    public $username;

    public function __construct($user, $conf = [])
    {
        $this->setUser($user);
        parent::__construct($conf);
    }

    public function rules()
    {
        return [
            [['name', 'surname', 'password', 'email', 'username'], 'string'],
            ['user_type', 'safe'],
        ];
    }

    public function setUser($user)
    {
        $this->user = $user;
        $this->email = $user->email;
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->user_type = $user->user_type;
        $this->username = $user->username;
    }
    
    public function save()
    {
        $user = $this->user;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->user_type = $this->user_type;
        $user->email = $this->email;
        $user->username = $this->username;
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save();
    }
}