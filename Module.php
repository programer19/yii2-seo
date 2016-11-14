<?php

namespace app\modules\SEO;

/**
 * Description of Module
 *
 * @author programer19
 */
class Module extends \yii\base\Module{
    public $alias = '@SEO';
    public $models = [
        'SEO' => __NAMESPACE__.'\\models\\SEO', 
    ];
    
    public function init(){
        parent::init();
        $this->setAliases([
            $this->alias => dirname(__FILE__)
        ]);
    }

    public function model($name){
        return \Yii::createObject($this->models[$name]);
    }
}
