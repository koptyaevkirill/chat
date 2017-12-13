<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Profile form
 * 
 */
class ProfileForm extends Model
{
    /** @var string */
    public $email;

    /** @var string */
    public $username;

    /** @var string */
    public $new_password;

    /** @var string */
    public $current_password;
    
    /** @var User */
    private $_user;

    /** @return User */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = Yii::$app->user->identity;
        }

        return $this->_user;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            'newPasswordLength' => ['new_password', 'string', 'max' => 72, 'min' => 6],
            'currentPasswordRequired' => ['current_password', 'required'],
            'currentPasswordValidate' => ['current_password', 'currentPassword'],
        ];
    }
    
    /** @inheritdoc */
    public function __construct(User $user, $config = [])
    {
        $this->setAttributes([
            'username' => $user->username,
            'email' => $user->email,
        ], false);
        parent::__construct($config);
    }
    
    /**
     * @param string $attribute
     * @param array $params
     */
    public function currentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, Yii::t('app', 'ERROR_WRONG_CURRENT_PASSWORD'));
            }
        }
    }
    
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email'            => Yii::t('app', 'Email'),
            'username'         => Yii::t('app', 'Username'),
            'new_password'     => Yii::t('app', 'New password'),
            'current_password' => Yii::t('app', 'Current password'),
        ];
    }
    
    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save()
    {
        /* @var $user User */
        $user = User::findIdentity($this->getUser()->id);
        if (!$user) {
            return false;
        }
        if ($this->validate()) {
            $user->username = $this->username;
            if($this->new_password) {
                $user->setPassword($this->new_password);
            }
            return $user->save();
        }
        return false;
    }
}
