<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\models;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */

class ContactForm extends Model {
	public $full_name;
	public $first_name;
	public $last_name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;
	public $contact_no;
	public $to;
	
	/**
	 *
	 * @return array the validation rules.
	 */
	public function rules() {
		return [ 
				// name, email, subject and body are required
				[ 
						[ 
								'first_name',
						        'last_name',
								'email',
								//'subject',
								'body' 
						],
						'required' 
				],
		    
		    [
		        [
		            'contact_no',
		            'to'
		        ],
		        'safe'
		    ],
				// email has to be a valid email address
				[ 
						'email',
						'email' 
				] 
		];
	}
	
	/**
	 *
	 * @return array customized attribute labels
	 */
	public function attributeLabels() {
		return [ 
				'verifyCode' => 'Verification Code',
				'body' => \yii::t ( 'app', 'Message' ) 
		];
	}
	
	/**
	 * Sends an email to the specified email address using the information collected by this model.
	 *
	 * @param string $email
	 *        	the target email address
	 * @return boolean whether the model passes validation
	 */
	public function contact($email) {
		if ($this->validate ()) {
			EmailQueue::add ( [ 
			        'from' => yii::$app->params['adminEmail'],
			        'contact' => $this->contact_no,
					'to' => $email,
					'subject' => $this->subject,
					'html' => $this->body 
			] );
			return true;
		}
		return false;
	}
	public function isAllowed()
	{
	    if (User::isAdmin())
	        return true;
	        if ($this instanceof User) {
	            return ($this->id == Yii::$app->user->id);
	        }
	        if ($this instanceof self) {
	            if ($this->created_by_id == Yii::$app->user->id)
	                return ($this->created_by_id == Yii::$app->user->id);
	        }
	        return false;
	}
}
