<?php
/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\components;

use yii\bootstrap4\ActiveForm;

/**
 *
 * @inheritdoc
 *
 * @author shiv
 *        
 */
class TActiveForm extends ActiveForm
{

    public $enableAjaxValidation = true;

    public $enableClientValidation = false;

    public $options = [
        'enctype' => 'multipart/form-data'
    ];

    public $fieldClass = 'app\components\TActiveField';
}
