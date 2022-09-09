<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ldap_tools
{
	var $host;
	var $port;
	var $dn;
	var $base;


	public function __construct()
	{
		$this->port = 389;
		$this->host = 'mail.inti.co.id';
	}

	public function validate_user($username, $password)
	{
		$conn = ldap_connect($this->host, $this->port);

		ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

		$this->dn = 'uid=' . $username . ',ou=people,dc=inti,dc=co,dc=id';
		$this->dn2 = 'uid=' . $username . ',ou=people,dc=mail,dc=inti,dc=co,dc=id';

		try {
			$bind = @ldap_bind($conn, $this->dn, $password);
			$bind2 = @ldap_bind($conn, $this->dn2, $password);
			if ($bind || $bind2) {
				//echo "LDAP bind successful...<br>"; 
				return TRUE; //returns "ok" to the calling page -- User is authenticated
			} else {
				//echo "LDAP bind failed...<br>"; 
				return FALSE;
			}
		} catch (Exception $e) {
			return FALSE;
		}


		ldap_close($conn);
	}
}
