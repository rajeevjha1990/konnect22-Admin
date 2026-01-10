<?php
namespace App\Controllers\Api;

use App\Controllers\BaseAuthController;


use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;

class Upload extends BaseAuthController
{
    public function index()
    {
        return view('welcome_message');
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
    }

    public function upload()
     {
          $validationRule = [
            'file_upload' => [
                'label' => 'Image File',
                'rules' => 'uploaded[file_upload]'
                    . '|is_image[file_upload]'
                    . '|mime_in[file_upload,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[file_upload,2000]'
                    . '|max_dims[file_upload,5000,5000]',
            ],
        ];
        if (! $this->validate($validationRule)) {
            $response = ['err' => $this->validator->getErrors()];
            return json_encode($response);
        }
        $imgFiles = $this->request->getFiles();
        $uploaded_files = [];
        foreach($imgFiles as $img){
          if ($img->isValid() && !$img->hasMoved()) {
              $newName = $img->getRandomName();

              $img->move(ROOTPATH . 'public/upload', $newName);
              // $img->move(WRITEPATH . 'uploads', $newName);
              // $uploaded_files[] = 'uploads/'.date('yyyymmdd').'/'.$newName;
              $uploaded_files= 'upload/'.$newName;
              //print_r($uploaded_files);

              // print_r($img);
              // throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
          } else {
              // $response = ['errors' => 'The file has already been moved.'];
          }
        }
        $response = array(
          'file_upload'=>$uploaded_files,
          't'=>$this->request->getVar('t')
        );
        return json_encode($response);
      }

}
?>
