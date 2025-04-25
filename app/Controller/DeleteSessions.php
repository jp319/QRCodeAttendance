<?php

namespace Controller;



use PDO;

class DeleteSessions
{
    public function connect(): PDO
    {
        $string = "mysql:host="."localhost".";dbname="."u753706103_qr_attendance";
        $con = new PDO($string, "u753706103_christian", "mZ2~G76JP1s5=B=Cy1L*");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception handling
        return $con;
    }
    public function deleteSession(): bool|array{
        $query = "DELETE FROM user_sessions WHERE expires_at < NOW()";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

$deleteSession = new DeleteSessions();
$deleteSession->deleteSession();