<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid'))
            return redirect('login');
        $this->load->model('Master_model', 'master_model');
        $this->load->model('Booking/Booking_model', 'booking_model');
    }

    public function category_master()
    {
        $data["page_title"] = 'Item Category Master';
        $data["card_title"] = 'Item Category';
        $data["content_view"] = 'Master/category_master_card';
        $this->template->base_template($data);
    }

    public function room_service_type()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["content_view"] = 'Master/room_service_type_master_card';
        $this->template->base_template($data);
    }

    public function save_room_service_type()
    {

        $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect(base_url('room-service-type'));
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->supplier_name_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            redirect(base_url('room-service-type'));
        }
    }
    public function supplier_master_card()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $mode = $this->security->xss_clean($this->input->post('mode'));
        $supplier_id = $this->security->xss_clean($this->input->post('custom_id'));
        if (isset($mode) && $mode == 'edit_supplier_list') {
            $data['single_supplier_data'] = $this->master_model->get_single_supplier_item_data($supplier_id);
        }
        $supplier_master_card_pageload_data = $this->master_model->get_supplier_master_records();
        $data["contry_data"] = $supplier_master_card_pageload_data[0];
        $data["state_data"] = $supplier_master_card_pageload_data[1];
        $data["district_data"] = $supplier_master_card_pageload_data[2];
        $data["content_view"] = 'Master/supplier_master_card';
        $this->template->base_template($data);
    }
    public function fetch_state_data()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->fetch_state_data($postdata);
        $state = [];
        if (!empty($result[0])) {
            foreach ($result[0] as $value) {
                $state[] = array(
                    "STATE_CODE" => $value["STATE_CODE"],
                    "STATE_NAME" => $value["STATE_NAME"],
                    "EN_STATE_CODE" => $this->my_encryption->encrypt($value["STATE_CODE"])
                );
            }
        }
        if (!empty($state)) {
            echo json_encode(array('status' => '1', 'message' => 'success', 'data' => $state));
        } else {
            echo json_encode(array('status' => '0', 'message' => 'error'));
        }
    }
    public function fetch_district_data()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->fetch_district_data($postdata);
        $district = [];
        if (!empty($result[0])) {
            foreach ($result[0] as $value) {
                $district[] = array(
                    "DISTRICT_CODE" => $value["DISTRICT_CODE"],
                    "DISTRICT" => $value["DISTRICT"],
                    "EN_DISTRICT_CODE" => $this->my_encryption->encrypt($value["DISTRICT_CODE"])
                );
            }
        }
        if (!empty($district)) {
            echo json_encode(array('status' => '1', 'message' => 'success', 'data' => $district));
        } else {
            echo json_encode(array('status' => '0', 'message' => 'error'));
        }
    }
    public function save_supplier_master_data()
    {

        $rules = array(
            array(
                'field' => 'supplier_shop_name',
                'label' => 'Supplier Shop Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'supplier_contact_no',
                'label' => 'Supplier Contact No',
                'rules' => 'required|min_length[10]|max_length[10]'
            ),
            array(
                'field' => 'supplier_contact_person',
                'label' => 'Supplier Contact Person',
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'valid_email'
            ),
            array(
                'field' => 'address_one',
                'label' => 'Address Line - 1',
                'rules' => 'required'
            ),
            array(
                'field' => 'country',
                'label' => 'Country',
                'rules' => 'required'
            ),
            array(
                'field' => 'state',
                'label' => 'State',
                'rules' => 'required'
            ),
            array(
                'field' => 'district',
                'label' => 'District',
                'rules' => 'required'
            ),
            array(
                'field' => 'pincode',
                'label' => 'Pincode',
                'rules' => 'required|min_length[6]|max_length[6]'
            ),
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->supplier_master_card();
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->supplier_master_card_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('supplier-master'));

        }

    }
    public function supplier_list_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["supplier_master_data"] = $this->master_model->supplier_master_view();
        $data["content_view"] = 'Master/supplier_list_view';
        $this->template->base_template($data);
    }
    public function update_supplier_list_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_supplier_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-supplier"));
    }
    /* public function update_supplier_master_status(){
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_supplier_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("supplier-list-view"));
    } */

    public function supplier_list_view_page()
    {

        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["supplier_data"] = $this->master_model->get_supplier_data();
        $data["content_view"] = 'Master/supplier_list_view_page';
        $this->template->base_template($data);
    }
    public function supplier_name_view_page()
    {
        $data["page_title"] = 'Item Category Master';
        $data["card_title"] = 'Item Category';
        $data["supplier_name"] = $this->master_model->get_supplier_data();
        $data["content_view"] = 'Master/supplier_name_view_page';
        $this->template->base_template($data);
    }

    public function department_name_type_master()
    {
        $data["page_title"] = 'Item Category Master';
        $data["card_title"] = 'Item Category';
        $data["content_view"] = 'Master/department_name_card';
        $this->template->base_template($data);
    }

    public function department_name_type_master_insert()
    {

        $this->form_validation->set_rules('department_name', 'department name', 'required');
        if ($this->form_validation->run() == FALSE) {
            redirect(base_url('department-master'));
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->department_name_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            redirect(base_url('department-master'));
        }
    }
    public function department_list_view_page()
    {
        $data["page_title"] = 'Item Category Master';
        $data["card_title"] = 'Item Category';
        $data["department_name"] = $this->master_model->get_department_name_data();
        $data["content_view"] = 'Master/department_list_view_page';
        $this->template->base_template($data);
    }
    public function user_master()
    {
        $data["page_title"] = 'User Master';
        $data["card_title"] = 'User Master';
        $data["user_data"] = $this->master_model->get_user_master_records();
        $data["content_view"] = 'Master/user_master';
        $this->template->base_template($data);
    }
    public function user_master_data_insert()
    {
        $this->form_validation->set_rules('user_name', 'User Name', 'required');
        $this->form_validation->set_rules('contact_no', 'Contact No', 'required');
        $this->form_validation->set_rules('dob', 'DOB', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('p_address', 'Parmanent Address', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            $data["page_title"] = 'Item Category Master';
            $data["card_title"] = 'Item Category';
            $data["content_view"] = 'Master/user_master';
            $this->template->base_template($data);
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->user_master_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            redirect(base_url('user-master'));
        }
    }
    public function item_master_card()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["content_view"] = 'Master/item_master_card';
        $data['uom_modal'] = 'Master/modal/uom_modal';
        $mode = $this->security->xss_clean($this->input->post('mode'));
        $record_id = $this->security->xss_clean($this->input->post('custom_id'));
        if (isset($mode) && $mode == 'edit_item_list') {
            $data['single_item_data'] = $this->master_model->get_single_item_master_data($record_id);
            // print_r($data['single_item_data']);
            // die;
        }
        $data_item_master_pageload = $this->master_model->item_master_pageload();
        $data['item_type'] = $data_item_master_pageload[0];
        // $data['item_category'] = $data_item_master_pageload[1];
        $data['uom_data'] = $data_item_master_pageload[1];
        $data['manufacturer_data'] = $data_item_master_pageload[2];
        $data['manufacturer_modal'] = 'Master/modal/manufacturer_modal';
        $this->template->base_template($data);
    }
    public function fetch_item_category_data()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->fetch_item_category_data($postdata);
        $item = [];
        if (!empty($result[1])) {
            foreach ($result[1] as $value) {
                $item[] = array(
                    "RECORD_ID" => $value["RECORD_ID"],
                    "RECORD_NAME" => $value["RECORD_NAME"],
                    "EN_RECORD_ID" => $this->my_encryption->encrypt($value["RECORD_ID"])
                );
            }
        }
        if (!empty($item)) {
            echo json_encode(array('status' => '1', 'message' => 'success', 'data' => $item));
        } else {
            echo json_encode(array('status' => '0', 'message' => 'error'));
        }
    }
    public function uom_data_bind()
    {
        $room_master_pageload_data = $this->master_model->item_master_pageload();
        $uom_data = $room_master_pageload_data[1];
        $uom = [];
        if (!empty($uom_data)) {
            foreach ($uom_data as $value) {
                $uom[] = array(
                    "RECORD_ID" => $value["RECORD_ID"],
                    "RECORD_NAME" => $value["RECORD_NAME"],
                    "EN_RECORD_ID" => $this->my_encryption->encrypt($value["RECORD_ID"])
                );
            }
        }
        echo json_encode($uom);
    }
    public function manufacturer_data_bind()
    {
        $room_master_pageload_data = $this->master_model->item_master_pageload();
        $manufacturer_data = $room_master_pageload_data[2];
        $manufacturer = [];
        if (!empty($manufacturer_data)) {
            foreach ($manufacturer_data as $value) {
                $manufacturer[] = array(
                    "RECORD_ID" => $value["RECORD_ID"],
                    "RECORD_NAME" => $value["RECORD_NAME"],
                    "EN_RECORD_ID" => $this->my_encryption->encrypt($value["RECORD_ID"])
                );
            }
        }
        echo json_encode($manufacturer);
    }
    public function item_master_card_insert()
    {

        $rules = array(
            array(
                'field' => 'item_category_name',
                'label' => 'Item Category',
                'rules' => 'required'
            ),
            array(
                'field' => 'item_name',
                'label' => 'Item Name',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'uom',
                'label' => 'UOM',
                'rules' => 'required'
            ),
            array(
                'field' => 'manufacturer',
                'label' => 'Manufacturer',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->item_master_card();
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->item_master_card_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('item-master'));
        }
    }
    public function uom_modal_insert()
    {

        $rules = array(
            array(
                'field' => 'uom',
                'label' => 'Add New Unit',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => '0', 'message' => strip_tags(validation_errors())));
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->item_master_uom_insert($postdata);
            echo json_encode($result);
        }
    }
    public function manufacturer_modal_insert()
    {

        $rules = array(
            array(
                'field' => 'manufacturer_name',
                'label' => 'Manufacturer Name',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => '0', 'message' => strip_tags(validation_errors())));
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->item_master_manufacturer_insert($postdata);
            echo json_encode($result);
        }
    }
    public function item_master_card_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata["item_value"]) && $postdata["item_value"] == 'item_search_value') {
            $item_master_data = $this->master_model->item_master_card_view($postdata);
            $data['item_data'] = $item_master_data[1];
        } else {
            $item_master_data = $this->master_model->item_master_card_view($postdata);
            $data['item_data'] = $item_master_data[1];
        }
        $data_item_master_pageload = $this->master_model->item_master_pageload();
        $data['item_type'] = $data_item_master_pageload[0];
        $data["content_view"] = 'Master/item_master_card_view';
        $this->template->base_template($data);
    }
    public function update_item_master_card_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_item_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-item"));
    }
    public function bed_type_master()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $mode = $this->security->xss_clean($this->input->post('mode'));
        $bed_id = $this->security->xss_clean($this->input->post('custom_id'));
        if (isset($mode) && $mode == 'edit_bed_type') {
            $data['single_bed_data'] = $this->master_model->get_single_bad_data($bed_id);
        }
        $data["content_view"] = 'Master/bed_type_master';
        $this->template->base_template($data);
    }
    public function bed_type_master_insert()
    {

        $rules = array(
            array(
                'field' => 'bed_type',
                'label' => 'Bed Type',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->bed_type_master();

        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->bed_type_master_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            redirect(base_url('bed-type-master'));

        }
    }
    public function update_bed_type_master_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_bed_type_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-bed-type"));
    }
    public function bed_type_master_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["bed_master"] = $this->master_model->bed_type_master_view();
        $data["content_view"] = 'Master/bed_type_master_view';
        $this->template->base_template($data);
    }
    public function room_category_master()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $mode = $this->security->xss_clean($this->input->post('mode'));
        $room_id = $this->security->xss_clean($this->input->post('custom_id'));
        if (isset($mode) && $mode == 'edit_room_type') {
            $data['single_room_data'] = $this->master_model->get_single_room_data($room_id);
        }
        $data["content_view"] = 'Master/room_category_master';
        $this->template->base_template($data);
    }
    public function room_category_master_insert()
    {

        $rules = array(
            array(
                'field' => 'room_cate',
                'label' => 'Room Category',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->room_category_master();
        } else {

            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->room_category_master_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('room-category-master'));
        }
    }
    public function update_room_category_master_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_room_category_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-room-category"));
        // $postdata = $this->security->xss_clean($this->input->post());
        // $result = $this->master_model->update_room_category_master_status($postdata);
        // $this->session->set_flashdata("update_msg", $result);
        // echo json_encode($result);
    }
    public function room_category_master_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["room_category_master"] = $this->master_model->room_category_master_view();
        $data["content_view"] = 'Master/room_category_master_view';
        $this->template->base_template($data);
    }
    public function room_master()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $mode = $this->security->xss_clean($this->input->post('mode'));
        $room_id = $this->security->xss_clean($this->input->post('custom_id'));
        if (isset($mode) && $mode == 'edit_room') {
            $data['single_room_data'] = $this->master_model->get_single_room_master_data($room_id);
        }
        $room_master_pageload_data = $this->master_model->room_master_pageload_data();
        $data['block_data'] = $room_master_pageload_data[0];
        $data['floor_data'] = $room_master_pageload_data[1];
        $data['room_category_data'] = $room_master_pageload_data[2];
        $data['room_type_data'] = $room_master_pageload_data[3];
        $data['bed_type_data'] = $room_master_pageload_data[4];
        $data['room_amenities_data'] = $room_master_pageload_data[5];
        $data['room_amenities_modal'] = 'Master/modal/room_amenities_modal';
        $data["content_view"] = 'Master/room_master';
        $this->template->base_template($data);
    }
    public function room_amenities_bind()
    {
        $room_master_pageload_data = $this->master_model->room_master_pageload_data();
        $room_amenities_data = $room_master_pageload_data[5];
        $amenities = [];
        if (!empty($room_amenities_data)) {
            foreach ($room_amenities_data as $value) {
                $amenities[] = array(
                    "RECORD_ID" => $value["RECORD_ID"],
                    "RECORD_NAME" => $value["RECORD_NAME"],
                    "EN_RECORD_ID" => $this->my_encryption->encrypt($value["RECORD_ID"])
                );
            }
        }
        echo json_encode($amenities);
    }
    public function block_wise_floor_master()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $mode = $this->security->xss_clean($this->input->post('mode'));
        $block_id = $this->security->xss_clean($this->input->post('custom_id'));
        if (isset($mode) && $mode == 'edit_block_wise_floor') {
            $data['single_block_data'] = $this->master_model->get_block_wise_floor_master_data($block_id);
        }
        $block_wise_floor_master_pageload_data = $this->master_model->get_block_wise_floor_master_records();
        $data['block_name_data'] = $block_wise_floor_master_pageload_data[0];
        $data["content_view"] = 'Master/block_wise_floor_master';
        $this->template->base_template($data);
    }
    public function block_wise_floor_master_insert()
    {

        $rules = array(
            array(
                'field' => 'block_name',
                'label' => 'Block Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'floor_name',
                'label' => 'Floor Name',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->block_wise_floor_master();
        } else {

            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->block_wise_floor_master_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('block-wise-floor-master'));
        }
    }
    public function block_wise_floor_master_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["block_wise_floor"] = $this->master_model->block_wise_floor_master_view();
        $data["content_view"] = 'Master/block_wise_floor_master_view';
        $this->template->base_template($data);
    }
    public function update_block_wise_floor_master_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_block_wise_floor_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-block-wise-floor"));
    }
    public function item_category_master_card()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $mode = $this->security->xss_clean($this->input->post('mode'));
        $item_id = $this->security->xss_clean($this->input->post('custom_id'));
        if (isset($mode) && $mode == 'edit_item') {
            $data['single_item_data'] = $this->master_model->get_single_item_category_master_data($item_id);
        }
        $item_category_master_card_pageload_data = $this->master_model->pageload_item_category_master();
        $data['parent_category_data'] = $item_category_master_card_pageload_data[1];
        $data["content_view"] = 'Master/item_category_master_card';
        $this->template->base_template($data);
    }
    public function item_category_master_card_insert()
    {

        $rules = array(
            array(
                'field' => 'pa_category',
                'label' => 'Parent Category',
                'rules' => 'required'
            ),
            array(
                'field' => 'child_category',
                'label' => 'Child Category',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->item_category_master_card();

        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->item_category_master_card_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('item-category-master'));
        }

    }
    public function item_category_master_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["item_category_data"] = $this->master_model->item_category_master_view();
        $data["content_view"] = 'Master/item_category_master_view';
        $this->template->base_template($data);
    }
    public function update_item_category_master_master_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_item_category_master_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-category-master"));
    }
    public function room_amenities_master_insert()
    {

        $rules = array(
            array(
                'field' => 'amenities',
                'label' => 'Amenities',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => '0', 'message' => strip_tags(validation_errors())));
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $output = $this->master_model->room_amenities_master_insert($postdata);
            echo json_encode($output);
        }

    }

    public function save_room_master()
    {


        if (isset($_POST['room_type'])) {
            $room_type = $this->my_encryption->decrypt($_POST['room_type']);

            if ($room_type == 'R_9_1') {
                $this->form_validation->set_rules('room_price_ac', 'AC Room Price', 'required');
                $this->form_validation->set_rules('room_price_nonac', 'Non-AC Room Price', 'required');

            } elseif ($room_type == 'R_9_2') {
                $this->form_validation->set_rules('room_price_nonac', 'Non-AC Room Price', 'required');
            }

        } else {
            $room_type = '';
        }



        $rules = array(
            array(
                'field' => 'block_no',
                'label' => 'Block No',
                'rules' => 'required'
            ),
            array(
                'field' => 'floor_no',
                'label' => 'Floor No',
                'rules' => 'required'
            ),
            array(
                'field' => 'room_no',
                'label' => 'Room No',
                'rules' => 'required'
            ),
            array(
                'field' => 'room_size',
                'label' => 'Room Size',
                'rules' => 'required'
            ),
            array(
                'field' => 'room_category',
                'label' => 'Room Category',
                'rules' => 'required'
            ),
            array(
                'field' => 'room_type',
                'label' => 'Room Type',
                'rules' => 'required'
            ),
            array(
                'field' => 'floor_no',
                'label' => 'Floor No',
                'rules' => 'required'
            ),
            array(
                'field' => 'guest_capacity',
                'label' => 'Guest Capacity',
                'rules' => 'required'
            ),
            array(
                'field' => 'bed_type',
                'label' => 'Bed Type',
                'rules' => 'required'
            ),
            /* array(
                'field' => 'room_price_ac',
                'label' => 'AC Room Price',
                'rules' => 'required'
            ),
            array(
                'field' => 'room_price_nonac',
                'label' => 'Non-AC Room Price',
                'rules' => 'required'
            ), */
            array(
                'field' => 'extra_guests',
                'label' => 'Extra Guests',
                'rules' => 'required'
            ),
            array(
                'field' => 'amenities[]',
                'label' => 'Amenities',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->room_master();
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $output = $this->master_model->save_room_master_record($postdata);
            $this->session->set_flashdata("message", $output);
            return redirect(base_url('room-master'));
        }
    }

    public function check_duplicate_room_no($room_no)
    {
        if ($this->master_model->check_duplicate_room_no($room_no)) {
            $this->form_validation->set_message('check_duplicate_room_no', 'The Room No already exists.');
            return false;
        } else {
            return true;
        }
    }

    public function upload_room_image()
    {
        if (isset($_FILES["room_image"]["name"]) && !empty($_FILES["room_image"]["name"][0])) {
            $this->load->library("upload");
            $file_count = count($_FILES["room_image"]["name"]);
            $uploaded_files = [];
            $error = [];
            for ($i = 0; $i < $file_count; $i++) {
                $filename = explode(".", $_FILES["room_image"]["name"][$i]);
                $rename_file = time() . "_" . geterate_uniqid() . "." . end($filename);

                $config["upload_path"] = "resources/room_image/";
                $config["file_name"] = $rename_file;
                $config["allowed_types"] = "jpg|jpeg|png|gif|bmp|webp";
                $this->upload->initialize($config);

                $_FILES['file']['name'] = $_FILES['room_image']['name'][$i];
                $_FILES['file']['type'] = $_FILES['room_image']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['room_image']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['room_image']['error'][$i];
                $_FILES['file']['size'] = $_FILES['room_image']['size'][$i];

                if (!$this->upload->do_upload('file')) {
                    $error[] = $this->upload->display_errors();
                } else {

                    $uploaded_files[] = $rename_file;
                }
            }

            if (empty($error)) {
                // $uploaded_file_names = implode(",", $uploaded_files);
                $response = ['status' => 1, 'message' => 'Successfully uploaded all files!', 'file_name' => $uploaded_files];
            } else {
                $response = ['status' => 0, 'message' => 'Something went wrong!', 'errors' => $error];
            }
        } else {
            $response = ['status' => 0, 'message' => 'No files uploaded.'];
        }
        echo json_encode($response);
    }
    public function update_room_master_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_room_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-room"));
    }

    public function room_master_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["room_master_data"] = $this->master_model->room_master_view();
        $data["content_view"] = 'Master/room_master_view';
        $this->template->base_template($data);
    }
    public function stock_management_master()
    {
        echo '<body class="d-flex align-items-center justify-content-center bg-dark text-white vh-100">
                <div class="text-center">
                    <h1 class="display-4">Coming Soon</h1>
                    <p class="lead">We are working hard to bring you something awesome. Stay tuned!</p>
                </div>
            </body>';
    }

    public function agent_master()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $mode = $this->security->xss_clean($this->input->post('mode'));
        $item_id = $this->security->xss_clean($this->input->post('custom_id'));
        if (isset($mode) && $mode == 'edit_agent') {
            $data['single_agent_data'] = $this->master_model->get_single_item_category_master_data($item_id);
        }
        $agent_master_pageload_data = $this->master_model->customer_master_pageload_data();
        $data["agent_master_pageload_data"] = $agent_master_pageload_data[0];
        $data["content_view"] = 'Master/agent_master';
        $this->template->base_template($data);
    }
    public function agent_master_insert()
    {
        $rules = array(
            array(
                'field' => 'agent_name',
                'label' => 'Agent Name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'mobile_number',
                'label' => 'Mobile Number',
                'rules' => 'trim|required|min_length[10]|max_length[10]'
            ),
            array(
                'field' => 'email',
                'label' => 'Email Id',
                'rules' => 'trim|valid_email'
            ),
            array(
                'field' => 'd_type',
                'label' => 'Document Type',
                'rules' => 'required'
            ),
            array(
                'field' => 'd_no',
                'label' => 'ID No.',
                'rules' => 'trim|required|min_length[10]|max_length[20]'
            ),
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->agent_master();
        } else {
            $file_paths = [];
            if (isset($_FILES['upload_photo']['name']) && $_FILES['upload_photo']['name'][0] != "") {
                $filesCount = count($_FILES['upload_photo']['name']);

                for ($i = 0; $i < $filesCount; $i++) {
                    $filename = explode('.', $_FILES['upload_photo']['name'][$i]);
                    $extension = strtolower(end($filename));
                    $rename_file = time() . '_' . $i . '.' . $extension;

                    $_FILES['file']['name'] = $rename_file;
                    $_FILES['file']['type'] = $_FILES['upload_photo']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['upload_photo']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['upload_photo']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['upload_photo']['size'][$i];

                    $config['upload_path'] = './resources/uploads/agent_image';
                    $config['file_name'] = $rename_file;
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size'] = 109700;
                    $config['max_width'] = 4084;
                    $config['max_height'] = 6724;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('file')) {
                        $data['error'][] = $this->upload->display_errors();
                    } else {
                        array_push($file_paths, $rename_file);
                    }
                }
            } else {
                if ($this->input->post('existing_file_paths')) {
                    $file_paths = $this->input->post('existing_file_paths');
                }
            }
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->agent_master_insert($postdata, $file_paths);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('agent-master'));
        }
    }

    public function agent_master_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $agent_master_page_data = $this->master_model->agent_master_master_view();
        $data["agent_master_data"] = $agent_master_page_data[0];
        $data["content_view"] = 'Master/agent_master_view';
        $this->template->base_template($data);
    }
    public function update_agent_master_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_agent_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-agent"));
    }

    public function customer_master_card()
    {
        $data["page_title"] = 'Hotel Room Booking';
        $data["card_title"] = 'Customer Master';
        $customer_id = $this->uri->segment(2);
        $single_customer_data = $this->master_model->get_single_customer_data($customer_id);
        $data['customer_data'] = isset($single_customer_data[0][0]) ? $single_customer_data[0][0] : [];
        $data['document_data'] = isset($single_customer_data[1][0]) ? $single_customer_data[1][0] : [];
        $data['relatsion_data'] = isset($single_customer_data[2]) ? $single_customer_data[2] : [];

        /* $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata['mode']) && $postdata['mode'] == 'edit_customer_details') {
            $single_customer_data = $this->master_model->get_single_customer_data($postdata);
            $data['customer_data'] = isset($single_customer_data[0][0]) ? $single_customer_data[0][0] : [];
            $data['document_data'] = isset($single_customer_data[1][0]) ? $single_customer_data[1][0] : [];
        } */

        $customer_master_pageload_data = $this->master_model->customer_master_pageload_data();
        $data['customer_master_data'] = $customer_master_pageload_data[0];
        $contry_state_district_data = $this->master_model->get_supplier_master_records();
        $data["contry_data"] = $contry_state_district_data[0];
        $data["state_data"] = $contry_state_district_data[1];
        $data["district_data"] = $contry_state_district_data[2];
        $data["content_view"] = 'Master/customer_master_card';
        $this->template->base_template($data);
    }

    public function customer_master_card_insert()
    {
        $rules = array(
            array(
                'field' => 'mobile',
                'label' => 'Contact No',
                'rules' => 'trim|required|min_length[10]|max_length[10]'
            ),
            array(
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'trim|valid_email'
            ),
            array(
                'field' => 'customer_name',
                'label' => 'Customer Name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'gst',
                'label' => 'GSTIN',
                'rules' => 'trim|min_length[15]|max_length[15]'
            ),
            array(
                'field' => 'id_no',
                'label' => 'ID No',
                'rules' => 'trim|min_length[10]|max_length[20]'
            ),
            array(
                'field' => 'dob',
                'label' => 'Date of Birth',
                'rules' => 'validate_age'
            ),
            array(
                'field' => 'address_one',
                'label' => 'Address Line 1',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'country',
                'label' => 'Country',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'state',
                'label' => 'State',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'city',
                'label' => 'City',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'pincode',
                'label' => 'Pincode',
                'rules' => 'trim|required'
            ),
        );

        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->customer_master_card();
        } else {
            $file_paths = [];
            if (isset($_FILES['doc_photo']['name']) && $_FILES['doc_photo']['name'] != "") {
                $filesCount = count($_FILES['doc_photo']['name']);

                for ($i = 0; $i < $filesCount; $i++) {
                    $filename = explode('.', $_FILES['doc_photo']['name'][$i]);
                    $extension = strtolower(end($filename));
                    $rename_file = time() . '_' . $i . '.' . $extension;

                    $_FILES['file']['name'] = $rename_file;
                    $_FILES['file']['type'] = $_FILES['doc_photo']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['doc_photo']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['doc_photo']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['doc_photo']['size'][$i];

                    $config['upload_path'] = './resources/uploads/customer_image';
                    $config['file_name'] = $rename_file;
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 109700;
                    $config['max_width'] = 4084;
                    $config['max_height'] = 6724;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('file')) {
                        $data['error'][] = $this->upload->display_errors();
                        /* if (file_exists($config['upload_path'] . $rename_file)) {
                            unlink($config['upload_path'] . $rename_file);
                        } */
                    } else {
                        array_push($file_paths, $rename_file);
                    }
                }
            }
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->customer_master_card_insert($postdata, $file_paths);
            $GUEST_ID = $result['GUEST_ID'];
            $this->session->set_flashdata("msg", $result);
            if ($GUEST_ID != '') {
                return redirect(base_url('customer-master/') . $this->my_encryption->encrypt($GUEST_ID));
            } else {
                return redirect(base_url('customer-master'));
            }
        }
    }
    public function restaurant_menu_master()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $postdata = $this->security->xss_clean($this->input->post());
        if (isset($postdata['mode']) && $postdata['mode'] == 'edit_restaurant_food') {
            $single_data = $this->master_model->get_single_restaurant_master_data($postdata);
            $data['single_parent_data'] = $single_data[0][0];
            $data['single_child_data'] = $single_data[1];
        }
        $restaurant_master_pageload_data = $this->master_model->restaurant_menu_master_pageload_data();
        $data['dish_category_data'] = $restaurant_master_pageload_data[0];
        $data['ingredients_name_data'] = $restaurant_master_pageload_data[2];
        $data["content_view"] = 'Master/restaurant_menu';
        $this->template->base_template($data);
    }
    public function fetch_unit_data()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->fetch_unit_data($postdata);
        $item = [];
        if (!empty($result[0])) {
            foreach ($result[0] as $value) {
                $item[] = array(
                    "DESC_2" => $value["DESC_2"],
                    "DESC_2_NAME" => $value["DESC_2_NAME"],
                    "EN_DESC_2" => $this->my_encryption->encrypt($value["DESC_2"])
                );
            }
        }
        if (!empty($item)) {
            echo json_encode(array('status' => '1', 'message' => 'success', 'data' => $item));
        } else {
            echo json_encode(array('status' => '0', 'message' => 'error'));
        }
    }
    public function restaurant_menu_master_insert()
    {
        $rules = array(
            array(
                'field' => 'dis_caregory',
                'label' => 'Dish Category',
                'rules' => 'required'
            ),
            array(
                'field' => 'dish_name',
                'label' => 'Dish Name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'dish_price',
                'label' => 'Dish Price',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'ingredients_name[]',
                'label' => 'Ingredients Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'qty_per_dish[]',
                'label' => 'Qty Per Dish',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'unit[]',
                'label' => 'Qty Per Dish',
                'rules' => 'trim|required'
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->restaurant_menu_master();
        } else {
            $postdata = $this->security->xss_clean($this->input->post());
            $result = $this->master_model->restaurant_menu_master_insert($postdata);
            $this->session->set_flashdata("msg", $result);
            return redirect(base_url('restaurant-food-master'));
        }
    }

    public function restaurant_menu_master_view()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $restaurant_master_view_data = $this->master_model->restaurant_master_view();
        // print_r($restaurant_master_view_data);
        // die;
        $data['parent_table_data'] = $restaurant_master_view_data[0];
        $data['child_table_data'] = $restaurant_master_view_data[1];
        $data["content_view"] = 'Master/restaurant_menu_view';
        $this->template->base_template($data);
    }
    public function update_restaurant_menu_master_status()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->update_restaurant_master_status($postdata);
        $this->session->set_flashdata("update_msg", $result);
        return redirect(base_url("view-food-master"));
    }
    public function payment_mode_master()
    {
        $data["page_title"] = 'Room Service Type';
        $data["card_title"] = 'Room Service Type';
        $data["content_view"] = 'Master/payment_mode_master';
        $this->template->base_template($data);
    }
    public function customer_co_occupant_file()
    {
        $new_file_name = '';
        if (isset($_FILES['co_file']['name']) && $_FILES['co_file']['name'] != "") {
            $filename = explode('.', $_FILES['co_file']['name']);
            $extension = strtolower(end($filename));
            $rename_file = time() . '.' . $extension;

            $_FILES['file']['name'] = $rename_file;
            $_FILES['file']['type'] = $_FILES['co_file']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['co_file']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['co_file']['error'];
            $_FILES['file']['size'] = $_FILES['co_file']['size'];

            $config['upload_path'] = './resources/uploads/customer_image';
            $config['file_name'] = $rename_file;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = 109700;
            $config['max_width'] = 4084;
            $config['max_height'] = 6724;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
                $data['error'] = $this->upload->display_errors();
                echo json_encode(array('status' => '1', 'message' => 'Failed', 'data' => $data['error']));

            } else {
                $new_file_name = $rename_file;
                echo json_encode(array('status' => '1', 'message' => 'File uploaded', 'data' => $new_file_name));
            }
        }

    }

    public function duplicate_check()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->duplicate_check($postdata);
        echo json_encode($result);
    }
    public function floor_name_duplicate_check()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->floor_name_duplicate_check_in_block_wise_floor_master($postdata);
        echo json_encode($result);
    }
    public function room_number_duplicate_check()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->room_number_duplicate_check_in_room_master($postdata);
        echo json_encode($result);
    }
    public function fetch_item_master_view_page_load_data()
    {
        $postdata = $this->security->xss_clean($this->input->post());
        $result = $this->master_model->fetch_item_master_view_page_load_data($postdata);
        $item = [];
        if (!empty($result[0])) {
            foreach ($result[0] as $value) {
                $item[] = array(
                    "RECORD_ID" => $value["RECORD_ID"],
                    "RECORD_NAME" => $value["RECORD_NAME"],
                    "EN_RECORD_ID" => $this->my_encryption->encrypt($value["RECORD_ID"])
                );
            }
        }
        if (!empty($item)) {
            echo json_encode(array('status' => '1', 'message' => 'success', 'data' => $item));
        } else {
            echo json_encode(array('status' => '0', 'message' => 'error'));
        }
    }
}