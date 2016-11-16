<?php
namespace frontend\models;

use common\models\User;
use nenad\passwordStrength\StrengthValidator;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Class representing account activation.
 */
class AccountActivationForm extends Model
{
    public $password;
    public $password_confirm;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates the user object given a token.
     *
     * @param  string $token  Account activation token.
     * @param  array  $config Name-value pairs that will be used to initialize the object properties.
     *                        
     * @throws \yii\base\InvalidParamException  If token is empty or not valid.
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) 
        {
            throw new InvalidParamException('Token không được để trống.');
        }

        $this->_user = User::findByAccountActivationToken($token);

        if (!$this->_user) 
        {
            throw new InvalidParamException('Không tìm thấy token này.');
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
            [['password', 'password_confirm'], 'required'],
            ['password_confirm','compare','compareAttribute'=>'password'],
            // use passwordStrengthRule() method to determine password strength
            $this->passwordStrengthRule(),
        ];
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
            'password' => 'Mật khẩu',
            'password_confirm' => 'Nhắc lại mật khẩu',
        ];
    }

    /**
     * Activates account.
     *
     * @return User|null|static
     */
    public function activateAccount()
    {
        $user = $this->_user;

        $user->setPassword($this->password);
        $user->status = User::STATUS_ACTIVE;
        $user->removeAccountActivationToken();

        if($user->save()) {
            return $user;
        }
        return null;
    }

    /**
     * Returns the username of the user who has activated account.
     *
     * @return string
     */
    public function getUsername()
    {
        $user = $this->_user;

        return $user->username;
    }
}
