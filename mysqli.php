<?php
class Db {
    private $con; // Siia salvestatakse mysqli ühendus

    function __construct() {
        $this->con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if ($this->con->connect_errno) {
            echo "<strong>Viga andmebaasiga:</strong> " . $this->con->connect_error;
        } else {
            mysqli_set_charset($this->con, "utf8");
        }
    }

    # Tagasiside lisamine
    function addFeedback($added, $name, $email, $message) {
        $stmt = $this->con->prepare("INSERT INTO feedback (added, name, email, message) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            echo "<div>Viga päringu ettevalmistamisel.</div>";
            return false;
        }
        $stmt->bind_param("ssss", $added, $name, $email, $message);
        return $stmt->execute();
    }

    # Kõigi tagasisidete saamine – sorteeritud kuupäeva järgi
    function getFeedback() {
        $sql = "SELECT id, added, name, email, message FROM feedback ORDER BY added DESC"; //tulemused sorteeritud kuupäeva järgi uuemad eespool.
        return $this->dbGetArray($sql);
    }

    # Tagasiside kustutamine ID alusel
    function deleteFeedback($id) {
        $stmt = $this->con->prepare("DELETE FROM feedback WHERE id = ?");
        if ($stmt === false) {
            echo "<div>Viga kustutamisel.</div>";
            return false;
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    # Üldine SQL päringu tegemine (INSERT, UPDATE, DELETE jne)
    function dbQuery($sql) {
        if ($this->con) {
            $res = mysqli_query($this->con, $sql);
            if ($res === false) {
                echo "<div>Vigane päring: " . htmlspecialchars($sql) . "</div>";
                return false;
            }
            return $res;
        }
        return false;
    }

    # SELECT päringute jaoks – tulemused massiivina
    function dbGetArray($sql) {
        $res = $this->dbQuery($sql);
        if ($res !== false) {
            $data = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row;
            }
            return !empty($data) ? $data : false;
        }
        return false;
    }

    # Turvaline $_POST ja $_GET väärtuste küsimine
    function getVar(string $name, ?string $method = null) {
        if ($method === 'post') {
            return $_POST[$name] ?? null;
        } elseif ($method === 'get') {
            return $_GET[$name] ?? null;
        } else {
            return $_POST[$name] ?? $_GET[$name] ?? null;
        }
    }

    # Sisendi puhastamine – turvaliseks muutmine
    function dbFix($var) {
        if (!$this->con || !($this->con instanceof mysqli)) {
            return 'NULL';
        }

        if (is_null($var)) {
            return 'NULL';
        } elseif (is_bool($var)) {
            return $var ? '1' : '0';
        } elseif (is_numeric($var)) {
            return $var;
        } else {
            return "'" . $this->con->real_escape_string($var) . "'";
        }
    }

    # HTML väärtuse sisestamine vormi value atribuudina
    function htmlValue(string $name, array $source): string {
        if (isset($source[$name])) {
            return 'value="' . htmlspecialchars($source[$name], ENT_QUOTES) . '"';
        }
        return '';
    }

    # HTML tekstisisu väljundi jaoks (nt <textarea>)
    function htmlTextContent(string $name, array $source): string {
        return isset($source[$name]) ? htmlspecialchars($source[$name], ENT_QUOTES) : "";
    }

    # Massiivide näitamine inimlikul kujul
    function show($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
}
