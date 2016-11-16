<?php
namespace frontend\controllers;

use common\models\Arrangement;
use common\models\Content;
use common\models\ContentSearch;
use common\models\Product;
use common\models\User;
use common\models\LoginForm;
use frontend\models\AccountActivationForm;
use frontend\models\ChangePasswordForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, password reset.
 */
class SiteController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['signup', 'logout', 'change-password'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['logout', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Declares external actions for the controller.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

//------------------------------------------------------------------------------------------------//
// STATIC PAGES
//------------------------------------------------------------------------------------------------//

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionIndex()
    {
        $featured = Product::find()->innerJoin('tbl_arrangement', 'tbl_product.id = tbl_arrangement.content_id')
            ->where(["tbl_product.activated" => 1, "tbl_product.deleted" => 0, "tbl_arrangement.deleted" => 0, "content_type" => Arrangement::TYPE_PRODUCT])
            ->orderBy('sorting')->all();

        $searchModel = new ContentSearch();
        $params = Yii::$app->request->queryParams;
        $params['ContentSearch'] = [
            'content_type' => Content::TYPE_SLIDER,
            'show_in_menu' => 1
        ];
        $dataProvider = $searchModel->search($params);

        $queryHp = Product::getProductByChildCategory(262);
        $queryDell = Product::getProductByChildCategory(261);

        return $this->render('index', [
            'featured' => $featured,
            'dataProvider' => $dataProvider,
            'hpList' => $queryHp->orderBy('price DESC')->all(),
            'dellList' => $queryDell->orderBy('price DESC')->all()
        ]);
    }

    /**
     * @param string $term
     * @return string
     */
    public function actionSearch($term = '')
    {
        $pageSize = 12;

        $query = Product::find();
        $query->where([
            'tbl_product.activated' => 1,
            'tbl_product.deleted' => 0,
            'status' => Product::isShowing()
        ]);

        if(!empty($term)) {
            //$query->andWhere(["OR", "name LIKE '%$term%'", "description LIKE '%$term%'", "general LIKE '%$term%'", "info_tech LIKE '%$term%'"]);
            $query->andWhere('MATCH (name) AGAINST (:name IN BOOLEAN MODE) OR name LIKE :name2', [':name' => $term, ':name2' => '%'.$term.'%']);
        }

        $orderBy = Yii::$app->getRequest()->getQueryParam('orderby');
        switch($orderBy) {
            case 'gt':{
                $query->orderBy('tbl_product.price ASC');
                break;
            }
            case 'az':{
                $query->orderBy('tbl_product.name ASC');
                break;
            }
            case 'za':{
                $query->orderBy('tbl_product.name DESC');
                break;
            }
            case 'gg':
            default: {
                $query->orderBy('tbl_product.price DESC');
                break;
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays the about static page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays the contact static page and sends the contact email.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->contact(Yii::$app->params['adminEmail'])) 
            {
                Yii::$app->session->setFlash('success', 
                    'Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ gởi phản hồi đến bạn sớm nhất có thể.');
            } 
            else 
            {
                Yii::$app->session->setFlash('error', 'Lỗi xảy ra khi gởi email.');
            }

            return $this->refresh();
        } 
        else 
        {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

//------------------------------------------------------------------------------------------------//
// LOG IN / LOG OUT / PASSWORD RESET
//------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['lwe'];

        // if 'lwe' value is 'true' we instantiate LoginForm in 'lwe' scenario
        $model = $lwe ? new LoginForm(['scenario' => 'lwe']) : new LoginForm();

        // now we can try to log in the user
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {
            return $this->goBack();
        }
        // user couldn't be logged in, because he has not activated his account
        elseif($model->notActivated())
        {
            // if his account is not activated, he will have to activate it first
            Yii::$app->session->setFlash('error', 
                'Bạn phải kích hoạt tài khoản trước khi đăng nhập. Vui lòng kiểm tra email của bạn.');

            return $this->refresh();
        }    
        // account is activated, but some other errors have happened
        else
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->sendEmail()) 
            {
                Yii::$app->getSession()->setFlash('success', 
                    'Vui lòng kiểm tra email của bạn để lấy lại mật khẩu.');

                return $this->goHome();
            } 
            else 
            {
                Yii::$app->getSession()->setFlash('error', 
                    'Xin lổi, chúng thôi không thể đặt lại mật khẩu với email của bạn.');
            }
        }
        else
        {
            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try 
        {
            $model = new ResetPasswordForm($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) 
            && $model->validate() && $model->resetPassword()) 
        {
            Yii::$app->getSession()->setFlash('success', 'Mật khẩu mới đã được cập nhật.');

            return $this->goHome();
        }
        else
        {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }       
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'Thay đổi mật khẩu thành công.');
            return $this->redirect(Url::toRoute(['site/index']));
        }
        else {
            return $this->render('changePassword', [
                'model' => $model
            ]);
        }
    }

//------------------------------------------------------------------------------------------------//
// SIGN UP / ACCOUNT ACTIVATION
//------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email
     * ( with link containing account activation token ). If activation is not
     * necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary,
     * @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        // get setting value for 'Registration Needs Activation'
        $rna = Yii::$app->params['rna'];

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = $rna ? new SignupForm(['scenario' => 'rna']) : new SignupForm();

        // collect and validate user data
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            // try to save user data in database
            if ($user = $model->signup())
            {
                // if user is active he will be logged in automatically ( this will be first user )
                if ($user->status === User::STATUS_ACTIVE)
                {
                    if (Yii::$app->getUser()->login($user))
                    {
                        return $this->goHome();
                    }
                }
                // activation is needed, use signupWithActivation()
                else
                {
                    $this->signupWithActivation($model, $user);

                    return $this->refresh();
                }
            }
            // user could not be saved in database
            else
            {
                // display error message to user
                Yii::$app->session->setFlash('error',
                    "Chúng tôi không thể tạo tài khoản cho bạn, vui lòng liên hệ trực tiếp với chúng tôi.");

                // log this error, so we can debug possible problem easier.
                Yii::error('Tạo tài khoản lỗi! Có lỗi xảy ra khi tạo tài khoản cho ' . Html::encode($user->username) . '.');

                return $this->refresh();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Sign up user with activation.
     * User will have to activate his account using activation link that we will
     * send him via email.
     *
     * @param \frontend\models\SignupForm $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // try to send account activation email
        if ($model->sendAccountActivationEmail($user)) 
        {
            Yii::$app->session->setFlash('success', 
                'Chào '.Html::encode($user->username).'.
                Để đăng nhập bạn cần phải kích hoạt tài khoản. Vui lòng kiểm tra email của bạn để kích hoạt.');
        }
        // email could not be sent
        else 
        {
            // display error message to user
            Yii::$app->session->setFlash('error', 
                "Chúng tôi không thể gởi email để kích hoạt tài khoản, vui lòng liên hệ với chúng tôi.");

            // log this error, so we can debug possible problem easier.
            Yii::error('Tạo tài khoản lỗi!
                Chúng tôi không thể gởi thông tin tài khoản ' . Html::encode($user->username) . ' đến email của bạn.');
        }
    }

/*--------------------*
 * ACCOUNT ACTIVATION *
 *--------------------*/

    /**
     * Activates the user account so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateAccount($token)
    {
        try 
        {
            $model = new AccountActivationForm($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate()) {
                // activate account
                $user = $model->activateAccount();
                if ($user) {
                    Yii::$app->getSession()->setFlash('success',
                        'Kích hoạt thành công! Tài khoản ' . Html::encode($model->getUsername()) . ' của bạn có  thể đăng nhập.');

                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                }
                return $this->redirect(Url::toRoute(['site/login']));
            }
            else {
                Yii::$app->getSession()->setFlash('error',
                    'Tài khoản ' . Html::encode($model->getUsername()) . ' của bạn không thể kích hoạt, hãy liên hệ lại với chúng tôi!');
            }
        }
        else
        {
            return $this->render('accountActivation', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $nickname
     * @return string
     */
    public function actionYahooStatus($nickname)
    {
        $nickname = trim($nickname);
        $status = file_get_contents('http://mail.opi.yahoo.com/online?u=' . $nickname . '&m=a&t=1');
        if(intval($status) === 1) {
            $name = 'yahoo-online.png';
        }
        else {
            $name = 'yahoo-offline.png';
        }
        $filename = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $name;
        if(file_exists($filename)) {
            return Yii::$app->response->sendFile($filename, $name);
        }
    }

    /**
     * @param $nickname
     * @return string
     */
    public function actionSkypeStatus($nickname)
    {
        $name = 'skype.png';
        $filename = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $name;
        if(file_exists($filename)) {
            return Yii::$app->response->sendFile($filename, $name);
        }
    }

}
