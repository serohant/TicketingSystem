<?php

class ticket {

    protected $db;
    protected $table;

    function __construct($s_user, $s_pass, $s_name, $s_host, $table = "tickets") {
        /**
         * Sınıf kurulum fonksiyonu
         * s_user: veritabanı kullanıcı adı
         * s_pass: veritabanı şifresi
         * s_name: veritabanı adı
         * s_host: veritabanı sunucusu
         * table: kullanıcı verilerinin tutulacağı kısım
         */
        try {
            $this->db = new PDO("mysql:host=".$s_host.";dbname=".$s_name, $s_user, $s_pass);
            $this->table = $table;

            try {
                $result = $this->db->query("SHOW TABLES LIKE '$this->table'");
                if($result->rowCount() < 1){
                    try {
                        $sql = "CREATE TABLE ".$this->table." (
                            id INT(11) AUTO_INCREMENT PRIMARY KEY,
                            userid INT(11) NOT NULL,
                            main INT(11) NULL,
                            subject VARCHAR(256) NOT NULL,
                            text VARCHAR(1024) NOT NULL,
                            date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            status INT(11) NOT NULL DEFAULT 0
                        )";
                    
                        $this->db->exec($sql);
                        return true;
                    } catch(PDOException $e) {
                        return "Tablo oluşturma hatası";
                    }
                        
                }
            } catch (PDOException $e) {
                echo "Tablo doğrulama hatası: " . $e->getMessage();
                return false;
            }
            
        } catch (PDOException $e) {
            echo "Sunucu bağlantı hatası, bilgileri kontrol edin! Hata: " . $e->getMessage();
        }
    }


    function changeStatus($id){
        /**
         * Durum değişim fonksiyonu
         * Talebin yanıt durumunu 0 (yanıtsız)'dan 1 (Yanıtlanmış) olarak değiştirir
         */
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $query = $stmt->fetch(PDO::FETCH_ASSOC);
            if($query){
                $sstmt = $this->db->prepare("UPDATE {$this->table} SET status = 1, date = :date WHERE id = :id");
                $sstmt->bindParam(':date', $query['date']);
                $sstmt->bindParam(':id', $id);
                if($sstmt->execute()){
                    return true;
                }else{
                    return false;
                }   
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    function closeTicket($id){
        /**
         * Talep kapatma fonksiyonu
         * Talebin sonlandırılması için kullanılan fonksiyon
         */
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $query = $stmt->fetch(PDO::FETCH_ASSOC);
            if($query){
                $sstmt = $this->db->prepare("UPDATE {$this->table} SET status = 2, date = :date WHERE id = :id");
                $sstmt->bindParam(':date', $query['date']);
                $sstmt->bindParam(':id', $id);
                if($sstmt->execute()){
                    return true;
                }else{
                    return false;
                }   
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    function createTicket($userid, $subject, $text){
        /**
         * Talep oluşturma fonksiyonu
         * Yanıtlanabilir, düzenlenebilir, silinebilir talep oluşturmak için kullanılır
         */
        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (userid, subject, text) VALUES (:userid, :subject, :text)");
        
            // Parametreleri bağla
            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':text', $text);
            
            return $stmt->execute() ? true : false;
        } catch (PDOException $e) {
            return $e;
        } 
    }

    function answerTicket($userid, $id, $text){
        /**
         * Talep cevaplama fonksiyonu
         * Hali hazırda oluşturulmuş bir talebe yanıt verme fonksiyonu
         */
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $query = $stmt->fetch(PDO::FETCH_ASSOC);
            if($query){
                $stmt = $this->db->prepare("INSERT INTO {$this->table} (userid, main, subject, text) VALUES (:userid, :main, :subject, :text)");
                // Parametreleri bağla
                $stmt->bindParam(':userid', $userid);
                $stmt->bindParam(':main', $query['id']);
                $stmt->bindParam(':subject', $query['subject']);
                $stmt->bindParam(':text', $text);
            
                if($stmt->execute()){
                    if($this->changeStatus($query['id'])){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }catch (PDOException $e) {
            return $e;
        } 
    }

    function updateTicket($id, $subject, $text){
        /**
         * Talep güncelleme fonksiyonu
         * Hali hazırda oluşturulmuş bir talebi güncelleme fonksiyonu
         */
        try {
            $sstmt = $this->db->prepare("UPDATE {$this->table} SET subject = :subject, text = :text WHERE id = :id");
            $sstmt->bindParam(':subject', $subject);
            $sstmt->bindParam(':text', $text);
            $sstmt->bindParam(':id', $id);
            if($sstmt->execute()){
                return true;
            }else{
                return false;
            }  
        } catch (PDOException $e) {
            return $e;
        }
    }

    function removeTicket($id){
        /**
         * Talep silme fonksiyonu
        */
        try {
            $sstmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $sstmt->bindParam(':id', $id);
            if($sstmt->execute()){
                return true;
            }else{
                return false;
            }    
        } catch (PDOException $e) {
            return $e;
        } 
    }

    function getTickets($userid){
        /**
         * Kullanıcıya ait tüm talepleri listeleme fonksiyonu
         */
        try {
            $query = $this->db->query("SELECT * FROM {$this->table} WHERE userid = {$userid}", PDO::FETCH_ASSOC);
            if ( $query->rowCount() ){
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            return $e;
        }
    }
    
}


?>
