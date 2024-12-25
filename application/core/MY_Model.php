<?php
class MY_Model extends CI_Model
{
    protected $thatdate;
    protected $userid;
    protected $session_id;
    public $users;
    public $session_name;

    public function __construct()
    {
        parent::__construct();
        $this->thatdate = date('Y-m-d h:i:s');
        $this->userid = $this->my_encryption->decrypt($this->session->userdata('userid'));
        $this->session_id = $this->my_encryption->decrypt($this->session->userdata('session'));
        $this->session_name = $this->session->userdata('SESSION_NAME');
    }

    public function get_autocode_againt_autofor($auto_for)
    {
        $procedure = "EXEC GENERATE_AUTOCODE_M_TYPE_FIXED_LENGTH @M_TYPE = '" . $auto_for . "',@CODE=''";
        $query = sqlsrv_query($this->db->conn_id, $procedure);
        if ($query) {
            do {
                while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                    $data[] = $row;
                }
            } while (sqlsrv_next_result($query));
            return $data[0]["CODE"];
        } else {
            return false;
        }
    }
}
