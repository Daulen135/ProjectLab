<?php

/**
 *
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author     : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 */
namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\components\ldap\LdapUserTrait;
use yii\helpers\Url;
use app\modules\pms\models\Deliverable;
use app\modules\pms\models\Milestone;
use app\modules\pms\models\Project;
use app\modules\pms\models\OpexBudget;
use app\modules\subscription\models\Billing;
use app\modules\subscription\models\Plan;
use app\components\helpers\TEmailTemplateHelper;

/**
 * This is the model class for table "tbl_user".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string $date_of_birth
 * @property integer $gender
 * @property string $about_me
 * @property string $contact_no
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $city
 * @property string $country
 * @property string $zipcode
 * @property string $language
 * @property string $profile_file
 * @property integer $tos
 * @property integer $role_id
 * @property integer $state_id
 * @property integer $type_id
 * @property string $last_visit_time
 * @property string $last_action_time
 * @property string $last_password_change
 * @property integer $login_error_count
 * @property string $activation_key
 * @property string $timezone
 * @property string $created_on
 * @property integer $created_by_id === Related data ===
 * @property LoginHistory[] $loginHistories
 * @property Page[] $pages
 * @property Company[] $companies
 */
class User extends \app\components\TActiveRecord implements \yii\web\IdentityInterface
{
    use LdapUserTrait;

    public $search;

    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;

    const STATE_BANNED = 2;

    const STATE_DELETED = 3;

    const MALE = 0;

    const FEMALE = 1;

    const ROLE_ADMIN = 0;

    const ROLE_MANAGER = 1;

    const ROLE_USER = 2;

    const ROLE_INTERVIEWER = 3;

    const TYPE_ON = 0;

    const TYPE_OFF = 1;

    const EMAIL_NOT_VERIFIED = 0;

    const EMAIL_VERIFIED = 1;

    public $confirm_password;

    public $newPassword;

    public $oldPassword;

    public function __toString()
    {
        return (string) $this->full_name;
    }

    public static function getActiveList()
    {
        return ArrayHelper::map(User::findActive()->all(), 'id', 'full_name');
    }

    public static function getInterviewers()
    {
        return User::find()->andWhere([
            '<=',
            'role_id',
            self::ROLE_INTERVIEWER
        ])->all();
    }

    public static function getGenderOptions($id = null)
    {
        $list = array(
            self::MALE => "Male",
            self::FEMALE => "Female"
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public static function getRoleOptions($id = null)
    {
        $list = array(

            self::ROLE_MANAGER => "Manager",
            self::ROLE_USER => "User"
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function getRole()
    {
        $list = self::getRoleOptions();
        return isset($list[$this->role_id]) ? $list[$this->role_id] : 'Not Defined';
    }

    public static function getStateOptions()
    {
        return [
            self::STATE_INACTIVE => yii::t('app', "Inactive"),
            self::STATE_ACTIVE => yii::t('app', "Active"),
            self::STATE_BANNED => yii::t('app', "Banned"),
            self::STATE_DELETED => yii::t('app', "Deleted")
        ];
    }

    public static function getUserAction()
    {
        return [
            self::STATE_INACTIVE => "In-activeate",
            self::STATE_ACTIVE => "Activate",
            self::STATE_BANNED => "Ban",
            self::STATE_DELETED => "Delete"
        ];
    }

    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

    public function getStateBadge()
    {
        $list = [
            self::STATE_INACTIVE => "secondary",
            self::STATE_ACTIVE => "success",
            self::STATE_BANNED => "warning",
            self::STATE_DELETED => "danger"
        ];
        return isset($list[$this->state_id]) ? \yii\helpers\Html::tag('span', $this->getState(), [
            'class' => 'badge badge-' . $list[$this->state_id]
        ]) : 'Not Defined';
    }

    public static function getTypeOptions()
    {
        return self::getRoleOptions();
    }

    public function getType()
    {
        return $this->getRole();
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (! isset($this->created_on))
                $this->created_on = date('Y-m-d H:i:s');
            if (! isset($this->created_by_id))
                $this->created_by_id = self::getCurrentUser();
        } else {}
        return parent::beforeValidate();
    }

    /**
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'date_of_birth' => Yii::t('app', 'Date Of Birth'),
            'gender' => Yii::t('app', 'Gender'),
            'about_me' => Yii::t('app', 'About Me'),
            'contact_no' => Yii::t('app', 'Contact No'),
            'address' => Yii::t('app', 'Address'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'city' => Yii::t('app', 'City'),
            'country' => Yii::t('app', 'Country'),
            'zipcode' => Yii::t('app', 'Zipcode'),
            'language' => Yii::t('app', 'Language'),
            'profile_file' => Yii::t('app', 'Profile File'),
            'tos' => Yii::t('app', 'Tos'),
            'role_id' => Yii::t('app', 'Role'),
            'state_id' => Yii::t('app', 'State'),
            'type_id' => Yii::t('app', 'Type'),
            'last_visit_time' => Yii::t('app', 'Last Visit Time'),
            'last_action_time' => Yii::t('app', 'Last Action Time'),
            'last_password_change' => Yii::t('app', 'Last Password Change'),
            'login_error_count' => Yii::t('app', 'Login Error Count'),
            'activation_key' => Yii::t('app', 'Activation Key'),
            'timezone' => Yii::t('app', 'Timezone'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by_id' => Yii::t('app', 'Created By')
        ];
    }

    public static function myProjects()
    {
        $query = User::find()->where([
            'manager_id' => Yii::$app->user->id
        ]);
        return $query;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoginHistories()
    {
        return $this->hasMany(LoginHistory::class, [
            'user_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::class, [
            'created_by_id' => 'id'
        ]);
    }

    public static function getHasManyRelations()
    {
        $relations = [];
        $relations['created_by_id'] = [
            'templates',
            'Template',
            'id'
        ];
        $relations['user_id'] = [
            'loginHistories',
            'LoginHistory',
            'id'
        ];

        return $relations;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), [
            'id' => 'created_by_id'
        ])->cache();
    }

    public function getPlan()
    {
        return $this->hasOne(Billing::className(), [
            'created_by_id' => 'id'
        ])->andOnCondition([
            'state_id' => Billing::STATE_ACTIVE
        ]);
    }

    public static function getHasOneRelations()
    {
        $relations = [];
        $relations['created_by_id'] = [
            'createdBy',
            'User',
            'id'
        ];
        return $relations;
    }

    public function sendRegistrationMailtoAdmin()
    {
        $sub = 'New User Registerd Successfully';
        $from = yii::$app->params['adminEmail'];
        EmailQueue::sendEmailToAdmins([
            'from' => $from,
            'subject' => $sub,
            'view' => 'newUser',
            'viewArgs' => [
                'user' => $this
            ]
        ], true);
    }

    public function beforeDelete()
    {
        if (! parent::beforeDelete()) {
            return false;
        }
        if ($this->id == \Yii::$app->user->id)
            return false;

        if (self::find()->count() <= 1)
            return false;

        LoginHistory::deleteRelatedAll([
            'user_id' => $this->id
        ]);
        Feed::deleteRelatedAll([
            'created_by_id' => $this->id
        ]);
        Deliverable::deleteRelatedAll([
            'created_by_id' => $this->id
        ]);
        Milestone::deleteRelatedAll([
            'created_by_id' => $this->id
        ]);
        Project::deleteRelatedAll([
            'created_by_id' => $this->id
        ]);
        OpexBudget::deleteRelatedAll([
            'created_by_id' => $this->id
        ]);
        Billing::deleteRelatedAll([
            'created_by_id' => $this->id
        ]);
        return true;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['register'] = [
            'full_name',
            'email',
            'confirm_password',
            'password'
        ];

        $scenarios['update'] = [
            'first_name',
            'last_name',
            'email',
            'password',
            'role_id',
            'state_id',
            'contact_no'
        ];

        $scenarios['add'] = [
            'first_name',
            'last_name',
            'email',
            'password',
            'role_id',
            'state_id',
            'contact_no',
            'last_action_time'
        ];

        $scenarios['signup'] = [
            'first_name',
            'last_name',
            'email',
            'password',
            'confirm_password',
            'last_action_time'
        ];
        $scenarios['changepassword'] = [
            'newPassword',
            'confirm_password'
        ];
        $scenarios['resetpassword'] = [
            'password',
            'confirm_password'
        ];

        return $scenarios;
    }

    /**
     *
     * @inheritdoc
     */
    /**
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'first_name',
                    'last_name',
                    'email',
                    'role_id',
                    'state_id',
                    'created_on'
                ],
                'required'
            ],
            [
                'email',
                'unique'
            ],
            [
                [
                    'newPassword',
                    'confirm_password'
                ],
                'required',
                'on' => 'changepassword'
            ],
            [
                'confirm_password',
                'compare',
                'compareAttribute' => 'newPassword',
                'message' => "Passwords don't match",
                'on' => [
                    'changepassword'
                ]
            ],
            [
                'newPassword',
                'app\components\validators\TPasswordValidator'
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                    'confirm_password'
                ],
                'required',
                'on' => 'signup'
            ],
            [
                'confirm_password',
                'compare',
                'compareAttribute' => 'password',
                'message' => "Passwords don't match",
                'on' => [
                    'signup'
                ]
            ],
            [
                'password',
                'compare',
                'compareAttribute' => 'confirm_password',
                'message' => "Passwords don't match",
                'on' => [
                    'resetpassword'
                ]
            ],
            [
                [
                    'password',
                    'confirm_password'
                ],
                'required',
                'on' => 'resetpassword'
            ],
            [
                'password',
                'app\components\validators\TPasswordValidator'
            ],

            [
                [
                    'full_name',
                    'first_name',
                    'last_name'
                ],
                'app\components\validators\TNameValidator'
            ],

            [

                'email',
                'email'
            ],
            [
                [
                    'full_name'
                ],
                'filter',
                'filter' => function ($data) {
                    return ucwords($data);
                }
            ],
            [
                [
                    'search',
                    'date_of_birth',
                    'last_visit_time',
                    'last_action_time',
                    'last_password_change',
                    'created_on',
                    'email_verified',
                    'is_verify'
                ],
                'safe'
            ],
            [
                [
                    'gender',
                    'tos',
                    'role_id',
                    'state_id',
                    'type_id',
                    'login_error_count',
                    'created_by_id',
                    'is_verify'
                ],
                'integer'
            ],
            [
                [
                    'full_name',
                    'email',
                    'about_me',
                    'city',
                    'country',
                    'zipcode',
                    'language',
                    'profile_file',
                    'timezone'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'first_name',
                    'last_name'
                ],
                'string',
                'max' => 256
            ],
            [
                [
                    'full_name',
                    'first_name',
                    'last_name',
                    'email',
                    'about_me',
                    'contact_no',
                    'city',
                    'country',
                    'zipcode',
                    'language',
                    'profile_file',
                    'timezone',
                    'activation_key',
                    'address',
                    'latitude',
                    'longitude'
                ],
                'trim'
            ],
            [
                [
                    'contact_no'
                ],
                'string',
                'min' => 8,
                'max' => 15
            ],
            [
                [
                    'password',
                    'activation_key'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'address',
                    'latitude',
                    'longitude'
                ],
                'string',
                'max' => 512
            ]
        ];
    }

    public function getFullname()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getImageUrl($thumbnail = false)
    {
        $params = [
            '/' . $this->getControllerID() . '/image'
        ];
        $params['id'] = $this->id;

        if (isset($this->profile_file) && ! empty($this->profile_file)) {
            $params['file'] = $this->profile_file;
        }

        if ($thumbnail)
            $params['thumbnail'] = is_numeric($thumbnail) ? $thumbnail : 150;

        return Url::toRoute($params);
    }

    public function asJson($with_relations = false)
    {
        $json = [];
        $json['id'] = $this->id;
        $json['full_name'] = $this->full_name;
        $json['email'] = $this->email;
        $json['date_of_birth'] = $this->date_of_birth;
        $json['gender'] = $this->gender;
        $json['about_me'] = $this->about_me;
        $json['contact_no'] = $this->contact_no;
        $json['language'] = $this->language;
        if (! empty($this->profile_file)) {
            $json['profile_file'] = $this->getImageUrl();
        } else {
            $json['profile_file'] = "";
        }
        $json['tos'] = $this->tos;
        $json['role_id'] = $this->role_id;
        $json['state_id'] = $this->state_id;
        $json['type_id'] = $this->type_id;
        $json['last_visit_time'] = $this->last_visit_time;
        $json['last_action_time'] = $this->last_action_time;
        $json['last_password_change'] = $this->last_password_change;
        $json['login_error_count'] = $this->login_error_count;
        $json['timezone'] = $this->timezone;
        $json['created_on'] = $this->created_on;
        $json['created_by_id'] = $this->created_by_id;
        if ($with_relations) {
            // EmailAccounts
            $list = $this->getEmailAccounts()->all();

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['EmailAccounts'] = $relationData;
            } else {
                $json['EmailAccounts'] = $list;
            }
            // EmailAccountRules
            $list = $this->getEmailAccountRules()->all();

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['EmailAccountRules'] = $relationData;
            } else {
                $json['EmailAccountRules'] = $list;
            }
            // LoginHistories
            $list = $this->getLoginHistories()->all();

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['LoginHistories'] = $relationData;
            } else {
                $json['LoginHistories'] = $list;
            }
            // Pages
            $list = $this->getPages()->all();

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['Pages'] = $relationData;
            } else {
                $json['Pages'] = $list;
            }
            // Rules
            $list = $this->getRules()->all();

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['Rules'] = $relationData;
            } else {
                $json['Rules'] = $list;
            }
            // Templates
            $list = $this->getTemplates()->all();

            if (is_array($list)) {
                $relationData = [];
                foreach ($list as $item) {
                    $relationData[] = $item->asJson();
                }
                $json['Templates'] = $relationData;
            } else {
                $json['Templates'] = $list;
            }
        }
        return $json;
    }

    /**
     *
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'state_id' => self::STATE_ACTIVE
        ]);
    }

    /**
     *
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'activation_key' => $token,
            'state_id' => self::STATE_ACTIVE
        ]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne([
            'email' => $email,
            'state_id' => self::STATE_ACTIVE
        ]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public function getUsername()
    {
        return substr($this->email, 0, strpos($this->email, '@'));
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByUsername($username)
    {
        if (! strstr($username, '@')) {
            $username = $username . '@toxsltech.com';
        }
        return static::findByEmail($username);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token
     *            password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (! static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'activation_key' => $token,
            'state_id' => self::STATE_ACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token
     *            password reset token
     * @return boolean
     */
    public function getResetUrl()
    {
        return Yii::$app->urlManager->createAbsoluteUrl([
            'user/resetpassword',
            'token' => $this->activation_key
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     *
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     *
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->activation_key;
    }

    /**
     *
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $this->hashPassword($password);
    }

    public function hashPassword($password)
    {
        $password = utf8_encode(Yii::$app->security->generatePasswordHash(yii::$app->name . $password));
        return $password;
    }

    /**
     * Validates password
     *
     * @param string $password
     *            password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword(yii::$app->name . $password, utf8_decode($this->password));
    }

    /**
     * convert normal password to hash password before saving it to database
     */

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->activation_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->activation_key = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->activation_key = null;
    }

    public static function isInterviewer()
    {
        $user = Yii::$app->user->identity;
        if ($user == null)
            return false;

        return ($user->isActive() && $user->role_id == User::ROLE_INTERVIEWER || self::isUser());
    }

    public static function isUser()
    {
        $user = Yii::$app->user->identity;
        if ($user == null)
            return false;

        return ($user->isActive() && $user->role_id == User::ROLE_USER);
    }

    public static function isTrialUser()
    {
        $user = Yii::$app->user->identity;
        if ($user == null) {
            return false;
        } else {

            $now = time(); // or your date as well
            $singup_date = strtotime($user->last_action_time);
            $datediff = $now - $singup_date;

            $days = round($datediff / (60 * 60 * 24));
            // if($days<Billing::TRIAL_PERIOD && empty($user->plan)){
            // return true;
            // }

            if (! (User::isAdmin())) {
                $plan = Billing::find()->where([
                    'created_by_id' => Yii::$app->user->id,
                    'state_id' => Plan::STATE_ACTIVE
                ])
                    ->andWhere([
                    '!=',
                    'type_id',
                    Billing::STATE_ACTIVE
                ])
                    ->one();
                if ($days < Billing::TRIAL_PERIOD) {
                    if (empty($plan)) {
                        return true;
                    }
                }
            }
        }
    }

    public static function isFriend()
    {
        $user = Yii::$app->user->identity;
        if ($user == null)
            return false;

        return ($user->isActive() && $user->is_verify == User::STATE_ACTIVE);
    }

    public static function isManager()
    {
        $user = Yii::$app->user->identity;
        if ($user == null)
            return false;

        return ($user->isActive() && $user->role_id == User::ROLE_MANAGER || self::isAdmin());
    }

    public function isSelf()
    {
        if ($this->id == Yii::$app->user->identity->id)
            return true;

        return false;
    }

    public static function isAdmin()
    {
        $user = Yii::$app->user->identity;
        if ($user == null)
            return false;

        return ($user->isActive() && $user->role_id == User::ROLE_ADMIN);
    }

    public static function isGuest()
    {
        if (Yii::$app->user->isGuest) {
            return true;
        }
        return false;
    }

    public function sendProfileImage()
    {
        $user = Yii::$app->user->identity;
        $image_path = UPLOAD_PATH . $user->profile_file;

        if (! isset($user->profile_file) || ! file_exists($image_path))
            throw new NotFoundHttpException(Yii::t('app', "File not found"));

        return Yii::$app->response->sendFile($image_path, $user->profile_file);
    }

    public function isActive()
    {
        return ($this->state_id == User::STATE_ACTIVE);
    }

    public function getFeeds()
    {
        return $this->hasMany(Feed::className(), [
            'created_by_id' => 'id'
        ]);
    }

    public function sendRegistrationMailtoUser()
    {
        $view = 'sendPassword';
        $sub = "Welcome! You new account is ready ";

        EmailQueue::add([
            'to' => $this->email,
            'subject' => $sub,
            'view' => $view,
            'viewArgs' => [
                'user' => $this
            ]
        ], true);
    }

    public function sendVerificationMailtoUser()
    {
        $sub = "Welcome! Your new account is ready for Project Lab";
        $message = TEmailTemplateHelper::renderFile('@app/mail/verification.php', [
            'user' => $this
        ]);
        $from = \Yii::$app->params['adminEmail'];
        EmailQueue::add([
            'from' => $from,
            'to' => $this->email,
            'subject' => $sub,
            'html' => $message
        ], true);
    }

    public function getVerified()
    {
        return Yii::$app->urlManager->createAbsoluteUrl([
            'user/confirm-email',
            'id' => $this->activation_key
        ]);
    }

    public function getLoginUrl()
    {
        return Yii::$app->urlManager->createAbsoluteUrl([
            'user/login'
        ]);
    }

    /*
     * public function getImageUrl($thumbnail = 0)
     * {
     * $params = [
     * 'id' => $this->id,
     * 'file' => $this->profile_file
     * ];
     *
     * if ($thumbnail) {
     * $params['thumbnail'] = $thumbnail;
     * }
     *
     * return $this->getUrl('image',$params);
     * }
     */
    public function isAllowed()
    {
        if (User::isAdmin()) {
            return true;
        }

        return parent::isAllowed();
    }

    public static function addData($data)
    {
        $faker = \Faker\Factory::create();
        if (self::find()->count() != 0)
            return;
        foreach ($data as $item) {
            $model = new self();

            $model->full_name = isset($item['full_name']) ? $item['full_name'] : $faker->name;
            $model->first_name = isset($item['first_name']) ? $item['first_name'] : $faker->name;
            $model->last_name = isset($item['last_name']) ? $item['last_name'] : $faker->name;

            $model->email = isset($item['email']) ? $item['email'] : $faker->email;

            $model->date_of_birth = isset($item['date_of_birth']) ? $item['date_of_birth'] : $faker->date($format = 'Y-m-d', $max = 'now');

            $model->gender = isset($item['gender']) ? $item['gender'] : 0;
            $model->password = isset($item['password']) ? $item['password'] : 'admin';

            $model->about_me = isset($item['about_me']) ? $item['about_me'] : $faker->text(10);

            $model->contact_no = isset($item['contact_no']) ? $item['contact_no'] : $faker->text(10);

            $model->address = isset($item['address']) ? $item['address'] : $faker->text(10);

            $model->latitude = isset($item['latitude']) ? $item['latitude'] : $faker->text(10);

            $model->longitude = isset($item['longitude']) ? $item['longitude'] : $faker->text(10);

            $model->city = isset($item['city']) ? $item['city'] : $faker->text(10);

            $model->country = isset($item['country']) ? $item['country'] : $faker->text(10);

            $model->zipcode = isset($item['zipcode']) ? $item['zipcode'] : $faker->text(10);

            $model->language = isset($item['language']) ? $item['language'] : $faker->text(10);

            $model->profile_file = isset($item['profile_file']) ? $item['profile_file'] : $faker->text(10);

            $model->tos = isset($item['tos']) ? $item['tos'] : 1;

            $model->role_id = isset($item['role_id']) ? $item['role_id'] : 1;
            $model->state_id = self::STATE_ACTIVE;

            $model->type_id = isset($item['type_id']) ? $item['type_id'] : 0;

            $model->last_visit_time = isset($item['last_visit_time']) ? $item['last_visit_time'] : $faker->date($format = 'Y-m-d', $max = 'now');

            $model->last_action_time = isset($item['last_action_time']) ? $item['last_action_time'] : $faker->date($format = 'Y-m-d', $max = 'now');

            $model->last_password_change = isset($item['last_password_change']) ? $item['last_password_change'] : $faker->date($format = 'Y-m-d', $max = 'now');

            $model->login_error_count = isset($item['login_error_count']) ? $item['login_error_count'] : $faker->numberBetween();

            $model->setPassword($model->password);

            $model->save();
        }
    }
}
