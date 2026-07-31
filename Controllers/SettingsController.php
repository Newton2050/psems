<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;

class SettingsController extends Controller
{
    public function index(): void
    {
        $settingModel = $this->model('Setting');
        $settings = $settingModel->all();
        
        $this->view('settings/index', [
            'title' => 'Settings - PSEMS',
            'settings' => $settings
        ]);
    }
    
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingModel = $this->model('Setting');
            
            foreach ($_POST['settings'] as $key => $value) {
                $settingModel->updateByKey($key, $value);
            }
            
            Session::flash('success', 'Settings updated successfully.');
            $this->redirect('settings');
        }
    }
}
