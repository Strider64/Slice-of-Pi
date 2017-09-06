<?php

namespace Library\Slider; // Uses a namespace so it doesn't  colide with other Classes:

class Slider {

    protected $files = [];
    /*
     * Supported image files for the slider
     */
    protected $supported_file = [
        'gif',
        'jpg',
        'jpeg',
        'png'
    ];
    protected $temp = \NULL;
    protected $image = \NULL;
    protected $ext = \NULL;

    /*
     * "assets/uploads/*.* is the default directory for the slide show.
     */

    public function __construct(string $image_dir = "assets/uploads/*.*", int $num = 7) {
        $this->temp = glob($image_dir); // Grab all the files in that directory:
        $this->files = array_reverse($this->temp);
        /* If files is larger than a certain total number of files wanted to use. */
        if (count($this->files) > $num) {
            array_splice($this->files, count($this->files) - (count($this->files) - $num));
        }
    }

    /*
     * If you want to use more than one slider on your website.
     */

    public function setDirectory(string $image_dir = \NULL, int $num = 7) {
        self::__construct($image_dir, $num);
    }

    public function outputImages() {
        echo '<ul id="slides">' . "\n";
        for ($i = 0; $i < count($this->files); $i++) {
            $this->image = $this->files[$i]; // Just making it easier to understand that $files[$i] are the individual image in the loop:
            $this->ext = strtolower(pathinfo($this->image, PATHINFO_EXTENSION));
            if (in_array($this->ext, $this->supported_file)) { /* Use an if statment to place images in HTML format. */
                /*
                 * echo basename($image); ### Shows name of image to show full path use just $image:
                 */
                if ($i === 0) {
                    echo '<li class="slide showing"><img src="' . htmlspecialchars($this->image) . '" alt="Slide Show Image"></li>' . "\n";
                } else {
                    echo '<li class="slide"><img src="' . htmlspecialchars($this->image) . '" alt="Slide Show Image"></li>' . "\n";
                }
            } else {
                continue;
            }
        }
        echo "</ul>\n";
    }

}
