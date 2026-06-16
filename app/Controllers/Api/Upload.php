<?php
namespace App\Controllers\Api;

use App\Controllers\BaseAuthController;
use App\Models\M_gallery;

class Upload extends BaseAuthController
{
    protected $session;
    protected $validation;
    protected $request;

    public function __construct()
    {
        $this->session    = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->request    = \Config\Services::request();
    }    

    public function index()
    {
        return view('welcome_message');
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
    }

    public function upload()
    {
       
        // Debug: Log all received data
        $allData = [
            'POST' => $this->request->getPost(),
            'FILES' => $_FILES,
            'getFiles' => $this->request->getFiles(),
            'headers' => $this->request->headers(),
            'method' => $this->request->getMethod(),
            'content_type' => $this->request->getHeaderLine('Content-Type')
        ];
        
        log_message('debug', 'Upload API received data: ' . json_encode($allData));
        
        // Check if any files were uploaded
        $imgFiles = $this->request->getFiles();
        
        if (empty($imgFiles) || !isset($imgFiles['file_upload'])) {
            $response = [
                'status' => 'error',
                'message' => 'No file uploaded. Please send a file with key "file_upload"',
                'debug_info' => [
                    'received_files' => array_keys($imgFiles),
                    'POST_data' => $this->request->getPost(),
                    'FILES' => $_FILES,
                    'content_type' => $this->request->getHeaderLine('Content-Type')
                ]
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }
        
        $validationRule = [
            'file_upload' => [
                'label' => 'Image File',
                'rules' => 'uploaded[file_upload]'
                    . '|is_image[file_upload]'
                    . '|mime_in[file_upload,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[file_upload,10240]'
                    . '|max_dims[file_upload,5000,5000]',
            ],
        ];
        
        if (! $this->validate($validationRule)) {
            $response = [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ];
            return $this->response->setJSON($response)->setStatusCode(400);
        }
        
        $uploaded_files = [];
        $galleryModel = new M_gallery();
        $insertId = null;
        
        foreach($imgFiles as $img){
          if ($img->isValid() && !$img->hasMoved()) {
              $newName = $img->getRandomName();
              $img->move(ROOTPATH . 'public/upload', $newName);
              
              $uploaded_files = 'upload/'.$newName;
              
              // Prepare data for database insertion into gallery table
              $galleryData = [
                  'gallery_userid' => $this->volunteerData->volntr_id ?? 0,
                  'gallery_image' => $uploaded_files,
                  'gallery_status' => 1
              ];
              
              // Insert into gallery table
              $insertId = $galleryModel->insert($galleryData);
              
              if (!$insertId) {
                  $response = [
                      'status' => 'error',
                      'message' => 'File uploaded but failed to save to database',
                      'errors' => $galleryModel->errors()
                  ];
                  return $this->response->setJSON($response)->setStatusCode(500);
              }
              
          } else {
              $response = [
                  'status' => 'error',
                  'message' => 'The file is invalid: ' . $img->getErrorString()
              ];
              return $this->response->setJSON($response)->setStatusCode(400);
          }
        }
        
        $response = [
            'status' => 'success',
            'message' => 'File uploaded and saved successfully',
            'data' => [
                'file_upload' => $uploaded_files,
                'gallery_id' => $insertId,
                't' => $this->request->getVar('t')
            ]
        ];
        
        return $this->response->setJSON($response);
    }

    public function galleryList()
    {
        $userId = $this->volunteerData->volntr_id;
        $m_gallery = new M_gallery();
        $response['galleries'] = $m_gallery->get_gallery($userId);
        return json_encode($response);
    }

}
?>
