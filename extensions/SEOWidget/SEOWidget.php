<?php

namespace app\modules\SEO\extensions\SEOWidget;

class SEOWidget extends \yii\base\Widget{
    
    public $route = null;
    public $model = null;
    public $activeForm = null;
    public $formOptions = [];
    
    public function run() {
        return isset($this->model) ? $this->forModel() : $this->forRoute();
    }
    
    private function forModel(){
        $res = $this->activeForm->field($this->model, 'seoUrl')->textInput(['maxlength' => 255])
                .$this->activeForm->field($this->model, 'seoTitle')->textInput(['maxlength' => 255])
                .$this->activeForm->field($this->model, 'seoKeywords')->textInput(['maxlength' => 255])
                .$this->activeForm->field($this->model, 'seoDescription')->textInput(['maxlength' => 255]);
        return $res;
                
    }
    private function forRoute(){
        ob_start();
        
        ?><div class="seoFormWrapper"><a href="#" onclick="$(this).parent().toggleClass('oppened'); return false" class="btn btn-primary">SEO панель</a><?php
        
        $form = \yii\widgets\ActiveForm::begin(array_merge($this->formOptions, ['action'=>\yii\helpers\Url::toRoute('/SEO/admin/update')]));
        $model = \app\modules\SEO\models\SEO::find()->andWhere(['route'=>$this->route, 'itemId'=>0])->one();
        if(!$model){$model = new \app\modules\SEO\models\SEO();}
        
        echo \yii\helpers\Html::hiddenInput('SEO[route]', $this->route);
        echo $form->field($model, 'url')->textInput();
        echo $form->field($model, 'title')->textInput();
        echo $form->field($model, 'keywords')->textInput();
        echo $form->field($model, 'description')->textInput();
        
        ?>
        <div class="form-group">
            <?= \yii\helpers\Html::submitButton(\Yii::t('app', 'Update SEO'), ['class' => 'btn btn-primary']) ?>
        </div>    
        <?php
        \yii\widgets\ActiveForm::end();
        
        ?></div><?php
        
        return ob_get_clean();
    }
}
