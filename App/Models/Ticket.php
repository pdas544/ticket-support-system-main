<?php



namespace App\Models;

use App\Controllers\ErrorController;
use App\Models\BaseModel;
use App\Core\Session;
use PDO;

class Ticket extends BaseModel
{
    protected string $table = 'new_tickets';


    public function create($user_id, $subject, $description): int
    {
        $sql = "INSERT INTO {$this->table} (user_id,subject,description)
                VALUES (:user_id, :subject, :description)";

        $params = [
            'user_id' => [$user_id,PDO::PARAM_INT],
            'subject' => [$subject,PDO::PARAM_STR],
            'description' => [$description,PDO::PARAM_STR],
        ];

        $insertedId = '';
        try {
            $this->query($sql, $params);
            $insertedId = $this->lastInsertId();
        } catch (\Exception $e) {
            Session::setFlashMessage('error', 'Ticket Creation Failed');
        }
        return $insertedId;
    }

    public function getAll(): array
    {
        $stmt = $this->query("SELECT * FROM {$this->table}");
        return $this->fetchAll($stmt);
    }

    public function getById($id)
    {
        $params = [
            'id' => [$id,PDO::PARAM_INT],
        ];
        $stmt = $this->query("SELECT * FROM {$this->table} WHERE id = :id", $params);
        return $this->fetch($stmt);
    }

    public function getTotalTickets()
    {
        $stmt = $this->query("SELECT COUNT(*) AS total FROM {$this->table}");
        $row = $this->fetch($stmt);
        return $row['total'];
    }

    public function getTicketsRaisedToday()
    {

        $stmt = $this->query("SELECT COUNT(*) AS total_raised_today FROM {$this->table} WHERE DATE(created_at) = CURDATE()");
        $row = $this->fetch($stmt);
        return $row['total_raised_today'];
    }

    public function getPendingTickets()
    {
        $stmt = $this->query("SELECT COUNT(*) AS total_pending FROM {$this->table} WHERE status IN ('open', 'in-progress')");
        $row = $this->fetch($stmt);
        return $row['total_pending'];
    }

    public function getResolvedTickets()
    {
        $stmt = $this->query("SELECT COUNT(*) AS total_resolved FROM {$this->table} WHERE status = 'resolved'");
        $row = $this->fetch($stmt);
        return $row['total_resolved'];
    }

    public function getTicketsByUserId($user_id)
    {
        $params = [
            'user_id' => [$user_id,PDO::PARAM_INT],
        ];
        $stmt = $this->query("SELECT COUNT(*) as total_by_user FROM {$this->table} WHERE user_id = :user_id", $params);
        $row = $this->fetch($stmt);
        return $row['total_by_user'];
    }


}
