<?php

/**
 * Company: ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 * Author : Shiv Charan Panjeta < shiv@toxsl.com >
 */

/**
 * This is the model class for table "tbl_email_queue".
 *
 * @property integer $id
 * @property string $from_email
 * @property string $to_email
 * @property string $message
 * @property string $subject
 * @property string $date_published
 * @property string $last_attempt
 * @property string $date_sent
 * @property integer $attempts
 * @property integer $state_id
 * @property integer $email_id
 * @property integer $project_id
 *
 */
namespace app\components;

use app\models\File;
use app\models\User;
use Yii;
use yii\helpers\VarDumper;

class TEmailQueue extends \app\components\TActiveRecord
{

    public $cc_all = null;

    public $bcc_self = false;

    public $mail_sent = 0;

    public function __toString()
    {
        return (string) $this->subject;
    }

    const STATE_PENDING = 0;

    const STATE_SENT = 1;

    const STATE_DELETED = 2;

    const STATE_SEEN = 3;

    public static function getStateOptions()
    {
        return [
            self::STATE_PENDING => "Pending",
            self::STATE_SENT => "Sent",
            self::STATE_DELETED => "Discarded",
            self::STATE_SEEN => "Seen"
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
            self::STATE_PENDING => "primary",
            self::STATE_SENT => "success",
            self::STATE_DELETED => "danger",
            self::STATE_SEEN => "warning"
        ];
        return isset($list[$this->state_id]) ? \yii\helpers\Html::tag('span', $this->getState(), [
            'class' => 'badge badge-' . $list[$this->state_id]
        ]) : 'Not Defined';
    }

    /**
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_queue}}';
    }

    /**
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'message'
                ],
                'string',
                'max' => 65000
            ],
            [
                [
                    'date_published',
                    'last_attempt',
                    'date_sent'
                ],
                'safe'
            ],
            [
                [
                    'state_id'
                ],
                'in',
                'range' => array_keys(TEmailQueue::getStateOptions())
            ],

            [
                [
                    'attempts',
                    'state_id',
                    'email_account_id'
                ],
                'integer'
            ],
            [
                [
                    'from_email',
                    'to_email'
                ],
                'string',
                'max' => 128,
                'min' => 3
            ],

            [
                [
                    'subject'
                ],
                'string',
                'max' => 255
            ],
            /* 				[
             'model_id',
             'unique',
             'targetAttribute' => [
             'model_id',
             'model_type'
             ]
             ], */
            [
                [
                    'from_email',
                    'to_email',
                    'message',
                    'subject'
                ],
                'trim'
            ]
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from_email' => Yii::t('app', 'From Email'),
            'to_email' => Yii::t('app', 'To Email'),
            'message' => Yii::t('app', 'Message'),
            'subject' => Yii::t('app', 'Subject'),
            'date_published' => Yii::t('app', 'Date Published'),
            'last_attempt' => Yii::t('app', 'Last Attempt'),
            'date_sent' => Yii::t('app', 'Date Sent'),
            'attempts' => Yii::t('app', 'Attempts'),
            'state_id' => Yii::t('app', 'State'),
            'email_account_id' => Yii::t('app', 'Email Account')
        ];
    }

    public function getModel()
    {
        if (! empty($this->model_type))
            return $this->model_type::findOne($this->model_id);
        return null;
    }

    public function getToEmails()
    {
        return $this->hasOne(self::class, [
            'to_email' => 'to_email'
        ]);
    }

    public static function getHasManyRelations()
    {
        $relations = [];
        return $relations;
    }

    public static function getHasOneRelations()
    {
        $relations = [];
        return $relations;
    }

    public function asJson($with_relations = false)
    {
        $json = [];
        $json['id'] = $this->id;
        $json['from_email'] = $this->from_email;
        $json['to_email'] = $this->to_email;
        $json['message'] = $this->message;
        $json['subject'] = $this->subject;
        $json['date_published'] = $this->date_published;
        $json['last_attempt'] = $this->last_attempt;
        $json['date_sent'] = $this->date_sent;
        $json['attempts'] = $this->attempts;
        $json['state_id'] = $this->state_id;
        $json['model_id'] = $this->model_id;
        $json['model_type'] = $this->model_type;
        $json['email_account_id'] = $this->email_account_id;
        if ($with_relations) {}
        return $json;
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (! isset($this->date_published))
                $this->date_published = date('Y-m-d h:i:s');
            if (! isset($this->state_id))
                $this->state_id = TEmailQueue::STATE_PENDING;
        }
        return parent::beforeValidate();
    }

    public function getMailer()
    {
        return \Yii::$app->mailer;
    }

    public function sendNow()
    {
        $mail_sent = 0;

        $mailer = $this->getMailer();

        try {

            $to_email = self::cleanEmailAddress($this->to_email);

            if (empty($to_email)) {
                self::log("Email id invalid");
                return 0;
            }

            if (! $this->unsubscribeCheck($to_email)) {
                return 0;
            }

            $mail = $mailer->compose();

            if (isset($this->message_id)) {
                $mail->setHeader('In-Reply-To', $this->message_id);
            }

            $mail->setHtmlBody($this->message . $this->getFooter());
            $mail->setTo($to_email);

            if ($this->bcc_self) {
                $mail->setBcc($this->from_email);
            }
            if ($this->cc_all) {
                $mail->setCc($this->cc_all);
            }
            if ($mailer->transport instanceof \Swift_SmtpTransport) {
                $mail->setFrom([
                    $mailer->transport->getUsername() => $this->from_email
                ]);
            } else {
                $mail->setFrom($this->from_email);
            }

            $mail->setSubject($this->subject);

            $mail->setReplyTo($this->from_email);
            $this->addExtraHeaders($mail);

            if (isset($this->files)) {
                foreach ($this->getFiles()->each() as $file) {
                    $filename = $file->fullPath;
                    if (is_file($filename)) {
                        self::log('Attaching file:' . $filename);
                        $mail->attach($filename);
                    }
                }
            }
            $mail_sent = $mail->send();
            $ids = $mail->getSymfonyEmail()
                ->getPreparedHeaders()
                ->getHeaderBody('Message-ID');
            $this->message_id = $ids[0];
            self::log($this->id . ' Sent:' . $this->message_id);
            $this->date_sent = date('Y-m-d H:i:s');
            $this->state_id = self::STATE_SENT;
            $this->updateAttributes([
                'state_id',
                'date_sent',
                'message_id',
                'message'
            ]);

            $project = $this->getModel();
            if ($project && method_exists($project, 'confirmSent')) {
                $project->confirmSent($this);
            }
        } catch (\Swift_Events_TransportExceptionEvent $e) {
            self::log($e->getMessage());
            self::log($e->getTraceAsString());
        } catch (\Exception $e) {
            self::log($e->getMessage());
            self::log($e->getTraceAsString());
        }
        return $mail_sent;
    }

    /**
     *
     * @param
     *            to_email
     */
    protected function unsubscribeCheck($to_email)
    {
        $class = 'app\modules\mailer\models\Unsubscribe';

        if (class_exists($class)) {
            $unsubscribe = $class::check($to_email);

            if ($unsubscribe) {
                $this->state_id = self::STATE_DELETED;
                self::log($to_email . ' Unsubscribed and so email Discarded');
                if (! $this->updateAttributes([
                    'state_id'
                ])) {
                    var_dump($this->errors);
                }
                return false;
            }
        }
        return true;
    }

    public function addExtraHeaders($mail)
    {
        $unsubscribeUrl = $this->getUrl('unsubscribe');

        $mail->addHeader('List-Unsubscribe', "<mailto:$this->from_email?Subject=Unsubscribe:{$this->id}:{$this->to_email}>,<$unsubscribeUrl>");
    }

    public static function sendEmailToAdmins($data, $trySendNow = (YII_ENV == 'prod'))
    {
        $allAdmins = User::findActive()->andWhere([
            'role_id' => User::ROLE_ADMIN
        ]);
        foreach ($allAdmins->batch() as $admins) {
            foreach ($admins as $admin) {
                $data['to'] = $admin->email;
                self::add($data, $trySendNow);
            }
        }
    }

    public function handleArgs($args = [])
    {
        // TODO:handle extra params if you need
    }

    public static function add($args = [], $trySendNow = true)
    {
        if (defined('MIGRATION_IN_PROGRESS')) {
            return false;
        }

        if (empty($args) || ! is_array($args)) {
            return false;
        }

        $class = get_called_class();
        $mail = new $class();
        $mail->handleArgs($args);

        $mail->from_email = isset($args['from']) ? self::cleanEmailAddress($args['from']) : Yii::$app->params['adminEmail'];
        if (isset($args['model'])) {
            $mail->model_id = $args['model']->id;
            $mail->model_type = get_class($args['model']);
        }
        if (is_object($args['to'])) {
            if ($args['to']->hasAttribute('email')) {
                $mail->to_email = $args['to']->email;
            }
        } else {
            $mail->to_email = $args['to'];
        }
        $to_email = self::cleanEmailAddress($mail->to_email);

        if (! $mail->unsubscribeCheck($to_email)) {
            return false;
        }
        $mail->subject = (isset($args['subject'])) ? $args['subject'] : "EmailQueue";
        $mail->date_sent = date('Y-m-d H:i:s');
        if (isset($args['html'])) {
            $mail->message = $args['html'];
        } else {
            $view = isset($args['view']) ? $args['view'] : '@app/mail/email';
            $args = isset($args['viewArgs']) ? $args['viewArgs'] : [];
            $mail->message = \Yii::$app->mailer->render($view, $args);
        }
        if (isset($args['message_id'])) {
            $mail->message_id = $args['message_id'];
        }

        if (! $mail->save()) {
            return null;
        }

        if (isset($args['attachments'])) {
            $attachments = is_array($args['attachments']) ? $args['attachments'] : [
                $args['attachments']
            ];
            foreach ($attachments as $attachment) {
                if (is_file($attachment)) {
                    File::add($mail, file_get_contents($attachment), basename($attachment));
                }
                if ($attachment instanceof File) {
                    File::add($mail, file_get_contents($attachment->fullPath), $attachment->name);
                }
            }
        }

        if ($trySendNow) {
            $mail->sendNow();
        }

        return $mail;
    }

    public function getFooter()
    {
        $enable_links = false;

        $unsubscribeUrl = $this->getUrl('unsubscribe');
        $imgUrl = $this->getUrl('image');
        $showUrl = $this->getUrl('show');

        $html = '<div class="text-center" align="center">';
        if ($enable_links == true) {
            $unsubscribeUrl = "mailto:{$this->from_email}?Subject=Unsubscribe:{$this->id}:{$this->to_email}";
            $html .= '<p style="font-size: 14px; padding: 0; color: #666"> If you are unable to see this content open in web browser <a href="' . $showUrl . '">Click here</a></p>';
        }
        $html .= '<p style="font-size: 14px; padding: 0; color: #666">';
        $html .= "This email was sent to {$this->to_email}</p>";
        $html .= "<p><a href=\"$unsubscribeUrl\">Unsubscribe</a></p><br>";
        $html .= "<p> <img src=\"$imgUrl\" style='width:1px; height:1px'></p> </div>";

        return $html;
    }

    public static function cleanEmailAddress($value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {

            $pattern = '/[a-z0-9_.\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
            if (preg_match($pattern, $value, $matches))
                $value = ($matches[0]);
        }
        return trim($value);
    }

    public function getControllerID()
    {
        return 'email-queue';
    }

    protected function processFeed($insert, $changedAttributes)
    {}

    public static function clearSent($days = 90)
    {
        $query = self::find()->where([
            'in',
            'state_id',
            [
                self::STATE_SENT,
                self::STATE_DELETED
            ]
        ]);

        if (! empty($days)) {
            $query->andWhere([
                '<',
                'DATE(date_sent)',
                date('Y-m-d', strtotime('-' . $days . ' days'))
            ]);
        }

        self::deleteRelatedAll($query);
    }
}
