
# CodeIt

CodeIt is a coding challenge platform designed for developers to enhance their skills, compete, and track their performance. The platform offers features like user authentication, leaderboards, coding challenges, and premium subscription plans.

---

## Features

- **User Authentication**: Secure login, registration, and two-factor authentication.
- **Coding Challenges**: A wide range of challenges to test and improve coding skills.
- **Leaderboards**: Track scores and rank among other users.
- **Subscription Plans**: Access premium challenges and features with a subscription.
- **Certificates**: Earn certificates upon completing challenges.
- **Admin Dashboard**: Manage categories, challenges, users, and subscriptions.
- **Payment Integration**: Supports PayPal for processing payments.

---

## Technologies Used

- **Backend**: Laravel (PHP Framework)
- **Frontend**: Blade Templates, Bootstrap
- **Database**: MySQL
- **Payment Gateway**: PayPal API
- **Version Control**: Git
- **Testing**: PHPUnit

---

## Installation

### Prerequisites

- PHP >= 8.0
- Composer
- MySQL
- Node.js and npm

### Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/Yeswanthkanakam/Codit.git
   cd Codit
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Configure the `.env` file with your database details:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
  
   ```

7. Run database migrations:
   ```bash
   php artisan migrate
   ```

8. Seed initial data (if any):
   ```bash
   php artisan db:seed
   ```

9. Compile frontend assets:
   ```bash
   npm run dev
   ```

10. Start the development server:
    ```bash
    php artisan serve
    ```

11. Open the application in your browser:
    ```
    http://127.0.0.1:8000
    ```

---




## File Structure

```
CodeIt/
├── app/
│   ├── Actions/       # Custom user actions
│   ├── Console/       # Artisan commands
│   ├── Exceptions/    # Exception handling
│   ├── Http/
│   │   ├── Controllers/   # Controller logic
│   │   ├── Middleware/    # HTTP middleware
│   └── Models/            # Eloquent models
├── bootstrap/         # Framework bootstrap files
├── config/            # Configuration files
├── database/
│   ├── migrations/    # Database migrations
│   ├── seeders/       # Seeder files
├── public/            # Public assets (CSS, JS, images)
├── resources/
│   ├── views/         # Blade templates for the frontend
│   ├── css/           # CSS files
│   ├── js/            # JavaScript files
├── routes/
│   ├── api.php        # API routes
│   ├── web.php        # Web routes
├── storage/           # Logs, cache, and other storage
├── tests/             # Automated tests
├── .env.example       # Example environment configuration
├── README.md          # Project documentation
```

---

## Usage

- **For Developers**: Register an account, explore coding challenges, and track your progress on the leaderboard.
- **For Admins**: Use the admin dashboard to manage users, challenges, subscriptions, and payments.

---

## Contributing

Contributions are welcome! Follow these steps to contribute:

1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m "Add feature"
   ```
4. Push to your fork:
   ```bash
   git push origin feature-name
   ```
5. Create a pull request.

---

## License

This project is licensed under the [MIT License](LICENSE).

---

Feel free to copy and paste this directly into your GitHub repository! Let me know if you need further adjustments.
