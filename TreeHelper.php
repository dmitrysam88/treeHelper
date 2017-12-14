<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 14.12.2017
 * Time: 13:14
 */

namespace yii\helpers;

use yii\helpers\ArrayHelper;


class TreeHelper{

    static public function madeTree($arrayModel){
        $dataset = Array();
        foreach ($arrayModel as $item){
            array_push($dataset,$item->toArray());
        }

        return self::mapTree($dataset);

    }

    static public function mapTree($dataset, $parent=null) {
        $tree = array();
        foreach ($dataset as $id=>&$node) {
            if ($node['parent_id'] === null) { // root node
                $tree[$id] = &$node;
            } else { // sub node
                $parentId = $node['parent_id'];
                $parentKey = key(array_filter($dataset,function($a) use ($parentId){
                    return ($a['id'] == $parentId);
                }));
                if (!isset($dataset[$parentKey]['children'])) $dataset[$parentKey]['children'] = array();
                $dataset[$parentKey]['children'][$id] = &$node;
            }
        }

        return $tree;

    }

}