<?php

namespace App\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Controllers\NotificationController;
use App\Core\Session;
use App\Core\Validation;

class TicketController
{

    private $ticketModel;
    private $userModel;
    private $notificationController;

    public function __construct()
    {
        // $this->view = $view;
        $this->ticketModel = new Ticket();
        $this->userModel = new User(); // Initialize user model if needed
        $this->notificationController = new NotificationController();
    }

    /**
     * Function to display all the tickets
     *
     * @return void
     */
    public function index(): void
    {
        /**
         * 1) check the user type
         * 2) if the user type is "admin" then get all tickets
         * 3) if the user type is "agent" the get all tickets
         * 4) if the user type is "guest"
         */
        $tickets = $this->ticketModel->getAll();

        loadView('tickets/index', ['tickets' => $tickets]);
    }



    public function create()
    {
        $user = Session::get('user');

        // Check if user is an agent and deny access
        if (isset($user['role']) && $user['role'] === 'agent') {
            ErrorController::unauthorized();
            exit;
        }
        loadView('tickets/create');

    }

    public function showStatusForm()
    {
        loadView('ticket-search');
    }
    public function processSearch()
    {
        $ticketId = $_POST['ticket_id'] ?? null;
        if (!$ticketId || !is_numeric($ticketId)) {
            Session::setFlashMessage('error', 'Ticket ID Not Found');
            redirect('/tickets/check-status');
        } else {
            redirect('/tickets/' . (int)$ticketId);
        }
    }



    public function show($id)
    {
        // inspectAndDie("show function called with id: {$id}");
        try {
            $ticket = $this->ticketModel->getById($id);
            // inspectAndDie($ticket);
            if (!$ticket) {
                Session::setFlashMessage('error', 'Ticket ID Not Found');
                redirect('/tickets/check-status');
            }
            loadView('tickets/show', [
                'ticket' => $ticket
            ]);
        } catch (\Exception $e) {
            ErrorController::notFound("Ticket with ID $id not found.");
        }
    }

    public function store()
    {
        // inspectAndDie("store function called");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $username = $_POST['username'];
            $subject = $_POST['subject'];
            $description = $_POST['description'];
            $user_id = '';

            /**
             * 1) check the type of user
             * 2) if the user is logged in, get the user id and create a ticket with that user id
             * 3) if the user is not logged in
             * 4) get the userid based on the email
             * 5) if the email does not exist, store the name,email, user_type of the guest user.
             * 6) create a ticket with user id.
             * 
             */

            //Validating the data
            $errors = [];

            // Validation
            if (!Validation::email($email)) {
                $errors['email'] = 'Please enter a valid email';
            }

            if (!Validation::string($username, 2, 50)) {
                $errors['name'] = 'Please enter a valid name';
            }

            if (!empty($errors)) {
                loadView('tickets/create', [
                    'errors' => $errors
                ]);
                exit;
            }

            // Check if user is logged in
            if (isset($_SESSION['user_id'])) {
                // User is logged in, use their ID
                $user_id = $_SESSION['user_id'];
            } else {
                //check if there is any user with the given email
                $user = $this->userModel->getUserByEmail($email);
                if (!$user) {
                    $regObject = $this->userModel->register($username, $email, null, 'guest');
                    $user_id = $regObject->insert_id;
                } else {
                    $user_id = $user['id'];
                }
            }


            $ticketId = $this->ticketModel->create($user_id, $subject, $description);

            /**
             * 1) Use the NotificationController to send an email to the user
             * 
             * Step 1: Use $email and $username to send an email
             * Step 2: Call the send() method of NotificationController
             * 
             */

            $this->notificationController->send(
                $email,
                "Ticket Created Successfully with Ticket ID $ticketId",
                "Dear Sir/Madam,\n\nThank you for contacting the IT Support Desk. Brief Summary of the issue is as follow: \n\n Ticket ID: $ticketId \n Description: $description \n\n\n The issue is being processed and you can check the ticket status using the 'View Ticket Status' option in the portal. \n\n\n\n Regards, \n IT Department, NIFT Bhubaneswar",
                $username
            );

            Session::setFlashMessage('success', "Thank You. Your Ticket ID is $ticketId. An Email has been sent with the ticket details");
            header("Location: /tickets/create");
        }
    }
}
