<?php

namespace app\modules\SEO\controllers;

/**
 * Description of AdminController
 *
 * @author programer19
 */
class AdminController extends \yii\base\Controller{

    public function actionUpdate(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = \Yii::$app->request->post();
        
        $class = \app\modules\SEO\models\SEO::class;
        $item = $class::find()->andWhere(['route'=>$post['SEO']['route']])->andWhere(['itemId'=>0])->one();
        if(!$item){$item=new $class();}
        
        $item->setAttributes([
            'route'=>$post['SEO']['route'],
            'itemId'=>0,
            'title'=>$post['SEO']['title'],
            'url'=>$post['SEO']['url'],
            'keywords'=>$post['SEO']['keywords'],
            'description'=>$post['SEO']['description'],
        ]);
        
        if($item->save()){
            return ['status'=>'OK'];
        }
        return ['status'=>'FAIL', 'errors'=>$item->getErrors()];
    }
}
