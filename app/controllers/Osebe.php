<?php
    class Osebe extends Controller {
        public function __construct()
        {
            $this->skupinaModel = $this->model('Skupina');
            $this->osebaModel = $this->model('Oseba');
            $this->apiModel = $this->model('Api');

            //Najde api z najmanj porabljenimi sms-i
            $this->smsApi = $this->api($this->apiModel->findAndComper());

            
        }

        public function index()
        {
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/users/login");
            }

            $osebe = $this->osebaModel->findAllOsebaById($_SESSION['user_id']);

            $data = [
                'osebe' => $osebe
            ];

            $this->view('osebe/index', $data);
            
        }
        //Oseba create
        public function create()
        {
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/osebe");
            }

            $data = [
                'oseba_ime' => '',
                'oseba_email' => '',
                'oseba_telefon' => '',
                'oseba_imeError' => '',
                'oseba_emailError' => '',
                'oseba_telefonError' => ''
            ];
            

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                if ($_POST['oseba_davcna']) {
                    header("Location: " . URLROOT . "/oseba/create_pravna");
                }
                
                $data = [
                    'oseba_ime' => trim($_POST['oseba_ime']),
                    'oseba_email' => trim($_POST['oseba_email']),
                    'oseba_telefon' => trim($_POST['oseba_telefon']),
                    'oseba_imeError' => '',
                    'oseba_emailError' => '',
                    'oseba_telefonError' => ''
                ];
    
                if(empty($data['oseba_ime'])) {
                    $data['oseba_imeError'] = 'Ime osebe ni bilo vnešeneo';
                }

                if(empty($data['oseba_email'])) {
                    $data['oseba_emailError'] = 'E-mail ni bil vnešen';
                }

                if(empty($data['oseba_telefon'])) {
                    $data['oseba_telefonError'] = 'Telefonska številka ni bila vnešena';
                }

                if($this->osebaModel->findOsebaByEmail($data['oseba_email'])) {
                    $data['oseba_emailError'] = 'Ta email že obstaja vpiši novega';    
                }
    
                if (empty($data['oseba_imeError']) && empty($data['oseba_emailError']) && empty($data['oseba_telefonError'])) {
                    if ($this->osebaModel->addOseba($data)) {
                        header("Location: " . URLROOT . "/osebe");
                    } else {
                        die("Nekja je šlo narobe poskusi znova!");
                    }
                } else {
                    $this->view('osebe/create', $data);
                }
            }

            $this->view('osebe/create', $data);
        }

        //Oseba Pravna create
        public function create_pravna()
        {
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/osebe");
            }

            $data = [
                'oseba_ime' => '',
                'oseba_email' => '',
                'oseba_telefon' => '',
                'oseba_davcna' => '',
                'oseba_imeError' => '',
                'oseba_emailError' => '',                
                'oseba_telefonError' => '',
                'oseba_davcnaError' => '',
            ];
            

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                
                
                $data = [
                    'oseba_ime' => trim($_POST['oseba_ime']),
                    'oseba_email' => trim($_POST['oseba_email']),
                    'oseba_telefon' => trim($_POST['oseba_telefon']),
                    'oseba_davcna' => trim($_POST['oseba_davcna']),
                    'oseba_imeError' => '',
                    'oseba_emailError' => '',
                    'oseba_telefonError' => '',
                    'oseba_davcnaError' => ''
                ];
    
                if(empty($data['oseba_ime'])) {
                    $data['oseba_imeError'] = 'Ime osebe ni bilo vnešeneo';
                }

                if(empty($data['oseba_email'])) {
                    $data['oseba_emailError'] = 'E-mail ni bil vnešen';
                }

                if(empty($data['oseba_telefon'])) {
                    $data['oseba_telefonError'] = 'Telefonska številka ni bila vnešena';
                }

                if(empty($data['oseba_davcna'])) {
                    $data['oseba_davcnanError'] = 'Davčna številka ni bila vnešena';
                }

                if($this->osebaModel->findOsebaByDavcna($data['oseba_davcna'])) {
                    $data['oseba_davcnaError'] = 'Ta davčna številka že obstaja';    
                }
    
                if (empty($data['oseba_imeError']) && empty($data['oseba_emailError']) && empty($data['oseba_telefonError']) && empty($data['oseba_davcnaError'])) {
                    if ($this->osebaModel->addOseba($data)) {
                        header("Location: " . URLROOT . "/osebe");
                    } else {
                        die("Nekja je šlo narobe poskusi znova!");
                    }
                } else {
                    $this->view('osebe/create_pravna', $data);
                }
            }

            $this->view('osebe/create_pravna', $data);
        }

        public function read($id)
        {
            $oseba = $this->osebaModel->findById($id);

            $data = [
                'oseba' => $oseba,
                'oseba_id' => $oseba->oseba_id,
                'oseba_ime' => $oseba->oseba_ime,
                'oseba_email' => $oseba->oseba_email,
                'oseba_telefon' => $oseba->oseba_telefon,
                'oseba_davcna' => $oseba->oseba_davcna,
                'user_id' => $oseba->user_id,
            
            ];

            if(empty($data)) {
                echo "Ta stran ne obstaja";
            }else {
                $this->view('osebe/read', $data);
            }               
                
            
        }

        public function update($id) {

            $oseba = $this->osebaModel->findById($id);

            
    
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/");
            } elseif($oseba->user_id != $_SESSION['user_id']){
                header("Location: " . URLROOT . "/");
            }
    
            $data = [
                'oseba' => $oseba,
                'oseba_id' => $oseba->oseba_id,
                'oseba_ime' => $oseba->oseba_ime,
                'oseba_email' => $oseba->oseba_email,
                'oseba_telefon' => $oseba->oseba_telefon,
                'oseba_imeError' => '',
                'oseba_emailError' => '',
                'oseba_telefonError' => ''
            ];

            $oldEmail = $oseba->oseba_email;
    
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
                $data = [
                    'oseba_id' => $id,
                    'oseba' => $oseba,
                    'oseba_ime' => trim($_POST['oseba_ime']),
                    'oseba_email' => trim($_POST['oseba_email']),
                    'oseba_telefon' => trim($_POST['oseba_telefon']),
                    'oseba_imeError' => '',
                    'oseba_emailError' => '',
                    'oseba_telefonError' => ''
                ];
    
                if(empty($data['oseba_ime'])) {
                    $data['oseba_ime'] = 'Izpustil si imensko polje';
                }
    
                if(empty($data['oseba_email'])) {
                    $data['oseba_email'] = 'Izpustil si email';
                }

                if(empty($data['oseba_telefon'])) {
                    $data['oseba_telefon'] = 'Izpustil si telefon';
                }
                

                if($this->osebaModel->findOsebaByEmail($data['oseba_email']) && $data['oseba_email'] !== $oldEmail) {
                    $data['oseba_emailError'] = 'Email že obstaja';    
                }
                
                
                if (empty($data['oseba_imeError']) && empty($data['oseba_emailError']) && empty($data['oseba_telefonError'])) {
                    if ($this->osebaModel->updateOseba($data)) {
                        header("Location: " . URLROOT . "/osebe");
                    } else {
                        die("Nekaj je šlo narobe, prosim poskusi znova!");
                    }
                } else {
                    $this->view('osebe/update', $data);
                }
            }
    
            $this->view('osebe/update', $data);
        }

        public function update_pravna($id) {

            $oseba = $this->osebaModel->findById($id);

            
    
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/");
            } elseif($oseba->user_id != $_SESSION['user_id']){
                header("Location: " . URLROOT . "/");
            }
    
            $data = [
                'oseba' => $oseba,
                'oseba_id' => $oseba->oseba_id,
                'oseba_ime' => $oseba->oseba_ime,
                'oseba_email' => $oseba->oseba_email,
                'oseba_telefon' => $oseba->oseba_telefon,
                'oseba_davcna' => $oseba->oseba_davcna,

                'oseba_imeError' => '',
                'oseba_emailError' => '',
                'oseba_telefonError' => '',
                'oseba_davcnaError' => ''
            ];

            $oldDavcna = $oseba->oseba_davcna;
            $oldEmail = $oseba->oseba_email;
    
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
                $data = [
                    'oseba_id' => $id,
                    'oseba' => $oseba,
                    'oseba_ime' => trim($_POST['oseba_ime']),
                    'oseba_email' => trim($_POST['oseba_email']),
                    'oseba_telefon' => trim($_POST['oseba_telefon']),
                    'oseba_davcna' => trim($_POST['oseba_davcna']),
                    
                    'oseba_imeError' => '',
                    'oseba_emailError' => '',
                    'oseba_telefonError' => '',
                    'oseba_davcnaError' => ''
                ];
    
                if(empty($data['oseba_ime'])) {
                    $data['oseba_ime'] = 'Izpustil si imensko polje';
                }
    
                if(empty($data['oseba_email'])) {
                    $data['oseba_email'] = 'Izpustil si email';
                }

                if(empty($data['oseba_telefon'])) {
                    $data['oseba_telefon'] = 'Izpustil si telefon';
                }

                if(empty($data['oseba_davcna'])) {
                    $data['oseba_davcna'] = 'Izpustil si davčno številko';
                }
                

                if($this->osebaModel->findOsebaByEmail($data['oseba_email']) && $data['oseba_email'] !== $oldEmail) {
                    $data['oseba_emailError'] = 'Email že obstaja';    
                }
                
                if($this->osebaModel->findOsebaByDavcna($data['oseba_davcna']) && $data['oseba_davcna'] !== $oldDavcna) {
                    $data['oseba_davcnaError'] = 'Ta davčna številka že obstaja';    
                }
                
                if (empty($data['oseba_imeError']) && empty($data['oseba_emailError']) && empty($data['oseba_telefonError']) && empty($data['oseba_davcnaError'])) {
                    if ($this->osebaModel->updateOseba($data)) {
                        header("Location: " . URLROOT . "/osebe");
                    } else {
                        die("Nekaj je šlo narobe, prosim poskusi znova!");
                    }
                } else {
                    $this->view('osebe/update', $data);
                }
            }
    
            $this->view('osebe/update', $data);
        }

       
        public function delete($id) {

            $oseba = $this->osebaModel->findById($id);
    
            if(!isLoggedIn()) {
                header("Location: " . URLROOT . "/osebe");
            } elseif($oseba->user_id != $_SESSION['user_id']){
                header("Location: " . URLROOT . "/osebe");
            }
    
            // $data = [
            //     'skupina' => $skupina,
            //     'skupina_ime' => '',
            //     'skupina_imeError' => ''
            // ];
    
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
                if($this->osebaModel->deleteOseba($id)) {
                        header("Location: " . URLROOT . "/osebe");
                } else {
                   die('Something went wrong!');
                }
            }
        }

        public function poslji_sms()
        {
            $data = [
                   
                    'oseba_ime' => '',
                    'sms_msg' => '',
                    
                    'oseba_imeError' => '',
                    'sms_msgError' => '',
                    'sucsess' => ''
                    
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'oseba_ime' => trim($_POST['oseba_ime']),
                    'sms_msg' => trim($_POST['sms_msg']),

                    'oseba_imeError' => '',
                    'sms_msgError' => '',
                    'sucsess' => ''
                    
                ];

                if(empty($data['oseba_ime'])) {
                    $data['oseba_imeError'] = 'Ime osebe ni bilo vnešeneo';
                }

                if(empty($data['sms_msg'])) {
                    $data['sms_msgError'] = 'Sms ni bil vnešen';
                }

                if(is_null($this->osebaModel->findOsebaByIme($data['oseba_ime']))) {
                    $data['oseba_imeError'] = 'Ta oseba ne obstaja';    
                }
    
                if (empty($data['oseba_imeError']) && empty($data['sms_msgError'])) {
                    $oseba = $this->osebaModel->findOsebaByIme($data['oseba_ime']);
                    
                    $this->smsApi->posljiSms($oseba->oseba_telefon, $data['sms_msg']);
                    
                    //Zmanjšamo count 
                    $this->apiModel->decrementOne(get_class($this->smsApi));
                    // if () {
                    //     header("Location: " . URLROOT . "/osebe");
                    // } else {
                    //     die("Nekja je šlo narobe poskusi znova!");
                    // }
                } else {
                    $this->view('osebe/poslji_sms', $data);
                }
            }

            $this->view('osebe/poslji_sms', $data);
        
        }

    }