<?php



namespace App\Models;

use App\Controllers\ErrorController;
use App\Models\BaseModel;
use App\Core\Session;

class Ticket extends BaseModel
{
    protected string $table = 'new_tickets';


    public function create($user_id, $subject, $description): int
    {
        $sql = "INSERT INTO {$this->table} (user_id,subject,description)
                VALUES (?, ?, ?)";

        $insertedId = '';
        try {
            $stmt = $this->query($sql, [$user_id, $subject, $description]);
            $insertedId = $stmt->insert_id;
        } catch (\Exception $e) {
            Session::setFlashMessage('error', 'Ticket Creation Failed');
        }
        return $insertedId;
    }

    public function getAll(): array
    {
        $stmt = $this->query("SELECT * FROM {$this->table}");
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getTotalTickets()
    {
        $stmt = $this->query("SELECT COUNT(*) AS total FROM {$this->table}");
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function getTicketsRaisedToday()
    {
        $stmt = $this->query("SELECT COUNT(*) AS total_raised_today FROM {$this->table} WHERE DATE(created_at) = CURDATE()");
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_raised_today'];
    }

    public function getPendingTickets()
    {
        $stmt = $this->query("SELECT COUNT(*) AS total_pending FROM {$this->table} WHERE status IN ('open', 'in-progress')");
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_pending'];
    }

    public function getResolvedTickets()
    {
        $stmt = $this->query("SELECT COUNT(*) AS total_resolved FROM {$this->table} WHERE status = 'resolved'");
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_resolved'];
    }


}
