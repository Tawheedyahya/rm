# Booking Flow - Phase 1

## Overview

```text
Customer Arrives
        │
        ▼
Enter Phone Number
        │
        ▼
Customer Exists?
   ┌─────────────┐
   │             │
  YES           NO
   │             │
   ▼             ▼
Load Customer  Create Customer
       │
       └──────────────┐
                      ▼
              Create Booking
                      │
                      ▼
              Booking Created
```

## Flow

### Step 1 - Enter Phone Number

The waiter enters the customer's mobile number.

### Step 2 - Check Customer

* If the customer exists, load the customer details.
* If the customer does not exist, create a new customer.

### Step 3 - Create Booking

Create a booking with the required details.

| Field                   | Required         |
| ----------------------- | ---------------- |
| Party Size              | ✅                |
| Booking Type            | ✅                |
| Status                  | ✅                |
| Reservation Date & Time | Reservation Only |

### Result

* Customer is linked to the booking.
* Booking is created successfully.
