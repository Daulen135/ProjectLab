


<?php
use app\modules\pms\models\Rename;
$capex = Rename::find()->where([
    'type_id' => Rename::TYPE_CAPEX
])
    ->select('title')
    ->one();
$task = Rename::find()->where([
    'type_id' => Rename::TYPE_TASK
])
    ->select('title')
    ->one();

$capextask = Rename::find()->where([
    'type_id' => Rename::TYPE_CAPEX_PER_TASK
])
    ->select('title')
    ->one();
$calculation = Rename::find()->where([
    'type_id' => Rename::TYPE_CALCULATION
])
    ->select('title')
    ->one();
$total = Rename::find()->where([
    'type_id' => Rename::TYPE_TOTAL
])
    ->select('title')
    ->one();
$description = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_DESCRIPTION
])
    ->select('title')
    ->one();
$exp = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_EXPENSE
])
    ->select('title')
    ->one();
$general = Rename::find()->Where([
    'type_id' => Rename::TYPE_GENERAL_EXPENSE
])
    ->select('title')
    ->one();
$payroll = Rename::find()->Where([
    'type_id' => Rename::TYPE_PAYROLL
])
    ->select('title')
    ->one();
$other = Rename::find()->Where([
    'type_id' => Rename::TYPE_OTHERS
])
    ->select('title')
    ->one();
$totalproject = Rename::find()->Where([
    'type_id' => Rename::TYPE_TOTAL_PROJECT
])
    ->select('title')
    ->one();

$projectbudget = Rename::find()->Where([
    'type_id' => Rename::TYPE_PROJECT_BUDGET
])
    ->select('title')
    ->one();
$capexproject = Rename::find()->Where([
    'type_id' => Rename::TYPE_CAPEX_PROJECT
])
    ->select('title')
    ->one();

?>


