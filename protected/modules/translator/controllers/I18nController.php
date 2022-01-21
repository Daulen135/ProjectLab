<?php

/**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 */
namespace app\modules\translator\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\i18n\PhpMessageSource;
use yii\web\NotFoundHttpException;
use app\components\TController;
use yii\base\Exception;
use app\components\filters\AccessRule;
use app\models\User;

class I18nController extends TController
{

    private $aliases;

    /**
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    private function getAliases()
    {
        if ($this->aliases === null) {

            $this->aliases = [];
            foreach (Yii::$app->i18n->translations as $name => $translation) {

                if (is_array($translation)) {
                    $translation = Yii::createObject($translation);
                }
                if (! ($translation instanceof PhpMessageSource) || $name == 'yii') {
                    continue;
                }
                $basePath = Yii::getAlias($translation->basePath);
                $rdi = new \RecursiveDirectoryIterator($basePath, \RecursiveDirectoryIterator::SKIP_DOTS);

                foreach (new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
                    $fileName = $file->getRealpath();
                    if (pathinfo($fileName, PATHINFO_EXTENSION) == 'php') {
                        $alias = $translation->basePath . substr($fileName, strlen($basePath));
                        $this->aliases[$alias] = $fileName;
                    }
                }
            }
        }
        return $this->aliases;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className()
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'update'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isAdmin();
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $aliases = $this->getAliases();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $aliases
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdate($id)
    {
        $aliases = $this->getAliases();
        if (! isset($aliases[$id])) {
            throw new NotFoundHttpException();
        }
        if (! is_writable($aliases[$id])) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'File "{file}" is not writable', [
                'file' => $aliases[$id]
            ]));
        }
        if (Yii::$app->request->isPost && ! is_null(Yii::$app->request->post('messages'))) {

            $messages = Yii::$app->request->post('messages');
            $data = Json::decode($messages);
            $hasErrors = false;
            foreach ((array) $data as $message => $translation) {
                if (! is_string($translation)) {
                    $hasErrors = true;
                    break;
                }
            }
            if (! $hasErrors) {
                try {

                    file_put_contents($aliases[$id], "<?php\n\nreturn " . var_export($data, true) . ";\n");
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Messages has been saved'));
                    // $this->refresh();
                    // Yii::$app->end();
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot save messages'));
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Wrong data'));
            }
        } else {

            try {

                $messages = Json::encode(include $aliases[$id]);
            } catch (Exception $e) {
                $messages = '{}';
                Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot read messages'));
            }
        }
        return $this->render('update', [
            'alias' => $id,
            'file' => $aliases[$id],
            'messages' => $messages
        ]);
    }
}
