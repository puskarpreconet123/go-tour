# Go Tour API Documentation

Base URL: `http://localhost:8000/api/v1` (or your configured environment base URL)

All endpoints that require authentication must include the API token. Depending on the `ApiAuthMiddleware` implementation, this is typically sent as a Bearer token in the Authorization header (`Authorization: Bearer <token>`) or as a query parameter (`?api_token=<token>`).

---

## 1. System

### Ping
Check if the API is running.
- **Endpoint:** `GET /ping`
- **Auth Required:** No
- **Request Format:** None
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "message": "Go Tour API v1 is running!",
    "environment": "local"
}
```

### Setup Database
Run database migrations.
- **Endpoint:** `GET /setup-db`
- **Auth Required:** No
- **Request Format:** None
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "message": "Database migrations ran successfully!",
    "output": "..."
}
```
- **Failed Response (500 Internal Server Error):**
```json
{
    "status": "error",
    "message": "Error details here"
}
```

### Setup Admin
Create a default admin user for testing (`admin@gotour.com` / `password123`).
- **Endpoint:** `GET /setup-admin`
- **Auth Required:** No
- **Request Format:** None
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "message": "Admin user created successfully!",
    "credentials": {
        "email": "admin@gotour.com",
        "password": "password123"
    }
}
```

---

## 2. Authentication

### Register User
Register a new user account.
- **Endpoint:** `POST /auth/register`
- **Auth Required:** No
- **Request Format (JSON/Form-Data):**
```json
{
    "name": "John Doe",         // string, max 255, required
    "email": "john@example.com", // string, email format, unique, required
    "password": "password123"    // string, min 8 characters, required
}
```
- **Success Response (201 Created):**
```json
{
    "status": "success",
    "message": "User registered successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "user",
        "api_token": "hashed_token_string",
        "created_at": "...",
        "updated_at": "..."
    },
    "token": "unhashed_token_string_to_use_for_requests"
}
```
- **Failed Response (422 Unprocessable Entity):**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email has already been taken."]
    }
}
```

### Login User
Authenticate an existing user.
- **Endpoint:** `POST /auth/login`
- **Auth Required:** No
- **Request Format (JSON/Form-Data):**
```json
{
    "email": "john@example.com", // email format, required
    "password": "password123"    // required
}
```
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "message": "Login successful",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "user",
        "api_token": "new_hashed_token_string",
        "created_at": "...",
        "updated_at": "..."
    },
    "token": "new_unhashed_token_string_to_use_for_requests"
}
```
- **Failed Response (422 Unprocessable Entity):**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The provided credentials are incorrect."]
    }
}
```

---

## 3. Destinations

### List Destinations
Fetch all available destinations with optional filtering.
- **Endpoint:** `GET /destinations`
- **Auth Required:** No
- **Query Parameters:**
  - `type` (optional, string)
  - `category` (optional, string)
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "name": "Paris",
            "type": "international",
            "category": "leisure",
            "...": "..."
        }
    ]
}
```

### Get Single Destination
Fetch details for a specific destination.
- **Endpoint:** `GET /destinations/{id}`
- **Auth Required:** No
- **Request Format:** None
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Paris",
        "type": "international",
        "category": "leisure",
        "...": "..."
    }
}
```
- **Failed Response (404 Not Found):**
```json
{
    "status": "error",
    "message": "Destination not found"
}
```

---

## 4. Bookings

### List Bookings
Fetch bookings for the authenticated user.
- **Endpoint:** `GET /bookings`
- **Auth Required:** Yes
- **Query Parameters:**
  - `status` (optional, string)
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "destination_id": 2,
            "type": "flight",
            "status": "upcoming",
            "total_amount": 500,
            "booking_details": { "...": "..." },
            "destination": {
                "id": 2,
                "name": "London"
            }
        }
    ]
}
```

### Create Booking
Create a new booking for the authenticated user.
- **Endpoint:** `POST /bookings`
- **Auth Required:** Yes
- **Request Format (JSON/Form-Data):**
```json
{
    "type": "flight",             // string, required
    "destination_id": 2,          // integer, optional, must exist in destinations
    "total_amount": 500.00,       // numeric, defaults to 0 if not provided
    "booking_details": {          // array/object, optional
        "passengers": 2,
        "date": "2026-06-01"
    }
}
```
- **Success Response (201 Created):**
```json
{
    "status": "success",
    "message": "Booking created successfully",
    "data": {
        "id": 2,
        "user_id": 1,
        "destination_id": 2,
        "type": "flight",
        "status": "upcoming",
        "total_amount": 500,
        "booking_details": { "passengers": 2, "date": "2026-06-01" },
        "created_at": "...",
        "updated_at": "..."
    }
}
```
- **Failed Response (422 Unprocessable Entity):** Validation errors.

### Get Single Booking
Fetch details for a specific user booking.
- **Endpoint:** `GET /bookings/{id}`
- **Auth Required:** Yes
- **Request Format:** None
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "user_id": 1,
        "destination_id": 2,
        "type": "flight",
        "status": "upcoming",
        "total_amount": 500,
        "booking_details": { "...": "..." },
        "destination": {
            "id": 2,
            "name": "London"
        }
    }
}
```
- **Failed Response (404 Not Found):**
```json
{
    "status": "error",
    "message": "Booking not found"
}
```

---

## 5. Support & Visa/Passport Requests

### List Requests
Fetch all support, visa, or passport requests for the authenticated user.
- **Endpoint:** `GET /requests`
- **Auth Required:** Yes
- **Query Parameters:**
  - `status` (optional, string)
- **Success Response (200 OK):**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "type": "visa",
            "status": "pending",
            "notes": "Need Schengen visa for upcoming trip"
        }
    ]
}
```

### Create Request
Submit a new support, visa, or passport request.
- **Endpoint:** `POST /requests`
- **Auth Required:** Yes
- **Request Format (JSON/Form-Data):**
```json
{
    "type": "visa",               // string, required (e.g., visa, passport, support)
    "notes": "Need assistance"    // string, optional
}
```
- **Success Response (201 Created):**
```json
{
    "status": "success",
    "message": "Request submitted successfully",
    "data": {
        "id": 2,
        "user_id": 1,
        "type": "visa",
        "status": "pending",
        "notes": "Need assistance",
        "created_at": "...",
        "updated_at": "..."
    }
}
```
- **Failed Response (422 Unprocessable Entity):** Validation errors.
