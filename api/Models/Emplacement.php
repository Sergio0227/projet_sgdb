<?php

namespace SGDB_API\Models;

use SGDB_API\Models\any_table;

class Emplacement extends any_table
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


