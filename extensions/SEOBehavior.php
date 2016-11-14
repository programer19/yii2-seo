<?php

namespace app\modules\SEO\extensions;

class SEOBehavior extends \yii\base\Behavior{
    
    public $seoTitle = '';
    public $seoKeywords = '';
    public $seoDescription = '';
    public $seoUrl = '';
    
    public $route;
    
    public function events() {
        return [
            \yii\db\ActiveRecord::EVENT_AFTER_INSERT => 'saveSEO',
            \yii\db\ActiveRecord::EVENT_AFTER_UPDATE => 'saveSEO',
            
            \yii\db\ActiveRecord::EVENT_AFTER_FIND => 'loadSEO',
        ];
    }
    public function saveSEO($event){
        
        $class = \app\modules\SEO\models\SEO::class;
        $item = $class::find()->andWhere(['route'=>$this->route, 'itemId'=>$this->owner->id])->one();
        if(!$item){$item = new $class;}
        
        $item->setAttributes([
            'route'=>$this->route,
            'itemId'=>$this->owner->id,
            'title'=>$this->seoTitle,
            'url'=>$this->seoUrl,
            'keywords'=>$this->seoKeywords,
            'description'=>$this->seoDescription,
        ]);
        
        if(!$item->save()){
            foreach($item->getErrors() as $attr=>$error){
                $this->owner->setError('seo'.ucfirst($attr), $error[0]);
            }
            return false;
        }
        return true;
    }
    
    public function loadSEO($event){
        $class = \app\modules\SEO\models\SEO::class;
        $item = $class::find()
                ->andWhere(['route'=>$this->route, 'itemId'=>$this->owner->id])
                ->andWhere(['or', ['<>', 'url', ''], ['=', 'route', SEORule::homeRoute]])
                ->one();
        if($item){
            $this->seoUrl = $item->url;
            $this->seoTitle = $item->title;
            $this->seoKeywords = $item->keywords;
            $this->seoDescription = $item->description;
        }
        return true;
    }
    
    public function attach($owner) {
        $owner->validators[] = \yii\validators\Validator::createValidator(
                \yii\validators\StringValidator::class, 
                $owner,
                ['seoUrl', 'seoTitle', 'seoKeywords', 'seoDescription'], []
        );
        return parent::attach($owner);
    }
}