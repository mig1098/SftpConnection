use phpseclib\Net\SFTP;
//
class SftpConnect{
    private $sftp_server;
    private $sftp_user_name;
    private $sftp_user_pass;
    private $sftp_port=2222;
    private $sftp_timeout = 15;
    public function __construct($server,$user,$pass){
        $this->sftp_server    = $server;
        $this->sftp_user_name = $user;
        $this->sftp_user_pass = $pass;
    }
    public function setNameFile($value){
        $this->file = $value;
        return $this;
    }
    public function setNameRemoteFile($value){
        $this->remote_file = $value;
        return $this;
    }
    public function setDirectory($value){
        $this->directory = $value;
        return $this;
    }
    /**
     * -------------------------------------------------
     * FTP CONNECTIONS
     * -------------------------------------------------
     * */
    public function putFile(){   
        $conn_id = new SFTP($this->sftp_server,$this->sftp_port,$this->sftp_timeout);
        if ($conn_id->login($this->sftp_user_name, $this->sftp_user_pass)) {
            $conn_id->chdir($this->directory);
            $conn_id->put($this->remote_file, $this->file, NET_SFTP_LOCAL_FILE);
            $msg = "$this->file loaded success\n";
        }else{
           $msg = "$this->file problem while uploading\n";
        }
        // puts a three-byte file named filename.remote on the SFTP server
        //$sftp->put('filename.remote', 'xxx');
        // puts an x-byte file named filename.remote on the SFTP server,
        // where x is the size of filename.local
        return $msg;
    }
    public function getFile(){
        $conn_id = new SFTP($this->sftp_server,$this->sftp_port,$this->sftp_timeout);
        if ($conn_id->login($this->sftp_user_name, $this->sftp_user_pass)) {
            $conn_id->chdir($this->directory);
            $conn_id->get($this->remote_file, $this->file);
            $msg = "$this->file downloaded success\n";
        }else{
           $msg = "problem while downloading\n";
        }
        return $msg;
    }
    public function getContents(){
        //return $this->ftp_server.' '.$this->sftp_port.' '.$this->sftp_timeout.' '.$this->sftp_user_name.' '. $this->sftp_user_pass;
        $conn_id = new SFTP($this->sftp_server,$this->sftp_port,$this->sftp_timeout);
        if (!$conn_id->login($this->sftp_user_name, $this->sftp_user_pass)) {
            exit('Login Failed');
        }
        $conn_id->chdir($this->directory);
        return $conn_id->nlist();
    }
}
