 🎟️ Event Ticketing System

Welcome to the Event Ticketing System! This project is a comprehensive solution for managing events, tickets, and sales. It leverages PHP and Laravel for the backend, and Vue.js for the frontend. With this system, users can see, create, update events, generate QR codes for event tickets, sell tickets via M-Pesa, and generate reports.

 🚀 Features

- **Event Management**: Create, view, update, and delete events.
- **Ticket Management**: Generate and manage tickets for each event.
- **QR Code Generation**: Generate QR codes for event tickets for easy sharing.
- **Payment Integration**: Sell tickets and process payments via M-Pesa.
- **Reporting**: Generate detailed reports on event attendance and ticket sales.

 🛠️ Technologies Used

- **Backend**: PHP, Laravel
- **Frontend**: Vue.js
- **Database**: MySQL
- **Payment Gateway**: M-Pesa

📦 Installation

 Prerequisites

- PHP >= 9
- Composer
- NPM
- MySQL

### Backend Setup

1. Clone the repository:
   
   git clone https://github.com/yourusername/event-ticketing-system.git
   cd event-ticketing-system
   cd server
 


2. Install PHP dependencies:
 
   composer install


3. Copy the example environment file and set up your environment variables:
 
   cp .env.example .env


4. Generate the application key:
 
   php artisan key:generate
  

5. Set up your database and run migrations:
 
   php artisan migrate
 

6. Seed the database with initial data (optional):

   php artisan db:seed
   

### Frontend Setup

1. Navigate to the frontend directory:
 
   cd client
   

2. Install JavaScript dependencies:
 
   npm install
   

3. Build the frontend assets:

   npm run dev


### Running the Application

1. Start the Laravel development server:
 
2.Go to server directory: cd server
   php artisan serve


3. Open another terminal and start the Vue development server:
  
   cd client
   npm run serve
  

4. Visit `http://localhost:8080` in your browser to see the application.

## 📚 Usage

### Viewing Events

- Navigate to the events page to see a list of all events.
- Each event will display its details including name, venue, and location.

### Creating/Updating Events

- Use the "Create Event" button to add a new event.
- Fill in the event details and submit the form.
- To update an event, click the "Edit" button next to the event in the list.

### Generating QR Codes

- After creating an event, you can generate a QR code for the event tickets.
- This QR code can be shared with attendees for easy access.

### Selling Tickets via M-Pesa

- When attendees purchase tickets, they can pay via M-Pesa.
- The system will handle the payment processing and ticket generation.

### Generating Reports

- Access the "Reports" section to generate detailed reports on event attendance and ticket sales.
- Reports can be filtered by date, event, and other criteria.

## 🤝 Contributing

We welcome contributions! Please fork the repository and create a pull request with your changes. Ensure that your code follows the project's coding standards and passes all tests.



## ♨ LiveLink 

Currently working on the live link.

---

Thank you for using the Event Ticketing System! We hope it helps you manage your events efficiently. 🎉

Feel free to explore and contribute to the project. Happy event managing!
