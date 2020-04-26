<?php

namespace Ozycast\core;

class Pagination
{

    /**
     * Данные для пагинации
     * @param $page - текущая страница
     * @param $count - кол-во записей в бд
     * @return mixed
     */
    public static function getPagination($page, $count)
    {
        $pages['count_page'] = ceil($count / 3);
        $pages['current_page'] = $page;
        $pages['offset'] = ($page - 1) * 3;
        $pages['count_item'] = $count;
        $pages['prev_page'] = !($pages['current_page']-1) ? 1 : $pages['current_page'] - 1;
        $pages['next_page'] = $pages['current_page']+1 > $pages['count_page'] ? $pages['count_page'] : $pages['current_page']+1;
        $url = substr($_SERVER['REQUEST_URI'], 1);
        if (preg_match("/(\?|&)page=([0-9]*)&?/i", $url))
            $pages['url_template'] = preg_replace("/(\?|&)page=([0-9]*)(&?)/i", "$1page={{:page}}$3", $url);
        else
            $pages['url_template'] = preg_match("/\?/i", $url) ? $url."&page={{:page}}" :  $url."?page={{:page}}";

        return $pages;
    }
}