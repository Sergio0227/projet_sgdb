<?php

require_once __DIR__ . '/tools/any_table.php';

class Emplacement extends AnyTable
{
    function buildTree($elements)
    {
        $indexedElements = [];
        $roots = [];

        foreach ($elements as $element) {
            $element['children'] = []; 
            $indexedElements[$element['id']] = $element;
        }

        foreach ($indexedElements as $id => &$element) {
            $parentId = $element['parent_id'];

            if ($parentId !== 0 && isset($indexedElements[$parentId])) {
                $indexedElements[$parentId]['children'][] = &$indexedElements[$id];
            } else {
                if ($parentId === null) {
                    $roots[] = &$indexedElements[$id];
                }
            }
        }
        return $roots;
    }
}


