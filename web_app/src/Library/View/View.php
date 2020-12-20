<?php


namespace Library\View;


class View
{
    private $tempPath;
    private $extraVars = [];

    public function __construct(string $tempPath)
    {
        $this->$tempPath = $tempPath;
    }

    public function setVariables(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    public function renderPageHtml(string $template_name, array $variables = [], int $response = 200)
    {
        http_response_code($response);
        extract($variables);
        extract($this->extraVars);
        ob_start();
        include $this->tempPath . '/' . $template_name;
        $cache = ob_get_contents();
        ob_end_clean();
        echo $cache;
    }
    public function listThree($arr)
    {

        if ($arr['class_name'] !== null) {
            echo '<ul class="ul " style="display: none">';
            echo '<li><a href="#' . $arr['class_name'] . '">' . $arr['class_name'] . '</a></li>';
            if (isset($arr['children'])) {
                if ($arr['children'] !== null) {
                    foreach ($arr['children'] as $child) {
                        $this->listThree($child);
                    };
                }
            };
            echo '</ul>';
        };

    }
}