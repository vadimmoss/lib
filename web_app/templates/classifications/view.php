<?php
function listThree($arr)
{
    if ($arr['class_name'] !== null) {
        echo '<ul class="ul " style="display: none">';
        echo '<li><a href="#' . $arr['class_name'] . '">' . $arr['class_name'] . '</a></li>';
        if (isset($arr['children'])) {
            if ($arr['children'] !== null) {
                foreach ($arr['children'] as $child) {
                    listThree($child);
                };
            }
        };
        echo '</ul>';
    };
}

foreach ($classification::buildClassTree() as $class) {
    if ($class['children'] !== null) {
        echo '<ul class="ul" > ' . '<li><a href="#' . $class['class_name'] . '">' . $class['class_name'] . '</a></li>';
        foreach ($class['children'] as $child) {
            listThree($child);
        };
        echo '</ul>';
    }
}
?>
<script src="https://code.jsqlQuery.com/jsqlQuery-3.5.0.js"></script>
<script src="/www/classesjs.js"></script>
