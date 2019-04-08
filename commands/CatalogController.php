<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Catalog;
use app\models\Modifications;
use app\models\Specifications;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use app\models\CatalogLogo;

class CatalogController extends Controller
{
    /**
     * Сбор марок автомобилей
     */
    public function actionBrands()
    {
        if ($data = shell_exec('node commands/beauto_brands.js')) {
            if (!$root = Catalog::findOne(['slug' => 'catalog'])) {
                $root = new Catalog(['name' => 'Каталог', 'slug' => 'catalog']);
                $root->makeRoot();
            }
            $i = 0;
            foreach (json_decode($data, true) as $brend) {
                $model = new Catalog;
                $model->name = $brend['name'];
                $model->slug = $brend['slug'];
                if ($model->appendTo($root)) {
                    $i++;
                }
            }
            $this->stdout($i);
        }
    }
    
    /**
     * Сбор моделей автомобилей
     */
    public function actionModels()
    {
        if ($brands = Catalog::find()->select('slug')->where(['depth' => 1])->column()) {
            foreach ($brands as $brand) {
                if ($data = shell_exec('node commands/beauto_models.js ' . $brand)) {
                    $i = 0;
                    $root = Catalog::findOne(['slug' => $brand]);
                    
                    foreach (json_decode($data, true) as $item) {
                        $model = new Catalog;
                        $model->name = $item['name'];
                        $model->slug = $item['slug'];
                        if ($model->appendTo($root)) {
                            $i++;
                        }
                    }
                    $this->stdout($brand . ': ' . $i . "\n");
                }
            }
        }
    }
    
    /**
     * Сбор поколений автомобилей
     */
    public function actionGenerations()
    {
        if ($brands = Catalog::find()->where(['depth' => 1])/*->andWhere(['slug' => 'volvo'])->andWhere(['>', 'id', 226])*/->all()) {
            $data = [];
            foreach ($brands as $brand) {
                $data[$brand->slug] = ArrayHelper::map($brand->children()->select(['id', 'slug'])/*->andWhere(['depth' => 2])->andWhere(['>', 'id', 2993])*/->all(), 'id', 'slug');
            }
            foreach ($data as $slug => $models) {
                foreach ($models as $id => $one) {
                    if ($data = shell_exec('node commands/beauto_generations.js ' . $slug . '/' . $one)) {
                        $i = 0;
                        $root = Catalog::findOne($id);
                        $years = [];
                        foreach (json_decode($data, true) as $item) {
                            $item['years'] = explode(' – ', $item['years']);
                            foreach ($item['years'] as $key => $year) {
                                $year = intval($year);
                                $year = $year == 0 ? 'н.в.' : $year;
                                $years[] = $year;
                                $item['years'][$key] = (string)$year;
                            }
                            $model = new Catalog;
                            $model->name = !empty($item['name']) ? $item['name'] : ($item['years'][0] . '-' . $item['years'][1]);
                            $model->year_from = $item['years'][0];
                            $model->year_to = $item['years'][1];
                            if ($model->appendTo($root)) {
                                $i++;
                            }
                        }
                        sort($years);
                        $year_end = in_array('н.в.', $years) ? 'н.в.' : end($years);
                        $years = array_diff($years, ['н.в.']);
                        $year_start = array_shift($years);
                        
                        if (!\Yii::$app->db->createCommand()->update('catalog', ['year_from' => $year_start, 'year_to' => $year_end], 'id=' . $root->id)->execute()) {
                            $this->stdout($slug . '/' . $one . " fail save date\n");
                        }
                        $this->stdout($slug . '/' . $one . ': ' . $i . "\n");
                    }
                }
            }
        }
    }
    
    /**
     * Сбор модификаций и характеристик автомобилей
     */
    public function actionModifications()
    {
        if ($brands = Catalog::find()->where(['depth' => 1])/*->andWhere(['slug' => 'ac'])->andWhere(['>', 'id', 14])*/->all()) {
            $data = [];
            foreach ($brands as $brand) {
                $data[$brand->slug] = ArrayHelper::map($brand->children()->select(['id', 'slug'])->andWhere(['depth' => 2/*, 'slug' => '378_gt'*/])/*->andWhere(['>', 'id', 2889])*/->all(), 'id', 'slug');
            }
            foreach ($data as $slug => $models) {
                foreach ($models as $id => $one) {
                    if ($result = shell_exec('node commands/beauto_modifications.js ' . $slug . '/' . $one)) {
                        $i = 0;
                        $j = 0;
                        $root = Catalog::findOne($id);
                        foreach (json_decode($result, true) as $item) {
                            $item['years'] = explode(' – ', $item['years']);
                            foreach ($item['years'] as $key => $year) {
                                $year = intval($year);
                                $year = $year == 0 ? 'н.в.' : $year;
                                $item['years'][$key] = (string)$year;
                            }
                            /*
                            if ($item['years'][0] == '2012' && $item['years'][1] == '2012') {
                            $generation = $root->children()->select(['id'])->andWhere([
                                'name' => 'I',
                                'year_from' => '2012',
                                'year_to' => '2012',
                                'depth' => 3
                            ])->scalar();
                            */
                            $generation = $root->children()->select(['id'])->andWhere([
                                'name' => !empty($item['name']) ? $item['name'] : ($item['years'][0] . '-' . $item['years'][1]),
                                'year_from' => $item['years'][0],
                                'year_to' => $item['years'][1],
                                'depth' => 3
                            ])->scalar();
                            
                            if ($generation) {
                                foreach ($item['mods'] as $mod) {
                                    if ($out = json_decode(shell_exec('node commands/beauto_specifications.js ' . $mod['link']), true)) {
                                        $model = new Modifications;
                                        $model->catalog_id = $generation;
                                        $model->name = $mod['mod'];
                                        $model->image = implode(',', $out[0]);
                                        if ($model->save()) {
                                            $i++;
                                            foreach ($out[1] as $spec_url) {
                                                if ($table = json_decode(shell_exec('node commands/beauto_table.js ' . $spec_url), true)) {
                                                    $spec = new Specifications;
                                                    $spec->modification_id = $model->id;    
                                                    $attr = $spec->attributeLabels();
                                                    foreach ($table as $row) {
                                                        if ($field = array_search($row['title'], $attr)) {
                                                            $spec->{$field} = in_array($field, ['capacity', 'power', 'racing', 'consumption']) ? explode(' ', $row['value'])[0] : $row['value'];
                                                        }
                                                        if ((strpos($row['title'], 'Размер') !== false) && is_array($row['value'])) {
                                                            $spec->wheel_size = implode(',', $row['value']);
                                                        }
                                                        if (strpos($row['title'], 'Степень') !== false) {
                                                            $spec->compression = $row['value'];
                                                        }
                                                    }
                                                    if ($spec->save()) {
                                                        $j++;
                                                    } else {
                                                        print_r($spec->errors);
                                                    }
                                                }
                                            }
                                        } else {
                                            print_r($model->errors);
                                        }
                                    }
                                }
                            }
                            //}
                        }
                        $this->stdout($slug . '/' . $one . ': ' . $i . ', spec: ' . $j . "\n");
                    }
                }
            }
        }
    }
    
    /**
     * Проверка на несобранные модификации и характеристики
     */
    public function actionZero()
    {
        if ($models = Catalog::find()->where(['depth' => 3])->all()) {
            $i = 0;
            $j = 0;
            foreach ($models as $one) {
                if (count($one->modifications) == 0) {
                    $this->stdout($one->parents(2)->select(['slug'])->one()->slug . '/' . $one->parents(1)->select(['slug'])->one()->slug . '/' . $one->slug . ": 0\n");
                } else {
                    foreach ($one->modifications as $mod) {
                        if (count($mod->specifications) == 0) {
                            $this->stdout($one->parents(2)->select(['slug'])->one()->slug . '/' . $one->parents(1)->select(['slug'])->one()->slug . '/' . $one->slug . '/' . $mod->id . " spec: 0\n");
                        }
                        $j++;
                    }    
                }
                $i++;
            }
            $this->stdout($i . 'modifications checked, ' . $j . " specifications checked\n");
        }
    }
    
    /**
     * Проверка на несобранные изображения в модификациях
     */
    public function actionEmpty()
    {
        if ($modifications = Modifications::find()->where(['image' => ''])->all()) {
            foreach ($modifications as $modification) {
                echo $modification->catalog->parents()->select(['slug'])->andWhere(['depth' => 1])->scalar() . '/' . $modification->catalog->parents()->select(['slug'])->andWhere(['depth' => 2])->scalar() . "\n";
            }
        }
    }
    
    /**
     * Замена повторяющихся строковых названий моделей на цифровые
     */
    public function actionModFields()
    {
        //print_r(Modifications::find()->select(['name'])->distinct()->orderBy('name ASC')->column());
        foreach (\Yii::$app->params['car_body_type']['options'] as $key => $value) {
            $i = 0;
            foreach (Modifications::find()->select(['id'])->where(['name' => $value])->indexBy('id')->asArray()->batch(10) as $item) {
                if (Modifications::updateAll(['name' => $key], 'id IN (' . implode(',', array_keys($item)) . ')')) {
                    $i++;
                }
            }
            $this->stdout($value . ': ' . $i*10 . "\n");
        }
    }
    
    /**
     * Замена повторяющихся строковых значений полей характеристик на цифровые
     */
    public function actionFields()
    {
        //print_r(Specifications::find()->select(['class'])->orderBy('drive ASC')->distinct()->column());
        foreach (\Yii::$app->params as $field => $param) {
            if (!in_array($field, ['car_body_type', 'condition', 'color'])) {
                foreach($param['options'] as $key => $option) {
                    $i = 0;
                    foreach (Specifications::find()->select(['id'])->where([$field => $option])->indexBy('id')->asArray()->batch(10) as $item) {
                        if (Specifications::updateAll([$field => $key], 'id IN (' . implode(',', array_keys($item)) . ')')) {
                            $i++;
                        }
                    }
                    $this->stdout($field . '/' . $option . ': ' . $i*10 . "\n");
                }
            }
        }
    }
    
    /**
     * Обрезка и сохранение изображений модефикаций
     */
    public function actionImages()
    {
        if ($modifications = Modifications::find()->all()) {
            try {
                foreach ($modifications as $modification) {
                    $path = 'web/images/uploads/source/Catalog/' . $modification->catalog->parents()->select(['slug'])->andWhere(['depth' => 1])->scalar();
                    FileHelper::createDirectory($path, 0777);
                    $i = 0;
                    $images = [];
                    foreach ($modification->image as $key => $url) {
                        $file = \igogo5yo\uploadfromurl\UploadFromUrl::initWithUrl('https://beauto.com.ua' . $url);
                        $parts = explode('/', $url);
                        $img_path = $path . '/' . $parts[3] . '_' . $parts[4] . '_' . $modification->id . '_' . ($key+1) . '.' . explode('.', $parts[6])[1];
                        if ($file->saveAs($img_path)) {
                            Image::crop($img_path, 640, 460, [0, 30])->save($img_path, ['quality' => 80]);
                            $images[] = str_replace('web/images/uploads/source/', '', $img_path);
                            $i++;
                        }
                    }
                    $modification->image = implode(',', $images);
                    if ($modification->save()) {
                        $this->stdout($parts[3] . '/' . $parts[4] . ': ' . $i . "\n");
                    } else {
                        print_r($modification->errors);
                    }
                }
            } catch (\Exception $e) {
                print_r($e->getMessage());
            }
        }
    }
}