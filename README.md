# Sanctum Post App

![Laravel Logo](https://cdn.worldvectorlogo.com/logos/laravel-2.svg)

## Project Description
Sanctum Post App is a simple project created to store learning outcomes using **Laravel Sanctum** and serves as a personal guide for future projects related to authentication.

### Project Goals:
- Provide a guide for authentication using Laravel Sanctum.
- Offer features such as **Register**, **Login**, **Logout**, and **CRUD Post**.

### Problems Addressed:
- Currently, there are no specific issues to solve other than completing unfinished features.

### Key Features:
- **User Authentication**
  - Register
  - Login
  - Logout
- **CRUD Post**
  - Create Post
  - Read Post
  - Update Post
  - Delete Post

---

## Prerequisites
Before installing and running this project, ensure you have the following software installed:

- **PHP**: Version 8.3.9 or newer.
- **Composer**: For managing Laravel dependencies.
- **PostgreSQL**: The database used.

### Additional Configuration:
- Set up the **.env** configuration file to match your local database setup.

This project **does not require any external services** or other special configurations beyond the above.

---

## Installation Instructions
Follow the steps below to install and run the project in a local environment:

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd sanctum-post-app
   ```

2. **Install dependencies using Composer**:
   ```bash
   composer install
   ```

3. **Prepare the .env file**:
   - Duplicate the `.env.example` file as `.env`.
   - Set up the database connection to match your PostgreSQL setup:
     ```dotenv
     DB_CONNECTION=pgsql
     DB_HOST=127.0.0.1
     DB_PORT=5432
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```

4. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

5. **Start the application server**:
   ```bash
   php artisan serve
   ```

6. **Test the application**:
   Use Postman or any API testing tool to access:
   ```
   http://127.0.0.1:8000/api/test
   ```

---

## Application Usage
### Running the Application
The application can be accessed using Postman or any other API client.

### API Endpoint URLs
Below are the available API endpoints:

1. **CSRF Cookie**
   - Method: `GET`
   - URL: `http://localhost:8000/sanctum/csrf-cookie`

2. **Decrypt CSRF Cookie**
   - Method: `GET`
   - URL: `http://localhost:8000/api/decrypt`
   - Header:
     - `X-XSRF-TOKEN`: `<token>`

3. **Authentication**
   - **Register**
     - Method: `POST`
     - URL: `http://localhost:8000/api/register`
     - Header:
       - `Accept`: `application/json`
       - `X-XSRF-TOKEN`: `<token>`
     - Body:
       ```json
       {
         "name": "Dzulkifli Anwar",
         "email": "dzul@gmail.com",
         "password": "123456"
       }
       ```
   - **Login**
     - Method: `POST`
     - URL: `http://localhost:8000/api/login`
     - Header:
       - `Accept`: `application/json`
       - `X-XSRF-TOKEN`: `<token>`
     - Body:
       ```json
       {
         "email": "dzul@gmail.com",
         "password": "123456"
       }
       ```
   - **Profile**
     - Method: `GET`
     - URL: `http://localhost:8000/api/profile`
     - Header:
       - `Authorization`: `Bearer <token>`
   - **Logout**
     - Method: `POST`
     - URL: `http://localhost:8000/api/logout`
     - Header:
       - `X-XSRF-TOKEN`: `<token>`
       - `Authorization`: `Bearer <token>`

4. **CRUD Post**
   - **Create Post**
     - Method: `POST`
     - URL: `http://localhost:8000/api/post/`
     - Header:
       - `Accept`: `application/json`
       - `X-XSRF-TOKEN`: `<token>`
       - `Authorization`: `Bearer <token>`
     - Body:
       ```json
       {
         "title": "Title 1",
         "body": "Body 1",
         "user_id": 1
       }
       ```
   - **Read Posts**
     - Method: `GET`
     - URL: `http://localhost:8000/api/post/`
     - Header:
       - `Authorization`: `Bearer <token>`
   - **Update Post**
     - Method: `PUT`
     - URL: `http://localhost:8000/api/post/{id}`
     - Header:
       - `Accept`: `application/json`
       - `X-XSRF-TOKEN`: `<token>`
       - `Authorization`: `Bearer <token>`
     - Body:
       ```json
       {
         "title": "Title 1",
         "body": "Body 1",
         "user_id": 1
       }
       ```
   - **Delete Post**
     - Method: `DELETE`
     - URL: `http://localhost:8000/api/post/{id}`
     - Header:
       - `X-XSRF-TOKEN`: `<token>`
       - `Authorization`: `Bearer <token>`

---

## Project Structure
The project directory structure follows the standard Laravel layout with additional **interface** and **service** folders under `app`:

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── AuthController.php
│   │       └── PostController.php
│   └── Resources/
│       ├── PostResource.php
│       └── UserResource.php
├── Interfaces/
│   ├── AuthControllerInterface.php
│   ├── AuthServiceInterface.php
│   ├── PostControllerInterface.php
│   └── PostServiceInterface.php
├── Services/
│   ├── AuthService.php
│   └── PostService.php
...
```

---

## Contributions
Contributions are welcome! However, the contribution guidelines are not yet ready and will be provided in the future. Please stay tuned for updates.

---

## License
This project is licensed under the **MIT License**. Please refer to the license file for more information.

---

## Testing
Testing for this project is conducted manually using Postman or other API testing tools.

---

## Known Issues
- **Unfinished Features**:
  - Edit user profile.
- No other known issues or bugs at this time.

---

## Contact and Support
If you encounter any issues or have questions about this project, feel free to contact:

- **Name**: Dzulkifli Anwar
- **Email**: [ad875.darkroom373@passinbox.com](mailto:ad875.darkroom373@passinbox.com)
- **Telegram**: [@dzul_578](https://t.me/dzul_578)

---

## References
This project is based on a YouTube learning playlist with code adjustments:
- [Learn Laravel Sanctum](https://www.youtube.com/playlist?list=PLaVebpbEIP3bbdPv_67BzjiYpiHWJyv9E)

---

