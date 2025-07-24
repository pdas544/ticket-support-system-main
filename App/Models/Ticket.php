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


        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'iss',
            $user_id,
            $subject,
            $description
        );

        try {
            $stmt->execute();
            return $stmt->insert_id;
        } catch (\Exception $e) {
            Session::setFlashMessage('error', 'Ticket Creation Failed');
        }
    }

    public function getAll(): array
    {
        $result = $this->db->query("SELECT * FROM {$this->table}");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getTotalTickets()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM {$this->table}");
    }

    public function getTicketsRaisedToday()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM tickets WHERE DATE(created_at) = CURDATE() UNION ALL SELECT COUNT(*) AS total FROM guest_tickets WHERE DATE(created_at) = CURDATE()");
        return $this->sumResults($stmt);
    }

    public function getPendingTickets()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM tickets WHERE status IN ('open', 'in-progress') UNION ALL SELECT COUNT(*) AS total FROM guest_tickets WHERE status IN ('open', 'in-progress')");
        return $this->sumResults($stmt);
    }

    public function getResolvedTickets()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM tickets WHERE status = 'resolved' UNION ALL SELECT COUNT(*) AS total FROM guest_tickets WHERE status = 'resolved'");
        return $this->sumResults($stmt);
    }

    private function sumResults($stmt)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        $total = 0;
        while ($row = $result->fetch_assoc()) {
            $total += $row['total'];
        }
        return $total;
    }
}
