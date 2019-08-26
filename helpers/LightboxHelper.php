<?php

namespace app\helpers;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\helpers\LightboxAssetHelper;

class LightboxHelper extends Widget {

    /** @var array Contains the attributes for the images. */
    public $files = [];

    /** @inheritdoc */
    public function init() {
        LightboxAssetHelper::register($this->getView());
    }

    /** @inheritdoc */
    public function run() {
        $html = '';
        foreach ($this->files as $file) {
            if (!isset($file['thumb']) || !isset($file['original'])) {
                continue;
            }

            $attributes = [
                'data-title' => isset($file['title']) ? $file['title'] : '',
            ];

            if (isset($file['group'])) {
                $attributes['data-lightbox'] = $file['group'];
            } else {
                $attributes['data-lightbox'] = 'image-' . uniqid();
            }

            $thumbOptions = isset($file['thumbOptions']) ? $file['thumbOptions'] : [];
            $linkOptions  = isset($file['linkOptions']) ? $file['linkOptions'] : [];

            if (isset($file['img-class'])) {
                $img_class = $file['img-class'];
            }else{
                $img_class = 'gallery-thumbnail';
            }

            // $img = Html::img($file['thumb'], $thumbOptions);
            $div = Html::tag('div', '', ['class' => $img_class, 'style' => 'background-image: url(' . $file['thumb'] . ')']);
            $a   = Html::a($div, $file['original'], ArrayHelper::merge($attributes, $linkOptions));

            $html .= $a;
        }
        return $html;
    }

}
