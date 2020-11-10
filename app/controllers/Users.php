<?php 
    class Users extends Controller {
        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        

        public function login()
        {
            $data = [
                'title' => 'Login page',
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => '',
            ];

            //Preveri metodo
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'usernameError' => '',                    
                    'passwordError' => ''                    
                ];

                

                //Validacija

                if(empty($data['username'])) {
                    $data['usernameError'] = 'Please enter a username';
                }

                if(empty($data['password'])) {
                    $data['passwordError'] = 'Please enter a password';
                }

                if(empty($data['usernameError']) && empty($data['passwordError'])) {
                    
                    $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                    

                    if($loggedInUser) {
                        $this->createUserSession($loggedInUser);
                        header('location: ' . URLROOT . '/osebe');
                    } else {
                        $data['passwordError'] = 'Password or Username incorrect. Please try again.';

                        $this->view('users/login', $data);
                    }
                }

            }
            else {
                $data = [
                    'username' => '',
                    'password' => '',
                    'usernameError' => '',
                    'passwordError' => '',
                ];
            }

            $this->view('users/login', $data);
        }

        public function logout()
        {
            //Session unset
            session_destroy();

            // unset($_SESSION['user_id']);
            // unset($_SESSION['username']);
            // unset($_SESSION['email']);

            header('location:' . URLROOT . '/users/login');
        }

        public function register()
        {
            $data = [
                'username' => '',
                'password' => '',
                'confirmPassword' => '',
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => '',
                
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirmPassword' => trim($_POST['confirmPassword']),
                    'usernameError' => '',
                    'emailError' => '',
                    'passwordError' => '',
                    'confirmPasswordError' => ''
                ];

                
                
                //RegX match 
                $nameValidation = "/^[a-zA-Z0-9]*$/";
                $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

                //Validacija usernamea
                if (empty($data['username'])) {
                    $data['usernameError'] = 'Please enter username.';
                } elseif (!preg_match($nameValidation, $data['username'])) {
                    $data['usernameError'] = 'Name can only contain letters and numbers';
                }
                //Validacija emaila
                if (empty($data['email'])) {
                    $data['emailError'] = 'Please enter email address.';
                } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $data['emailError'] = 'Please enter the correct format';    
                }else {
                    if ($this->userModel->findUserByEmail($data['email'])) {
                        $data['emailError'] = 'Email is already taken.'; 
                    }
                }
                //Validacija passworda
                if(empty($data['password'])) {
                    $data['passwordError'] = 'Please enter password.';
                } elseif (strlen($data['password']) < 8) {
                    $data['passwordError'] = 'Password must be at least 8 chars.';
                } elseif (!preg_match($passwordValidation, $data['username'])) {
                    $data['passwordError'] = 'Password must have at least one numeric value';
                }
                
                //Validacija potrditvenega passworda
                if(empty($data['confirmPassword'])) {
                    $data['passwordError'] = 'Please enter password.';
                } else {
                    if ($data['password'] != $data['confirmPassword']) {
                        $data['confirmPasswordError'] = 'Password do not match, please try again';
                    }
                }
                if (empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    
                    //Registriraj userja iz modela
                    
                    if ($this->userModel->register($data)) {
                        //Redirect to the login page
                        header('location: ' . URLROOT . '/users/login');
                    } else {
                        die ('Ni našlo URL-a');
                    }
                } 
            }
            //Prepričaj se, da so errors prazne
            
            $this->view('users/register', $data);
        }

        public function createUserSession($user)
        {

            //Session startamo v helperju
            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
        }
    }