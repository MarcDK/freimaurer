<?php

class generateGallery
{
    private $imgTypes = array('jpeg', 'jpg', 'png', 'gif'); // The extensions of Images that the plugin will read
    private $directory = "gallery";
    private $categoriesOrder = "byName"; //byDate, byDateReverse, byName, byNameReverse, random
    private $imagesOrder = "random"; //byDate, byDateReverse, byName, byNameReverse, random

    public function toAscii($str, $replace = array(), $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    public function getFoldersList($directory)
    {
        $categoriesOrder = $this->categoriesOrder;
        if (!is_dir($directory)) {//If the parameter is a directory if not then just return
            return array();
        }
        $results = array();
        $handler = opendir($directory);
        while ($file = readdir($handler)) {
            if ($file != "." && $file != ".." && $file != ".DS_Store" && is_dir($directory . '/' . $file) && $file != "thumbnails") {//If it is a folder
                $ctime = filemtime($directory . '/' . $file) . ',' . $file; //BRING THE DATE OF THE FOLDER
                if ($categoriesOrder == 'byName' || $categoriesOrder == 'byNameReverse') {
                    $ctime = $file;
                }
                $results[strtolower($ctime)] = $file;
            }
        }

        closedir($handler);
        if ($categoriesOrder == 'byDate' || $categoriesOrder == 'byNameReverse') {
            krsort($results);
        } else if ($categoriesOrder == 'byDateReverse' || $categoriesOrder == 'byName') {
            ksort($results);
        } else if ($categoriesOrder == 'random') {
            shuffle($results);
        }

        return $results;
    }

    public function getImagesList($directory)
    {

        $imagesOrder = $this->imagesOrder;

        if (!is_dir($directory)) {
            return array();
        }

        $results = array();

        $handler = opendir($directory);

        while ($file = readdir($handler)) {
            if ($file != "." && $file != ".." && $file != ".DS_Store") {
                $extension = preg_split('/\./', $file);
                $extension = strtolower($extension[count($extension) - 1]);

                if (array_search($extension, $this->imgTypes) !== FALSE) {
                    $ctime = filemtime($directory . '/' . $file) . ',' . $file; //BRING THE DATE OF THE IMAGE
                    if ($imagesOrder == 'byName' || $imagesOrder == 'byNameReverse') {
                        $ctime = $file;
                    }
                    $results[strtolower($ctime)] = $file;
                }

            }
        }

        closedir($handler);
        if ($imagesOrder == 'byDate' || $imagesOrder == 'byNameReverse') {
            krsort($results);
        } else if ($imagesOrder == 'byDateReverse' || $imagesOrder == 'byName') {
            ksort($results);
        } else if ($imagesOrder == 'random') {
            shuffle($results);
        }
        return $results;
    }


    public function fixArray($list, $directory)
    {

        $return = array();

        foreach ($list as $key => $value) {

            $thumb = 'no';
            if (file_exists($directory . '/thumbnails' . '/' . $value)) {//VERIFY IF THERE IS ANY THUMBNAIL FOR THE IMAGE
                $thumb = 'yes';
            }
            //CUSTOMIZATION-->
            $values = array();
            //$values["thumb"] = $thumb;
            //$values["order"] = $key;

            $return[$value] = $values;
        }

        return $return;
    }

    public function generateNavigation($img_array)
    {

        $folder_names = array_keys($img_array);
        $i = true;
        $html = '<nav style="display:none;" class="button-group filter-button-group">';

        foreach ($folder_names as $folder_name) {

            $folder_name_slug = $this->toAscii($folder_name);

            if ($i) {
                $html .= '<button class="pure-button button pure-button-active" data-filter="' . $folder_name_slug . '">' . $folder_name . '</button>';
            } else {
                $html .= '<button class="pure-button button" data-filter="' . $folder_name_slug . '">' . $folder_name . '</button>';
            }

            $i = false;
        }

        $html .= '</nav>';

        return $html;
    }


    public function generateImageGrid($img_array)
    {

        $html = '<ul style="display: none;" class="grid">';

        foreach ($img_array as $key => $elem) {
            if (is_array($elem)) {

                foreach ($elem as $img_filename => $elem) {

                    $path_parts = pathinfo($img_filename);

                    $filename_ext = $path_parts['extension'];
                    $filename = $path_parts['filename'];

                    $item = "\n";
                    $item .= '<li class="element-item all ' . $this->toAscii($key) . '" data-category="' .  $this->toAscii($key) . '">';
                    $item .= "\n";
                    $item .= '<a title="' . $key . '" data-category="' . $this->toAscii($key) . '" rel="all" class="gallery" href="/gallery/' . $key . '/' . $img_filename . '">';
                    $item .= "\n";
                    $item .= '<span class="sprite fullscreenicon">' . $key . '</span>';
                    $item .= "\n";
                    $item .= '<img width="265" height="150" src="/images/loading.png" class="lazy" data-src="/gallery/' . $key . '/thumbnails/' . $img_filename . '" data-src-retina="/gallery/' . $key . '/thumbnails/' . $filename . '@2x.' . $filename_ext . '">';
                    $item .= "\n";
                    $item .= '</a>';
                    $item .= "\n";
                    $item .= '</li>';

                    $array_img_list[] = $item;
                }

            }
        }

        shuffle($array_img_list);

        foreach ($array_img_list as $html_item) {
            $html .= $html_item;
        }

        $html .= '</ul>';
        return $html;
    }

    public function __construct($directory = '')
    {
        $directory = $this->directory;

        $output = array();

        //GET THE CATEGORIES
        $folders = $this->getFoldersList($directory);

        //GET THE IMAGES IN ROOT
        $imagesInRoot = $this->getImagesList($directory);

        //ADD THE IMAGES IN ROOT
        $output['All'] = $this->fixArray($imagesInRoot, $directory);

        //GET THE IMAGES OF EACH CATEGORY
        foreach ($folders as $key => $value) {

            $images = $this->getImagesList($directory . "/" . $value);

            //ADD THE IMAGES OF EACH CATEGORY
            $output[$value] = $this->fixArray($images, $directory . '/' . $value);
        }

        $nav = $this->generateNavigation($output);
        echo $nav;

        $gallery = $this->generateImageGrid($output);
        echo $gallery;

    }

}

new generateGallery();






