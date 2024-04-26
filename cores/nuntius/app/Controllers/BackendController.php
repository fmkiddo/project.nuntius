<?php
namespace App\Controllers;


abstract class BackendController extends BaseController {
    
    private $isLogged   = false;
    private $session    = NULL;
    
    public function index (): string {
        if (!$this->isLogged ()) return $this->response->redirect ();
        else {
            $get = $this->request->getGet ();
            if (array_key_exists('route', $get)) return $this->directiveInquiry($get['route']);
            else {
                $result = [
                    'status'    => 404,
                    'message'   => 'Page Not Found!'
                ];
                $this->response->setHeader ('Content-Type', 'application/json');
                $this->response->setBody (json_encode ($result));
                $this->response->send ();
            }
        }
    }
    
    protected function initComponents() {
        $this->session  = \Config\Services::session ();
    }
    
    abstract protected function directiveInquiry ($directive);
    
    private function isLogged (): bool {
        // $sessionData    = $this->session->get (USER_KEYDATA_LOGGED);
        return true;
    }
}