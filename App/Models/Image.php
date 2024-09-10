<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-20
 * Time: 22:54
 */

namespace App\Models;

use PDO;
use Gmagick;

/**
 * Category model
 * User: Alexander Korus
 * Date: 2019-02-17
 */
class Image extends \Core\Model
{

    public $id;
    public $path;
    public $thumbnail;
    public $post_id;


    /*
     * Findet alle Bilder zu einer Post ID und gibt sie zurück
     */
    public static function findByPost(int $id)
    {

        try {
            $db = static::getDB();


            $stmt = $db->prepare('select * from image 
                 where post_id = :post_id');
            $stmt->execute(array(
                ":post_id" => $id
            ));
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Image');
            $results = $stmt->fetchAll();

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    /*
     * Fügt ein neues Bild mit Thumbnail zur Datenbank hinzu. Das Bild wird zuvor gecroppded und anschließend wird ein Logo als Wasser
     * zeichen eingefügt.
     */
    public function add()
    {

        $rc = $this->db->insert('image', array(
            'path' => $this->addWatermark($this->cropImageFromCenter($this->path, 'cropped', 350, 350)),
            'thumbnail' => $this->cropImageFromCenter($this->path, 'thumbnail', 50, 50),
            'post_id' => $this->post_id
        ));

        return $rc;

    }


    /*
     * Schneidet ein Ausschnitt von der Mitte des Bildes mit den übergebenen Größenangaben heraus
     */
    private function cropImageFromCenter(string $source, $target, int $height, int $width): string
    {


        $image = new Gmagick('uploads/' . $source);

        $image->cropthumbnailimage($width, $height);

        $image->write('uploads/' . $target . '_' . $source);

        return $target . '_' . $source;
    }


    /*
     * Fügt ein Wasserzeichen auf das Bild der übergebenen Source
     */
    private function addWatermark($source)
    {

        $stamp = imagecreatefrompng("images/yourad.png");
        $image = imagecreatefromjpeg('uploads/' . $source);

        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        imagecopy($image, $stamp, imagesx($image) - $sx - $marge_right,
            imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        ob_start();
            imagepng($image, 'uploads/' . $source);
        ob_end_clean();

        // be tidy; free up memory
        imagedestroy($image);

        return $source;

    }

}
