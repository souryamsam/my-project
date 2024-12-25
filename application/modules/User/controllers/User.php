<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model', 'login_model');
        $this->load->model('User_model', 'user_model');
    }

    public function login()
    {
        if ($this->session->userdata('userid'))
            return redirect(base_url($this->session->userdata("fav_Page")));
        $data["page_title"] = 'Login';
        $this->load->view('User/login_template', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata(array('__ci_last_regenerate', 'userid', 'cnciot_sessions', 'fav_Page', 'user_status', 'user_code', 'user_id', 'password', 'fav_pages', 'user_data', 'user_group_code', 'menus', 'room_data', 'selected_room'));
        session_destroy();
        return redirect(base_url('login'));
    }

    public function user_logging_in()
    {
        /* if($this->session->userdata('userid'))
            return redirect(base_url($this->session->userdata("fav_Page"))); */
        $rules = array(
            array(
                "field" => "userid",
                "label" => "User Id",
                "rules" => "trim|required"
            ),
            array(
                "field" => "password",
                "label" => "Password",
                "rules" => "trim|required|min_length[4]|max_length[20]"
            )
        );
        $this->form_validation->set_error_delimiters('<span class="invalid-feedback" style="display:block;">', '</span>');
        $this->form_validation->set_rules($rules);
        if (!$this->form_validation->run()) {
            $this->login();
            /* $errors = array("status"=>'0',"message"=>strip_tags(validation_errors()));
            $this->session->set_flashdata("login_msg",$errors);
            redirect(base_url("login")); */
        } else {
            $postdata = $this->security->xss_clean($_POST);
            $output = $this->login_model->doLogin($postdata["userid"], $postdata["password"]);
            $this->session->set_flashdata(array("login_msg" => $output, 'data' => array("username" => $postdata["userid"], "password" => $this->my_encryption->encrypt($postdata["password"]))));
            redirect(base_url("login"));
        }
    }

    public function save_favorite_pages()
    {
        if ($this->session->userdata('userid'))
            return redirect(base_url());
        $postdata = $this->security->xss_clean($_POST);
        $output = $this->login_model->saveFouritepages($postdata);
        $this->session->set_flashdata("login_msg", $output);
        redirect(base_url("login"));
    }

    public function profile()
    {
        if (!$this->session->userdata('userid'))
            return redirect(base_url('login'));
        /* $data["page_header_name"] = 'Profile';
        $data["page_title"] = 'Profile';
        $data["icon"] = "fa fa-chevron-right";
        $data["icon_color"] = "#000000"; */
        $data['userdata'] = $this->user_model->userdata();
        $data["content_view"] = 'User/profile_template';
        $this->template->base_template($data);
    }

    public function get_state_against_country_id()
    {
        $userdata = $this->user_model->userdata();
        $state_data = isset($userdata[2]) ? $userdata[2] : array();
        $country_id = $this->my_encryption->decrypt($_POST["country_id"]);
        $states = all_states($state_data, $country_id);
        echo json_encode($states);
    }

    public function check_old_password()
    {
        $this->form_validation->set_rules("old_password", "Current Password", "trim|required");
        if ($this->form_validation->run()) {
            $old_password = $this->input->post('old_password');
            $result = $this->user_model->checkOldpassword($old_password);
            if ($result == "YES") {
                echo json_encode(array('status' => '1', 'message' => 'Password has been verified successfully.'));
            } else {
                echo json_encode(array('status' => '0', 'message' => "The current password does not exist."));
            }
        } else {
            echo json_encode(array('status' => '0', 'message' => strip_tags(validation_errors())));
        }
    }

    public function update_user_password()
    {
        $rules = array(
            array(
                'field' => 'password',
                'label' => 'New password',
                'rules' => 'required|min_length[4]|max_length[30]'
            ),
            array(
                'field' => 'c_password',
                'label' => 'Confirm password',
                'rules' => 'required|min_length[4]|max_length[30]|matches[password]'
            )
        );
        $this->form_validation->set_rules($rules);
        if (!$this->form_validation->run()) {
            $errors = strip_tags(validation_errors());
            echo json_encode(array('status' => '0', 'message' => $errors));
        } else {
            $res = $this->user_model->update_user_password($this->input->post(), reqstpage());
            echo json_encode($res);
        }
    }

    public function updateuser()
    {
        $user_data = $this->user_model->userdata();
        $currentdata = array(
            'user_id' => $this->my_encryption->decrypt($this->session->userdata('userid')),
            'dob' => $this->input->post('dob'),
            'contact_no' => $user_data[0][0]['CONTACT_NUMBER'],
            'alt_contact_no' => $this->input->post('alt_contact_no'),
            'country_code' => $this->my_encryption->decrypt($this->input->post('country')),
            'state_code' => $this->my_encryption->decrypt($this->input->post('state')),
            'pin' => $this->input->post('pincode'),
            'address' => $this->input->post('address'),
            'email' => $this->input->post('email'),
            'image' => $this->input->post('profilefilename')

        );
        $result = $this->user_model->update_user($currentdata);
        $this->session->set_flashdata('update_msg', $result);
        redirect(base_url('profile'));
    }

    public function update_profile_image()
    {
        /* $config['upload_path'] = './resources/images/';
        $array = explode('.', $_FILES['profile_image']['name']);
        $extension = end($array);
        $config['allowed_types'] = 'jpg|png|jpeg';
        $file_name = time() .'.'. $extension;
        $config['file_name'] = $file_name; */
        $imgfile = explode('.', $_FILES['profile_image']['name']);
        $img = time() . '.' . end($imgfile);
        $config['upload_path'] = './resources/images/';
        $config['file_name'] = $img;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 109700;
        if (!is_dir($config['upload_path']))
            die("THE UPLOAD DIRECTORY DOES NOT EXIST");
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('profile_image')) {
            $image = $this->upload->data();
            $name = $image['file_name'];
            echo json_encode(array('status' => '1', 'message' => 'Image has been upload successfully.', 'file' => $name));
        } else {
            echo json_encode(array('status' => '0', 'message' => 'Something went wrong!.', ));
        }
    }

    public function change_password()
    {
        $rules = array(
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[6]|max_length[30]'
            ),
            array(
                'field' => 'c_password',
                'label' => 'Retype password',
                'rules' => 'trim|required|min_length[6]|max_length[30]|matches[password]'
            )
        );
        $this->form_validation->set_error_delimiters('<span class="invalid-feedback" style="display:block;">', '</span>');
        $this->form_validation->set_rules($rules);
        if (!$this->form_validation->run()) {
            $errors = strip_tags(validation_errors());
            echo json_encode(array('status' => '0', 'message' => $errors));
        } else {
            $postdata = $this->security->xss_clean($_POST);
            $old_password = $postdata["old_password"];
            $password = $postdata["password"];
            $result = $this->user_model->change_password($old_password, $password);
            $this->session->set_flashdata('update_msg', $result);
            if ($result['status'] == 1) {
                redirect(base_url('logout'));
            } else {
                redirect(base_url('profile'));
            }
        }
    }
    public function user_master()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata['mode']) && $postdata['mode'] == 'edit_user') {
            $single_data = $this->user_model->get_single_user_master_data($postdata);
            $data['user_single_data'] = $single_data[0][0];
        }
        $user_master_page_data = $this->user_model->user_master_pageload_data();
        if ($user_master_page_data[0][0]['STATUS'] == 'NO') {
            return redirect(base_url("access-denied"));
        }
        $data['department_data'] = $user_master_page_data[1];
        $data['designation_data'] = $user_master_page_data[2];
        $data['country_data'] = $user_master_page_data[3];
        $data['set_role'] = $user_master_page_data[4];
        $data["content_view"] = 'User/user_master';
        $this->template->base_template($data);
    }
    public function user_master_insert()
    {
        $rules = array(
            array(
                'field' => 'user_name',
                'label' => 'Name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'user_dep',
                'label' => 'Department',
                'rules' => 'required'
            ),
            array(
                'field' => 'user_designation',
                'label' => 'Designation',
                'rules' => 'required'
            ),
            array(
                'field' => 'user_contact_no',
                'label' => 'Contact No.',
                'rules' => 'trim|required|min_length[10]|max_length[10]'
            ),
            array(
                'field' => 'user_dob',
                'label' => 'DOB',
                'rules' => 'required'
            ),
            array(
                'field' => 'user_email',
                'label' => 'Email',
                'rules' => 'valid_email'
            ),
            array(
                'field' => 'user_country',
                'label' => 'Country',
                'rules' => 'required'
            ),
            array(
                'field' => 'user_country',
                'label' => 'Country',
                'rules' => 'required'
            ),
            array(
                'field' => 'user_state',
                'label' => 'State',
                'rules' => 'required'
            ),
            array(
                'field' => 'user_pincode',
                'label' => 'Pincode',
                'rules' => 'required|min_length[6]|max_length[6]'
            ),
            array(
                'field' => 'user_address',
                'label' => 'Address',
                'rules' => 'required'
            ),
            array(
                'field' => 'set_role[]',
                'label' => 'Set Role',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $this->user_master();
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $config['upload_path'] = './resources/uploads/user_image';
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = date('YmdHis');
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!empty($_FILES['user_photo']['name']) && $this->upload->do_upload('user_photo')) {
                $fileData = $this->upload->data();
                $postdata['user_photo'] = $fileData['file_name'];
            } else {
                $postdata['user_photo'] = $postdata['existing_photo_path'];
            }
            $result = $this->user_model->user_master_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('create-user'));
        }
    }
    public function view_user_master()
    {
        $data["page_title"] = 'Room Service Type';
        $view_user_data = $this->user_model->view_user_master();
        if ($view_user_data[0][0]['STATUS'] == 'NO') {
            return redirect(base_url("access-denied"));
        }
        $data['user_data'] = $view_user_data[1];
        $data["card_title"] = 'Room Service Type';
        $data["content_view"] = 'User/view_user_master';
        $this->template->base_template($data);
    }
    public function inactive_data_view_user_master()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->user_model->inactive_data_view_user_master($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("user-list"));
    }
    public function duplicate_checking_user_master()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->user_model->duplicate_checking_user_master($postdata);
        echo json_encode($result);
    }
    public function create_role()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata['mode']) && $postdata['mode'] == 'edit_role') {
            $ug_id = $this->my_encryption->decrypt($postdata["custom_id"]);
        } else {
            $ug_id = '';
        }
        $user_role_data = $this->user_model->pageload_user_role_master($ug_id);
        if ($user_role_data[0][0]['STATUS'] == 'NO') {
            return redirect(base_url("access-denied"));
        }
        $data['privileges'] = $user_role_data[1];
        $data['super_menus'] = $user_role_data[2];
        $data['sub_menus'] = $user_role_data[3];
        $data['role_name'] = isset($user_role_data[4][0]) ? $user_role_data[4][0] : '';
        $data['pages'] = $user_role_data[5];
        $data['privilege'] = $user_role_data[6];
        $data["content_view"] = 'User/create_role';
        $this->template->base_template($data);
    }
    public function create_role_insert()
    {
        $rules = array(
            array(
                'field' => 'role_name',
                'label' => 'Role Name',
                'rules' => 'trim|required'
            ),
            /* array(
                'field' => 'page_id[]',
                'label' => 'Page',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'privilege_id[]',
                'label' => 'Privilege',
                'rules' => 'trim|required'
            ) */
        );
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == false) {
            $this->create_role();
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->user_model->insert_update_user_role_master($postdata);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('create-role'));
        }
    }

    public function view_role()
    {
        $view_role_data = $this->user_model->pageload_role_list_view();
        $data["view_role_page_data"] = $view_role_data[0];
        $data["content_view"] = 'User/view_role';
        $this->template->base_template($data);
    }

    public function role_name_duplicate_checking()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->user_model->role_name_duplicate_checking($postdata);
        echo json_encode($result);
    }
    public function update_role_master_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->user_model->update_role_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("role-list-view"));
    }
}