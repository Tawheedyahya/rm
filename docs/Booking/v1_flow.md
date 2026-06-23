# Booking Flow

## Overview

```text
Customer Arrives
        │
        ▼
Enter Mobile Number
        │
 ┌──────┴──────────┐
 │                 │
Existing?        New Customer
 │                 │
 ▼                 ▼
Load Customer   Create Customer
        │
        ▼
Create Booking
        │
        ▼
Check Availability
        │
        ▼
Assign Table
        │
        ▼
Booking Confirmed
        │
        ▼
Customer Arrives
        │
        ▼
Check In
        │
        ▼
Dining
        │
        ▼
Payment
        │
        ▼
Complete Booking
        │
        ▼
Add Loyalty Points
```

---

## Step 1

Waiter asks for customer's mobile number.

**Input**

- Mobile Number

**Output**

- Existing customer
- New customer

---

## Step 2

If customer exists

- Load customer
- Show loyalty points
- Show booking history

Else

- Create customer

---

## Step 3

Create booking

Fields

| Field | Required |
|--------|----------|
| Date | ✅ |
| Time | ✅ |
| Guests | ✅ |
| Table | Optional |
| Note | Optional |

...