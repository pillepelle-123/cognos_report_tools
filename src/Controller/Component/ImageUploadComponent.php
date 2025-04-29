<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry; // Import the ComponentRegistry class
use Cake\Filesystem\File;
use Cake\Utility\Text;

class ImageUploadComponent extends Component
{

    public function __construct(
        ComponentRegistry $registry,
        array $config = [],
        //UserService $users // Ensure the UserService class is defined and autoloaded
    ) {
        parent::__construct($registry, $config);
        //$this->users = $users;
    }


    public function handleUpload($file, $userId)
    {

        $a = !is_array($file);
        $b = empty($file);
        $name = $file->getClientFilename();
        //$c = !is_uploaded_file($file['tmp_name']);

        //1. Validierung hinzufügen
        // if (empty($fileName) || !is_uploaded_file($fileName)) {
        //     throw new \RuntimeException('Invalid file upload');
        // }

        // 2. Upload-Verzeichnis sicher erstellen
        $uploadPath = WWW_ROOT . 'img' . DS . 'users' . DS;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        // 3. Dateinamen sicher generieren
        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            throw new \RuntimeException('Invalid file type');
        }
        $filename = Text::uuid() . '.' . $extension;
        $destination = $uploadPath.$filename;

        $file->moveTo($destination);

        return $filename;
        //$filename = Text::uuid() . '.' . $extension;

        //$move = move_uploaded_file($fileName, $uploadPath . $filename);
        // echo 'hey' . $move;
        //moveTo(WWW_ROOT . 'img' . DS . $fileTable->images);

        // 4. Datei sicher verschieben
        // if (move_uploaded_file($filename, $uploadPath . $filename)) {
        //     return $filename;
        // }

        //throw new \RuntimeException('File upload failed');
    }


    // public function handleUpload($file, $userId)
    // {
    //     $uploadPath = WWW_ROOT . 'img' . DS . 'users' . DS;
    //     $filename = Text::uuid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        
    //     if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
    //         return $filename;
    //     }
        
    //     return false;
    // }

    public function generateDefaultAvatar($email)
    {
        $initials = strtoupper(substr($email, 0, 2));
        $colors = ['#FFD1DC', '#C8A2C8', '#89CFF0', '#77DD77', '#FFB347'];
        $bgColor = $colors[array_rand($colors)];
        
        $filename = Text::uuid() . '.png';
        $path = WWW_ROOT . 'img' . DS . 'users' . DS . $filename;
        
        // GD-Lib Implementation
        $image = imagecreatetruecolor(1024, 1024);
        $bg = $this->hex2rgb($bgColor);
        $bgColor = imagecolorallocate($image, $bg[0], $bg[1], $bg[2]);
        imagefill($image, 0, 0, $bgColor);
        
        $textColor = imagecolorallocate($image, 255, 255, 255);
        $font = WWW_ROOT . 'fonts' . DS . 'arial.ttf'; // Font hinzufügen
        imagettftext($image, 400, 0, 260, 640, $textColor, $font, $initials);
        
        imagepng($image, $path);
        imagedestroy($image);
        
        return $filename;
    }
    
    private function hex2rgb($hex) {
        return sscanf($hex, "#%02x%02x%02x");
    }
}