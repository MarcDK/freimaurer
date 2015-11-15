<?php

/*

Freimaurer

Generate gallery html and nav html from images in /gallery folder.

Author: Marc Tönsing

*/

class Freimaurer
{
    private $path = '/freimaurer_demo'; // The location of freimaurer on the server
    private $imgTypes = array('jpeg', 'jpg', 'png', 'gif'); // The extensions of Images that the plugin will read
    private $directory = "gallery";
    private $categoriesOrder = "byName"; //byDate, byDateReverse, byName, byNameReverse, random
    private $imagesOrder = "byDateReverse"; //byDate, byDateReverse, byName, byNameReverse, random
    private $output;

    private function toAscii($str, $replace = array(), $delimiter = '-')
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

    private function getFoldersList($directory)
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

    private function getImagesList($directory)
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


    private function fixArray($list, $directory)
    {

        $return = array();

        foreach ($list as $key => $value) {

            //CUSTOMIZATION-->
            $values = array();
            $return[$value] = $values;
        }

        return $return;
    }

    private function generateNavigation($img_array)
    {

        $folder_names = array_keys($img_array);
        $i = true;
        $html = '<div class="nav-wrapper">';
        $html .= '<nav id="nav" class="freimaurer-nav nav-collapse" style="display:none;">';
        $html .= '<ul>';
        foreach ($folder_names as $folder_name) {

            $folder_name_slug = $this->toAscii($folder_name);

            if ($i) {
                $html .= '<li><a class="active" data-filter="' . $folder_name_slug . '">' . $folder_name . '</a></li>';
            } else {
                $html .= '<li><a class="" data-filter="' . $folder_name_slug . '">' . $folder_name . '</a></li>';
            }

            $i = false;
        }
        $html .= '</ul>';
        $html .= '</nav>';
        $html .= '</div>';


        return $html;
    }


    private function generateImageGrid($img_array)
    {

        $html = '<ul style="display: none;" class="freimaurer">';

        $i = 0;


        $path = $_SERVER['REQUEST_URI'];


        foreach ($img_array as $key => $elem) {
            if (is_array($elem)) {

                foreach ($elem as $img_filename => $elem) {

                    $img_path = './../' . $path . 'gallery/' . $key . '/' . $img_filename;
                    $img_path_thumb = './../' . 'gallery/' . $key . '/' . $img_filename;
                    $img_size = getimagesize('gallery/' . $key . '/' . $img_filename);
                    $org_width = $img_size[0];
                    $org_height = $img_size[1];

                    if($org_width == 1280 && $org_height == 720) {
                        $big_img = $img_path;
                    } else {
                        $big_img =  $path . 'freimaurer/thumb.php?src=' . $img_path_thumb . '&size=1280x720crop=1';
                    }

                    $item = "\n";
                    $item .= '<li class="element-item all ' . $this->toAscii($key) . '" data-category="' . $this->toAscii($key) . '">';
                    $item .= "\n";
                    $item .= '<a data-size="1920x1080" data-index="' . $i . '" title="' . $key . '"
                    data-category="' . $this->toAscii($key) . '" rel="all" class="gallery" href="' . $big_img . '">';
                    $item .= "\n";
                    $item .= '<img width="265" height="150" src="freimaurer/img/loading.png" class="lazy"
                    data-src="' . $path . 'freimaurer/thumb.php?src=' . $img_path_thumb . '&size=300x168?crop=1"
                    data-src-retina="' . $path . 'freimaurer/thumb.php?src=' . $img_path_thumb . '&size=600x337?crop=1">';
                    $item .= "\n";
                    $item .= '</a>';
                    $item .= "\n";
                    $item .= '</li>';

                    $array_img_list[] = $item;

                    $i++;
                }

            }
        }



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


        $this->output = $output;
    }

    public function getPhotoSwipeHTML()
    {
        $html = '
        <!-- Root element of PhotoSwipe. Must have class pswp. -->
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

            <!-- Background of PhotoSwipe.
                 It\'s a separate element as animating opacity is faster than rgba(). -->
            <div class="pswp__bg"></div>

            <!-- Slides wrapper with overflow:hidden. -->
            <div class="pswp__scroll-wrap">

                <!-- Container that holds slides.
                    PhotoSwipe keeps only 3 of them in the DOM to save memory.
                    Don\'t modify these 3 pswp__item elements, data is added later on. -->
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>

                <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                <div class="pswp__ui pswp__ui--hidden">

                    <div class="pswp__top-bar">

                        <!--  Controls are self-explanatory. Order can be changed. -->

                        <div class="pswp__counter"></div>

                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                        <button class="pswp__button pswp__button--share" title="Share"></button>

                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                        <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                        <!-- element will get class pswp__preloader--active when preloader is running -->
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div>
                    </div>

                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                    </button>

                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                    </button>

                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>

                </div>

            </div>

        </div>';

        return $html;
    }

    public function getGalleryNav()
    {

        $nav = $this->generateNavigation($this->output);

        return $nav;
    }

    public function getGallery()
    {

        $gallery = $this->generateImageGrid($this->output);

        return $gallery;
    }

}


