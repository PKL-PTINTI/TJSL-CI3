<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LdapModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function take_users($USERNAME)
    {
        $db_ldap = $this->load->database('ldap', TRUE);

        $db_ldap->like(array('E_MAIL' => $USERNAME));
        $db_ldap->from('QS_LOGIN');

        $query = $db_ldap->get();
        $query = $query->result_array();

        if ($query) {
            return $query[0];
        }
    }
}
