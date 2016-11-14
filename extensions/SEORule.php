<?php

namespace app\modules\SEO\extensions;

use yii\web\UrlRuleInterface;
use yii\base\Object;

class SEORule extends Object implements UrlRuleInterface
{
    
    const homeRoute = "pages/default/home";

    public function createUrl($manager, $route, $params)
    {
        $item = \app\modules\SEO\models\SEO::find()
                ->andWhere(['route'=>$route])
                ->andWhere(['itemId'=>isset($params['id']) ? $params['id'] : 0])
                ->andWhere(['or', ['<>', 'url', ''], ['=', 'route', self::homeRoute]])
                ->one();
        
        if ($item) {
            $p = $params;
            unset($p['id']);
            return $item->url.(!empty($p) ? "?".http_build_query($p) : '');
        }
        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $item = \app\modules\SEO\models\SEO::find()
                ->andWhere(['url'=>$pathInfo])
                ->andWhere(['or', ['<>', 'url', ''], ['=', 'route', self::homeRoute]])
                ->one();
        if ($item) {
            $params = ['id'=>$item->itemId];
            
            \Yii::$app->view->title = $item->title;
            \Yii::$app->view->registerMetaTag(['keywords'=>$item->keywords]);
            \Yii::$app->view->registerMetaTag(['description'=>$item->description]);
            
            return [$item->route, $params];
        }
        return false;  // this rule does not apply
    }
}