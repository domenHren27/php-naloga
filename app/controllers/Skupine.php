<?php 
    class Skupine extends Controller {
        public function __construct()
        {
            $this->skupinaModel = $this->model('Skupina');
            $this->osebaModel = $this->model('Oseba');
            $this->smsApi = $this->api('SmsApi'); 
        }

        public function index()
        {
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/users/login");
            }

            $skupine = $this->skupinaModel->findAllSkupineById($_SESSION['user_id']);

            // if(!empty((array)$skupine)) {
            //     foreach($skupine as $skupina) {
            //        $osebe = [];
            //        if($this->skupinaModel->hasOsebaMany($skupina->skupina_id)) {
            //            $osebe = array_push($this->skupinaModel->hasOsebaMany($skupina->skupina_id));
            //        }
                    
            //     }
            // }

            $data = [
                'skupine' => $skupine
                //'osebe' => $osebe
            ];

            $this->view('skupine/index', $data);
            
        }

        public function create()
        {
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/skupine");
            }

            $data = [
                'skupina_ime' => '',
                'skupina_imeError' => ''
            ];
            

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'skupina_ime' => trim($_POST['skupina_ime']),
                    'skupina_imeError' => ''
                ];
    
                if(empty($data['skupina_ime'])) {
                    $data['skupina_imeError'] = 'Ime ni bilo vnešene';
                }

                if($this->skupinaModel->findSkupinaByIme($data['skupina_ime'])) {
                    $data['skupina_imeError'] = 'To ime že obstaja vpiši novega';    
                }
    
                if (empty($data['skupina_imeError'])) {
                    if ($this->skupinaModel->addSkupina($data)) {
                        header("Location: " . URLROOT . "/skupine");
                    } else {
                        die("Nekja je šlo narobe poskusi znova!");
                    }
                } else {
                    $this->view('skupine/create', $data);
                }
            }

            $this->view('skupine/create', $data);
        }

        public function read($id)
        {
            $skupina = $this->skupinaModel->findById($id);

            $data = [
                'skupina' => $skupina,
                'skupina_id' => $skupina->skupina_id,
                'skupina_ime' => $skupina->skupina_ime,
                'user_id' => $skupina->user_id,
            
            ];

            if(empty($data)) {
                echo "Ta stran ne obstaja";
            }else {
                $this->view('skupine/read', $data);
            }               
                
            
        }

        public function update($id) {

            $skupina = $this->skupinaModel->findById($id);

            
    
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/");
            } elseif($skupina->user_id != $_SESSION['user_id']){
                header("Location: " . URLROOT . "/");
            }
    
            $data = [
                'skupina' => $skupina,
                'skupina_id' => $skupina->skupina_id,
                'skupina_ime' => $skupina->skupina_ime,
                'skupina_imeError' => ''
            ];
    
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
                $data = [
                    'skupina_id' => $id,
                    'skupina' => $skupina,
                    'skupina_ime' => trim($_POST['skupina_ime']),
                    'skupina_imeError' => ''
                ];
    
                if(empty($data['skupina_ime'])) {
                    $data['skupina_ime'] = 'Skupina ime polje nesme biti prazno';
                }
    
                if($data['skupina_ime'] == $this->skupinaModel->findById($id)->skupina_ime) {
                    $data['skupina_imeError'] == 'Nisi spremenil imena';
                }

                if($this->skupinaModel->findSkupinaByIme($data['skupina_ime'])) {
                    $data['skupina_imeError'] = 'To ime že obstaja, prosim  vpiši novega';    
                }
                
                var_dump($data['skupina_imeError']);
    
                if (empty($data['skupina_imeError'])) {
                    if ($this->skupinaModel->updateSkupina($data)) {
                        header("Location: " . URLROOT . "/skupine");
                    } else {
                        die("Nekaj je šlo narobe, prosim poskusi znova!");
                    }
                } else {
                    $this->view('skupine/update', $data);
                }
            }
    
            $this->view('skupine/update', $data);
        }

        public function oseba_skupina($id)
        {
            $skupina = $this->skupinaModel->findById($id);
            
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/");
            } elseif($skupina->user_id != $_SESSION['user_id']){
                header("Location: " . URLROOT . "/");
            }

            $data = [
                'skupina' => $skupina,
                'oseba_ime' => '',
                'oseba_imeError' => ''
            ];
            

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'skupina' => $skupina,
                    'oseba_ime' => trim($_POST['oseba_ime']),
                    'skupina_imeError' => ''
                ];
    
                if(empty($data['oseba_ime'])) {
                    $data['skupina_imeError'] = 'Ime osebe ni bilo vnešeno';
                }

                if(is_null($this->osebaModel->findOsebaByIme($data['oseba_ime']))) {
                    $data['oseba_imeError'] = 'Nismo mogli najti vpisanega imena';    
                }
    
                if (empty($data['oseba_imeError'])) {
                    $oseba = $this->osebaModel->findOsebaByIme($data['oseba_ime']);
                    if ($this->osebaModel->addToSkupina($oseba->oseba_id, $skupina->skupina_id)) {
                        header("Location: " . URLROOT . "/skupine");
                    } else {
                        die("Nekja je šlo narobe poskusi znova!");
                    }
                } else {
                    $this->view('skupine/oseba_skupina', $data);
                }
            }

            $this->view('skupine/oseba_skupina', $data);
        }
    
        public function delete($id) {

            $skupina = $this->skupinaModel->findById($id);
    
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/skupine");
            } elseif($skupina->user_id != $_SESSION['user_id']){
                header("Location: " . URLROOT . "/skupine");
            }
    
            // $data = [
            //     'skupina' => $skupina,
            //     'skupina_ime' => '',
            //     'skupina_imeError' => ''
            // ];
    
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
                if($this->skupinaModel->deleteSkupina($id)) {
                        header("Location: " . URLROOT . "/skupine");
                } else {
                   die('Something went wrong!');
                }
            }
        }

        

}
