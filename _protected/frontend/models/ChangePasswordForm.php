<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/21/2015
 * Time: 10:38 AM
 */

namespace frontend\models;


use common\models\User;
use nenad\passwordStrength\StrengthValidator;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

class ChangePasswordForm extends Model
{
    public $password_old;
    public $password;
    public $password_confirm;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates the user object given a token.
     *
     * @param  array  $config Name-value pairs that will be used to initialize the object properties.
     *
     * @throws \yii\base\InvalidParamException  If token is empty or not valid.
     */
    public function __construct($config = [])
    {
        $this->_user = User::findOne(Yii::$app->user->id);

        if (!$this->_user)
        {
            throw new InvalidParamException('Bạn không có quyền vào trang này.');
        }

        parent::__construct($config);
    }

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['password_old', 'password', 'password_confirm'], 'required'],
            // use passwordStrengthRule() method to determine password strength
            $this->passwordStrengthRule(),
            ['password_old', 'passwordOldChecking'],
            ['password_confirm','compare','compareAttribute'=>'password'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute The attribute currently being validated.
     * @param array  $params    The additional name-value pairs.
     */
    public function passwordOldChecking($attribute, $params) {
        $user = $this->_user;
        if(!$user->validatePassword($this->password_old))
        {
            $this->addError($attribute, 'Mật khẩu cũ không đúng.');
        }
    }

    /**
     * Set password rule based on our setting value (Force Strong Password).
     *
     * @return array Password strength rule
     */
    private function passwordStrengthRule()
    {
        // get setting value for 'Force Strong Password'
        $fsp = Yii::$app->params['fsp'];

        // password strength rule is determined by StrengthValidator
        // presets are located in: vendor/nenad/yii2-password-strength/presets.php
        // NOTE: you should use RESET rule because it doesn't require username and email validation
        $strong = [['password'], StrengthValidator::className(),
            'preset'=>'reset', 'userAttribute'=>'password'];

        // use normal yii rule
        $normal = ['password', 'string', 'min' => 6];

        // if 'Force Strong Password' is set to 'true' use $strong rule, else use $normal rule
        return ($fsp) ? $strong : $normal;
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password_old' => 'Mật khẩu cũ',
            'password' => 'Mật khẩu mới',
            'password_confirm' => 'Nhắc lại mật khẩu mới',
        ];
    }

    /**
     * Change password.
     *
     * @return bool Whether the password was reset.
     */
    public function changePassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);

        return $user->save();
    }
}