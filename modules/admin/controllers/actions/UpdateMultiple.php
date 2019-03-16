<?php 
namespace app\modules\admin\controllers\actions;

use Yii;
use yii\web\NotFoundHttpException;

class UpdateMultiple extends \yii\base\Action
{
    use MultipleTraite;
    
    public $model;
    public $models;
    public $owner;
    public $view = 'updateMultiple';
    public $partial = false;
    public $redirect = ['index'];
    
    public function run()
    {
        $id = Yii::$app->request->getQueryParam('id');
        $model = $this->model;
        
        if (!$model = $model::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена.'));
        }
        $modelsClass = $this->models;
        $models = $modelsClass::find()->where([$this->owner => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save() && $this->multipleUpdate($model, $modelsClass, $models, $this->owner)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
                return $this->controller->redirect($this->redirect);
            }
        }
        $data = [
            'model' => $model,
            'models' => (empty($models)) ? [new $modelsClass] : $models
        ];
        return $this->partial ? $this->controller->renderPartial($this->view, $data) : $this->controller->render($this->view, $data);
    }
} 
?>